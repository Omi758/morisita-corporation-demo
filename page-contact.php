<?php get_header(); ?>

<!-- contact-kv -->
<?php if ( have_posts() ) :while ( have_posts() ) : the_post(); ?>

<section class="c-subkv">
  <div class="l-container">
    <div class="c-subkv-title">
      <span class="c-subkv-title--en" lang="en"><?php echo esc_html (strtoupper($post->post_name)); ?></span>
      <h1 class="c-subkv-title--ja"><?php the_title(); ?></h1>
    </div>
  </div>
</section>

<!-- パンくず -->
<?php get_template_part( "template-parts/breadcrumb" ); ?>

<!-- contact-kv end -->

<!-- contact -->
<main>
  <div class="contact">
    <div class="l-container-s">
      <p class="contact-text">
        ご質問やご相談があれば、以下フォームよりお問い合わせください。
      </p>

      <div class="contact-form">
        <?php the_content(); ?>
      </div>

    </div>
  </div>
  <!-- contact end -->
</main>
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>