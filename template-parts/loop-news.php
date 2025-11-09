<?php
/**
 * 【共通ニュースループ】
 * 引数：
 * - layout: "top" | "archive"
 * - posts_per_page: int
 * - year: int (0=制限なし)
 * - monthnum : int (0=制限なし)
 * - day : int (0=制限なし)
 * - paged : int
 * - with_pagination: bool
 */
$args = wp_parse_args($args ?? [],[
  "layout"          => "archive",
  "posts_per_page"  => 10,
  "year"            => 0,
  "monthnum"        => 0,
  "day"        => 0,
  "paged"           => max(1, get_query_var("paged")),
  "with_pagination" => false,
]);

$qargs = [
  "post_type"          => "post",
  "post_status"        => "publish",
  "orderby"            => "date",
  "order"              => "DESC",
  "posts_per_page"     => (int) $args["posts_per_page"],
  "paged"              => (int) $args["paged"],
  "ignore_sticky_posts" => true,
];

if ($args["year"]) {
  $qargs["year"] = (int) $args["year"];
}

if ($args["monthnum"]) {
  $qargs["monthnum"] = (int) $args["monthnum"];
}

if ($args["day"]) {
  $qargs["day"] = (int) $args["day"];
}

// トップはpagedを除外 & no_found_rows
if ($args["layout"] === "top") {
  unset($qargs["paged"]);
  $qargs["no_found_rows"] = true;
}

$q = new WP_Query($qargs);

/* ---- トップページ用 ---- */
if ($args["layout"] === "top") : ?>
<div class="top-news-list">
  <?php if ( $q->have_posts() ) : while ($q->have_posts()) : $q->the_post(); ?>

  <article class="top-news-item">
    <a href="<?php the_permalink(); ?>" class="top-news-link">
      <time class="top-news-date" datetime="<?php echo esc_attr( get_the_date( "c" ) ); ?>">
        <?php echo esc_html( get_the_date( "Y.m.d" )); ?>
      </time>
      <h3 class="top-news-post-title">
        <?php the_title(); ?>
      </h3>
    </a>
  </article>
  <?php endwhile; else: ?>

  <article class="top-news-item">
    <span class="top-news-link">
      <time class="top-news-date" datetime="<?php echo esc_attr( date( 'c' ) ); ?>">
        <?php echo esc_html( date( 'Y.m.d' ) ); ?>
      </time>
      <h3 class="top-news-post-title">お知らせはまだありません</h3>
    </span>
  </article>
  <?php endif; wp_reset_postdata(); ?>
</div>

<?php 
/* ----- お知らせ一覧用----- */
else: ?>

<div class="news-main-list">
  <?php if ($q->have_posts()) :while ($q->have_posts()) : $q->the_post(); ?>
  <article <?php post_class("news-main-item"); ?>>
    <a href="<?php the_permalink(); ?>" class="news-main-link">
      <time datetime="<?php echo esc_attr(get_the_date("c")); ?>">
        <?php echo esc_html(get_the_date("Y.m.d")); ?>
      </time>
      <h2 class="news-main-title">
        <?php the_title(); ?>
      </h2>
    </a>
  </article>
  <?php endwhile; else: ?>
  <p>記事がありません。</p>
  <?php endif; ?>
</div>

<!-- ページネーション -->
<?php if ($args["with_pagination"] && $q->max_num_pages > 1) :
  $year     = (int) $args["year"];
  $monthnum = (int) $args["monthnum"];
  $day      = (int) $args["day"];

  // クエリ文字列運用時の保険（Pretty Permalink でも害はなし）
  $add_args =[];
  if ($year)     {$add_args["year"]     = $year; }
  if ($monthnum) {$add_args["monthnum"] = $monthnum; }
  if ($day)      {$add_args["day"]      = $day; }
  if (!$add_args) { $add_args = false; }


  $pagination =paginate_links([
    "current"       => (int) $args["paged"],
    "total"         => $q->max_num_pages,
    "mid_size"      => 1, // 現在のページの左右に1件ずつ表示
    "end_size"      => 1, // 最初と最後に1件ずつ常に表示
    "prev_text"     => "<span aria-label='前のページへ'>prev</span>",
    "next_text"     => "<span aria-label='次のページへ'>next</span>",
    "add_args"      => $add_args, // 年/月/日を維持
    "type"          => "array",
  ]);

if ($pagination) :
  echo "<nav class='c-pagination' aria-label='ニュース一覧のページネーション'>";
  echo "<ul class='c-pagination-list'>";
  foreach ($pagination as $page_link) {
    echo "<li class='c-pagination-item'>{$page_link}</li>";
  }
  echo "</ul>";
  echo "</nav>";
endif;

wp_reset_postdata(); ?>

<?php endif; ?>

<?php endif; ?>