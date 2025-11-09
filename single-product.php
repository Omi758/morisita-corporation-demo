<?php get_header(); ?>

<!-- product-single-kv -->
<?php get_template_part("template-parts/subkv-single"); ?>
<!-- パンくずリスト -->
<?php get_template_part( "template-parts/breadcrumb" ); ?>

<!-- product-single-info-->
<?php
$title = get_the_title();

// メイン画像(アイキャッチ)
$has_thumb = has_post_thumbnail();
$main_img_html = $has_thumb ? get_the_post_thumbnail(get_the_ID(), "product_hero",[
  "class"     => "product-main-image",
  "id"        => "productMainImage",
  "loading"   => "eager", // LCP対策
  "decoding"  => "async",
])
: sprintf(
  "<img class='product-main-image' id='productMainImage' src='%s' width='1400' height='900' alt='' loading='eager' decoding='async' >",
  esc_url( get_template_directory_uri() . "/img/dummy-1400X900.webp" )
);

// サムネ配列（1枚目：アイキャッチ、2・3枚目：ACF）
$thumb_ids = [];
if ($has_thumb) {
  $thumb_ids[] = get_post_thumbnail_id();
}
foreach (["sub_thumb_1", "sub_thumb_2"] as $field) {
  $id = get_field($field);
  if ($id) {
    $thumb_ids[] = $id;
  }
}
?>

<main>
  <section class="product-single-info">
    <div class="l-container-s">
      <div class="product-single-gallery">
        <!-- メイン画像 -->
        <figure class="product-single-main-thumbnail js-product-single-main-thumbnail">
          <?php echo $main_img_html; ?>
        </figure>

        <!-- サムネイル -->
        <?php if ( $thumb_ids ) : ?>
        <ul class="product-single-sub-thumbnail-list" role="listbox" aria-label="製品画像サムネイル">
          <?php foreach ( $thumb_ids as $i => $id ) : ?>
          <?php
              // サムネ用ではなく、メインとして使える大きい画像URLを取得
              $full_url = wp_get_attachment_image_url($id, "product_hero"); // fullでもOK
              $alt      = get_post_meta( $id, "_wp_attachment_image_alt", "true" );
              ?>
          <li class="product-single-sub-thumbnail js-product-single-sub-thumbnail" role="option"
            aria-selected="<?php echo $i === 0 ? "true" : "false"; ?>">
            <img src='<?php echo esc_url( $full_url ); ?>' alt='<?php echo esc_attr($alt); ?>' loading="lazy"
              decoding='async'>
          </li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>
      </div>

      <!-- 製品情報 -->
      <div class="product-single-details">
        <dl class="product-single-info-list">
          <div class="product-single-info-item">
            <dt class="product-single-info-item-title">製品名</dt>
            <dd class="product-single-info-item-data">
              <?php echo esc_html( $title ); ?>
            </dd>
          </div>
          <?php
          // スペック表(ACFから取得)
          $rows = [
            "製品コード"             => get_field("product_code"),
            "材質"                  => get_field("material"),
            "サイズ（直径 × 長さ）"  => get_field("size"),
            "ドライブタイプ"         => get_field("drive_type"),
            "用途"                  => get_field("use_case"),
            "パッケージ単位（入数）"  => get_field("package_unit"),
          ];

          foreach ( $rows as $label => $value ) :
            if ( $value === "" || $value === null ) continue;
          ?>

          <div class="product-single-info-item">
            <dt class="product-single-info-item-title"><?php echo esc_html( $label ); ?></dt>
            <dd class="product-single-info-item-data">
              <?php
              echo ($label === "用途")
              ? nl2br( esc_html( $value ) ) // 改行対応
              : esc_html( $value );
              ?>
            </dd>
          </div>
          <?php endforeach; ?>
        </dl>
      </div>

    </div>
  </section>
</main>

<!-- business-design end -->

<?php get_footer(); ?>