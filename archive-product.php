    <?php get_header(); ?>

    <!-- product-kv -->
    <?php get_template_part('template-parts/subkv-archive'); ?>


    <!-- パンくず -->
    <?php get_template_part( "template-parts/breadcrumb" ); ?>
    <!-- product-kv end -->

    <!-- product-introduction -->
    <main>
      <div class="product-intro">
        <div class="product-intro-wrapper l-container">

          <?php if ( have_posts() ) : ?>
          <?php while ( have_posts() ) : the_post(); ?>

          <?php get_template_part("template-parts/loop", "products"); ?>
          <?php endwhile; ?>
          <?php else : ?>
          <p class="no-posts">現在、公開中の製品はありません。</p>
          <?php endif; ?>

        </div>
      </div>
    </main>

    <!-- product-introduction end -->

    <?php get_footer(); ?>