<?php /**
* template-parts/loop-business.php
* -------------------------------------------------------------
* 事業紹介（CPT: business）のリンクリスト出力用テンプレートパーツ
*
* - context: 'top'（TOPページ） or 'header'（ヘッダー）
* - limit: -1（未指定または-1で全件表示）
** -------------------------------------------------------------
*/

$context = $args["context"] ?? "top";
$limit   = isset($args["limit"]) ? (int) $args["limit"] : -1;

// クエリ設定：公開済みの「business」投稿を並び順で取得
// Intuitive Custom Post Order対応(menu_order ASC)
$q = new WP_Query([
  "post_type"        => "business",
  "post_status"      => "publish",
  "posts_per_page"   => $limit,
  "orderby"          => "menu_order", // IntuitiveCPOの順
  "order"            => "ASC",
  "no_found_rows"    => true,
]);

if ($q->have_posts()):
  while ($q->have_posts()) : $q->the_post();
    $title = get_the_title(); // ページタイトル
    $url   = get_permalink(); // リンク先URL

// 出力するクラスをcontextに応じて切替え
if ($context === "header"): ?>
<li class="header-menu-sub-item">
  <a class="header-menu-sub-link js-header-menu-item-link" href="<?php echo esc_url($url); ?>">
    <?php echo esc_html($title); ?>
  </a>
</li>

<?php else: // topページの場合 ?>
<li class="top-business-item">
  <a href="<?php echo esc_url($url); ?>" class="top-business-link">
    <?php echo esc_html($title); ?>
  </a>
</li>
<?php endif;

endwhile;
wp_reset_postdata();
endif;