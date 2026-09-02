/**
 * Section reveals for the Explore Cards pattern.
 *
 * Mirrors the approved mockup: the intro block and the two cards rise into
 * place as they are scrolled to, in batches so a row arrives together rather
 * than one card at a time, and the inked underline strokes itself across the
 * word it marks.
 *
 * Everything here is enhancement. Nothing is hidden in the stylesheet — the
 * section renders complete and static with JavaScript off, or with reduced
 * motion on, and this file only winds elements back once it is certain it can
 * play them forward again.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

(function () {
  "use strict";

  var section = document.querySelector(".iflynepal-explore");

  if (!section) {
    return;
  }

  var reduced = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  // No GSAP, or motion is unwelcome: the section is already in its finished
  // state, so there is nothing to do.
  if (reduced || typeof window.gsap === "undefined" || !window.ScrollTrigger) {
    return;
  }

  var gsap = window.gsap;
  var ScrollTrigger = window.ScrollTrigger;

  gsap.registerPlugin(ScrollTrigger);

  /* --------------------------------------------------------------- rise in */

  var reveals = Array.prototype.slice.call(
    document.querySelectorAll(
      ".iflynepal-explore__intro, .iflynepal-explore__card",
    ),
  );

  if (reveals.length) {
    gsap.set(reveals, { opacity: 0, y: 26 });

    // Batched so cards that come into view together animate together.
    ScrollTrigger.batch(reveals, {
      start: "top 88%",
      once: true,
      interval: 0.12,
      batchMax: 6,
      onEnter: function (batch) {
        gsap.to(batch, {
          opacity: 1,
          y: 0,
          duration: 0.85,
          stagger: 0.08,
          overwrite: true,
        });
      },
    });
  }

  /* ------------------------------------------------------------- underline */

  /*
   * The mark is a pseudo-element, which GSAP cannot tween directly, so the
   * stylesheet reads its scale from a custom property and the property is what
   * gets animated. Winding back happens here rather than in the stylesheet, so
   * the mark is never missing when this file is not running.
   */
  gsap.utils
    .toArray(
      ".iflynepal-explore__underline, .iflynepal-explore__title .underline",
    )
    .forEach(function (mark) {
      gsap.set(mark, { "--iflynepal-underline-scale": 0 });

      /*
       * Slower than the mockup's 0.75s, and started a little later, on
       * purpose. At that speed the stroke was over before a visitor
       * scrolling at any pace had the heading settled in front of them —
       * the mark was simply there, and the drawing went unseen. This
       * duration, beginning once the heading is properly in view, keeps
       * it playing while the reader is looking at it.
       */
      gsap.to(mark, {
        "--iflynepal-underline-scale": 1,
        duration: 0.9,
        ease: "power1.inOut",
        scrollTrigger: {
          trigger: mark,
          start: "top 80%",
          once: true,
        },
      });
    });

  window.addEventListener("load", function () {
    ScrollTrigger.refresh();
  });
})();
