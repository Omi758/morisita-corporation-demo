    <?php get_header(); ?>
    <!-- privacy-kv -->

    <section class="c-subkv">
      <div class="l-container">
        <div class="c-subkv-title">
          <span class="c-subkv-title--en" lang="en">privacy policy</span>
          <h1 class="c-subkv-title--ja">プライバシーポリシー</h1>
        </div>
      </div>
    </section>

    <!-- ====== パンくず ====== -->
    <?php get_template_part( "template-parts/breadcrumb" ); ?>

    <!-- privacy-kv end -->

    <!-- privacy -->
    <main>
      <div class="privacy">
        <div class="l-container-s">
          <article <?php post_class("privacy-article"); ?>>
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <div class="privacy-wrapper entry-content">
              <?php the_content(); ?>
            </div>
            <?php endwhile; endif; ?>
          </article>
        </div>
      </div>
    </main>

    <!-- privacy end -->

    <?php get_footer(); ?>