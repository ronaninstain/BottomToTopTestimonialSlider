=== Testimonials Slider – Elementor Widget ===
Author: Shoive Hossain
Version: 1.0.0
Requires: WordPress 5.8+, Elementor 3.5+

== INSTALLATION ==

1. Upload the entire `testimonials-slider-elementor` folder to:
   /wp-content/plugins/

   Your structure should look like:
   /wp-content/plugins/testimonials-slider-elementor/
     ├── testimonials-slider.php        ← main plugin file
     └── widget-testimonials-slider.php ← widget class

2. Go to WP Admin → Plugins → Activate "Testimonials Slider – Elementor Widget"

3. Open any page in Elementor editor.

4. In the left panel search for "Testimonials Slider" or find it under the General widgets category.

5. Drag it onto the canvas.

== ADDING / EDITING REVIEWS ==

• In the Elementor panel → Content → Reviews section click "+ Add Item".
• Each review item has:
    - Platform     : Google / Trustpilot / Reviews.io
    - Review Text  : the testimonial body
    - Author Name  : defaults to "Shoive Hossain"
    - Author Role  : optional company / job title
    - Initials     : 1–3 chars shown in the avatar circle
    - Avatar Color : background colour picker for the avatar

• Reviews are auto-distributed left → middle → right → left … across the 3 columns.
• Add 1 review → 1 card in column 1.
• Add 4 reviews → 2 cards in col 1, 1 in col 2, 1 in col 3. And so on.

== ANIMATION SETTINGS ==

Under Content → Animation you can tune:
  - Column 1 / 2 / 3 Speed (px per second)
  - Grid Height (px)

== STYLE SETTINGS ==

Under Style you can change:
  - Section background colour
  - Card background & border colour
  - Heading, sub-text, and review text colours

All other fine-grained colours (stars, platform logos, avatar backgrounds) are
controlled per-review through the Repeater above.

== RESPONSIVE BEHAVIOUR ==

  > 900 px  : 3 columns (full desktop)
  560–900 px : 2 columns (tablet)
  < 560 px  : 1 column  (mobile)

Columns are hidden progressively; the first column (col 1) is always visible.
