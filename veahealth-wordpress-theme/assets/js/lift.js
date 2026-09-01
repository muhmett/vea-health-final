/**
 * The journey, as a lift.
 *
 * The stages of a treatment trip are floors, and the reader's scroll is the
 * descent: doors open, the figure steps in, the car drops to the next stage,
 * the doors open again and he steps out to stand beside what is written there.
 * Scroll back up and the whole thing runs backwards, because the timeline is a
 * function of scroll position rather than a sequence of played animations —
 * which is also why it never ends up out of step with the page.
 *
 * Everything is drawn in particles, sampled from the same kind of SVG
 * silhouettes the rest of the site's particle work uses: a few hundred bytes
 * of path, rasterised once, rejection-sampled so density follows area. Each
 * point then eases toward where it should be rather than jumping, so the
 * figure assembles and dissolves instead of appearing.
 *
 * Floors are read from the page, not hard-coded: the car stops level with the
 * real section it belongs to, so editing the journey cannot put the lift out
 * of register with the text.
 *
 * @package VeaHealth
 */
(function () {
  'use strict';

  var host = document.querySelector('[data-lift]');
  if (!host) return;

  var scope = host.closest('[data-lift-scope]');
  var stops = scope ? [].slice.call(scope.querySelectorAll('[data-lift-stop]')) : [];
  if (!scope || stops.length < 2) return;

  var still = window.matchMedia('(prefers-reduced-motion: reduce)');
  if (still.matches) return;              // the page reads fine without it

  /* --------------------------------------------------------------------------
     Silhouettes, in a 100 x 100 box
     -------------------------------------------------------------------------- */

  var PATHS = {
    // A person standing: head, shoulders, torso, arms held in, two legs.
    person:
      'M50 6 a10 10 0 1 1 -0.1 0 z ' +
      'M50 28 c-9 0-15 5-15 13 v20 c0 3 2 5 5 5 h20 c3 0 5-2 5-5 v-20 c0-8-6-13-15-13 z ' +
      'M33 33 c-4 2-5 5-5 9 v17 c0 3 4 3 4 0 v-15 c0-3 1-5 3-7 z ' +
      'M67 33 c4 2 5 5 5 9 v17 c0 3-4 3-4 0 v-15 c0-3-1-5-3-7 z ' +
      'M42 66 h6 v27 c0 3-6 3-6 0 z M52 66 h6 v27 c0 3-6 3-6 0 z',
    // The car: an open frame, so whoever is inside it can be seen.
    car:
      'M8 4 h84 v92 h-84 z ' +
      'M15 11 v78 h70 v-78 z',
    // One door panel. Two of these are placed and slid apart.
    door: 'M28 12 h44 v76 h-44 z'
  };

  /**
   * Points from the filled area of a path, centred on the origin.
   *
   * Rejection sampling rather than walking the outline: density then follows
   * area, so a torso reads as solid and an arm as slender, which is what makes
   * a silhouette legible instead of wiry.
   */
  function sample(path, count) {
    var res = 200;
    var c = document.createElement('canvas');
    c.width = c.height = res;
    var g = c.getContext('2d');
    if (!g || typeof Path2D === 'undefined') return null;
    g.fillStyle = '#fff';
    g.scale(res / 100, res / 100);
    try { g.fill(new Path2D(path)); } catch (e) { return null; }

    var d = g.getImageData(0, 0, res, res).data;
    var out = new Float32Array(count * 2);
    var i = 0, guard = 0;
    while (i < count && guard < count * 500) {
      guard++;
      var x = Math.random() * res, y = Math.random() * res;
      if (d[((y | 0) * res + (x | 0)) * 4 + 3] < 128) continue;
      out[i * 2]     = x / res - 0.5;
      out[i * 2 + 1] = y / res - 0.5;
      i++;
    }
    return i === count ? out : out.subarray(0, i * 2);
  }

  /* --------------------------------------------------------------------------
     Groups
     -------------------------------------------------------------------------- */

  var ctx = host.getContext('2d');
  if (!ctx) return;

  // Counts sized to the rail, not to the screen: this is a small drawing and
  // more points past a few hundred only cost frames.
  var GROUPS = [
    { key: 'car',   n: 520, path: PATHS.car },
    { key: 'doorL', n: 130, path: PATHS.door },
    { key: 'doorR', n: 130, path: PATHS.door },
    { key: 'person', n: 440, path: PATHS.person }
  ];

  GROUPS.forEach(function (g) {
    g.pts = sample(g.path, g.n);
    if (!g.pts) return;
    g.n = g.pts.length / 2;
    g.x = new Float32Array(g.n);
    g.y = new Float32Array(g.n);
    g.seeded = false;
    g.jit = new Float32Array(g.n);
    for (var i = 0; i < g.n; i++) g.jit[i] = Math.random() * Math.PI * 2;
  });
  GROUPS = GROUPS.filter(function (g) { return g.pts; });
  if (!GROUPS.length) return;

  /* --------------------------------------------------------------------------
     Where the floors are
     -------------------------------------------------------------------------- */

  var floors = [];      // y of each stop, in canvas space, 0..1 of rail height
  var railTop = 0, railH = 1;

  function measure() {
    var r = host.getBoundingClientRect();
    var dpr = Math.min(window.devicePixelRatio || 1, 2);
    host.width  = Math.max(1, Math.round(r.width  * dpr));
    host.height = Math.max(1, Math.round(r.height * dpr));
    ctx.setTransform(dpr, 0, 0, dpr, 0, 0);

    // Each stop's centre, expressed against the scrollable scope, becomes the
    // floor the car stops at. Read from the page so the lift cannot drift out
    // of register with the text it is describing.
    var s = scope.getBoundingClientRect();
    railTop = s.top + window.scrollY;
    railH = Math.max(1, s.height);
    floors = stops.map(function (el) {
      var b = el.getBoundingClientRect();
      return ((b.top + window.scrollY + b.height / 2) - railTop) / railH;
    });
  }

  /* --------------------------------------------------------------------------
     The timeline
     -------------------------------------------------------------------------- */

  // Fractions of one floor-to-floor segment. The car spends most of a segment
  // travelling; the rest is the business at each end of the trip.
  var ENTER_END = 0.16, SHUT_END = 0.26, RIDE_END = 0.76, OPEN_END = 0.86;

  function ease(t) { return t < 0.5 ? 2 * t * t : 1 - Math.pow(-2 * t + 2, 2) / 2; }
  function clamp01(v) { return v < 0 ? 0 : v > 1 ? 1 : v; }
  function seg(v, a, b) { return clamp01((v - a) / (b - a)); }

  /**
   * Read the scroll position as: which floor, and what is happening.
   *
   * @return {{carY:number, open:number, out:number, floor:number}}
   *   carY  0..1 down the rail; open 0..1 how far the doors are apart;
   *   out   0 inside the car, 1 standing outside it.
   */
  function state() {
    var vh = window.innerHeight;
    var p = clamp01((window.scrollY + vh * 0.5 - railTop) / railH);

    // Which pair of floors are we between?
    var i = 0;
    while (i < floors.length - 2 && p > floors[i + 1]) i++;
    var a = floors[i], b = floors[i + 1];
    var u = b > a ? clamp01((p - a) / (b - a)) : 0;

    var carY, open, out;
    if (u < ENTER_END) {                       // doors open, he steps in
      carY = a; open = 1; out = 1 - ease(seg(u, 0, ENTER_END));
    } else if (u < SHUT_END) {                 // doors close on him
      carY = a; open = 1 - ease(seg(u, ENTER_END, SHUT_END)); out = 0;
    } else if (u < RIDE_END) {                 // the descent
      carY = a + (b - a) * ease(seg(u, SHUT_END, RIDE_END)); open = 0; out = 0;
    } else if (u < OPEN_END) {                 // arrived, doors part
      carY = b; open = ease(seg(u, RIDE_END, OPEN_END)); out = 0;
    } else {                                   // he steps out and waits
      carY = b; open = 1; out = ease(seg(u, OPEN_END, 1));
    }
    return { carY: carY, open: open, out: out, floor: i };
  }

  /* --------------------------------------------------------------------------
     Draw
     -------------------------------------------------------------------------- */

  var ink = '#1C726D', dim = 'rgba(28,114,109,.42)';
  function readColours() {
    var cs = getComputedStyle(host);
    ink = cs.getPropertyValue('--lift-ink').trim() || ink;
    dim = cs.getPropertyValue('--lift-dim').trim() || dim;
  }

  function place(g, cx, cy, w, h, alpha) {
    var pts = g.pts, n = g.n;
    if (!g.seeded) {
      for (var s = 0; s < n; s++) { g.x[s] = cx; g.y[s] = cy; }
      g.seeded = true;
    }
    g.alpha = alpha;
    for (var i = 0; i < n; i++) {
      var tx = cx + pts[i * 2] * w;
      var ty = cy + pts[i * 2 + 1] * h;
      g.x[i] += (tx - g.x[i]) * 0.16;
      g.y[i] += (ty - g.y[i]) * 0.16;
    }
  }

  function paint(t) {
    var w = host.clientWidth, h = host.clientHeight;
    ctx.clearRect(0, 0, w, h);
    for (var k = 0; k < GROUPS.length; k++) {
      var g = GROUPS[k];
      if (g.alpha <= 0.01) continue;
      ctx.fillStyle = g.key === 'person' ? ink : dim;
      ctx.globalAlpha = g.alpha;
      for (var i = 0; i < g.n; i++) {
        // A breath, so a still lift is not a dead one.
        var jx = Math.sin(t * 0.0011 + g.jit[i]) * 0.38;
        var jy = Math.cos(t * 0.0009 + g.jit[i] * 1.3) * 0.38;
        ctx.fillRect(g.x[i] + jx, g.y[i] + jy, 1.5, 1.5);
      }
    }
    ctx.globalAlpha = 1;
  }

  var raf = 0, visible = false;

  function frame(t) {
    raf = 0;
    var w = host.clientWidth, h = host.clientHeight;
    if (w < 8 || h < 8) { schedule(); return; }

    var st = state();

    /*
     * A lift car is portrait, and the first cut drew it square — which read as
     * a crate. The rail also has to be wide enough for somebody to stand next
     * to the car once the doors open, or "steps out" has nowhere to happen:
     * the car sits off-centre and the pavement beside it is the rest.
     */
    var carW = Math.min(w * 0.66, 132);
    var carH = carW * 1.42;
    var pw   = carW * 0.30;
    var cx   = carW / 2 + 2;                       // the car hugs the inline start
    var outX = cx + carW * 0.52 + pw * 0.55;       // where he waits on the floor
    var cy   = carH / 2 + (h - carH) * st.carY;

    var car = byKey('car'), dl = byKey('doorL'), dr = byKey('doorR'), pr = byKey('person');
    if (car) place(car, cx, cy, carW, carH, 1);

    // Shut, the panels meet on the centre line; open, they are swallowed by
    // the car's own walls rather than sliding off into the page.
    var half = carW * 0.21;
    var slide = st.open * half * 1.7;
    if (dl) place(dl, cx - half - slide, cy, carW * 0.44, carH * 0.84, 1 - st.open * 0.55);
    if (dr) place(dr, cx + half + slide, cy, carW * 0.44, carH * 0.84, 1 - st.open * 0.55);

    if (pr) {
      var ph = carH * 0.62;
      place(pr, cx + (outX - cx) * st.out, cy + carH * 0.07, pw, ph, 1);
    }

    paint(t);
    schedule();
  }

  function byKey(k) {
    for (var i = 0; i < GROUPS.length; i++) if (GROUPS[i].key === k) return GROUPS[i];
    return null;
  }

  function schedule() {
    if (!raf && visible) raf = requestAnimationFrame(frame);
  }

  /* --------------------------------------------------------------------------
     Only while it is on screen
     -------------------------------------------------------------------------- */

  readColours();
  measure();

  var io = new IntersectionObserver(function (es) {
    visible = es[0].isIntersecting;
    if (visible) schedule();
    else if (raf) { cancelAnimationFrame(raf); raf = 0; }
  }, { threshold: 0 });
  io.observe(scope);

  var ro = new ResizeObserver(function () { measure(); schedule(); });
  ro.observe(host);
  ro.observe(scope);

  window.addEventListener('scroll', schedule, { passive: true });
  window.addEventListener('resize', function () { measure(); schedule(); });
  still.addEventListener('change', function () { if (still.matches && raf) { cancelAnimationFrame(raf); raf = 0; } });
})();
