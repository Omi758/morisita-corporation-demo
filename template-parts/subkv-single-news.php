<?php
/**
 * サブKV（ニュース個別用）
 * - 英字/日本語ラベル_NEWS / お知らせ
 * - 画像はアイキャッチ優先（なければフォールバック）
 * - 日付 <time> を表示（ACF不使用／通常投稿の日時）
 */
// 上書き用
$en = $args["en"] ?? "NEWS";
$ja = $args["ja"] ?? "お知らせ";

// タイトル（日付あり）
$title = get_the_title();

// アイキャッチ
$img_id  = has_post_thumbnail() ? get_post_thumbnail_id() : 0;
$img_src = $img_id ? wp_get_attachment_image_url($img_id, "subkv_single") : "";
if (!$img_src && $img_id) {
  $img_src = wp_get_attachment_image_url($img_id, "full");
}
$img_alt = $img_id ? get_post_meta($img_id, "_wp_attachment_image_alt", true) : "";

// フォールバック
if (!$img_src) {
  $img_src = get_template_directory_uri() . "/img/business-info-subfv-thumb-pc@2x.webp";
  $img_alt = "";
}
?>


<div class="c-subkv-single">
  <div class="l-container">
    <div class="c-subkv-single-wrapper">

      <!-- サムネイル -->
      <picture class="c-subkv-single-image">
        <source media="(max-width: 1079px)" srcset="<?php echo esc_url($img_src); ?>" />
        <img width="484" height="323" src="<?php echo esc_url($img_src); ?>" alt="<?php echo esc_attr($img_alt); ?>" />
      </picture>

      <div class="c-subkv-single-text-container">
        <div class="c-subkv-single-text-heading">
          <div class="c-subkv-single-title">
            <span class="c-subkv-single-title--en" lang="en"><?php echo esc_html($en); ?></span>
            <h1 class="c-subkv-single-title--ja"><?php echo esc_html($ja); ?></h1>
          </div>

          <!-- 個別ニュースページのみ日付表示 -->
          <time class="c-subkv-single-time" datetime="<?php echo esc_attr( get_the_date('Y-m-d') ); ?>">
            <?php echo esc_html( get_the_date('Y.m.d') ); ?>
          </time>
        </div>

        <p class="c-subkv-single-title-text c-subkv-news-single-title-text">
          <?php the_title(); ?>
        </p>
      </div>
    </div>
  </div>
</div>