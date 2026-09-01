/* =============================================================================
   VeaHealth Turkey — site behaviour
   No external dependencies. Everything degrades: with JS disabled the page is
   fully readable, all content visible, all links working.
   ============================================================================= */
(function () {
  'use strict';

  var root = document.documentElement;
  root.classList.add('js');

  var reduced = window.matchMedia('(prefers-reduced-motion: reduce)');
  var isReduced = function () { return reduced.matches; };

  var $  = function (s, c) { return (c || document).querySelector(s); };
  var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };

  /* ---------------------------------------------------------------------------
     1. Scroll reveal — IntersectionObserver, with stagger inside a group
     --------------------------------------------------------------------------- */
  function initReveal() {
    var targets = $$('[data-anim], .reveal-lines');
    if (!targets.length) return;

    if (isReduced() || !('IntersectionObserver' in window)) {
      targets.forEach(function (el) { el.classList.add('is-in'); });
      return;
    }

    // stagger children of any [data-stagger] container
    $$('[data-stagger]').forEach(function (group) {
      var gap = parseInt(group.getAttribute('data-stagger'), 10) || 80;
      $$('[data-anim]', group).forEach(function (el, i) {
        el.style.setProperty('--d', (i * gap) + 'ms');
      });
    });

    // split headline text into lines for the mask reveal
    $$('.reveal-lines').forEach(function (el) {
      if (el.dataset.split === 'done') return;
      var lines = el.innerHTML.split(/<br\s*\/?>/i);
      el.innerHTML = lines.map(function (line, i) {
        return '<span class="rl" style="--d:' + (i * 110) + 'ms"><span>' + line + '</span></span>';
      }).join('');
      el.dataset.split = 'done';
    });

    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (!e.isIntersecting) return;
        e.target.classList.add('is-in');
        io.unobserve(e.target);
      });
    }, { rootMargin: '0px 0px -12% 0px', threshold: 0.06 });

    targets.forEach(function (el) { io.observe(el); });
  }

  /* ---------------------------------------------------------------------------
     2. Header state + scroll progress + floating WhatsApp
     --------------------------------------------------------------------------- */
  function initScrollChrome() {
    var header = $('.site-header');
    var bar    = $('.scroll-progress');
    var wa     = $('.wa-float');
    var ticking = false;

    function frame() {
      var y = window.scrollY || window.pageYOffset;
      if (header) header.classList.toggle('is-stuck', y > 8);
      if (bar) {
        var h = document.documentElement.scrollHeight - window.innerHeight;
        bar.style.transform = 'scaleX(' + (h > 0 ? Math.min(y / h, 1) : 0) + ')';
      }
      if (wa) wa.classList.toggle('is-in', y > 420);
      ticking = false;
    }
    function onScroll() {
      if (ticking) return;
      ticking = true;
      window.requestAnimationFrame(frame);
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onScroll, { passive: true });
    frame();
  }

  /* ---------------------------------------------------------------------------
     3. Parallax — transform only, rAF-throttled, skipped when reduced
     --------------------------------------------------------------------------- */
  function initParallax() {
    var layers = $$('[data-parallax]');
    if (!layers.length || isReduced()) return;

    var ticking = false;
    function frame() {
      var vh = window.innerHeight;
      layers.forEach(function (el) {
        var r = el.getBoundingClientRect();
        if (r.bottom < -200 || r.top > vh + 200) return;
        var speed = parseFloat(el.getAttribute('data-parallax')) || 0.15;
        var progress = (r.top + r.height / 2 - vh / 2) / vh; // -1 .. 1
        el.style.transform = 'translate3d(0,' + (progress * speed * 100).toFixed(2) + 'px,0)';
      });
      ticking = false;
    }
    function onScroll() {
      if (ticking) return;
      ticking = true;
      window.requestAnimationFrame(frame);
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onScroll, { passive: true });
    frame();
  }

  /* ---------------------------------------------------------------------------
     4. Count-up numbers
     --------------------------------------------------------------------------- */
  function initCounters() {
    var nodes = $$('[data-count]');
    if (!nodes.length) return;
    if (isReduced() || !('IntersectionObserver' in window)) {
      nodes.forEach(function (n) { n.textContent = n.getAttribute('data-count'); });
      return;
    }
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (!e.isIntersecting) return;
        var el = e.target;
        io.unobserve(el);
        var target = parseFloat(el.getAttribute('data-count'));
        var suffix = el.getAttribute('data-suffix') || '';
        var dur = 1400, t0 = null;
        function tick(ts) {
          if (t0 === null) t0 = ts;
          var p = Math.min((ts - t0) / dur, 1);
          var eased = 1 - Math.pow(1 - p, 3);
          var v = target * eased;
          el.textContent = (target % 1 === 0 ? Math.round(v) : v.toFixed(1)) + suffix;
          if (p < 1) window.requestAnimationFrame(tick);
        }
        window.requestAnimationFrame(tick);
      });
    }, { threshold: 0.4 });
    nodes.forEach(function (n) { io.observe(n); });
  }

  /* ---------------------------------------------------------------------------
     5. Before / after — a lens on a mouse, a divider on a finger

        Both photographs are pre-aligned, so the top one sits exactly over the
        bottom one and a single clip-path decides how much of it shows. The
        divider is an inset; the lens is a circle. Under both is a real
        <input type=range>, which is what makes the thing keyboard operable and
        screen-reader announced without any ARIA of its own.

        Which mode a figure is in follows the pointer that touched it, not the
        screen width: a laptop with a touchscreen gets whichever the visitor
        actually used, and focusing the range with a keyboard returns it to the
        divider, because there is no pointer to put a lens under.
     --------------------------------------------------------------------------- */
  function initBeforeAfter() {
    var fine = window.matchMedia('(hover: hover) and (pointer: fine)');
    var still = window.matchMedia('(prefers-reduced-motion: reduce)');

    $$('.ba[data-ba]').forEach(function (ba) {
      var range  = $('.ba-range', ba);
      var handle = $('.ba-handle', ba);
      if (!range || !handle) return;

      var raf = 0, want = null;

      function divider(v) {
        ba.dataset.mode = 'divider';
        ba.style.setProperty('--ba-pos', v + '%');
        handle.style.left = v + '%';
      }

      function lens(x, y) {
        ba.dataset.mode = 'lens';
        // Sized to the frame, so the lens covers a mouth at any rendered width.
        ba.style.setProperty('--ba-r', Math.round(ba.clientWidth * 0.26) + 'px');
        ba.style.setProperty('--ba-x', x + 'px');
        ba.style.setProperty('--ba-y', y + 'px');
      }

      function closeLens() {
        ba.style.setProperty('--ba-r', '0px');
      }

      function schedule(fn) {
        want = fn;
        if (raf) return;
        raf = requestAnimationFrame(function () { raf = 0; var f = want; want = null; if (f) f(); });
      }

      range.addEventListener('input', function () { divider(this.value); });
      // Arriving by keyboard means there is no pointer to follow.
      range.addEventListener('focus', function () { divider(range.value); });

      divider(range.value);

      var dragging = false;

      function pct(clientX) {
        var r = ba.getBoundingClientRect();
        return Math.max(0, Math.min(100, ((clientX - r.left) / r.width) * 100));
      }

      ba.addEventListener('pointermove', function (e) {
        ba.dataset.touched = '1';
        if (dragging) {
          var v = pct(e.clientX);
          range.value = v;
          schedule(function () { divider(v); });
          return;
        }
        if (e.pointerType === 'mouse' && fine.matches && !still.matches) {
          var r = ba.getBoundingClientRect();
          var x = e.clientX - r.left, y = e.clientY - r.top;
          schedule(function () { lens(x, y); });
        }
      });

      ba.addEventListener('pointerleave', function () {
        if (ba.dataset.mode === 'lens') closeLens();
      });

      ba.addEventListener('pointerdown', function (e) {
        // A press means the divider, whatever the pointer: it is the mode you
        // can hold still and read, and it is the only one a finger can drive.
        dragging = true;
        ba.dataset.touched = '1';
        ba.setPointerCapture(e.pointerId);
        var v = pct(e.clientX);
        range.value = v;
        divider(v);
      });

      ba.addEventListener('pointerup', function (e) {
        dragging = false;
        if (ba.hasPointerCapture && ba.hasPointerCapture(e.pointerId)) ba.releasePointerCapture(e.pointerId);
      });
      ba.addEventListener('pointercancel', function () { dragging = false; });
    });
  }

  /* ---------------------------------------------------------------------------
     5b. Language menu

        A disclosure, not a role="menu". These are links to pages, so the
        browser's own behaviour is the right behaviour: Tab moves through them,
        Enter follows one. What is added is only what a dropdown owes the
        keyboard — Escape closes it and hands focus back to the button, arrows
        walk the list for a pointer-free user, and a click anywhere else closes
        it. Without JavaScript nothing can open the panel, so CSS drops the
        button and lays the four links out flat instead: changing language is
        not a thing to take away from somebody whose script did not load.
     --------------------------------------------------------------------------- */
  function initLangMenu() {
    $$('[data-lang]').forEach(function (wrap) {
      var btn  = $('.lang-btn', wrap);
      var menu = $('.lang-menu', wrap);
      if (!btn || !menu) return;

      var links = function () { return $$('a', menu); };

      function open(focusFirst) {
        menu.hidden = false;
        btn.setAttribute('aria-expanded', 'true');
        if (focusFirst) { var a = links()[0]; if (a) a.focus(); }
      }
      function close(giveBack) {
        menu.hidden = true;
        btn.setAttribute('aria-expanded', 'false');
        if (giveBack) btn.focus();
      }
      function isOpen() { return btn.getAttribute('aria-expanded') === 'true'; }

      btn.addEventListener('click', function (e) {
        e.stopPropagation();
        isOpen() ? close(false) : open(false);
      });

      btn.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowDown') { e.preventDefault(); open(true); }
      });

      /*
       * Escape is bound to the whole control, not to the panel. Opening with
       * the mouse leaves focus on the button, so a handler on the panel alone
       * never hears the key most people reach for first.
       */
      wrap.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
          if (!isOpen()) return;
          e.preventDefault();
          close(true);
          return;
        }
        if (e.key !== 'ArrowDown' && e.key !== 'ArrowUp') return;
        var all = links();
        if (!all.length || !menu.contains(document.activeElement)) return;
        e.preventDefault();
        var i = all.indexOf(document.activeElement);
        ( e.key === 'ArrowDown' ? ( all[i + 1] || all[0] )
                                : ( all[i - 1] || all[all.length - 1] ) ).focus();
      });

      // Leaving the whole control by any means closes it, so a menu never
      // stays open behind the page the visitor has moved on to.
      document.addEventListener('click', function (e) {
        if (isOpen() && !wrap.contains(e.target)) close(false);
      });
      wrap.addEventListener('focusout', function (e) {
        if (isOpen() && !wrap.contains(e.relatedTarget)) close(false);
      });
    });
  }

  /* ---------------------------------------------------------------------------
     6. Mobile navigation
     --------------------------------------------------------------------------- */
  function initNav() {
    var burger = $('.burger');
    var panel  = $('.mobile-nav');
    if (!burger || !panel) return;

    function setOpen(open) {
      burger.setAttribute('aria-expanded', open ? 'true' : 'false');
      panel.classList.toggle('is-open', open);
      document.body.style.overflow = open ? 'hidden' : '';
    }
    burger.addEventListener('click', function () {
      setOpen(burger.getAttribute('aria-expanded') !== 'true');
    });
    panel.addEventListener('click', function (e) {
      if (e.target.tagName === 'A') setOpen(false);
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') setOpen(false);
    });
    window.addEventListener('resize', function () {
      if (window.innerWidth > 1080) setOpen(false);
    });
  }

  /* ---------------------------------------------------------------------------
     7. Magnetic buttons — small, cheap, pointer-only
     --------------------------------------------------------------------------- */
  function initMagnets() {
    if (isReduced() || !window.matchMedia('(pointer:fine)').matches) return;
    $$('.magnet').forEach(function (el) {
      el.addEventListener('pointermove', function (e) {
        var r = el.getBoundingClientRect();
        var x = (e.clientX - r.left - r.width / 2) * 0.18;
        var y = (e.clientY - r.top - r.height / 2) * 0.28;
        el.style.transform = 'translate(' + x.toFixed(1) + 'px,' + y.toFixed(1) + 'px)';
      });
      el.addEventListener('pointerleave', function () { el.style.transform = ''; });
    });
  }

  /* ---------------------------------------------------------------------------
     8. Cookie consent — Google tags stay blocked until the visitor accepts.
        Consent is stored per browser; nothing leaves the page before that.
     --------------------------------------------------------------------------- */
  var CONSENT_KEY = 'vh-consent';

  function readConsent() {
    try { return localStorage.getItem(CONSENT_KEY); } catch (e) { return null; }
  }
  function writeConsent(v) {
    try { localStorage.setItem(CONSENT_KEY, v); } catch (e) { /* private mode */ }
  }

  function loadAnalytics() {
    var id = root.getAttribute('data-ga');
    if (!id || window.__vhGaLoaded) return;
    window.__vhGaLoaded = true;
    var s = document.createElement('script');
    s.async = true;
    s.src = 'https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(id);
    document.head.appendChild(s);
    window.dataLayer = window.dataLayer || [];
    window.gtag = function () { window.dataLayer.push(arguments); };
    window.gtag('js', new Date());
    window.gtag('config', id, { anonymize_ip: true });
  }

  function initConsent() {
    var banner = $('.cookie');
    var state = readConsent();
    if (state === 'all') { loadAnalytics(); return; }
    if (state === 'necessary') return;
    if (!banner) return;

    /* The banner is pinned to the bottom of the screen and the floating
       WhatsApp button lives in the same corner, so on a phone the banner
       buries it. Flagging the state on <html> lets the button hold its
       off-screen position until the visitor has answered — the same class of
       fix, and the same mechanism, as the open mobile menu. */
    function show() { banner.classList.add('is-in'); root.classList.add('cookie-open'); }
    function dismiss() { banner.classList.remove('is-in'); root.classList.remove('cookie-open'); }

    window.setTimeout(show, 900);

    var accept = $('[data-consent="all"]', banner);
    var reject = $('[data-consent="necessary"]', banner);
    if (accept) accept.addEventListener('click', function () {
      writeConsent('all'); dismiss(); loadAnalytics();
    });
    if (reject) reject.addEventListener('click', function () {
      writeConsent('necessary'); dismiss();
    });
  }

  /* ---------------------------------------------------------------------------
     9. Enquiry form
        Multi-step, validated, and it always captures a reachable contact
        (email + phone) before offering the WhatsApp hand-off.
        Submission target is configured with data-endpoint on the form.
     --------------------------------------------------------------------------- */
  function initForm() {
    var form = $('#enquiry-form');
    if (!form) return;

    var steps  = $$('.form-step', form);
    var bars   = $$('.form-steps .fs', form);
    var status = $('.form-status', form);
    var idx = 0;

    function show(i) {
      idx = Math.max(0, Math.min(steps.length - 1, i));
      steps.forEach(function (s, n) { s.classList.toggle('is-active', n === idx); });
      bars.forEach(function (b, n) {
        b.classList.toggle('is-done', n < idx);
        b.classList.toggle('is-active', n === idx);
      });
      var h = form.querySelector('.form-step.is-active h2, .form-step.is-active h3');
      if (h) h.setAttribute('tabindex', '-1'), h.focus({ preventScroll: true });
    }

    function fieldError(input, msg) {
      var wrap = input.closest('.field');
      var slot = wrap ? $('.field-error', wrap) : null;
      input.setAttribute('aria-invalid', msg ? 'true' : 'false');
      if (slot) slot.textContent = msg || '';
      return !msg;
    }

    function validateStep(n) {
      var ok = true;
      $$('.form-step', form)[n].querySelectorAll('[required]').forEach(function (input) {
        var v = (input.value || '').trim();
        var msg = '';
        if (!v) {
          msg = 'This field is required.';
        } else if (input.type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(v)) {
          msg = 'Enter a valid email address, for example name@example.com.';
        } else if (input.type === 'tel' && v.replace(/[^\d]/g, '').length < 7) {
          msg = 'Enter a phone number including your country code.';
        }
        if (!fieldError(input, msg)) ok = false;
      });
      return ok;
    }

    form.addEventListener('click', function (e) {
      var next = e.target.closest('[data-step="next"]');
      var prev = e.target.closest('[data-step="prev"]');
      if (next) { if (validateStep(idx)) show(idx + 1); }
      if (prev) { show(idx - 1); }
    });

    // live-clear errors as the visitor types
    form.addEventListener('input', function (e) {
      if (e.target.getAttribute('aria-invalid') === 'true') fieldError(e.target, '');
    });

    function collect() {
      var fd = new FormData(form);
      var treatments = fd.getAll('treatments');
      return {
        firstName: (fd.get('firstName') || '').trim(),
        lastName:  (fd.get('lastName')  || '').trim(),
        email:     (fd.get('email')     || '').trim(),
        phone:     (fd.get('phone')     || '').trim(),
        country:   (fd.get('country')   || '').trim(),
        timing:    (fd.get('timing')    || '').trim(),
        message:   (fd.get('message')   || '').trim(),
        treatments: treatments,
        page: window.location.pathname
      };
    }

    function waMessage(d) {
      var lines = [
        'New enquiry from veahealthturkey.com',
        'Name: ' + d.firstName + ' ' + d.lastName,
        'Email: ' + d.email,
        'Phone: ' + d.phone,
        'Country: ' + d.country,
        'Treatments: ' + (d.treatments.length ? d.treatments.join(', ') : '—'),
        'Timing: ' + d.timing
      ];
      if (d.message) lines.push('Message: ' + d.message);
      return lines.join('\n');
    }

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      if (form.querySelector('[name="company"]').value) return;  // honeypot
      var last = steps.length - 1;
      for (var n = 0; n <= last; n++) {
        if (!validateStep(n)) { show(n); return; }
      }
      var consent = $('[name="consent"]', form);
      if (consent && !consent.checked) {
        status.className = 'form-status is-err';
        status.textContent = 'Please confirm you agree to the privacy policy so we can reply to you.';
        return;
      }

      var data = collect();
      var endpoint = form.getAttribute('data-endpoint');
      var btn = $('[type="submit"]', form);
      var label = btn ? btn.textContent : '';
      if (btn) { btn.disabled = true; btn.textContent = 'Sending…'; }

      function done(ok) {
        if (btn) { btn.disabled = false; btn.textContent = label; }
        status.className = 'form-status ' + (ok ? 'is-ok' : 'is-err');
        status.textContent = ok
          ? 'Thank you. Your request has been received — a patient coordinator will reply within one working day. Opening WhatsApp so you can also reach us there right away.'
          : 'We could not send the form automatically. Please continue on WhatsApp or email info@veahealthturkey.com — your details have not been lost.';
        if (window.gtag) window.gtag('event', 'generate_lead', { method: ok ? 'form' : 'form_fallback' });
        var wa = form.getAttribute('data-whatsapp');
        if (wa) {
          window.setTimeout(function () {
            window.open(wa + '?text=' + encodeURIComponent(waMessage(data)), '_blank', 'noopener');
          }, 1200);
        }
      }

      if (!endpoint) { done(false); return; }

      fetch(endpoint, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body: JSON.stringify(data)
      }).then(function (r) { done(r.ok); }).catch(function () { done(false); });
    });

    show(0);
  }

  /* ---------------------------------------------------------------------------
     10. Smooth in-page anchors (respects reduced motion via CSS scroll-behavior)
     --------------------------------------------------------------------------- */
  function initAnchors() {
    document.addEventListener('click', function (e) {
      var a = e.target.closest('a[href^="#"]');
      if (!a) return;
      var id = a.getAttribute('href');
      if (id === '#' || id === '#main') return;
      var t = document.querySelector(id);
      if (!t) return;
      e.preventDefault();
      var top = t.getBoundingClientRect().top + window.scrollY - 90;
      window.scrollTo({ top: top, behavior: isReduced() ? 'auto' : 'smooth' });
      t.setAttribute('tabindex', '-1');
      t.focus({ preventScroll: true });
      history.replaceState(null, '', id);
    });
  }

  /* --------------------------------------------------------------------------- */
  function boot() {
    initReveal();
    initScrollChrome();
    initParallax();
    initCounters();
    initBeforeAfter();
    initLangMenu();
    initNav();
    initMagnets();
    initConsent();
    initForm();
    initAnchors();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }
})();
