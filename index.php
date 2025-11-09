<?php get_header(); ?>
<!-- news-kv -->
<?php get_template_part('template-parts/subkv-archive'); ?>

<!-- パンくず -->
<?php get_template_part( "template-parts/breadcrumb" ); ?>

<!-- news -->
<div class="l-container">
  <div class="news-2col">
    <main class="news-main">

      <?php
// 年・月・日・ページ番号を取得して共通ループに渡す
      $year     = (int) get_query_var('year');
      $monthnum = (int) get_query_var('monthnum');
      $day      = (int) get_query_var('day');
      $paged    = max(1, (int) get_query_var('paged'));

      get_template_part('template-parts/loop-news', null,[
        'layout'          => 'archive', // 一覧用
        'posts_per_page'  => 10,
        'year'            => $year,
        'monthnum'        => $monthnum,
        'day'             => $day,
        'paged'           => $paged,
        'with_pagination' => true,  // ページネーション出力
      ]);
     ?>

    </main>
    <!-- news end -->
    <!-- aside -->
    <aside class="news-sidebar">
      <?php
      // 年別アーカイブ(ALL/年リンク)
      get_template_part("template-parts/sidebar-news", null, [
        "current_year" => $year, // asideはALL+.年リンクのみ
      ]);
      ?>
    </aside>
    <!-- aside end -->
  </div>
</div>

<?php get_footer(); ?>