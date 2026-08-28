/* =============================================================================
   VeaHealth — WebGL layer

   Two effects, and no library. Three.js is 160 KB gzipped and would be carrying
   a scene graph, a camera and a material system to draw two full-screen quads;
   the whole of this file is 6 KB and does the same job with the same shaders.
   On a site whose business depends on how fast a treatment page opens on a
   phone in a waiting room, that difference is worth writing the boilerplate.

   Loaded on demand by motion.js, and only when the visit can use it:
   a fine pointer, a wide screen, a working WebGL context, and no Save-Data
   header. Everything degrades to the plain DOM image if any of that is false.
   ============================================================================= */
window.VHGL = (function () {
  'use strict';

  var VERT = [
    'attribute vec2 aPos;',
    'varying vec2 vUv;',
    'void main(){',
    '  vUv = aPos * 0.5 + 0.5;',
    '  gl_Position = vec4(aPos, 0.0, 1.0);',
    '}'
  ].join('\n');

  /* The card hover: the picture bends toward the pointer, splits its channels
     a little at the point of contact, and settles back when the pointer goes. */
  var FRAG_HOVER = [
    'precision mediump float;',
    'uniform sampler2D uTex;',
    'uniform vec2  uMouse;',
    'uniform vec2  uCover;',
    'uniform vec2  uRes;',
    'uniform float uHover;',
    'uniform float uTime;',
    'varying vec2 vUv;',
    'void main(){',
    '  vec2 uv = vUv;',
    '  float a = uRes.x / max(uRes.y, 1.0);',
    '  vec2  d = vec2((uv.x - uMouse.x) * a, uv.y - uMouse.y);',
    '  float dist = length(d);',
    '  float ring = smoothstep(0.62, 0.0, dist);',
    // a slow wobble keeps the bend from reading as a mechanical lens
    '  float w = sin(dist * 13.0 - uTime * 2.0) * 0.5 + 0.5;',
    '  float amt = ring * uHover * (0.018 + 0.011 * w);',
    '  vec2 dir = d / max(dist, 0.0001);',
    '  vec2 off = dir * amt;',
    // pull the image very slightly in under the pointer
    '  uv = mix(uv, uMouse + (uv - uMouse) * (1.0 - 0.07 * uHover), ring);',
    '  uv = (uv - 0.5) * uCover + 0.5;',
    // A chromatic split reads as an artefact the moment you can name it.
    // Kept low enough that it registers as depth rather than as a bug.
    '  float c = amt * 0.20;',
    '  vec3 col;',
    '  col.r = texture2D(uTex, uv - off - vec2(c, 0.0)).r;',
    '  col.g = texture2D(uTex, uv - off).g;',
    '  col.b = texture2D(uTex, uv - off + vec2(c, 0.0)).b;',
    // a whisper of extra contrast where the pointer is, so the eye follows it
    '  col = mix(col, col * 1.06, ring * uHover);',
    '  gl_FragColor = vec4(col, 1.0);',
    '}'
  ].join('\n');

  /* The menu preview: one picture displaces out as the next displaces in. */
  var FRAG_FADE = [
    'precision mediump float;',
    'uniform sampler2D uFrom;',
    'uniform sampler2D uTo;',
    'uniform vec2  uCoverFrom;',
    'uniform vec2  uCoverTo;',
    'uniform float uProg;',
    'uniform float uTime;',
    'varying vec2 vUv;',
    'void main(){',
    '  vec2 uv = vUv;',
    '  float n = sin((uv.x * 3.4 + uv.y * 5.1) + uTime * 0.35) * 0.5 + 0.5;',
    '  float p = uProg;',
    '  float k = 0.16 * (0.55 + 0.45 * n);',
    '  vec2 a = (uv + vec2(p * k, p * k * 0.25) - 0.5) * uCoverFrom + 0.5;',
    '  vec2 b = (uv - vec2((1.0 - p) * k, (1.0 - p) * k * 0.25) - 0.5) * uCoverTo + 0.5;',
    '  vec3 ca = texture2D(uFrom, a).rgb;',
    '  vec3 cb = texture2D(uTo,   b).rgb;',
    '  gl_FragColor = vec4(mix(ca, cb, p), 1.0);',
    '}'
  ].join('\n');

  /* --------------------------------------------------------------------------
     Minimal plumbing
     -------------------------------------------------------------------------- */
  function context(canvas) {
    var opts = { alpha: false, antialias: false, depth: false, stencil: false, powerPreference: 'low-power' };
    return canvas.getContext('webgl', opts) || canvas.getContext('experimental-webgl', opts);
  }

  function shader(gl, type, src) {
    var s = gl.createShader(type);
    gl.shaderSource(s, src);
    gl.compileShader(s);
    if (!gl.getShaderParameter(s, gl.COMPILE_STATUS)) {
      if (window.console) console.warn('[veahealth] shader:', gl.getShaderInfoLog(s));
      return null;
    }
    return s;
  }

  function program(gl, fragSrc) {
    var v = shader(gl, gl.VERTEX_SHADER, VERT);
    var f = shader(gl, gl.FRAGMENT_SHADER, fragSrc);
    if (!v || !f) return null;
    var p = gl.createProgram();
    gl.attachShader(p, v);
    gl.attachShader(p, f);
    gl.linkProgram(p);
    if (!gl.getProgramParameter(p, gl.LINK_STATUS)) return null;
    gl.useProgram(p);

    var buf = gl.createBuffer();
    gl.bindBuffer(gl.ARRAY_BUFFER, buf);
    gl.bufferData(gl.ARRAY_BUFFER, new Float32Array([-1, -1, 3, -1, -1, 3]), gl.STATIC_DRAW);
    var loc = gl.getAttribLocation(p, 'aPos');
    gl.enableVertexAttribArray(loc);
    gl.vertexAttribPointer(loc, 2, gl.FLOAT, false, 0, 0);
    return p;
  }

  function texture(gl, image, unit) {
    var t = gl.createTexture();
    gl.activeTexture(gl.TEXTURE0 + unit);
    gl.bindTexture(gl.TEXTURE_2D, t);
    gl.pixelStorei(gl.UNPACK_FLIP_Y_WEBGL, true);
    // CLAMP_TO_EDGE, so a displaced sample past the edge smears rather than
    // wrapping the opposite side of the photograph into frame.
    gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_S, gl.CLAMP_TO_EDGE);
    gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_T, gl.CLAMP_TO_EDGE);
    gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MIN_FILTER, gl.LINEAR);
    gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MAG_FILTER, gl.LINEAR);
    gl.texImage2D(gl.TEXTURE_2D, 0, gl.RGB, gl.RGB, gl.UNSIGNED_BYTE, image);
    return t;
  }

  /** object-fit: cover, expressed as a UV scale about the centre. */
  function cover(iw, ih, cw, ch) {
    var ai = (iw || 1) / (ih || 1);
    var ac = (cw || 1) / (ch || 1);
    return ai > ac ? [ac / ai, 1] : [1, ai / ac];
  }

  function ready(img) {
    if (img.complete && img.naturalWidth) return Promise.resolve(img);
    return new Promise(function (resolve, reject) {
      img.addEventListener('load', function () { resolve(img); }, { once: true });
      img.addEventListener('error', reject, { once: true });
    });
  }

  function supported() {
    try {
      var c = document.createElement('canvas');
      return !!(window.WebGLRenderingContext && context(c));
    } catch (e) { return false; }
  }

  /* ==========================================================================
     1. Hover field — ONE context, moved to whichever card the pointer is over.

     Browsers cap the number of live WebGL contexts (Chrome drops the oldest
     past sixteen). A treatments archive can show more cards than that, so a
     canvas per card is not an option; a single canvas that follows the pointer
     costs one context no matter how long the page is.
     ========================================================================== */
  function hoverField(selector) {
    var cards = Array.prototype.slice.call(document.querySelectorAll(selector));
    if (!cards.length) return null;

    var canvas = document.createElement('canvas');
    canvas.className = 'vh-gl';
    canvas.setAttribute('aria-hidden', 'true');
    var gl = context(canvas);
    if (!gl) return null;

    var prog = program(gl, FRAG_HOVER);
    if (!prog) return null;

    var u = {
      tex:   gl.getUniformLocation(prog, 'uTex'),
      mouse: gl.getUniformLocation(prog, 'uMouse'),
      cover: gl.getUniformLocation(prog, 'uCover'),
      res:   gl.getUniformLocation(prog, 'uRes'),
      hover: gl.getUniformLocation(prog, 'uHover'),
      time:  gl.getUniformLocation(prog, 'uTime')
    };
    gl.uniform1i(u.tex, 0);

    var dpr = Math.min(window.devicePixelRatio || 1, 2);
    var host = null;        // the .svc-media the canvas currently sits in
    var tex = null;
    var mouse = [0.5, 0.5], target = [0.5, 0.5];
    var hover = 0, hoverTarget = 0;
    var running = false, t0 = performance.now();
    var textures = new WeakMap();

    function size(el) {
      var r = el.getBoundingClientRect();
      var w = Math.max(1, Math.round(r.width * dpr));
      var h = Math.max(1, Math.round(r.height * dpr));
      if (canvas.width !== w || canvas.height !== h) {
        canvas.width = w; canvas.height = h;
      }
      gl.viewport(0, 0, canvas.width, canvas.height);
      gl.uniform2f(u.res, canvas.width, canvas.height);
      return r;
    }

    function frame() {
      if (!running) return;
      // ease both the pointer and the hover weight, so nothing snaps
      mouse[0] += (target[0] - mouse[0]) * 0.12;
      mouse[1] += (target[1] - mouse[1]) * 0.12;
      hover    += (hoverTarget - hover) * 0.09;

      gl.uniform2f(u.mouse, mouse[0], mouse[1]);
      gl.uniform1f(u.hover, hover);
      gl.uniform1f(u.time, (performance.now() - t0) / 1000);
      gl.drawArrays(gl.TRIANGLES, 0, 3);

      if (hoverTarget === 0 && hover < 0.004) {
        // faded out: park the canvas rather than keep a RAF alive
        running = false;
        canvas.classList.remove('is-on');
        if (canvas.parentNode) canvas.parentNode.removeChild(canvas);
        host = null;
        return;
      }
      requestAnimationFrame(frame);
    }

    function enter(media) {
      var img = media.querySelector('img');
      if (!img || !img.naturalWidth) return;

      host = media;
      media.appendChild(canvas);
      var r = size(media);

      var t = textures.get(img);
      if (!t) { t = texture(gl, img, 0); textures.set(img, t); }
      else { gl.activeTexture(gl.TEXTURE0); gl.bindTexture(gl.TEXTURE_2D, t); }
      tex = t;

      var c = cover(img.naturalWidth, img.naturalHeight, r.width, r.height);
      gl.uniform2f(u.cover, c[0], c[1]);

      hoverTarget = 1;
      canvas.classList.add('is-on');
      if (!running) { running = true; requestAnimationFrame(frame); }
    }

    cards.forEach(function (card) {
      var media = card.matches('.svc-media') ? card : card.querySelector('.svc-media');
      if (!media) return;

      card.addEventListener('pointerenter', function (e) {
        if (e.pointerType && e.pointerType !== 'mouse') return;   // touch keeps the plain image
        ready(media.querySelector('img')).then(function () { enter(media); }).catch(function () {});
      });
      card.addEventListener('pointermove', function (e) {
        if (host !== media) return;
        var r = media.getBoundingClientRect();
        target[0] = (e.clientX - r.left) / r.width;
        target[1] = 1 - (e.clientY - r.top) / r.height;
      });
      card.addEventListener('pointerleave', function () {
        if (host === media) hoverTarget = 0;
      });
    });

    window.addEventListener('resize', function () { if (host) size(host); }, { passive: true });
    return { canvas: canvas, cards: cards.length };
  }

  /* ==========================================================================
     2. Menu preview — one picture displaces out as the next comes in.
     ========================================================================== */
  function previewFade(container) {
    if (!container) return null;
    var imgs = Array.prototype.slice.call(container.querySelectorAll('img'));
    if (imgs.length < 2) return null;

    var canvas = document.createElement('canvas');
    canvas.className = 'vh-gl vh-gl--preview is-on';
    canvas.setAttribute('aria-hidden', 'true');
    var gl = context(canvas);
    if (!gl) return null;

    var prog = program(gl, FRAG_FADE);
    if (!prog) return null;

    var u = {
      from: gl.getUniformLocation(prog, 'uFrom'),
      to:   gl.getUniformLocation(prog, 'uTo'),
      cf:   gl.getUniformLocation(prog, 'uCoverFrom'),
      ct:   gl.getUniformLocation(prog, 'uCoverTo'),
      prog: gl.getUniformLocation(prog, 'uProg'),
      time: gl.getUniformLocation(prog, 'uTime')
    };
    gl.uniform1i(u.from, 0);
    gl.uniform1i(u.to, 1);

    var dpr = Math.min(window.devicePixelRatio || 1, 2);
    var texs = [], dims = [];
    var from = 0, to = 0, p = 1, pTarget = 1;
    var running = false, t0 = performance.now();

    function size() {
      var r = container.getBoundingClientRect();
      if (!r.width) return;
      canvas.width = Math.max(1, Math.round(r.width * dpr));
      canvas.height = Math.max(1, Math.round(r.height * dpr));
      gl.viewport(0, 0, canvas.width, canvas.height);
      applyCover();
    }

    function applyCover() {
      var a = dims[from], b = dims[to];
      if (a) gl.uniform2f(u.cf, cover(a[0], a[1], canvas.width, canvas.height)[0], cover(a[0], a[1], canvas.width, canvas.height)[1]);
      if (b) gl.uniform2f(u.ct, cover(b[0], b[1], canvas.width, canvas.height)[0], cover(b[0], b[1], canvas.width, canvas.height)[1]);
    }

    function frame() {
      p += (pTarget - p) * 0.075;
      gl.activeTexture(gl.TEXTURE0); gl.bindTexture(gl.TEXTURE_2D, texs[from]);
      gl.activeTexture(gl.TEXTURE1); gl.bindTexture(gl.TEXTURE_2D, texs[to]);
      gl.uniform1f(u.prog, p);
      gl.uniform1f(u.time, (performance.now() - t0) / 1000);
      gl.drawArrays(gl.TRIANGLES, 0, 3);
      if (running) requestAnimationFrame(frame);
    }

    Promise.all(imgs.map(ready)).then(function (loaded) {
      loaded.forEach(function (img, i) {
        texs[i] = texture(gl, img, i < 2 ? i : 0);
        dims[i] = [img.naturalWidth, img.naturalHeight];
      });
      container.appendChild(canvas);
      size();
      running = true;
      requestAnimationFrame(frame);
    }).catch(function () {});

    window.addEventListener('resize', size, { passive: true });

    return {
      /** Show image `i`, displacing whatever is showing now out of frame. */
      show: function (i) {
        i = i % imgs.length;
        if (i === to) return;
        // whatever is on screen becomes the outgoing frame
        from = to;
        to = i;
        p = 0; pTarget = 1;
        applyCover();
      },
      stop: function () { running = false; },
      start: function () { if (!running) { running = true; requestAnimationFrame(frame); } }
    };
  }

  return { supported: supported, hoverField: hoverField, previewFade: previewFade };
})();
