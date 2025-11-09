<?php
/**
 * サブKV（シングル用・共通）
 * - 英字/日本語ラベルは $args['en'], $args['ja'] で上書き可
 * - 未指定時は投稿タイプから自動生成（archive版と整合）
 * - 日付はここでは出さない（ニュースのみ別テンプレで対応想定）
 */

// 受け取り
$en_override = $args["en"] ?? null;
$ja_override = $args["ja"] ?? null;

// 投稿タイプを取得
$ptype_key = get_post_type() ?: "post";
$ptype_obj = get_post_type_object($ptype_key);

// 規定マッピング
$label_map = [
  "post"     => ["NEWS",     "お知らせ"],
  "product"  => ["PRODUCT",  "製品紹介"],
  "business" => ["BUSINESS", "事業紹介"],
];

// 英字ラベル
if ($en_override !== null) {
  $label_en = $en_override;
} elseif (isset($label_map[$ptype_key][0])) {
  $label_en = $label_map[$ptype_key][0];
} elseif ($ptype_obj && !empty($ptype_obj->rewrite['slug'])) {
  $label_en = strtoupper($ptype_obj->rewrite['slug']);
} elseif ($ptype_obj) {
  $label_en = strtoupper($ptype_obj->name);
} else {
  $label_en = 'SINGLE';
}

// 日本語ラベル
if ($ja_override !== null) {
  $label_ja = $ja_override;
} elseif (isset($label_map[$ptype_key][1])) {
  $label_ja = $label_map[$ptype_key][1];
} elseif ($ptype_obj && !empty($ptype_obj->labels->name)) {
  $label_ja = $ptype_obj->labels->name; // CPTのラベル名
} else {
  $ja_title = get_post_type() ? get_post_type_object(get_post_type())->labels->singular_name ?? '' : '';
  $label_ja = $ja_title ?: '詳細';
}

// タイトルと画像
$title = get_the_title();

// KV画像_ACFのPC/SP用フィールド(画像ID)を取得（未使用なら空のまま）
$kv_pc_id = function_exists("get_field") ? get_field("kv_image_pc") : 0;
$kv_sp_id = function_exists("get_field") ? get_field("kv_image_sp") : 0;

// ACF未設定ならPC側はアイキャッチをフォールバック
if (!$kv_pc_id && has_post_thumbnail()) {
  $kv_pc_id = get_post_thumbnail_id();
}

// URLに変換_IDがない場合は空文字
$kv_pc_url = $kv_pc_id ? wp_get_attachment_image_url($kv_pc_id, "full") : "";
$kv_sp_url = $kv_sp_id ? wp_get_attachment_image_url($kv_sp_id, "full") : "";

// 最終フォールバック
if (!$kv_pc_url) {
  $kv_pc_url = get_template_directory_uri() . "/img/business-info-subfv-thumb-pc@2x.webp";
}
if (!$kv_sp_url) {
  $kv_sp_url = $kv_pc_url;
}

// altはPC画像のalt_なければページタイトル
$kv_img_alt = get_the_title();
if ($kv_pc_id) {
  $alt = get_post_meta($kv_pc_id, "_wp_attachment_image_alt", true);
  if ($alt !== "") {
    $kv_img_alt = $alt;
  };
}
?>

<div class="c-subkv-single">
  <div class="l-container">
    <div class="c-subkv-single-wrapper">
      <picture class="c-subkv-single-image">
        <source media="(max-width: 1079px)" srcset="<?php echo esc_url($kv_sp_url); ?>" />
        <img width="484" height="323" src="<?php echo esc_url($kv_pc_url) ?>"
          alt="<?php echo esc_attr($kv_img_alt); ?>" />
      </picture>

      <div class="c-subkv-single-text-container">
        <div class="c-subkv-single-title">
          <span class="c-subkv-single-title--en" lang="en"><?php echo esc_html($label_en) ?></span>
          <h1 class="c-subkv-single-title--ja"><?php echo esc_html($label_ja); ?></h1>
        </div>
        <p class="c-subkv-single-title-text"><?php echo esc_html($title); ?></p>
      </div>
    </div>
  </div>
</div>