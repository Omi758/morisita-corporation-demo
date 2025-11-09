<?php
/**
 * 年別アーカイブ（ALL + 年リンク）
 * 引数:
 *  - current_year: int (0=ALL)
 * サイドバーの目的
 * - 「ALL」リンク /news/ (すべての投稿)
 * - 年別リンク /news/2025/ (その年の投稿のみ)
 */

$current_year = isset($args["current_year"]) ? (int) $args["current_year"] : (int) get_query_var('year'); // 現在の年

// 投稿ページ (/news)URLを取得
$posts_page_id  = (int) get_option("page_for_posts");
$posts_page_url = $posts_page_id ? get_permalink($posts_page_id) : home_url("/news/"); // フォールバック

// ALLページかどうか
$is_all = !$current_year;

// ===========================
// 年リスト
// SQL直書きせず、WP_Queryだけで年を集める
// 公開済postだけ対象
// ===========================
$all_posts_for_years = new WP_Query([
  'post_type'          => 'post',
  'post_status'        => 'publish',
  'posts_per_page'     => -1, // 全件
  'fields'             => 'ids', // 投稿IDだけ取得(軽い)
  'orderby'            => 'date',
  'order'             => 'DESC',
  'ignore_sticky_posts' => true,
  'no_found_rows'       => true,  // ページ総数のカウントをしないので高速
]);

$years_list =[]; // 例:[2025, 2024, 2023,...]のように入れる
if ($all_posts_for_years->have_posts()) {
  foreach ( $all_posts_for_years->posts as $post_id ) {
    $y = (int) get_the_date('Y', $post_id); // その投稿の年
    $years_list[$y] =true; // 連想配列のキーにして重複排除
  }
  // キーだけ取り出して数値の降順に並べ替える
  $years_list = array_keys($years_list); // [2025, 2024,...]という配列に
  rsort($years_list, SORT_NUMERIC); // 大きい年→小さい年の順に
}
?>

<div class="news-sidebar-wrapper">
  <div class="news-sidebar-title-container">
    <h2 class="news-sidebar-title c-section-title">
      <span class="c-section-title--en" lang="en">archive</span>
      <span class="c-section-title--jp">アーカイブ</span>
    </h2>
  </div>

  <nav class="news-sidebar-nav" aria-label="アーカイブ">
    <ol class="news-sidebar-archive-list">

      <!-- ALL -->
      <li class="news-sidebar-archive-item">

        <a href="<?php echo esc_url($posts_page_url); ?>" class="news-sidebar-archive-link"
          <?php if ($is_all) echo 'aria-current="page"'; ?>>
          <span class="news-sidebar-archive-all" lang="en">all</span>
        </a>
      </li>

      <!-- 年毎のリンク -->
      <?php if (!empty($years_list)) : ?>
      <?php foreach ($years_list as $y) :
           $year_url = home_url("/news/{$y}/");
          $is_current_year = ((int)$y === (int)$current_year);
          ?>


      <li class="news-sidebar-archive-item">
        <a class="news-sidebar-archive-link" href="<?php echo esc_url($year_url); ?>"
          <?php if ($is_current_year) echo 'aria-current="page"' ?>>
          <time datetime="<?php echo esc_attr($y); ?>">
            <span class="news-sidebar-archive-number"><?php echo esc_html($y); ?></span>
            <span class="news-sidebar-archive-year-jp">年</span>
          </time>
        </a>
      </li>
      <?php endforeach ?>
      <?php endif; ?>

    </ol>
  </nav>
</div>