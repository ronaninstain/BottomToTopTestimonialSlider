<?php
/**
 * Plugin Name:  Testimonials Slider – Elementor Widget
 * Description:  Drag-and-drop vertical testimonials slider for Elementor. Add any number of reviews dynamically.
 * Version:      1.1.0
 * Author:       Shoive Hossain
 * Requires Plugins: elementor
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* ─────────────────────────────────────────────────────────────
   Guard: only proceed when Elementor is fully loaded
───────────────────────────────────────────────────────────── */
add_action( 'plugins_loaded', function () {

    if ( ! did_action( 'elementor/loaded' ) ) return;

    /* Register the widget once Elementor's widget manager is ready */
    add_action( 'elementor/widgets/register', function ( $manager ) {

        /* ─────────────────────────────────────────────────────
           Widget Class (defined inside the hook so Elementor
           base classes are guaranteed to exist)
        ───────────────────────────────────────────────────── */
        class TS_Testimonials_Slider_Widget extends \Elementor\Widget_Base {

            public function get_name()       { return 'ts_testimonials_slider'; }
            public function get_title()      { return esc_html__( 'Testimonials Slider', 'ts' ); }
            public function get_icon()       { return 'eicon-testimonial-carousel'; }
            public function get_categories() { return [ 'general' ]; }
            public function get_keywords()   { return [ 'testimonials', 'reviews', 'slider', 'vertical' ]; }

            /* ── Controls ─────────────────────────────────── */
            protected function register_controls() {

                /* Section: Header */
                $this->start_controls_section( 'sec_header', [
                    'label' => esc_html__( 'Header', 'ts' ),
                    'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                ] );

                $this->add_control( 'heading', [
                    'label'   => esc_html__( 'Heading', 'ts' ),
                    'type'    => \Elementor\Controls_Manager::TEXTAREA,
                    'rows'    => 2,
                    'default' => "Professionals Who Levelled Up\nwith Our Training",
                ] );

                $this->add_control( 'subtext', [
                    'label'   => esc_html__( 'Sub-text', 'ts' ),
                    'type'    => \Elementor\Controls_Manager::TEXTAREA,
                    'rows'    => 2,
                    'default' => 'Hear from learners who improved compliance confidence, met organisational standards, and strengthened their CVs.',
                ] );

                $this->end_controls_section();

                /* Section: Reviews Repeater */
                $this->start_controls_section( 'sec_reviews', [
                    'label' => esc_html__( 'Reviews', 'ts' ),
                    'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                ] );

                $this->add_control( 'reviews_note', [
                    'type' => \Elementor\Controls_Manager::RAW_HTML,
                    'raw'  => '<small style="color:#a4afb7;line-height:1.6;display:block;padding:6px 0">Reviews are auto-distributed across <strong>3 columns</strong> (left &rarr; middle &rarr; right &rarr; left&hellip;). Add as many as you like.</small>',
                ] );

                $repeater = new \Elementor\Repeater();

                $repeater->add_control( 'platform', [
                    'label'   => esc_html__( 'Platform', 'ts' ),
                    'type'    => \Elementor\Controls_Manager::SELECT,
                    'default' => 'google',
                    'options' => [
                        'google'     => 'Google',
                        'trustpilot' => 'Trustpilot',
                        'reviews'    => 'Reviews.io',
                    ],
                ] );

                $repeater->add_control( 'review_text', [
                    'label'       => esc_html__( 'Review Text', 'ts' ),
                    'type'        => \Elementor\Controls_Manager::TEXTAREA,
                    'rows'        => 4,
                    'default'     => 'Great learning experience! The lessons are clear, well-structured, and the platform is easy to use.',
                    'placeholder' => esc_html__( 'Enter the review…', 'ts' ),
                ] );

                $repeater->add_control( 'author_name', [
                    'label'   => esc_html__( 'Author Name', 'ts' ),
                    'type'    => \Elementor\Controls_Manager::TEXT,
                    'default' => 'Shoive Hossain',
                ] );

                $repeater->add_control( 'author_role', [
                    'label'       => esc_html__( 'Role / Company', 'ts' ),
                    'type'        => \Elementor\Controls_Manager::TEXT,
                    'placeholder' => 'e.g. UI Designer, Acme Ltd',
                    'default'     => '',
                ] );

                $repeater->add_control( 'initials', [
                    'label'       => esc_html__( 'Avatar Initials', 'ts' ),
                    'type'        => \Elementor\Controls_Manager::TEXT,
                    'default'     => 'SH',
                    'description' => esc_html__( '1-3 characters shown in the avatar circle.', 'ts' ),
                ] );

                $repeater->add_control( 'avatar_color', [
                    'label'   => esc_html__( 'Avatar Color', 'ts' ),
                    'type'    => \Elementor\Controls_Manager::COLOR,
                    'default' => '#4f6bff',
                ] );

                $this->add_control( 'reviews', [
                    'label'       => esc_html__( 'Reviews', 'ts' ),
                    'type'        => \Elementor\Controls_Manager::REPEATER,
                    'fields'      => $repeater->get_controls(),
                    'title_field' => '{{{ author_name }}} - {{{ platform }}}',
                    'default'     => [
                        [ 'platform' => 'google',     'review_text' => 'Great learning experience with Training Express! The lessons are clear, well-structured, and the platform is easy to use. I really enjoy learning at my own pace.',                   'author_name' => 'Shoive Hossain', 'author_role' => '',                   'initials' => 'SH', 'avatar_color' => '#4f6bff' ],
                        [ 'platform' => 'trustpilot', 'review_text' => 'The course was delivered at a steady pace and allowed me to maximise my learning at different times.',                                                                             'author_name' => 'Shoive Hossain', 'author_role' => 'UI Designer',         'initials' => 'SH', 'avatar_color' => '#9b5de5' ],
                        [ 'platform' => 'reviews',    'review_text' => 'Excellent course, clear, concise, and easy to join. Information was delivered almost in bullet-point form and very easy to digest.',                                               'author_name' => 'Shoive Hossain', 'author_role' => '',                   'initials' => 'SH', 'avatar_color' => '#f97316' ],
                        [ 'platform' => 'google',     'review_text' => "It's been a great experience! The modules are easy to access and follow. They are also well explained. Thanks for the knowledge imparted.",                                       'author_name' => 'Shoive Hossain', 'author_role' => 'Project Manager',    'initials' => 'SH', 'avatar_color' => '#10b981' ],
                        [ 'platform' => 'trustpilot', 'review_text' => 'Very informative and convenient sections to complete at different times especially.',                                                                                             'author_name' => 'Shoive Hossain', 'author_role' => '',                   'initials' => 'SH', 'avatar_color' => '#ec4899' ],
                        [ 'platform' => 'reviews',    'review_text' => 'This is brilliant! So easy to learn from and I can do this perfectly around my busy work schedule in my own time!',                                                               'author_name' => 'Shoive Hossain', 'author_role' => '',                   'initials' => 'SH', 'avatar_color' => '#38bdf8' ],
                        [ 'platform' => 'google',     'review_text' => 'The course was very in-depth and covered quite a wide variety of subjects. It gives me a better and more detailed understanding of the topic.',                                   'author_name' => 'Shoive Hossain', 'author_role' => 'Compliance Officer', 'initials' => 'SH', 'avatar_color' => '#fbbf24' ],
                        [ 'platform' => 'trustpilot', 'review_text' => 'Got way more than I expected. Extremely detailed. You are able to engage with the modules as much or as little as your time allows. Highly recommend.',                          'author_name' => 'Shoive Hossain', 'author_role' => '',                   'initials' => 'SH', 'avatar_color' => '#4ade80' ],
                        [ 'platform' => 'reviews',    'review_text' => 'Really well-structured course. Everything was clear and concise. I will definitely be returning for more courses. Very happy with my learning experience.',                       'author_name' => 'Shoive Hossain', 'author_role' => 'HR Specialist',      'initials' => 'SH', 'avatar_color' => '#fb7185' ],
                    ],
                ] );

                $this->end_controls_section();

                /* Section: Animation */
                $this->start_controls_section( 'sec_anim', [
                    'label' => esc_html__( 'Animation', 'ts' ),
                    'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                ] );

                $this->add_control( 'speed_col1', [
                    'label'   => esc_html__( 'Column 1 Speed (px/s)', 'ts' ),
                    'type'    => \Elementor\Controls_Manager::SLIDER,
                    'range'   => [ 'px' => [ 'min' => 10, 'max' => 150 ] ],
                    'default' => [ 'size' => 52 ],
                ] );

                $this->add_control( 'speed_col2', [
                    'label'   => esc_html__( 'Column 2 Speed (px/s)', 'ts' ),
                    'type'    => \Elementor\Controls_Manager::SLIDER,
                    'range'   => [ 'px' => [ 'min' => 10, 'max' => 150 ] ],
                    'default' => [ 'size' => 40 ],
                ] );

                $this->add_control( 'speed_col3', [
                    'label'   => esc_html__( 'Column 3 Speed (px/s)', 'ts' ),
                    'type'    => \Elementor\Controls_Manager::SLIDER,
                    'range'   => [ 'px' => [ 'min' => 10, 'max' => 150 ] ],
                    'default' => [ 'size' => 64 ],
                ] );

                $this->add_control( 'grid_height', [
                    'label'   => esc_html__( 'Grid Height (px)', 'ts' ),
                    'type'    => \Elementor\Controls_Manager::SLIDER,
                    'range'   => [ 'px' => [ 'min' => 300, 'max' => 1000 ] ],
                    'default' => [ 'size' => 580 ],
                ] );

                $this->end_controls_section();

                /* Section: Style */
                $this->start_controls_section( 'sec_style', [
                    'label' => esc_html__( 'Style', 'ts' ),
                    'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                ] );

                $this->add_control( 'bg_color', [
                    'label'     => esc_html__( 'Section Background', 'ts' ),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'default'   => '#111113',
                    'selectors' => [ '{{WRAPPER}} .ts-wrap' => 'background:{{VALUE}}' ],
                ] );

                $this->add_control( 'card_bg', [
                    'label'     => esc_html__( 'Card Background', 'ts' ),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'default'   => '#1c1c1f',
                    'selectors' => [ '{{WRAPPER}} .ts-card' => 'background:{{VALUE}}' ],
                ] );

                $this->add_control( 'card_border_color', [
                    'label'     => esc_html__( 'Card Border', 'ts' ),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'default'   => '#2a2a2e',
                    'selectors' => [ '{{WRAPPER}} .ts-card' => 'border-color:{{VALUE}}' ],
                ] );

                $this->add_control( 'heading_color', [
                    'label'     => esc_html__( 'Heading Color', 'ts' ),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'default'   => '#ffffff',
                    'selectors' => [ '{{WRAPPER}} .ts-header h2' => 'color:{{VALUE}}' ],
                ] );

                $this->add_control( 'subtext_color', [
                    'label'     => esc_html__( 'Sub-text Color', 'ts' ),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'default'   => '#9ca3af',
                    'selectors' => [ '{{WRAPPER}} .ts-header p' => 'color:{{VALUE}}' ],
                ] );

                $this->add_control( 'review_text_color', [
                    'label'     => esc_html__( 'Review Text Color', 'ts' ),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'default'   => '#d1d5db',
                    'selectors' => [ '{{WRAPPER}} .ts-text' => 'color:{{VALUE}}' ],
                ] );

                $this->end_controls_section();
            }

            /* ── Render ───────────────────────────────────── */
            protected function render() {
                $s       = $this->get_settings_for_display();
                $reviews = ! empty( $s['reviews'] ) ? (array) $s['reviews'] : [];
                $uid     = 'ts_' . $this->get_id();
                $speeds  = [
                    max( 1, intval( $s['speed_col1']['size'] ) ),
                    max( 1, intval( $s['speed_col2']['size'] ) ),
                    max( 1, intval( $s['speed_col3']['size'] ) ),
                ];
                $height  = max( 200, intval( $s['grid_height']['size'] ) );
                $bg      = ! empty( $s['bg_color'] ) ? $s['bg_color'] : '#111113';

                /* Round-robin distribution across 3 columns */
                $cols = [ [], [], [] ];
                foreach ( $reviews as $idx => $r ) {
                    $cols[ $idx % 3 ][] = $r;
                }

                $tp_star = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14 2 9.27z"/></svg>';
                $chk_svg = '<svg viewBox="0 0 10 8" aria-hidden="true"><polyline points="1,4 3.5,6.5 9,1.5"/></svg>';

                // phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
                ?>
<style>
#<?php echo $uid; ?>,
#<?php echo $uid; ?> *,
#<?php echo $uid; ?> *::before,
#<?php echo $uid; ?> *::after{box-sizing:border-box;margin:0;padding:0}
#<?php echo $uid; ?>.ts-wrap{font-family:Helvetica,Arial,sans-serif;background:#111113;color:#fff;width:100%;padding:60px 20px}
#<?php echo $uid; ?> .ts-inner{max-width:1400px;margin:0 auto}
#<?php echo $uid; ?> .ts-header{text-align:center;margin-bottom:48px}
#<?php echo $uid; ?> .ts-header h2{font-size:clamp(22px,4vw,36px);font-weight:700;line-height:1.28;letter-spacing:-.5px;color:#fff;margin-bottom:12px}
#<?php echo $uid; ?> .ts-header p{font-size:clamp(13px,1.5vw,14.5px);color:#9ca3af;line-height:1.6;max-width:430px;margin:0 auto}
#<?php echo $uid; ?> .ts-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px;height:<?php echo esc_attr( $height ); ?>px;overflow:hidden;position:relative}
#<?php echo $uid; ?> .ts-grid::before,
#<?php echo $uid; ?> .ts-grid::after{content:'';position:absolute;left:0;right:0;height:90px;z-index:10;pointer-events:none}
#<?php echo $uid; ?> .ts-grid::before{top:0;background:linear-gradient(to bottom,<?php echo esc_attr( $bg ); ?>,transparent)}
#<?php echo $uid; ?> .ts-grid::after{bottom:0;background:linear-gradient(to top,<?php echo esc_attr( $bg ); ?>,transparent)}
#<?php echo $uid; ?> .ts-col{overflow:hidden;position:relative}
#<?php echo $uid; ?> .ts-track{display:flex;flex-direction:column;gap:16px;will-change:transform}
#<?php echo $uid; ?> .ts-card{background:#1c1c1f;border:1px solid #2a2a2e;border-radius:14px;padding:20px;flex-shrink:0;transition:border-color .25s,transform .25s}
#<?php echo $uid; ?> .ts-card:hover{border-color:#3f3f45;transform:translateY(-2px)}
#<?php echo $uid; ?> .ts-platform{display:flex;align-items:center;margin-bottom:12px}
#<?php echo $uid; ?> .ts-logo-g{font-size:17px;font-weight:700;letter-spacing:-.3px;line-height:1}
#<?php echo $uid; ?> .ts-logo-g .gb{color:#4285F4}
#<?php echo $uid; ?> .ts-logo-g .gr{color:#EA4335}
#<?php echo $uid; ?> .ts-logo-g .gy{color:#FBBC05}
#<?php echo $uid; ?> .ts-logo-g .gg{color:#34A853}
#<?php echo $uid; ?> .ts-tp{display:flex;align-items:center;gap:6px}
#<?php echo $uid; ?> .ts-tp-star{width:20px;height:20px;background:#00b67a;display:flex;align-items:center;justify-content:center;border-radius:2px;flex-shrink:0}
#<?php echo $uid; ?> .ts-tp-star svg{width:12px;height:12px;fill:#fff}
#<?php echo $uid; ?> .ts-tp-name{font-size:16px;font-weight:700;color:#fff;letter-spacing:-.2px}
#<?php echo $uid; ?> .ts-rv{display:flex;align-items:center;gap:5px}
#<?php echo $uid; ?> .ts-rv-badge{width:20px;height:20px;background:#ff5a5f;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:900;color:#fff;flex-shrink:0}
#<?php echo $uid; ?> .ts-rv-name{font-size:14px;font-weight:700;color:#fff}
#<?php echo $uid; ?> .ts-rv-name span{color:#9ca3af;font-weight:400;font-size:11px}
#<?php echo $uid; ?> .ts-stars{display:flex;gap:2px;margin-bottom:11px}
#<?php echo $uid; ?> .ts-star{font-size:13px;color:#f59e0b}
#<?php echo $uid; ?> .ts-star-tp{font-size:13px;color:#00b67a}
#<?php echo $uid; ?> .ts-text{font-size:13px;line-height:1.65;color:#d1d5db;margin-bottom:16px}
#<?php echo $uid; ?> .ts-author{display:flex;align-items:center;gap:10px}
#<?php echo $uid; ?> .ts-avatar{width:36px;height:36px;border-radius:50%;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#fff}
#<?php echo $uid; ?> .ts-ainfo{display:flex;flex-direction:column;gap:1px}
#<?php echo $uid; ?> .ts-aname{font-size:13px;font-weight:600;color:#f3f4f6;display:flex;align-items:center;gap:4px;line-height:1.4}
#<?php echo $uid; ?> .ts-verified{width:14px;height:14px;border-radius:50%;background:#3b82f6;display:inline-flex;align-items:center;justify-content:center;flex-shrink:0}
#<?php echo $uid; ?> .ts-verified svg{width:8px;height:8px;fill:none;stroke:#fff;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}
#<?php echo $uid; ?> .ts-arole{font-size:11px;color:#6b7280}
@media(max-width:900px){
  #<?php echo $uid; ?> .ts-grid{grid-template-columns:repeat(2,1fr);height:520px}
  #<?php echo $uid; ?> .ts-col:last-child{display:none}
}
@media(max-width:560px){
  #<?php echo $uid; ?>.ts-wrap{padding:44px 16px}
  #<?php echo $uid; ?> .ts-grid{grid-template-columns:1fr;height:480px}
  #<?php echo $uid; ?> .ts-col:nth-child(n+2){display:none}
  #<?php echo $uid; ?> .ts-header{margin-bottom:32px}
}
</style>

<div id="<?php echo esc_attr( $uid ); ?>" class="ts-wrap">
  <div class="ts-inner">
    <div class="ts-header">
      <h2><?php echo nl2br( esc_html( $s['heading'] ) ); ?></h2>
      <p><?php echo esc_html( $s['subtext'] ); ?></p>
    </div>

    <div class="ts-grid">
      <?php foreach ( $cols as $ci => $col_items ) :
          if ( empty( $col_items ) ) {
              echo '<div class="ts-col"></div>';
              continue;
          }
          $set = array_merge( $col_items, $col_items, $col_items );
      ?>
      <div class="ts-col">
        <div class="ts-track" data-speed="<?php echo esc_attr( $speeds[ $ci ] ); ?>">
          <?php foreach ( $set as $r ) :
              $plat  = isset( $r['platform'] ) ? $r['platform'] : 'google';
              $sstar = $plat === 'trustpilot' ? 'ts-star-tp' : 'ts-star';
          ?>
          <div class="ts-card">
            <div class="ts-platform">
              <?php if ( $plat === 'google' ) : ?>
                <span class="ts-logo-g" aria-label="Google"><span class="gb">G</span><span class="gr">o</span><span class="gy">o</span><span class="gg">g</span><span class="gb">l</span><span class="gr">e</span></span>
              <?php elseif ( $plat === 'trustpilot' ) : ?>
                <div class="ts-tp" aria-label="Trustpilot">
                  <div class="ts-tp-star"><?php echo $tp_star; ?></div>
                  <span class="ts-tp-name">Trustpilot</span>
                </div>
              <?php else : ?>
                <div class="ts-rv" aria-label="Reviews.io">
                  <div class="ts-rv-badge">&#10022;</div>
                  <span class="ts-rv-name">REVIEWS<span>.io</span></span>
                </div>
              <?php endif; ?>
            </div>
            <div class="ts-stars" aria-label="5 stars">
              <?php echo str_repeat( '<span class="' . esc_attr( $sstar ) . '" aria-hidden="true">&#9733;</span>', 5 ); ?>
            </div>
            <p class="ts-text"><?php echo esc_html( isset( $r['review_text'] ) ? $r['review_text'] : '' ); ?></p>
            <div class="ts-author">
              <div class="ts-avatar" style="background:<?php echo esc_attr( isset( $r['avatar_color'] ) ? $r['avatar_color'] : '#4f6bff' ); ?>">
                <?php echo esc_html( isset( $r['initials'] ) ? $r['initials'] : 'SH' ); ?>
              </div>
              <div class="ts-ainfo">
                <span class="ts-aname">
                  <?php echo esc_html( isset( $r['author_name'] ) ? $r['author_name'] : '' ); ?>
                  <span class="ts-verified" aria-label="Verified"><?php echo $chk_svg; ?></span>
                </span>
                <?php if ( ! empty( $r['author_role'] ) ) : ?>
                  <span class="ts-arole"><?php echo esc_html( $r['author_role'] ); ?></span>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<script>
(function () {
  var uid = '<?php echo esc_js( $uid ); ?>';
  var wrap = document.getElementById(uid);
  if (!wrap) return;

  var tracks = [];
  wrap.querySelectorAll('.ts-track').forEach(function (trk, i) {
    var spd = parseFloat(trk.getAttribute('data-speed')) || 50;
    var col = trk.parentElement;
    var state = { el: trk, pos: 0, paused: false, spd: spd };
    col.addEventListener('mouseenter', function () { state.paused = true; });
    col.addEventListener('mouseleave', function () { state.paused = false; });
    tracks.push(state);
  });

  if (!tracks.length) return;

  var last = null;
  function tick(ts) {
    if (!last) last = ts;
    var dt = Math.min((ts - last) / 1000, 0.1);
    last = ts;
    tracks.forEach(function (t) {
      if (t.paused || !t.el.scrollHeight) return;
      t.pos += t.spd * dt;
      var loop = t.el.scrollHeight / 3;
      if (loop > 0 && t.pos >= loop) t.pos -= loop;
      t.el.style.transform = 'translateY(-' + t.pos + 'px)';
    });
    requestAnimationFrame(tick);
  }
  requestAnimationFrame(tick);
}());
</script>
                <?php
                // phpcs:enable
            } // end render()

        } // end class TS_Testimonials_Slider_Widget

        $manager->register( new TS_Testimonials_Slider_Widget() );

    } ); // elementor/widgets/register

} ); // plugins_loaded
