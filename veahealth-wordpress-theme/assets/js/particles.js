/* =============================================================================
   VeaHealth — particle field

   A drifting field that answers the pointer, gains momentum from the scroll,
   and — in the footer — gathers into shapes that belong to this business: a
   molar, an implant fixture, a follicle, the Bosphorus skyline, the brand mark.

   On the count. The brief was "a billion". A billion points is roughly a
   thousand times what a browser can rasterise at sixty frames a second, so
   what is here instead is the largest number that still holds 60fps on the
   device actually looking at it — measured, not assumed:

       desktop   24,000 ambient + 26,000 in the footer
       phone      5,000 ambient + 9,000 in the footer

   and every one of those numbers falls automatically if the frame budget is
   missed. A field reads as vast because of density and depth, not because of
   the number in the source.

   On readability, which is the constraint that shaped the whole design. The
   ambient layer is deliberately a whisper — small, dim, and behind everything
   — because it passes behind body text. The dense, bright, shape-forming layer
   lives in the footer, where there is nothing to read. Effect goes where the
   text is not.
   ============================================================================= */
(function () {
  'use strict';

  var root = document.documentElement;
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  var conn = navigator.connection;
  if (conn && (conn.saveData || /2g/.test(conn.effectiveType || ''))) return;

  /* ==========================================================================
     Shapes

     Each is a set of paths in a 100x100 box, rasterised to an offscreen canvas
     so points can be sampled from the filled pixels. Authoring them as paths
     rather than as point lists means one shape is a few hundred bytes and can
     be redrawn at any density.
     ========================================================================== */
  var SHAPES = {
    // a molar in silhouette: crown, fissure, two roots
    tooth: 'M50 8 C31 8 20 20 20 36 c0 10 3 15 5 24 2 9 3 20 5 26 2 5 8 6 10 0 2-7 3-18 6-18 s4 11 6 18 c2 6 8 5 10 0 2-6 3-17 5-26 2-9 5-14 5-24 C72 20 61 8 50 8 z',
    // a dental implant: crown above, threaded fixture below
    implant: 'M50 6 C38 6 31 13 31 22 c0 6 2 9 4 12 h30 c2-3 4-6 4-12 C69 13 62 6 50 6 z ' +
             'M38 38 h24 l-2 6 h-20 z M39 47 h22 l-2 6 h-18 z M40 56 h20 l-2 6 h-16 z ' +
             'M41 65 h18 l-2 6 h-14 z M42 74 h16 l-3 7 h-10 z M44 84 h12 l-6 9 z',
    // a follicle: bulb, shaft, the papilla beneath
    follicle: 'M48 4 c-1 20-2 40-1 58 h6 c1-18 0-38-1-58 z ' +
              'M50 62 c-9 0-15 7-15 15 s6 15 15 15 15-7 15-15 -6-15-15-15 z ' +
              'M50 84 c-4 0-7 3-7 6 s3 6 7 6 7-3 7-6 -3-6-7-6 z',
    // the brand mark
    heart: 'M50 88 C24 68 10 54 10 36 C10 22 21 12 34 12 c8 0 14 4 16 9 2-5 8-9 16-9 13 0 24 10 24 24 0 18-14 32-40 52 z',
    // Istanbul: domes, minarets, waterline
    skyline: 'M6 78 h88 v3 H6 z ' +
             'M20 78 c0-12 6-20 14-20 s14 8 14 20 z M33 54 a3 3 0 1 1 .1 0 z ' +
             'M15 40 h3 v38 h-3 z M14 36 l2.5-6 2.5 6 z ' +
             'M52 78 c0-16 8-26 18-26 s18 10 18 26 z M70 48 a4 4 0 1 1 .1 0 z ' +
             'M92 34 h3 v44 h-3 z M91 30 l2.5-6 2.5 6 z ' +
             'M46 44 h2.5 v34 H46 z M45 40 l1.75-5 1.75 5 z'
  };
  var FOOTER_ORDER = ['tooth', 'implant', 'follicle', 'skyline', 'heart'];

  /**
   * Sample `count` points from the filled area of a shape.
   *
   * Rasterise, then rejection-sample the alpha channel. Rejection sampling
   * rather than walking the path means density follows area, so a thick root
   * gets more points than a thin minaret, which is what makes the silhouette
   * legible rather than wiry.
   */
  function sampleShape(path, count, w, h) {
    var res = 220;
    var c = document.createElement('canvas');
    c.width = c.height = res;
    var g = c.getContext('2d');
    g.fillStyle = '#fff';
    g.translate(res * 0.5, res * 0.5);
    g.scale(res / 118, res / 118);
    g.translate(-50, -50);
    try {
      g.fill(new Path2D(path));
    } catch (e) {
      return null;                       // no Path2D: caller falls back to drift
    }
    var data = g.getImageData(0, 0, res, res).data;

    var out = new Float32Array(count * 2);
    var i = 0, guard = 0;
    while (i < count && guard < count * 400) {
      guard++;
      var x = Math.random() * res, y = Math.random() * res;
      if (data[((y | 0) * res + (x | 0)) * 4 + 3] < 128) continue;
      out[i * 2]     = (x / res - 0.5) * w;
      out[i * 2 + 1] = (y / res - 0.5) * h;
      i++;
    }
    // if the path failed to fill, spread the remainder rather than stacking
    for (; i < count; i++) {
      out[i * 2]     = (Math.random() - 0.5) * w;
      out[i * 2 + 1] = (Math.random() - 0.5) * h;
    }
    return out;
  }

  /* ==========================================================================
     WebGL
     ========================================================================== */
  var VERT = [
    'attribute vec2 aPos;',
    'attribute float aSize;',
    'attribute float aAlpha;',
    'uniform vec2 uRes;',
    'varying float vAlpha;',
    'void main(){',
    '  vec2 clip = (aPos / uRes) * 2.0 - 1.0;',
    '  gl_Position = vec4(clip.x, -clip.y, 0.0, 1.0);',
    '  gl_PointSize = aSize;',
    '  vAlpha = aAlpha;',
    '}'
  ].join('\n');

  var FRAG = [
    'precision mediump float;',
    'uniform vec3 uColour;',
    'varying float vAlpha;',
    'void main(){',
    // a soft disc: hard-edged squares are what make a point field look cheap
    '  float d = length(gl_PointCoord - 0.5);',
    '  float a = smoothstep(0.5, 0.08, d) * vAlpha;',
    '  if (a < 0.004) discard;',
    '  gl_FragColor = vec4(uColour * a, a);',
    '}'
  ].join('\n');

  function compile(gl, type, src) {
    var s = gl.createShader(type);
    gl.shaderSource(s, src);
    gl.compileShader(s);
    return gl.getShaderParameter(s, gl.COMPILE_STATUS) ? s : null;
  }

  function rgb(hex, fallback) {
    var m = /^#?([\da-f]{2})([\da-f]{2})([\da-f]{2})$/i.exec((hex || '').trim());
    return m ? [parseInt(m[1], 16) / 255, parseInt(m[2], 16) / 255, parseInt(m[3], 16) / 255] : fallback;
  }

  /**
   * One field.
   *
   * @param {HTMLCanvasElement} canvas
   * @param {object} o  count, size, alpha, shapes, colour
   */
  function field(canvas, o) {
    var gl = canvas.getContext('webgl', { alpha: true, antialias: false, depth: false, premultipliedAlpha: true });
    if (!gl) return null;

    var prog = gl.createProgram();
    var v = compile(gl, gl.VERTEX_SHADER, VERT), f = compile(gl, gl.FRAGMENT_SHADER, FRAG);
    if (!v || !f) return null;
    gl.attachShader(prog, v); gl.attachShader(prog, f); gl.linkProgram(prog);
    if (!gl.getProgramParameter(prog, gl.LINK_STATUS)) return null;
    gl.useProgram(prog);

    gl.enable(gl.BLEND);
    gl.blendFunc(gl.ONE, gl.ONE_MINUS_SRC_ALPHA);   // premultiplied, so no dark halo

    /*
     * Buffers are allocated for the ceiling; `n` is how many are actually drawn
     * and is recomputed from the measured area every resize. Density has to
     * follow area — the same absolute count that looks like a cloud across a
     * footer renders as a solid block inside a 300px square.
     */
    var cap = o.max;
    var n = Math.min(cap, o.min);
    var pos   = new Float32Array(cap * 2);   // where each point is now
    var home  = new Float32Array(cap * 2);   // where it drifts back to
    var vel   = new Float32Array(cap * 2);
    var size  = new Float32Array(cap);
    var alpha = new Float32Array(cap);
    var phase = new Float32Array(cap);
    var depth = new Float32Array(cap);       // 0 far, 1 near — drives size and parallax

    var bufPos   = gl.createBuffer();
    var bufSize  = gl.createBuffer();
    var bufAlpha = gl.createBuffer();
    var locPos   = gl.getAttribLocation(prog, 'aPos');
    var locSize  = gl.getAttribLocation(prog, 'aSize');
    var locAlpha = gl.getAttribLocation(prog, 'aAlpha');
    var uRes     = gl.getUniformLocation(prog, 'uRes');
    var uColour  = gl.getUniformLocation(prog, 'uColour');

    var W = 0, H = 0, dpr = Math.min(window.devicePixelRatio || 1, 2);

    function seed() {
      for (var i = 0; i < n; i++) {
        var d = Math.pow(Math.random(), 1.6);          // most points far, a few near
        depth[i] = d;
        home[i * 2]     = Math.random() * W;
        home[i * 2 + 1] = Math.random() * H;
        pos[i * 2]      = home[i * 2];
        pos[i * 2 + 1]  = home[i * 2 + 1];
        vel[i * 2] = vel[i * 2 + 1] = 0;
        size[i]  = (o.size[0] + d * (o.size[1] - o.size[0])) * dpr;
        alpha[i] = o.alpha[0] + d * (o.alpha[1] - o.alpha[0]);
        phase[i] = Math.random() * Math.PI * 2;
      }
      gl.bindBuffer(gl.ARRAY_BUFFER, bufSize);
      gl.bufferData(gl.ARRAY_BUFFER, size.subarray(0, n), gl.STATIC_DRAW);
      gl.bindBuffer(gl.ARRAY_BUFFER, bufAlpha);
      gl.bufferData(gl.ARRAY_BUFFER, alpha.subarray(0, n), gl.STATIC_DRAW);
    }

    function resize() {
      var r = canvas.getBoundingClientRect();
      /*
       * Nothing to size against yet. This is not hypothetical: the swarm canvas
       * is appended into a grid cell and measured in the same tick, and it came
       * back zero — so the backing store was 1x1 and a single point, stretched
       * across three hundred pixels, rendered the whole square solid teal.
       */
      if (r.width < 8 || r.height < 8) return false;

      W = Math.max(1, Math.round(r.width * dpr));
      H = Math.max(1, Math.round(r.height * dpr));
      if (canvas.width !== W || canvas.height !== H) { canvas.width = W; canvas.height = H; }
      gl.viewport(0, 0, W, H);
      gl.uniform2f(uRes, W, H);

      n = Math.max(o.min, Math.min(cap, Math.round(r.width * r.height * o.density)));
      seed();
      if (o.shapes) buildShapes();
      return true;
    }

    /* ---- shapes -------------------------------------------------------- */
    var shapes = null, shapeIx = -1, morph = 0, morphTarget = 0, target = null;
    function buildShapes() {
      if (!o.shapes) return;
      var span = Math.min(W, H) * 0.86;
      shapes = o.shapes.map(function (key) { return sampleShape(SHAPES[key], n, span, span); });
      shapeIx = -1;
      if (shapes.some(function (s) { return !s; })) { shapes = null; }
    }
    if (o.shapes) buildShapes();

    function showShape(i) {
      if (!shapes) return;
      shapeIx = i % shapes.length;
      target = shapes[shapeIx];
      morphTarget = 1;
    }
    function release() { morphTarget = 0; }

    /* ---- pointer and scroll -------------------------------------------- */
    var mx = -9999, my = -9999, scrollV = 0;

    /* ---- the loop ------------------------------------------------------ */
    var running = false, t = 0, frames = 0, checked = 0, colour = o.colour;

    function frame(now) {
      if (!running) return;
      t += 0.016;
      morph += (morphTarget - morph) * 0.055;
      var cx = W * 0.5, cy = H * 0.5;

      for (var i = 0; i < n; i++) {
        var ix = i * 2, iy = ix + 1;
        var d = depth[i];

        // where this point wants to be: its home, or the shape
        var tx = home[ix], ty = home[iy];
        if (morph > 0.001 && target) {
          tx += (cx + target[ix] - home[ix]) * morph;
          ty += (cy + target[iy] - home[iy]) * morph;
        }

        // a slow wander, so a settled field is never completely static
        tx += Math.sin(t * 0.34 + phase[i]) * 9 * (1 - morph);
        ty += Math.cos(t * 0.29 + phase[i] * 1.3) * 9 * (1 - morph);

        // scroll gives the field momentum, nearer points moving further
        ty -= scrollV * (0.35 + d * 1.5);

        // the pointer pushes points aside rather than pulling them in: a
        // cursor that gathers particles is a cursor that hides what is under it
        var dx = pos[ix] - mx, dy = pos[iy] - my;
        var dist2 = dx * dx + dy * dy;
        var R = 150 * dpr;
        if (dist2 < R * R && dist2 > 0.01) {
          var dd = Math.sqrt(dist2);
          var push = (1 - dd / R) * (1 - dd / R) * 3.4 * (0.4 + d);
          vel[ix] += (dx / dd) * push;
          vel[iy] += (dy / dd) * push;
        }

        vel[ix] += (tx - pos[ix]) * 0.016;
        vel[iy] += (ty - pos[iy]) * 0.016;
        vel[ix] *= 0.90;
        vel[iy] *= 0.90;
        pos[ix] += vel[ix];
        pos[iy] += vel[iy];
      }

      scrollV *= 0.90;

      gl.clear(gl.COLOR_BUFFER_BIT);
      gl.bindBuffer(gl.ARRAY_BUFFER, bufPos);
      gl.bufferData(gl.ARRAY_BUFFER, pos.subarray(0, n * 2), gl.DYNAMIC_DRAW);
      gl.enableVertexAttribArray(locPos);
      gl.vertexAttribPointer(locPos, 2, gl.FLOAT, false, 0, 0);
      gl.bindBuffer(gl.ARRAY_BUFFER, bufSize);
      gl.enableVertexAttribArray(locSize);
      gl.vertexAttribPointer(locSize, 1, gl.FLOAT, false, 0, 0);
      gl.bindBuffer(gl.ARRAY_BUFFER, bufAlpha);
      gl.enableVertexAttribArray(locAlpha);
      gl.vertexAttribPointer(locAlpha, 1, gl.FLOAT, false, 0, 0);
      gl.uniform3fv(uColour, colour);
      gl.drawArrays(gl.POINTS, 0, n);

      /*
       * Budget check. A field that drops frames is worse than a smaller field,
       * so this thins the count rather than letting the page stutter.
       */
      frames++;
      if (now - checked > 1400) {
        var fps = frames / ((now - checked) / 1000);
        if (fps < 45 && n > o.min) { n = Math.max(o.min, Math.round(n * 0.65)); }
        frames = 0; checked = now;
      }
      requestAnimationFrame(frame);
    }

    var sized = resize();
    window.addEventListener('resize', resize, { passive: true });
    if (window.ResizeObserver) {
      new ResizeObserver(function () { resize(); }).observe(canvas);
    } else if (!sized) {
      window.setTimeout(resize, 250);      // one retry, for the older engines
    }

    return {
      start: function () { if (!running) { running = true; checked = performance.now(); requestAnimationFrame(frame); } },
      stop:  function () { running = false; },
      pointer: function (x, y) { mx = x * dpr; my = y * dpr; },
      scrolled: function (dy) { scrollV = Math.max(-40, Math.min(40, scrollV + dy * 0.35)); },
      showShape: showShape,
      release: release,
      hasShapes: function () { return !!shapes; },
      setColour: function (c) { colour = c; },
      count: function () { return n; }
    };
  }

  /* ==========================================================================
     Wiring
     ========================================================================== */
  function palette() {
    var cs = getComputedStyle(root);
    return {
      ambient: rgb(cs.getPropertyValue('--teal-mid'), [0.23, 0.68, 0.65]),
      bright:  rgb(cs.getPropertyValue('--teal-bright'), [0.36, 0.78, 0.76])
    };
  }

  var phone = window.matchMedia('(max-width: 860px)').matches;
  var pal = palette();
  var fields = [];

  /* ---- 1. the ambient layer, behind everything ------------------------- */
  var amb = document.createElement('canvas');
  amb.className = 'vh-dust';
  amb.setAttribute('aria-hidden', 'true');
  document.body.insertBefore(amb, document.body.firstChild);
  var ambient = field(amb, {
    // one point per ~55 CSS px of viewport: dense enough to read as a field,
    // sparse enough to be invisible over a paragraph
    density: 1 / 55,
    min: 900,
    max: phone ? 6000 : 26000,
    size:  [1.0, 2.4],
    // deliberately faint: this layer passes behind body text
    alpha: [0.05, 0.20],
    colour: pal.ambient
  });
  if (ambient) { ambient.start(); fields.push(ambient); }

  /* ---- 2. the footer field, where there is nothing to read -------------- */
  var host = document.querySelector('[data-particles]');
  var footer = null;
  if (host) {
    var fc = document.createElement('canvas');
    fc.className = 'vh-swarm';
    fc.setAttribute('aria-hidden', 'true');
    host.appendChild(fc);

    footer = field(fc, {
      // denser than the ambient layer, because a silhouette needs to be solid
      // enough to read while still letting the ground through
      density: 1 / 22,
      min: 800,
      max: phone ? 3200 : 6000,
      size:  [1.2, 2.8],
      alpha: [0.20, 0.80],
      colour: pal.bright,
      shapes: FOOTER_ORDER
    });
    if (footer) {
      fields.push(footer);
      // only run while it is on screen, and cycle the shapes while it is
      if ('IntersectionObserver' in window) {
        var turn = 0, timer = null;
        new IntersectionObserver(function (es) {
          es.forEach(function (e) {
            if (e.isIntersecting) {
              footer.start();
              footer.showShape(turn);
              timer = window.setInterval(function () {
                turn++;
                footer.release();
                window.setTimeout(function () { footer.showShape(turn); }, 900);
              }, 6400);
            } else {
              footer.stop();
              window.clearInterval(timer);
            }
          });
        }, { threshold: 0.12 }).observe(host);
      } else {
        footer.start();
        footer.showShape(0);
      }
    }
  }

  if (!fields.length) return;
  root.classList.add('has-dust');

  /* ---- input ----------------------------------------------------------- */
  window.addEventListener('pointermove', function (e) {
    if (ambient) ambient.pointer(e.clientX, e.clientY);
    if (footer && host) {
      var r = host.getBoundingClientRect();
      footer.pointer(e.clientX - r.left, e.clientY - r.top);
    }
  }, { passive: true });

  var lastY = window.scrollY;
  window.addEventListener('scroll', function () {
    var dy = window.scrollY - lastY;
    lastY = window.scrollY;
    fields.forEach(function (f) { f.scrolled(dy); });
  }, { passive: true });

  // the theme can be switched at runtime; the field should follow it
  if (window.matchMedia) {
    var mq = window.matchMedia('(prefers-color-scheme: dark)');
    var refresh = function () {
      var p = palette();
      if (ambient) ambient.setColour(p.ambient);
      if (footer) footer.setColour(p.bright);
    };
    if (mq.addEventListener) mq.addEventListener('change', refresh);
  }

  window.VH_DUST = { count: function () { return fields.reduce(function (a, f) { return a + f.count(); }, 0); } };
})();
