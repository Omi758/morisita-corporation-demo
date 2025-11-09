<?php
/**
 * 汎用サブKV（アーカイブ・投稿一覧・固定ページ 共通）
 */

$args        = isset($args) && is_array($args) ? $args : [];
$en_override = $args['en'] ?? null;
$ja_override = $args['ja'] ?? null;

/*
* 投稿一覧（is_home）と「投稿の日付アーカイブ(is_date)」は
* NEWS / お知らせ をベースに日付アーカイブ時は英字に年を付与
*/
if($en_override === null && $ja_override === null) {
  // 「投稿 post」の日付アーカイブの時
  $is_posts_date = is_date() && (empty(get_query_var('post_type')) || get_query_var('post_type') === 'post');

if (is_home() || $is_posts_date) {
  $year = (int) get_query_var('year'); // 例：/news/2025/なら2025_英字は大文字で渡す(オーバーライドは後段でupperされないため)
  $en_override = 'NEWS' . ($is_posts_date && $year ? '&nbsp;' . $year : '');
  $ja_override = 'お知らせ';
  }
}

// 現在の投稿タイプ（CPTアーカイブ/投稿一覧/固定ページを想定したフォールバック）
$ptype = get_post_type_object( get_query_var('post_type') ?: get_post_type() ?: 'post' );

/* ─ 英字タイトル ─ */
$en_title = $en_override;
if ($en_title === null) {
  if ($ptype && !empty($ptype->rewrite['slug'])) {
    $en_title = strtoupper($ptype->rewrite['slug']);
  } elseif ($ptype && !empty($ptype->name)) {
    $en_title = strtoupper($ptype->name);
  } else {
    $en_title = 'ARCHIVE';
  }
}

/* ─ 日本語タイトル ─ */
$ja_title = $ja_override;
if ($ja_title === null) {
  if ($ptype && !empty($ptype->labels->name)) {
    $ja_title = $ptype->labels->name;
  } else {
    // アーカイブタイトル(フォールバック)
    $from_archive = post_type_archive_title('', false);
    if (!empty($from_archive)) {
      $ja_title = $from_archive;
    } else {
      $ja_title = is_home() ? 'お知らせ' : 'アーカイブ';
    }
  }
}
?>
<section class="c-subkv">
  <div class="l-container">
    <div class="c-subkv-title">
      <span class="c-subkv-title--en" lang="en"><?php echo esc_html($en_title); ?></span>
      <h1 class="c-subkv-title--ja"><?php echo esc_html($ja_title); ?></h1>
    </div>
  </div>
</section>