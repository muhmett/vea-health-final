/* =============================================================================
   VeaHealth — motion layer

   Loads GSAP, ScrollTrigger and Lenis *on demand* and only when the visit can
   actually use them. A visitor who asks for reduced motion, or who is on a
   small screen, never downloads the 133 KB of libraries at all — they get the
   plain page, which is fully functional on its own.

   Everything below is additive: if this file fails to load, site.js still
   handles reveals, counters, the menu and the form.
   ============================================================================= */
(function () {
  'use strict';

  var root = document.documentElement;
  var $  = function (s, c) { return (c || document).querySelector(s); };
  var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };

  /* --------------------------------------------------------------------------
     Gate: should the motion layer run at all?
     -------------------------------------------------------------------------- */
  var reduced = window.matchMedia('(prefers-reduced-motion: reduce)');
  var wide    = window.matchMedia('(min-width: 861px)');

  if (reduced.matches) return;                       // respect the setting, always
  if (!('IntersectionObserver' in window)) return;    // very old browser: leave it alone
  if (!window.VH_MOTION || !window.VH_MOTION.base) return;

  var BASE = window.VH_MOTION.base;                   // theme asset URL, from PHP

  /* --------------------------------------------------------------------------
     Loader
     -------------------------------------------------------------------------- */
  function loadScript(src) {
    return new Promise(function (resolve, reject) {
      var s = document.createElement('script');
      s.src = src;
      s.async = false;                                // keep execution order
      s.onload = resolve;
      s.onerror = function () { reject(new Error('failed: ' + src)); };
      document.head.appendChild(s);
    });
  }

  var libs = [
    BASE + '/js/vendor/gsap.min.js',
    BASE + '/js/vendor/ScrollTrigger.min.js',
    BASE + '/js/vendor/lenis.min.js'
  ];

  libs.reduce(function (chain, src) {
    return chain.then(function () { return loadScript(src); });
  }, Promise.resolve())
    .then(boot)
    .catch(function (e) {
      // The plain page is already working; a library that will not load is not
      // worth breaking anything over.
      if (window.console) console.warn('[veahealth] motion layer skipped —', e.message);
    });

  /* ==========================================================================
     Boot
     ========================================================================== */
  function boot() {
    if (!window.gsap || !window.ScrollTrigger || !window.Lenis) return;

    gsap.registerPlugin(ScrollTrigger);
    root.classList.add('has-motion');

    initSmoothScroll();
    initHeadlines();
    initHeroFilm();
    initJourneyRail();
    initMediaParallax();
    initMarqueeVelocity();
    initMenu();
    if (wide.matches && window.matchMedia('(pointer:fine)').matches) initCursor();
    initPageTransitions();
    initWebGL();

    // sections and images settle at different times; make sure the trigger
    // positions are measured against the final layout
    window.addEventListener('load', function () { ScrollTrigger.refresh(); });
  }

  /* --------------------------------------------------------------------------
     1. Smooth scroll, driven by GSAP's ticker so scroll-linked animation and
        the scroll position never disagree by a frame.
     -------------------------------------------------------------------------- */
  var lenis;
  function initSmoothScroll() {
    lenis = new Lenis({
      duration: 1.05,
      easing: function (t) { return Math.min(1, 1.001 - Math.pow(2, -10 * t)); },
      smoothWheel: true,
      touchMultiplier: 1.6
    });

    lenis.on('scroll', ScrollTrigger.update);
    gsap.ticker.add(function (time) { lenis.raf(time * 1000); });
    gsap.ticker.lagSmoothing(0);

    // in-page anchors go through Lenis so they inherit the same easing
    document.addEventListener('click', function (e) {
      var a = e.target.closest('a[href^="#"]');
      if (!a) return;
      var id = a.getAttribute('href');
      if (id === '#' || id === '#main') return;
      var target = document.querySelector(id);
      if (!target) return;
      e.preventDefault();
      lenis.scrollTo(target, { offset: -90 });
    }, true);
  }

  /* --------------------------------------------------------------------------
     2. Headlines reveal one line at a time.
        The lines are measured from the rendered text rather than guessed, so
        the masks follow whatever the type actually wraps to.
     -------------------------------------------------------------------------- */
  function splitLines(el) {
    if (el.dataset.split === 'done') return $$('.vh-line', el);
    var html = el.innerHTML;
    // wrap every word so we can read its position, then group by top offset
    el.innerHTML = html.replace(/(<br\s*\/?>)|([^\s<]+(?:<[^>]+>)?)/g, function (m, br, word) {
      return br ? br : '<span class="vh-w">' + word + '</span>';
    });
    var words = $$('.vh-w', el);
    if (!words.length) { el.innerHTML = html; return []; }

    var lines = [], current = null, lastTop = null;
    words.forEach(function (w) {
      var top = Math.round(w.offsetTop);
      if (lastTop === null || Math.abs(top - lastTop) > 4) {
        current = [];
        lines.push(current);
        lastTop = top;
      }
      current.push(w);
    });

    var frag = document.createDocumentFragment();
    lines.forEach(function (group) {
      var outer = document.createElement('span');
      outer.className = 'vh-line';
      var inner = document.createElement('span');
      group.forEach(function (w, i) {
        inner.appendChild(document.createTextNode(i ? ' ' : ''));
        while (w.firstChild) inner.appendChild(w.firstChild);
      });
      outer.appendChild(inner);
      frag.appendChild(outer);
    });
    el.innerHTML = '';
    el.appendChild(frag);
    el.classList.add('vh-lines');
    el.dataset.split = 'done';
    return $$('.vh-line', el);
  }

  function initHeadlines() {
    $$('[data-lines]').forEach(function (el) {
      var lines = splitLines(el);
      if (!lines.length) return;
      gsap.to(lines.map(function (l) { return l.firstElementChild; }), {
        y: '0%',
        duration: 1.15,
        ease: 'expo.out',
        stagger: 0.09,
        scrollTrigger: { trigger: el, start: 'top 88%', once: true }
      });
    });
  }

  /* --------------------------------------------------------------------------
     3. The hero film, scrubbed by scroll.

        The clip never plays on its own: its currentTime is tied to how far the
        hero has been scrolled, so the camera move belongs to the visitor.
        Seeking is only smooth because the file is encoded with every frame as a
        keyframe — see the encode note in the theme README.
     -------------------------------------------------------------------------- */
  function initHeroFilm() {
    var wrap = $('.hero-film');
    if (!wrap) return;
    var video = $('video', wrap);
    var hero  = wrap.closest('.hero');
    if (!video || !hero) return;

    var bar = $('.hero-scrub span');
    var state = { t: 0 };

    /*
     * The frames are painted into a canvas rather than shown by the <video>
     * itself.
     *
     * A paused, never-played, seek-only video is not something every browser
     * composites: the element can hold a perfectly good decoded frame — you can
     * read it with drawImage — and still paint as an empty black box. iOS
     * Safari is the notorious case, and headless Chromium does it too, which is
     * how this was caught. Copying each frame out with drawImage sidesteps the
     * whole question: if the frame decoded, it appears.
     */
    var canvas = document.createElement('canvas');
    canvas.setAttribute('aria-hidden', 'true');
    var cx = canvas.getContext('2d');
    var dpr = Math.min(window.devicePixelRatio || 1, 2);
    wrap.appendChild(canvas);

    function sizeCanvas() {
      var r = wrap.getBoundingClientRect();
      var w = Math.max(1, Math.round(r.width * dpr));
      var h = Math.max(1, Math.round(r.height * dpr));
      if (canvas.width !== w || canvas.height !== h) { canvas.width = w; canvas.height = h; }
    }

    /** object-fit: cover, done by hand because a canvas has no such property. */
    function draw() {
      if (!video.videoWidth || video.readyState < 2) return;
      var cw = canvas.width, ch = canvas.height;
      var scale = Math.max(cw / video.videoWidth, ch / video.videoHeight);
      var dw = video.videoWidth * scale, dh = video.videoHeight * scale;
      cx.drawImage(video, (cw - dw) / 2, (ch - dh) / 2, dw, dh);
    }

    // a seek finishes asynchronously, so repaint when the frame actually lands
    video.addEventListener('seeked', draw);
    window.addEventListener('resize', function () { sizeCanvas(); draw(); }, { passive: true });

    function attach() {
      sizeCanvas();
      draw();
      wrap.classList.add('is-ready');
      var duration = video.duration || 5;

      gsap.to(state, {
        t: 1,
        ease: 'none',
        scrollTrigger: {
          trigger: hero,
          start: 'top top',
          end: '+=' + (window.innerHeight * 1.6),
          scrub: 0.6,
          pin: false
        },
        onUpdate: function () {
          // guard against seeking while the browser is still buffering
          if (video.readyState >= 2) {
            video.currentTime = Math.min(duration - 0.05, state.t * duration);
            draw();
          }
          if (bar) bar.style.transform = 'scaleX(' + state.t.toFixed(3) + ')';
        }
      });

      // the copy lifts and fades as the film runs
      gsap.to('.hero-inner', {
        y: -60,
        opacity: 0.15,
        ease: 'none',
        scrollTrigger: {
          trigger: hero,
          start: 'top top',
          end: '+=' + (window.innerHeight * 1.2),
          scrub: 0.6
        }
      });
    }

    /*
     * Pick exactly one file, here, in JS.
     *
     * The obvious markup — two <source> children and a data-attribute swap for
     * narrow screens — makes the browser fetch the clip more than once: it
     * starts on the first <source>, and assigning .src afterwards begins a
     * second load without cancelling the first. On the homepage that turned
     * 907 KB into 2.8 MB. So the element ships with no sources at all and gets
     * the one URL it needs, chosen from what this browser can actually decode.
     *
     * With no JavaScript the clip is simply never fetched, which is the right
     * outcome: it is decorative, aria-hidden, and the still underneath it is
     * the element that gets indexed.
     */
    var d = video.dataset;
    var narrow = !wide.matches;

    /*
     * AV1 first, H.264 only where AV1 cannot be decoded.
     *
     * Every frame here is a keyframe, because scrubbing seeks to arbitrary
     * points and a frame that depends on its neighbours cannot be shown on its
     * own. All-intra is expensive, and H.264 spends that budget badly: at the
     * weight this hero can afford it was giving each frame about a fifth of
     * the bits it needed, which is what made the footage look soft — the clip
     * itself is fine. AV1 encodes the same frames far more efficiently, so the
     * same page weight buys a visibly cleaner picture.
     *
     * H.264 stays for Safari before 17 and older Android, which cannot decode
     * AV1 at all and would otherwise get nothing.
     */
    var av1 = video.canPlayType('video/webm; codecs="av01.0.05M.08"');
    var h264 = video.canPlayType('video/mp4; codecs="avc1.42E01E"');

    var src = '';
    if (av1) src = narrow && d.av1Narrow ? d.av1Narrow : d.av1Wide;
    if (!src && h264) src = narrow && d.srcNarrow ? d.srcNarrow : d.srcWide;
    if (!src) src = d.srcWide || d.av1Wide;
    if (!src) return;
    video.src = src;

    video.preload = 'auto';
    if (video.readyState >= 2) {
      attach();
    } else {
      video.addEventListener('loadeddata', attach, { once: true });
      video.addEventListener('error', function () {
        // poster stays, page still works
        if (window.console) console.warn('[veahealth] hero film unavailable');
      }, { once: true });
      video.load();
    }
  }

  /* --------------------------------------------------------------------------
     4. The journey, as a horizontal track pinned while it scrolls through.
     -------------------------------------------------------------------------- */
  function initJourneyRail() {
    var rail  = $('.journey-rail');
    var track = $('.journey-track', rail || document);
    if (!rail || !track || !wide.matches) return;

    var bar = $('.journey-progress span');

    var distance = function () {
      return Math.max(0, track.scrollWidth - window.innerWidth + parseFloat(getComputedStyle(track).paddingLeft) * 2);
    };

    gsap.to(track, {
      x: function () { return -distance(); },
      ease: 'none',
      scrollTrigger: {
        trigger: rail,
        start: 'top top',
        end: function () { return '+=' + distance(); },
        pin: true,
        scrub: 0.8,
        anticipatePin: 1,
        invalidateOnRefresh: true,
        onUpdate: function (self) {
          if (bar) bar.style.transform = 'scaleX(' + self.progress.toFixed(3) + ')';
        }
      }
    });
  }

  /* --------------------------------------------------------------------------
     5. Framed media drifts a little slower than the page.

     The service cards are deliberately excluded: their photograph is handed to
     the WebGL hover field instead, and a scroll parallax underneath a pointer
     warp reads as two effects fighting over the same picture. One per image.
     -------------------------------------------------------------------------- */
  function initMediaParallax() {
    $$('.media-frame img').forEach(function (img) {
      gsap.fromTo(img,
        { yPercent: -6, scale: 1.12 },
        {
          yPercent: 6,
          ease: 'none',
          scrollTrigger: { trigger: img.closest('figure, .svc-media, .media-frame') || img, scrub: true }
        });
    });
  }

  /* --------------------------------------------------------------------------
     6. The trust strip speeds up and reverses with the scroll.
     -------------------------------------------------------------------------- */
  function initMarqueeVelocity() {
    var track = $('.marquee-track');
    if (!track) return;
    track.style.animation = 'none';

    var half = track.scrollWidth / 2 || 1;
    var x = 0, dir = 1, base = 0.6;

    ScrollTrigger.create({
      onUpdate: function (self) {
        dir = self.direction;
        base = 0.6 + Math.min(Math.abs(self.getVelocity()) / 900, 6);
      }
    });

    gsap.ticker.add(function () {
      x -= base * dir;
      if (x <= -half) x += half;
      if (x > 0) x -= half;
      track.style.transform = 'translate3d(' + x.toFixed(2) + 'px,0,0)';
    });
  }

  /* --------------------------------------------------------------------------
     7. Fullscreen menu
     -------------------------------------------------------------------------- */
  function initMenu() {
    var toggle = $('.menu-toggle');
    var menu   = $('.vh-menu');
    if (!toggle || !menu) return;

    var items   = $$('.vh-menu__item > a', menu);
    var preview = $$('.vh-menu__preview img', menu);
    var open    = false;
    var lastFocus = null;

    var tl = gsap.timeline({ paused: true })
      .set(menu, { visibility: 'visible' })
      .fromTo(menu,
        { clipPath: 'inset(0 0 100% 0)' },
        { clipPath: 'inset(0 0 0% 0)', duration: 0.85, ease: 'expo.inOut' })
      .fromTo(items,
        { y: '105%' },
        { y: '0%', duration: 0.9, stagger: 0.055, ease: 'expo.out' }, '-=0.45')
      .fromTo('.vh-menu__meta > *',
        { opacity: 0, y: 18 },
        { opacity: 1, y: 0, duration: 0.7, stagger: 0.08, ease: 'expo.out' }, '-=0.6');

    function setOpen(next) {
      open = next;
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      menu.classList.toggle('is-open', open);
      /*
       * The close control is the same button that opened it, and that button
       * lives inside the header — which has a stacking context of its own, so
       * no z-index on the button itself can lift it above a full-screen
       * overlay. The whole header has to rise, and only while the menu is up.
       * Without this there is no way out on a touchscreen: no Escape key, and
       * the X is painted underneath the thing it closes.
       */
      document.documentElement.classList.toggle('menu-open', open);
      document.body.style.overflow = open ? 'hidden' : '';
      if (lenis) { open ? lenis.stop() : lenis.start(); }

      if (open) {
        lastFocus = document.activeElement;
        tl.play();
        window.setTimeout(function () { if (items[0]) items[0].focus(); }, 500);
      } else {
        tl.reverse();
        tl.eventCallback('onReverseComplete', function () {
          gsap.set(menu, { visibility: 'hidden' });
        });
        if (lastFocus) lastFocus.focus();
      }
    }

    toggle.addEventListener('click', function () { setOpen(!open); });
    menu.addEventListener('click', function (e) { if (e.target.tagName === 'A') setOpen(false); });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && open) setOpen(false);
      if (e.key === 'Tab' && open) {
        // keep focus inside the open menu
        var focusable = $$('a, button', menu);
        if (!focusable.length) return;
        var first = focusable[0], last = focusable[focusable.length - 1];
        if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
        else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
      }
    });

    // Hovering a link swaps the preview image. If the WebGL layer came up it
    // does the swap with a displacement; if it did not, the plain CSS crossfade
    // below is what runs, and nobody can tell a feature is missing.
    items.forEach(function (a, i) {
      a.addEventListener('mouseenter', function () {
        var n = i % preview.length;
        if (glPreview) { glPreview.show(n); return; }
        preview.forEach(function (img, m) { img.classList.toggle('is-active', m === n); });
      });
    });
    if (preview[0]) preview[0].classList.add('is-active');

    // the preview only needs to draw while the menu is on screen
    menuIsOpen = function () { return open; };
  }
  var menuIsOpen = function () { return false; };

  /* --------------------------------------------------------------------------
     8. Cursor. A ring that lags behind a dot, and takes a label from whatever
         it is over.
     -------------------------------------------------------------------------- */
  function initCursor() {
    var ring = document.createElement('div');
    ring.className = 'vh-cursor';
    ring.innerHTML = '<span class="vh-cursor-label"></span>';
    var dot = document.createElement('div');
    dot.className = 'vh-cursor-dot';
    document.body.appendChild(ring);
    document.body.appendChild(dot);
    root.classList.add('has-cursor');

    var label = $('.vh-cursor-label', ring);
    var xTo = gsap.quickTo(ring, 'x', { duration: 0.5, ease: 'power3' });
    var yTo = gsap.quickTo(ring, 'y', { duration: 0.5, ease: 'power3' });
    var xDot = gsap.quickTo(dot, 'x', { duration: 0.12, ease: 'power3' });
    var yDot = gsap.quickTo(dot, 'y', { duration: 0.12, ease: 'power3' });

    window.addEventListener('pointermove', function (e) {
      xTo(e.clientX); yTo(e.clientY);
      xDot(e.clientX); yDot(e.clientY);
    }, { passive: true });

    document.addEventListener('pointerover', function (e) {
      var t = e.target.closest('[data-cursor], a, button, .ba, video');
      if (!t) {
        ring.removeAttribute('data-state');
        gsap.to(ring, { scale: 1, duration: 0.3 });
        label.textContent = '';
        return;
      }
      /*
       * On a before/after figure the lens is already the pointer's affordance,
       * and it lands on the mouth — which is the one part of the picture the
       * ring and its label were covering up. So the cursor gets out of the way
       * there and only labels the figure while it is being dragged.
       */
      if (t.closest && t.closest('.ba[data-mode="lens"]')) {
        root.classList.add('cursor-hidden');
        label.textContent = '';
        return;
      }
      root.classList.remove('cursor-hidden');

      var state = t.getAttribute('data-cursor')
        || (t.tagName === 'VIDEO' ? 'media'
        : (t.classList.contains('ba') ? 'drag' : 'link'));
      ring.setAttribute('data-state', state);
      label.textContent = t.getAttribute('data-cursor-label')
        || (state === 'media' ? 'Play' : state === 'drag' ? 'Drag' : '');
      gsap.to(ring, { scale: state === 'link' ? 1.5 : 1.9, duration: 0.35, ease: 'expo.out' });
    });

    // never leave a stray cursor behind when the pointer leaves the window
    document.addEventListener('mouseleave', function () { root.classList.add('cursor-hidden'); });
    document.addEventListener('mouseenter', function () { root.classList.remove('cursor-hidden'); });
  }

  /* --------------------------------------------------------------------------
     9. Page transitions.
         Uses the browser's own View Transitions where available; elsewhere a
         short veil covers the navigation. Either way the link still works if
         anything goes wrong — nothing is intercepted that would block it.
     -------------------------------------------------------------------------- */
  function initPageTransitions() {
    var veil = document.createElement('div');
    veil.className = 'vh-veil';
    document.body.appendChild(veil);
    gsap.set(veil, { scaleY: 0 });

    /*
     * No arrival animation. There used to be one — the veil was set to cover
     * the viewport and then lifted over 0.7s, so the page appeared to be
     * revealed. It cannot work, because this file runs after the browser has
     * already painted: what a visitor actually saw was the page, then a black
     * screen dropped over it, then the page again. On a phone the black frame
     * lasted long enough to look like a fault.
     *
     * The only way to lift a curtain is to have the curtain down before the
     * first paint, which would mean shipping a page that is deliberately blank
     * until JavaScript arrives — worse to look at, and a blank site if the
     * script ever fails. So the veil is now only what it can be honestly: a
     * wipe on the way OUT, covering the gap while the next page loads.
     */

    document.addEventListener('click', function (e) {
      var a = e.target.closest('a');
      if (!a) return;
      if (e.metaKey || e.ctrlKey || e.shiftKey || e.button !== 0) return;
      if (a.target === '_blank' || a.hasAttribute('download')) return;

      var url;
      try { url = new URL(a.href); } catch (err) { return; }
      if (url.origin !== window.location.origin) return;
      if (url.pathname === window.location.pathname && url.hash) return;
      if (/\.(pdf|zip|mp4|jpe?g|png|webp)$/i.test(url.pathname)) return;

      e.preventDefault();
      gsap.fromTo(veil,
        { scaleY: 0, transformOrigin: '50% 100%' },
        {
          scaleY: 1,
          duration: 0.55,
          ease: 'expo.inOut',
          onComplete: function () { window.location.href = a.href; }
        });
    });

    // coming back through history should not land on a covered page
    window.addEventListener('pageshow', function (ev) {
      if (ev.persisted) gsap.set(veil, { scaleY: 0 });
    });
  }

  /* --------------------------------------------------------------------------
     10. WebGL

     Loaded last and separately, because it is the one piece nothing else
     depends on. If gl.js never arrives, or the GPU refuses a context, or the
     visitor is on a phone or has asked the browser to save data, every element
     it would have enhanced is already on screen and already works.
     -------------------------------------------------------------------------- */
  var glPreview = null;

  function initWebGL() {
    if (!wide.matches) return;                                   // phones keep the plain image
    if (!window.matchMedia('(pointer:fine)').matches) return;     // and so does anything touch-first
    var conn = navigator.connection;
    if (conn && (conn.saveData || /2g/.test(conn.effectiveType || ''))) return;
    if (navigator.deviceMemory && navigator.deviceMemory < 4) return;

    loadScript(BASE + '/js/gl.js').then(function () {
      if (!window.VHGL || !VHGL.supported()) return;

      // the treatment cards
      var field = VHGL.hoverField('.svc-card');
      if (field) root.classList.add('has-gl');

      // the menu preview
      var box = $('.vh-menu__preview');
      if (box) {
        glPreview = VHGL.previewFade(box);
        if (glPreview) {
          box.classList.add('has-gl');
          // stop drawing whenever the menu is closed; there is no point burning
          // a frame budget on a canvas behind a clip-path
          glPreview.stop();
          var toggle = $('.menu-toggle');
          if (toggle) {
            toggle.addEventListener('click', function () {
              window.setTimeout(function () {
                menuIsOpen() ? glPreview.start() : glPreview.stop();
              }, 0);
            });
          }
          document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') window.setTimeout(function () { glPreview.stop(); }, 0);
          });
        }
      }
    }).catch(function (e) {
      if (window.console) console.warn('[veahealth] WebGL layer skipped —', e.message);
    });
  }
})();
