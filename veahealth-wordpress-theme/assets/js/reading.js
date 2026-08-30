/* =============================================================================
   VeaHealth — reading behaviour

   Four things, none of which the article needs in order to be readable:

     a progress bar that measures the article rather than the page
     the contents list tracking the section you are in
     each block lifting slightly as it arrives
     the contents fold closing itself once you have used it, on a phone

   No dependency on the motion layer. Reduced motion keeps the progress bar and
   the contents tracking — those are wayfinding — and drops the reveal.
   ============================================================================= */
(function () {
  'use strict';

  var $  = function (s, c) { return (c || document).querySelector(s); };
  var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };

  var article = $('.post-body');
  if (!article) return;

  var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var wide    = window.matchMedia('(min-width: 1100px)');

  /* --------------------------------------------------------------------------
     Header height, so the sticky rail parks below it and an anchored heading
     lands below it too.
     -------------------------------------------------------------------------- */
  (function measureHeader() {
    var header = $('.site-header');
    if (!header) return;
    var set = function () {
      document.documentElement.style.setProperty(
        '--header-h', Math.round(header.getBoundingClientRect().height) + 'px');
    };
    set();
    window.addEventListener('resize', set, { passive: true });
  })();

  /* --------------------------------------------------------------------------
     1. Progress
     Measured from the top of the body to the point where the last line clears
     the bottom of the window, so it reaches 100% when you have actually read
     to the end rather than when the footer arrives.
     -------------------------------------------------------------------------- */
  function initProgress() {
    var bar = document.createElement('div');
    bar.className = 'read-progress';
    bar.setAttribute('aria-hidden', 'true');
    bar.innerHTML = '<span></span>';
    document.body.appendChild(bar);
    var fill = bar.firstChild;

    function update() {
      var box = article.getBoundingClientRect();
      var total = box.height - window.innerHeight;
      var done = total > 0 ? Math.min(1, Math.max(0, -box.top / total)) : (box.top < 0 ? 1 : 0);
      fill.style.transform = 'scaleX(' + done.toFixed(4) + ')';
    }
    onScroll(update);
    update();
  }

  /* --------------------------------------------------------------------------
     2. Contents tracking
     -------------------------------------------------------------------------- */
  function initSpy() {
    var links = $$('.post-toc a[href^="#"]');
    if (!links.length) return;

    var targets = links
      .map(function (a) { return { a: a, el: document.getElementById(a.getAttribute('href').slice(1)) }; })
      .filter(function (t) { return t.el; });
    if (!targets.length) return;

    var current = null;
    function update() {
      var line = window.innerHeight * 0.3;
      var found = targets[0];
      for (var i = 0; i < targets.length; i++) {
        if (targets[i].el.getBoundingClientRect().top <= line) found = targets[i];
      }
      if (found === current) return;
      if (current) { current.a.classList.remove('is-current'); current.a.removeAttribute('aria-current'); }
      found.a.classList.add('is-current');
      found.a.setAttribute('aria-current', 'true');
      current = found;
    }
    onScroll(update);
    update();

    /*
     * On a phone the contents is a <details>. Leaving it open after a jump
     * means the reader lands on a heading with the whole list still covering
     * the text under it, so it closes itself once it has been used.
     */
    var fold = $('.post-toc');
    if (fold && fold.tagName === 'DETAILS') {
      // open where it becomes a rail, closed where it would be the first screen
      var fit = function () { fold.open = wide.matches; };
      fit();
      if (wide.addEventListener) wide.addEventListener('change', fit);

      links.forEach(function (a) {
        a.addEventListener('click', function () {
          if (!wide.matches) fold.open = false;
        });
      });
    }
  }

  /* --------------------------------------------------------------------------
     3. Reveal
     -------------------------------------------------------------------------- */
  function initReveal() {
    if (reduced || !('IntersectionObserver' in window)) return;

    // Mark the blocks rather than every node: revealing a list item at a time
    // makes a list feel like it is being typed at you.
    var blocks = $$(':scope > *', article).filter(function (el) {
      return !el.classList.contains('post-toc');
    });
    if (!blocks.length) return;

    blocks.forEach(function (el) { el.setAttribute('data-r', ''); });

    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (!e.isIntersecting) return;
        e.target.classList.add('is-in');
        io.unobserve(e.target);
      });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.05 });

    blocks.forEach(function (el) { io.observe(el); });

    /*
     * Anything already on screen at load is shown at once. Without this the
     * first two paragraphs fade in after the page has settled, which reads as
     * the page still loading.
     */
    window.requestAnimationFrame(function () {
      blocks.forEach(function (el) {
        if (el.getBoundingClientRect().top < window.innerHeight * 0.92) {
          el.classList.add('is-in');
          io.unobserve(el);
        }
      });
    });
  }

  /** One rAF-throttled scroll listener per caller. */
  function onScroll(fn) {
    var ticking = false;
    window.addEventListener('scroll', function () {
      if (ticking) return;
      ticking = true;
      window.requestAnimationFrame(function () { fn(); ticking = false; });
    }, { passive: true });
    window.addEventListener('resize', fn, { passive: true });
  }

  function boot() {
    initProgress();
    initSpy();
    initReveal();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }
})();
