# Hero media

Drop the hero footage here as `hero-nepal.mp4`, then set its URL under
**Appearance > Customize > Hero Background** (Video URL).

Encoding: H.264, roughly an 8 second loop, no audio track, ~1600px wide.
Keep it under 2 MB — it competes with the hero still for bandwidth during the
largest paint.

## How it loads

`template-parts/home/hero-section.php` renders the `<video>` with the source on
a `<source>` child, `preload` set to `none` and no `autoplay`, so the
browser fetches nothing on its own. `assets/js/hero.js` then calls `load()` only
when the clip is worth its bytes — not on viewports at or below 760px, not under
Data Saver, and not under `prefers-reduced-motion`. Everyone else gets the clip
fading in over the still once it is genuinely playable.

Where the clip is skipped or missing, the still image underneath simply stays
put. That is the intended fallback; nothing breaks, and the still is the same
picture the poster frame shows.

The still, the poster frame and an optional second video source are set under
**Appearance > Customize > Hero Background**.
