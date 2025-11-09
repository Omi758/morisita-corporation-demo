<?php
$post_id   = get_the_ID();
$permalink = get_permalink($post_id);
$title     = get_the_title($post_id);

// カスタム分類:product_category
$cat_label = "";
$terms     = get_the_terms($post_id, "product_category");
if ($terms && !is_wp_error($terms)) {
  $cat_label = $terms[0]->name;
}
?>

<article class="product-intro-card">
  <a href="<?php echo esc_url($permalink); ?>" class="product-intro-link"
    aria-label="<?php echo esc_attr($title); ?> の詳細へ">

    <?php if ( has_post_thumbnail($post_id) ) : ?>
    <?php the_post_thumbnail("medium_large", [
      "class"   => "product-intro-thumb",
      "loading" => "lazy",
      "decoding" => "async",
    ]); ?>

    <?php else: ?>
    <img class="product-intro-thumb"
      src="<?php echo esc_url(get_template_directory_uri() . '/img/dummy-image-640X480.webp'); ?>" width="640"
      height="480" alt="" loading="lazy" decoding="async" />
    <?php endif; ?>

    <div class="product-intro-text-container">
      <?php if( $cat_label ) : ?>
      <p class="product-intro-label"><?php echo esc_html($cat_label); ?></p>
      <?php endif; ?>
      <h2 class="product-intro-title"><?php echo esc_html($title); ?></h2>
    </div>
  </a>
</article>