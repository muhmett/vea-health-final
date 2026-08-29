/* =============================================================================
   VeaHealth — the treatment room

   A lit volume you move around, with the treatment's object suspended in it and
   notes pinned in the air beside it.

   The whole thing is one WebGL canvas drawing four full-screen quads — a
   gradient volume, a light, the object, and a grain pass. That is it. Three.js
   would be 160 KB gzipped of scene graph to draw four quads; this is 11 KB and
   does the same job.

   It is also entirely optional. The room's markup is server-rendered with every
   note's text in it, so the fallback for no WebGL is not a blank screen — it is
   the same room as a readable list.
   ============================================================================= */
(function () {
  'use strict';

  var $  = function (s, c) { return (c || document).querySelector(s); };
  var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };

  var room = $('[data-room]');
  var open = $('[data-room-open]');
  if (!room || !open) return;

  var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ==========================================================================
     The scene
     ========================================================================== */
  var VERT = [
    'attribute vec2 aPos;',
    'varying vec2 vUv;',
    'void main(){ vUv = aPos * 0.5 + 0.5; gl_Position = vec4(aPos, 0.0, 1.0); }'
  ].join('\n');

  var FRAG = [
    'precision mediump float;',
    'uniform sampler2D uObject;',
    'uniform vec2  uRes;',
    'uniform vec2  uCover;',   // cover-fit for the object texture
    'uniform vec2  uLook;      // where the pointer is, -1..1',
    'uniform float uTime;',
    'uniform float uEnter;     // 0 while opening, 1 once open',
    'uniform vec3  uDeep;',
    'uniform vec3  uGlow;',
    'varying vec2 vUv;',

    // cheap value noise, enough for dust and grain
    'float hash(vec2 p){ return fract(sin(dot(p, vec2(127.1, 311.7))) * 43758.5453); }',
    'float noise(vec2 p){',
    '  vec2 i = floor(p), f = fract(p);',
    '  vec2 u = f * f * (3.0 - 2.0 * f);',
    '  return mix(mix(hash(i), hash(i + vec2(1,0)), u.x),',
    '             mix(hash(i + vec2(0,1)), hash(i + vec2(1,1)), u.x), u.y);',
    '}',

    'void main(){',
    '  vec2 uv = vUv;',
    '  float a = uRes.x / max(uRes.y, 1.0);',
    '  vec2 c = vec2((uv.x - 0.5) * a, uv.y - 0.5);',

    // ---- the volume: a dark room with one soft light high and behind ----
    '  vec2 lightPos = vec2(uLook.x * 0.22, 0.30 + uLook.y * 0.10);',
    '  float d = length(c - lightPos);',
    '  float light = exp(-d * 2.35);',
    '  vec3 col = uDeep + uGlow * light * 0.30;',

    // a slow drift in the volume so the space is never completely still
    '  float haze = noise(c * 2.4 + vec2(uTime * 0.045, uTime * 0.03));',
    '  col += uGlow * haze * 0.030 * light;',

    // ---- the object, parallaxed against the volume ----
    // The object sits closer than the light, so it moves further with the
    // pointer. That difference is the only thing making this read as depth.
    '  vec2 ouv = uv;',
    '  ouv -= vec2(uLook.x * 0.045, uLook.y * -0.035);',
    '  ouv = (ouv - 0.5) / (0.62 + 0.06 * uEnter) + 0.5;',   // the object floats smaller than frame
    '  vec2 tuv = (ouv - 0.5) * uCover + 0.5;',
    '  vec4 obj = vec4(0.0);',
    '  if (ouv.x > 0.0 && ouv.x < 1.0 && ouv.y > 0.0 && ouv.y < 1.0) {',
    '    obj = texture2D(uObject, tuv);',
    // Feather the plate so the object dissolves into the volume instead of
    // sitting on a visible rectangle.
    '    float ex = min(ouv.x, 1.0 - ouv.x), ey = min(ouv.y, 1.0 - ouv.y);',
    '    float edge = smoothstep(0.0, 0.22, ex) * smoothstep(0.0, 0.22, ey);',
    // and drop the near-black ground of the source render into the room
    '    float lum = dot(obj.rgb, vec3(0.299, 0.587, 0.114));',
    '    float keep = smoothstep(0.10, 0.46, lum);',
    '    obj.a = edge * keep * uEnter;',
    '  }',
    '  col = mix(col, obj.rgb * (0.58 + light * 1.15), obj.a);',

    // ---- a rim of light along the top of the object ----
    '  col += uGlow * obj.a * pow(light, 2.2) * 0.22;',

    // ---- vignette, then grain ----
    '  float vig = 1.0 - smoothstep(0.42, 1.15, length(c) * 1.25);',
    '  col *= 0.42 + vig * 0.58;',
    '  float g = hash(uv * uRes + fract(uTime) * 137.0);',
    '  col += (g - 0.5) * 0.035;',

    '  gl_FragColor = vec4(col, 1.0);',
    '}'
  ].join('\n');

  function ctx(canvas) {
    var o = { alpha: false, antialias: false, depth: false, stencil: false, powerPreference: 'low-power' };
    return canvas.getContext('webgl', o) || canvas.getContext('experimental-webgl', o);
  }

  function shader(gl, type, src) {
    var s = gl.createShader(type);
    gl.shaderSource(s, src); gl.compileShader(s);
    if (!gl.getShaderParameter(s, gl.COMPILE_STATUS)) {
      if (window.console) console.warn('[veahealth] room shader:', gl.getShaderInfoLog(s));
      return null;
    }
    return s;
  }

  /** '#rrggbb' -> [r,g,b] in 0..1, read from the page's own tokens. */
  function rgb(hex) {
    var m = /^#?([\da-f]{2})([\da-f]{2})([\da-f]{2})$/i.exec((hex || '').trim());
    return m ? [parseInt(m[1], 16) / 255, parseInt(m[2], 16) / 255, parseInt(m[3], 16) / 255] : [0.06, 0.14, 0.16];
  }

  var scene = null;

  function buildScene() {
    var stage = $('[data-room-stage]');
    var art   = $('[data-room-art]');
    if (!stage || !art || !art.naturalWidth) return null;

    var canvas = document.createElement('canvas');
    canvas.className = 'room__canvas';
    canvas.setAttribute('aria-hidden', 'true');
    var gl = ctx(canvas);
    if (!gl) return null;

    var v = shader(gl, gl.VERTEX_SHADER, VERT), f = shader(gl, gl.FRAGMENT_SHADER, FRAG);
    if (!v || !f) return null;
    var prog = gl.createProgram();
    gl.attachShader(prog, v); gl.attachShader(prog, f); gl.linkProgram(prog);
    if (!gl.getProgramParameter(prog, gl.LINK_STATUS)) return null;
    gl.useProgram(prog);

    var buf = gl.createBuffer();
    gl.bindBuffer(gl.ARRAY_BUFFER, buf);
    gl.bufferData(gl.ARRAY_BUFFER, new Float32Array([-1, -1, 3, -1, -1, 3]), gl.STATIC_DRAW);
    var loc = gl.getAttribLocation(prog, 'aPos');
    gl.enableVertexAttribArray(loc);
    gl.vertexAttribPointer(loc, 2, gl.FLOAT, false, 0, 0);

    var tex = gl.createTexture();
    gl.activeTexture(gl.TEXTURE0);
    gl.bindTexture(gl.TEXTURE_2D, tex);
    gl.pixelStorei(gl.UNPACK_FLIP_Y_WEBGL, true);
    gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_S, gl.CLAMP_TO_EDGE);
    gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_T, gl.CLAMP_TO_EDGE);
    gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MIN_FILTER, gl.LINEAR);
    gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MAG_FILTER, gl.LINEAR);
    gl.texImage2D(gl.TEXTURE_2D, 0, gl.RGB, gl.RGB, gl.UNSIGNED_BYTE, art);

    var u = {};
    ['uObject','uRes','uCover','uLook','uTime','uEnter','uDeep','uGlow'].forEach(function (n) {
      u[n] = gl.getUniformLocation(prog, n);
    });
    gl.uniform1i(u.uObject, 0);

    // the room borrows the page's own colours rather than inventing any
    var cs = getComputedStyle(document.documentElement);
    gl.uniform3fv(u.uDeep, rgb(cs.getPropertyValue('--deep') || '#0F2428'));
    gl.uniform3fv(u.uGlow, rgb(cs.getPropertyValue('--teal-mid') || '#3AADA7'));

    stage.appendChild(canvas);

    var dpr = Math.min(window.devicePixelRatio || 1, 2);
    var look = [0, 0], target = [0, 0], enter = 0, running = false, t0 = performance.now();
    var frames = 0, lastCheck = t0;

    function size() {
      var r = stage.getBoundingClientRect();
      var w = Math.max(1, Math.round(r.width * dpr)), h = Math.max(1, Math.round(r.height * dpr));
      if (canvas.width !== w || canvas.height !== h) { canvas.width = w; canvas.height = h; }
      gl.viewport(0, 0, w, h);
      gl.uniform2f(u.uRes, w, h);
      // cover-fit the object texture into the plate the shader draws it on
      var ai = art.naturalWidth / art.naturalHeight, ac = w / h;
      gl.uniform2f(u.uCover, ai > ac ? ac / ai : 1, ai > ac ? 1 : ai / ac);
    }

    function frame() {
      if (!running) return;
      look[0] += (target[0] - look[0]) * 0.055;
      look[1] += (target[1] - look[1]) * 0.055;
      enter   += ((room.classList.contains('is-open') ? 1 : 0) - enter) * 0.06;

      gl.uniform2f(u.uLook, look[0], look[1]);
      gl.uniform1f(u.uEnter, enter);
      gl.uniform1f(u.uTime, (performance.now() - t0) / 1000);
      gl.drawArrays(gl.TRIANGLES, 0, 3);

      /*
       * Drop the resolution rather than the frame rate. A room that runs at
       * 30 fps feels broken; one running at 0.75 device pixels does not, and
       * nobody has ever noticed the difference on a gradient and a grain pass.
       */
      frames++;
      var now = performance.now();
      if (now - lastCheck > 1200) {
        var fps = frames / ((now - lastCheck) / 1000);
        if (fps < 45 && dpr > 0.75) { dpr = Math.max(0.75, dpr - 0.35); size(); }
        frames = 0; lastCheck = now;
      }
      requestAnimationFrame(frame);
    }

    window.addEventListener('resize', size, { passive: true });
    size();

    return {
      canvas: canvas,
      look: function (x, y) { target[0] = x; target[1] = y; },
      start: function () { if (!running) { running = true; t0 = performance.now(); requestAnimationFrame(frame); } },
      stop:  function () { running = false; }
    };
  }

  /* ==========================================================================
     Notes
     ========================================================================== */
  var openNote = null;

  function setNote(li, want) {
    if (!li) return;
    var btn = $('.room-note__pin', li);
    li.classList.toggle('is-open', want);
    btn.setAttribute('aria-expanded', want ? 'true' : 'false');
    if (want) {
      if (openNote && openNote !== li) setNote(openNote, false);
      openNote = li;
      var card = $('.room-note__card', li);
      // move focus to the card so a keyboard reader lands on the answer
      window.setTimeout(function () { card.setAttribute('tabindex', '-1'); card.focus(); }, 120);
      li.classList.add('is-read');
    } else if (openNote === li) {
      openNote = null;
    }
  }

  function initNotes() {
    $$('.room-note').forEach(function (li) {
      $('.room-note__pin', li).addEventListener('click', function () {
        setNote(li, !li.classList.contains('is-open'));
      });
      var close = $('[data-room-note-close]', li);
      if (close) {
        close.addEventListener('click', function () {
          setNote(li, false);
          $('.room-note__pin', li).focus();
        });
      }
    });
  }

  /* ==========================================================================
     Open and close
     ========================================================================== */
  var lastFocus = null;

  function openRoom() {
    lastFocus = document.activeElement;
    room.hidden = false;
    // a frame between unhiding and animating, or the transition never runs
    requestAnimationFrame(function () {
      room.classList.add('is-open');
      document.body.classList.add('room-is-open');
      open.setAttribute('aria-expanded', 'true');
      if (!scene && !reduced) scene = buildScene();
      if (scene) scene.start();
      var exit = $('[data-room-exit]');
      if (exit) exit.focus();
    });
  }

  function closeRoom() {
    room.classList.remove('is-open');
    document.body.classList.remove('room-is-open');
    open.setAttribute('aria-expanded', 'false');
    if (openNote) setNote(openNote, false);
    window.setTimeout(function () {
      room.hidden = true;
      if (scene) scene.stop();
      if (lastFocus) lastFocus.focus();
    }, reduced ? 0 : 620);
  }

  open.addEventListener('click', openRoom);
  $$('[data-room-exit]').forEach(function (b) { b.addEventListener('click', closeRoom); });

  document.addEventListener('keydown', function (e) {
    if (e.key !== 'Escape' || room.hidden) return;
    // Escape closes the note first, the room second — never both at once
    if (openNote) { var n = openNote; setNote(n, false); $('.room-note__pin', n).focus(); }
    else closeRoom();
  });

  /* keep tab inside the room while it is open */
  document.addEventListener('keydown', function (e) {
    if (e.key !== 'Tab' || room.hidden) return;
    var f = $$('button, a[href], [tabindex="-1"]:focus', room).filter(function (el) {
      return el.offsetParent !== null || el === document.activeElement;
    });
    if (!f.length) return;
    var first = f[0], last = f[f.length - 1];
    if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
    else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
  });

  /* --------------------------------------------------------------------------
     Looking around
     The pointer moves the light and the object by different amounts, and the
     notes move with the depth they were pinned at. Touch gets the same thing
     from a drag.
     -------------------------------------------------------------------------- */
  function initLook() {
    if (reduced) return;
    var notes = $$('.room-note');
    var hint = $('[data-room-hint]');
    var moved = false;

    function apply(nx, ny) {
      if (scene) scene.look(nx, ny);
      notes.forEach(function (li) {
        var d = parseFloat(li.style.getPropertyValue('--depth')) || 0.5;
        li.style.setProperty('--px', (-nx * d * 46).toFixed(1) + 'px');
        li.style.setProperty('--py', (ny * d * 34).toFixed(1) + 'px');
      });
      if (!moved && hint) { moved = true; hint.classList.add('is-gone'); }
    }

    room.addEventListener('pointermove', function (e) {
      var r = room.getBoundingClientRect();
      apply((e.clientX - r.left) / r.width * 2 - 1, 1 - (e.clientY - r.top) / r.height * 2);
    });

    // touch: drag to look, clamped so it always springs back to centre
    var down = null;
    room.addEventListener('pointerdown', function (e) { if (e.pointerType !== 'mouse') down = { x: e.clientX, y: e.clientY }; });
    room.addEventListener('pointerup', function () { down = null; apply(0, 0); });
    room.addEventListener('pointermove', function (e) {
      if (!down || e.pointerType === 'mouse') return;
      apply(Math.max(-1, Math.min(1, (e.clientX - down.x) / 180)),
            Math.max(-1, Math.min(1, -(e.clientY - down.y) / 180)));
    });
  }

  initNotes();
  initLook();
})();
