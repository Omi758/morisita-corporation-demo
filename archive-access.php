<?php get_header(); ?>

<!-- access-kv(archive) -->
<?php get_template_part('template-parts/subkv-archive'); ?>


<!-- パンくず -->
<?php get_template_part( "template-parts/breadcrumb" ); ?>
<!-- access-kv end -->

<!-- access-info -->
<main>
  <section class="access-info">
    <div class="access-info-wrapper l-container-s">

      <?php if (have_posts()) : ?>
      <?php while ( have_posts() ) :  the_post(); ?>
      <?php
      // ACF フィールド取得
            $title = get_the_title();
            $addr  = get_field('address');   // 住所
            $embed = get_field('map_url');   // 埋め込みURL
            $view  = get_field('map_view_url'); // 閲覧用URL
            $is_hq = (bool) get_field('is_headquarters'); // 本社フラグ

            // 本社なら --hq クラスを付与（コンテナ幅いっぱい））
            $card_class = 'access-info-card';
            if ( $is_hq ) {
              $card_class .= ' access-info-card--hq';
            }

            // GoogleMapボタンのリンク
            if ( !empty($view) ) {
              $gm_link = $view;
              } elseif ( !empty($embed) ) {
                $q = $title . ( $addr ? ' ' . preg_replace('/\s+/', ' ', $addr) : '' );
                $gm_link = 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode($q);
              }else{
                $gm_link = "#";
              }
      ?>

      <article class="<?php echo esc_attr( $card_class ); ?>">
        <div class="access-info-text-container">
          <div>
            <h2 class="access-info-name"><?php echo esc_html( $title ); ?></h2>
            <?php if ( $addr ) : ?>
            <address class="access-info-address">
              <?php echo nl2br( esc_html( $addr ) ); ?>
            </address>
            <?php endif; ?>
          </div>

          <a class="access-info-link c-button c-button--lightest-blue" href="<?php echo esc_url($gm_link); ?>"
            target="_blank" rel="noopener noreferrer" lang="en">google map</a>
        </div>

        <?php if ( $embed ) : ?>
        <div class="access-info-map" role="group" aria-label="<?php echo esc_attr( $title ); ?>の地図">
          <iframe src="<?php echo esc_url( $embed ); ?>" title="<?php echo esc_attr( $title ); ?>の地図" style="border: 0"
            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
          </iframe>
        </div>
        <?php endif; ?>
      </article>

      <?php endwhile; ?>
      <?php endif; ?>

    </div>
  </section>
</main>

<!-- access-info end -->

<?php get_footer(); ?>