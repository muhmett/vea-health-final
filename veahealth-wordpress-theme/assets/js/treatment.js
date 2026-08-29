/* =============================================================================
   VeaHealth — treatment page behaviour

   Four small things, each of which the page works without:

     the contents rail highlights the section you are reading
     the procedure spine fills as you move down it
     the cost bars draw themselves once they are on screen
     the enquiry bar rises after the hero has gone

   No dependency on the motion layer. A visitor who has asked for reduced motion
   still gets the rail highlighting and the enquiry bar — those are wayfinding,
   not decoration — but nothing animates.
   ============================================================================= */
(function () {
  'use strict';

  var $  = function (s, c) { return (c || document).querySelector(s); };
  var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };

  if (!$('.treatment')) return;

  var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var io = 'IntersectionObserver' in window;

  /* --------------------------------------------------------------------------
     1. Contents rail
     Highlights whichever section currently owns the upper third of the screen.
     A plain "topmost visible section" test flickers on short sections, so the
     rail tracks the last heading the reader has passed instead.
     -------------------------------------------------------------------------- */
  function initRail() {
    var links = $$('.tp-rail__list a[data-spy]');
    if (!links.length) return;

    var targets = links
      .map(function (a) { return { a: a, el: document.getElementById(a.dataset.spy) }; })
      .filter(function (t) { return t.el; });
    if (!targets.length) return;

    var current = null;
    function update() {
      var line = window.innerHeight * 0.34;
      var found = targets[0];
      for (var i = 0; i < targets.length; i++) {
        if (targets[i].el.getBoundingClientRect().top <= line) found = targets[i];
      }
      if (found === current) return;
      if (current) current.a.classList.remove('is-current');
      found.a.classList.add('is-current');
      found.a.setAttribute('aria-current', 'true');
      if (current) current.a.removeAttribute('aria-current');
      current = found;
    }

    var ticking = false;
    window.addEventListener('scroll', function () {
      if (ticking) return;
      ticking = true;
      requestAnimationFrame(function () { update(); ticking = false; });
    }, { passive: true });
    window.addEventListener('resize', update, { passive: true });
    update();
  }

  /* --------------------------------------------------------------------------
     2. Procedure spine
     -------------------------------------------------------------------------- */
  function initSteps() {
    var list = $('.tp-steps');
    if (!list) return;
    var fill  = $('.tp-steps__spine i', list);
    var steps = $$('.tp-step', list);
    if (!steps.length) return;

    if (reduced) {
      steps.forEach(function (s) { s.classList.add('is-reached'); });
      return;
    }

    function update() {
      var line = window.innerHeight * 0.62;
      var reached = 0;
      steps.forEach(function (s) {
        var hit = s.getBoundingClientRect().top <= line;
        s.classList.toggle('is-reached', hit);
        if (hit) reached++;
      });
      if (fill) {
        // fill to the last marker reached, not past it
        fill.style.transform = 'scaleY(' + (reached / steps.length).toFixed(3) + ')';
        fill.style.transition = 'transform .35s linear';
      }
    }

    var ticking = false;
    window.addEventListener('scroll', function () {
      if (ticking) return;
      ticking = true;
      requestAnimationFrame(function () { update(); ticking = false; });
    }, { passive: true });
    update();
  }

  /* --------------------------------------------------------------------------
     3. Cost bars
     The widths are already in the markup as inline custom properties, so the
     bars are correct with no JavaScript at all; this only delays the draw until
     the panel is in view so the comparison is watched rather than missed.
     -------------------------------------------------------------------------- */
  function initCost() {
    var panel = $('.tp-cost');
    if (!panel) return;
    if (reduced || !io) { panel.classList.add('is-drawn'); return; }

    new IntersectionObserver(function (entries, obs) {
      entries.forEach(function (e) {
        if (!e.isIntersecting) return;
        // stagger by row so the eye follows the comparison down the panel
        $$('.tp-cost-bar span', panel).forEach(function (bar, i) {
          bar.style.transitionDelay = (i * 90) + 'ms';
        });
        panel.classList.add('is-drawn');
        obs.disconnect();
      });
    }, { threshold: 0.25 }).observe(panel);
  }

  /* --------------------------------------------------------------------------
     4. Enquiry bar
     Up once the hero is behind you, down again at the closing call to action so
     it never covers the form it is pointing at.
     -------------------------------------------------------------------------- */
  function initBar() {
    var bar = $('[data-tp-bar]');
    var hero = $('.tp-hero');
    if (!bar || !hero) return;
    bar.hidden = false;

    var band = $('.cta-band');
    function update() {
      var past = hero.getBoundingClientRect().bottom < 0;
      var atEnd = band ? band.getBoundingClientRect().top < window.innerHeight : false;
      bar.classList.toggle('is-up', past && !atEnd);
    }
    var ticking = false;
    window.addEventListener('scroll', function () {
      if (ticking) return;
      ticking = true;
      requestAnimationFrame(function () { update(); ticking = false; });
    }, { passive: true });
    update();
  }

  /* --------------------------------------------------------------------------
     5. Copy a section link
     -------------------------------------------------------------------------- */
  function initAnchors() {
    if (!navigator.clipboard) return;
    $$('.tp-anchor').forEach(function (a) {
      a.addEventListener('click', function (e) {
        e.preventDefault();
        var url = location.origin + location.pathname + a.getAttribute('href');
        navigator.clipboard.writeText(url).then(function () {
          history.replaceState(null, '', a.getAttribute('href'));
          a.textContent = '✓';
          window.setTimeout(function () { a.textContent = '#'; }, 1400);
        }).catch(function () { location.hash = a.getAttribute('href'); });
      });
    });
  }

  /*
     Measure the sticky header once, so the rail parks below it and an anchored
     section lands below it too. Hard-coding the height means every change to
     the header quietly breaks both.
   */
  function measureHeader() {
    var header = $('.site-header');
    if (!header) return;
    var set = function () {
      document.documentElement.style.setProperty('--header-h', Math.round(header.getBoundingClientRect().height) + 'px');
    };
    set();
    window.addEventListener('resize', set, { passive: true });
  }

  function boot() {
    measureHeader();
    initRail();
    initSteps();
    initCost();
    initBar();
    initAnchors();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }
})();
