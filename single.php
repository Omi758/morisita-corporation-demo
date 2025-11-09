<?php get_header(); ?>

<?php if ( have_posts() ) :while ( have_posts() ) : the_post(); ?>

<!-- news-single-kv -->
<?php get_template_part("template-parts/subkv-single-news"); ?>

<!-- パンくず -->
<?php get_template_part( "template-parts/breadcrumb" ); ?>
<!-- </div> -->

<!-- news-single-kv end -->

<!-- news-single-->
<main>
  <div class="news-single">
    <div class="l-container-s">
      <div class="news-single-content">

        <article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
          <div class="entry-content">
            <?php
              the_content();

              // ページ分割が使われた場合のページナビ
              wp_link_pages( [
                'before' => '<nav class="post-pages" aria-label="ページナビゲーション"><span class="post-pages__label">Pages:</span>',
                'after'  => '</nav>',
              ] );
            ?>
          </div>
        </article>
      </div>


      <!-- 前後記事リンク -->
      <?php
$prev = get_previous_post(); // 隣接「前」記事（最新寄り）
$next = get_next_post();     // 隣接「次」記事（古い方）

$cls = 'news-single-pagination';
if ( $prev && !$next ) $cls .= ' has-prev-only';
if ( $next && !$prev ) $cls .= ' has-next-only';
?>

      <nav class="<?php echo esc_attr($cls); ?>" aria-label="前後の記事">
        <?php if ( $prev ) : ?>
        <div class="news-single-prev">
          <?php previous_post_link('%link', 'prev'); ?>
        </div>
        <?php endif; ?>

        <?php if ( $next ) : ?>
        <div class="news-single-next">
          <?php next_post_link('%link', 'next'); ?>
        </div>
        <?php endif; ?>
      </nav>
    </div>
  </div>
</main>

<!-- news-single end -->
<?php endwhile; endif ?>

<?php get_footer(); ?>