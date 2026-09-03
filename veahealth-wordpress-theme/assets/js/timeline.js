/**
 * The journey timeline.
 *
 * A rail down the reading edge of the stages with one numbered node per step,
 * drawn by particles that fall down the gutter and settle onto the line as
 * scrolling reveals it.
 *
 * Three things it has to be, in order:
 *
 * Legible. The numbers are the information — they say which step of five you
 * are reading — so they are drawn first and last, and they survive with the
 * particles switched off entirely.
 *
 * Out of the way. The rail lives inside a gutter the sections reserve in CSS,
 * so it cannot end up on top of a line of text however narrow the screen. That
 * was the fault in the lift this replaces.
 *
 * Cheap. The canvas is one viewport tall and sticky rather than as tall as the
 * scope, everything is drawn in one pass per frame, and the particle count is
 * chosen from the screen — a phone is not asked to move as many as a desktop,
 * and a reader who asked for no motion is given a still rail.
 *
 * The node positions are measured from the real sections, so a step added or
 * removed in the template moves the rail without anything here being told.
 */
(function () {
  'use strict';

  var host = document.querySelector('[data-timeline]');
  if (!host || !host.getContext) return;

  var scope = host.closest('[data-timeline-scope]');
  if (!scope) return;

  var stops = [].slice.call(scope.querySelectorAll('[data-timeline-step]'));
  if (!stops.length) return;

  var cx = host.getContext('2d');
  var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var rtl = getComputedStyle(document.documentElement).direction === 'rtl';

  var ink = '#1E7A75';
  var dim = 'rgba(30,122,117,.3)';
  var num = '#16302F';
  var dpr = 1;
  var W = 0;          // css pixels
  var H = 0;
  var railX = 0;      // where the line sits across the gutter

  /* Node positions, in document coordinates, measured from the sections. */
  var nodes = [];
  var top = 0;        // document y of the first node
  var bottom = 0;     // document y of the last

  function measure() {
    var cs = getComputedStyle(host);
    ink = cs.getPropertyValue('--tl-ink').trim() || ink;
    dim = cs.getPropertyValue('--tl-dim').trim() || dim;
    num = cs.getPropertyValue('--tl-num').trim() || num;

    var r = host.getBoundingClientRect();
    dpr = Math.min(window.devicePixelRatio || 1, 2);
    W = Math.max(1, r.width);
    H = Math.max(1, r.height);
    host.width = Math.round(W * dpr);
    host.height = Math.round(H * dpr);
    cx.setTransform(dpr, 0, 0, dpr, 0, 0);
    railX = rtl ? W * 0.62 : W * 0.38;

    var page = window.scrollY || window.pageYOffset;
    nodes = stops.map(function (el) {
      /*
       * The node sits on the step's heading rather than the middle of the
       * section: a section is mostly picture and list, and a number floating
       * beside a photograph does not read as belonging to anything.
       */
      var anchor = el.querySelector('h2') || el;
      var b = anchor.getBoundingClientRect();
      return { y: b.top + page + b.height / 2 };
    });
    top = nodes[0].y;
    bottom = nodes[nodes.length - 1].y;
    if (bottom - top < 1) bottom = top + 1;
  }

  /* ----------------------------------------------------------------------
     Particles. They fall down the gutter; where the rail has been drawn they
     are pulled onto it and slow to a stop, so the line looks made of them.
     ---------------------------------------------------------------------- */
  var parts = [];
  var COUNT = reduced ? 0 : (window.innerWidth < 700 ? 420 : 1300);

  function seed() {
    parts.length = 0;
    for (var i = 0; i < COUNT; i++) {
      parts.push({
        x: Math.random() * W,
        y: Math.random() * H,
        v: 0.25 + Math.random() * 1.1,
        r: Math.random() < 0.12 ? 1.5 : 0.7 + Math.random() * 0.5,
        a: 0.12 + Math.random() * 0.5,
        s: 0                                  // 0 falling, 1 settled on the rail
      });
    }
  }

  function draw() {
    var page = window.scrollY || window.pageYOffset;
    var railTop = top - page;                 // in canvas space
    var railBottom = bottom - page;

    // How far down the steps the reader has come, 0..1, measured against the
    // middle of the viewport so the rail fills as a step reaches reading height.
    var eye = page + window.innerHeight * 0.55;
    var prog = (eye - top) / (bottom - top);
    prog = prog < 0 ? 0 : prog > 1 ? 1 : prog;
    var drawnTo = railTop + (railBottom - railTop) * prog;

    cx.clearRect(0, 0, W, H);

    // the whole rail, faint
    cx.strokeStyle = dim;
    cx.lineWidth = 1;
    cx.beginPath();
    cx.moveTo(railX, Math.max(-10, railTop));
    cx.lineTo(railX, Math.min(H + 10, railBottom));
    cx.stroke();

    // the part that has been reached, solid
    if (drawnTo > railTop) {
      cx.strokeStyle = ink;
      cx.lineWidth = 1.6;
      cx.beginPath();
      cx.moveTo(railX, Math.max(-10, railTop));
      cx.lineTo(railX, Math.min(H + 10, drawnTo));
      cx.stroke();
    }

    // particles
    for (var i = 0; i < parts.length; i++) {
      var p = parts[i];

      if (p.s === 0) {
        p.y += p.v;
        // captured once it falls into the drawn part of the rail
        if (p.y > railTop && p.y < drawnTo && Math.abs(p.x - railX) < 16) {
          p.s = 1;
        }
        if (p.y > H + 8) { p.y = -8; p.x = Math.random() * W; }
      } else {
        // settled: ease onto the line, then hold
        p.x += (railX - p.x) * 0.12;
        p.y += 0.06;
        if (p.y > drawnTo + 6 || p.y > H + 8) { p.s = 0; p.y = -8; p.x = Math.random() * W; }
      }

      cx.globalAlpha = p.s ? Math.min(0.85, p.a + 0.3) : p.a;
      cx.fillStyle = ink;
      cx.beginPath();
      cx.arc(p.x, p.y, p.r, 0, 6.2832);
      cx.fill();
    }
    cx.globalAlpha = 1;

    // nodes and their numbers, drawn last so nothing is scattered over them
    for (var n = 0; n < nodes.length; n++) {
      var y = nodes[n].y - page;
      if (y < -40 || y > H + 40) continue;
      var reached = nodes[n].y <= eye;

      cx.beginPath();
      cx.arc(railX, y, reached ? 12 : 9, 0, 6.2832);
      cx.fillStyle = reached ? ink : 'transparent';
      if (reached) cx.fill();
      cx.strokeStyle = reached ? ink : dim;
      cx.lineWidth = 1.4;
      cx.stroke();

      cx.fillStyle = reached ? '#fff' : num;
      cx.globalAlpha = reached ? 1 : 0.55;
      cx.font = '600 ' + (reached ? 12 : 11) + 'px ui-monospace, SFMono-Regular, Menlo, monospace';
      cx.textAlign = 'center';
      cx.textBaseline = 'middle';
      cx.fillText(String(n + 1), railX, y + 0.5);
      cx.globalAlpha = 1;
    }
  }

  /* ----------------------------------------------------------------------
     Run only while the steps are on screen. A timeline animating three
     sections below the fold is battery spent on nothing.
     ---------------------------------------------------------------------- */
  var running = false;
  var visible = false;

  function frame() {
    if (!running) return;
    draw();
    requestAnimationFrame(frame);
  }

  function start() {
    if (running || reduced) return;
    running = true;
    requestAnimationFrame(frame);
  }

  function stop() { running = false; }

  if ('IntersectionObserver' in window) {
    new IntersectionObserver(function (entries) {
      visible = entries[0].isIntersecting;
      if (visible) { start(); } else { stop(); }
      if (!visible) draw();          // leave a correct still frame behind
    }, { rootMargin: '120px' }).observe(scope);
  } else {
    visible = true;
    start();
  }

  var resizeTimer = null;
  window.addEventListener('resize', function () {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function () { measure(); seed(); draw(); }, 120);
  }, { passive: true });

  // Reduced motion still gets the rail and the numbers, repainted on scroll —
  // it is the information, not the decoration.
  if (reduced) {
    window.addEventListener('scroll', draw, { passive: true });
  }

  measure();
  seed();
  draw();

  /*
   * Images above the steps change their height as they arrive, which moves
   * every node measured before them. Re-measure once the page has settled
   * rather than trying to catch each load.
   */
  window.addEventListener('load', function () {
    measure();
    seed();
    draw();
  });
})();
