<?php

/**
 * ===============================
 * bodyタグにページごとのクラスを付与する
 * topページ＝白いロゴ、白文字
 * 下層ページ＝カラーのロゴ、黒い文字
 * ===============================
 */
function my_theme_body_class($classes) {
    if (is_front_page()) {
        $classes[] = 'page-top';
        $classes[] = 'js-page-top';
    } else {
        $classes[] = 'page-sub';
    }
    return $classes;
}
add_filter('body_class', 'my_theme_body_class');

/**
 * ===============================
 * ESモジュールの読み込み
 * ===============================
 */
function add_type_attribute_to_script($tag, $handle, $src) {
    // "morisita-corporation-main"のハンドルを持つスクリプトにだけtype="module"を追加
    if ("morisita-corporation-main" === $handle) {
        $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
    }
    return $tag;
}
add_filter("script_loader_tag", "add_type_attribute_to_script", 10, 3);

/**
 * ===============================
 * Google Fonts,CSS,JS,splide,gsapを読み込む
 * ===============================
 */
function my_theme_enqueue_scripts() {
    // Google Fonts
    wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@500&family=Play:wght@400;700&family=Zen+Kaku+Gothic+New:wght@400;500;700&display=swap', array(), null );

    // CSS
    wp_enqueue_style( 'splide-core-style', get_template_directory_uri() . '/css/vendor/splide-core.min.css', array(), '4.1.4' );
    wp_enqueue_style( 'my-theme-style', get_template_directory_uri() . '/css/style.css', array('splide-core-style'), '1.0.0' );

    // JS
    // 依存関係を配列で指定_gsap -> ScrollTrigger -> ScrollToPlugin の順で読み込まれる_array('依存ファイル')
    wp_enqueue_script( 'gsap', get_template_directory_uri() . '/js/vendor/gsap.min.js', array(), '3.12.5', true );
    wp_enqueue_script( 'scroll-trigger', get_template_directory_uri() . '/js/vendor/ScrollTrigger.min.js', array('gsap'), '3.12.5', true );
    wp_enqueue_script( 'scroll-to-plugin', get_template_directory_uri() . '/js/vendor/ScrollToPlugin.min.js', array('gsap'), '3.12.5', true );

    // splide
    wp_enqueue_script( 'splide', get_template_directory_uri() . '/js/vendor/splide.min.js', array(), '4.1.4', true );
    wp_enqueue_script( 'splide-extension-auto-scroll', get_template_directory_uri() . '/js/vendor/splide-extension-auto-scroll.min.js', array('splide'), '0.5.3', true );

    // 'gsap', 'splide' など、このテーマで読み込んでいる他のJSに依存する場合
    $main_js_dependencies = array('gsap', 'scroll-trigger', 'scroll-to-plugin', 'splide', 'splide-extension-auto-scroll');
    wp_enqueue_script( 'morisita-corporation-main', get_template_directory_uri() . '/js/main.js', $main_js_dependencies, '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_scripts' );


/**
 * ===============================
 * titleの区切り文字を変更
 * ===============================
 */
add_filter("document_title_separator", "my_document_title_separator");
function my_document_title_separator($separator) {
    $separator = "|";
    return $separator;
}

/**
 * ===============================
 * アイキャッチ画像を使用可能にする
 * ===============================
 */
add_theme_support("post-thumbnails");

// 製品ヒーロー(横長)：1400 * 900 を中心に運用
add_image_size("product_hero", 1400, 900, true);

// サブKV右側サムネ (PC版で484*323)
add_image_size("subkv_single", 484, 323, true);

// サムネ群
add_image_size("product_thumb_square", 640, 640, true);

/**
 * ===============================
 * Contact Form 7の自動整形を無効化
 * ===============================
 */
add_filter("wpcf7_autop_or_not", "my_wpcf7_autop");
function my_wpcf7_autop() {
    return false;
}

/**
 * ===============================
 * access-archive.phpのACFで設定したorderの並び順
 * ===============================
 */
add_action("pre_get_posts", function($q){
    if (!is_admin() && $q->is_main_query() && is_post_type_archive("access")) {

        $q->set("meta_query",[
            "relation" => "AND",
            "hp" => [
                "key" => "is_headquarters",
                "type" => "NUMERIC",
                "compare" => "EXISTS"
            ],
            "ord" => [
                "key" => "order",
                "type" => "NUMERIC",
                "compare" => "EXISTS"
            ]
        ]);

        $q->set("orderby",[
            "hp" => "DESC", //本社が最初
            "ord" => "ASC", // order順(小→大)
            "date" => "ASC", // 同順位なら日付順(古→新)
        ]);
    }
});

/**
 * ===============================
 * Breadcrumb NavXT
 * product の個別投稿では「タクソノミー系パンくず」を常に除去する
 * - 管理画面からも設定で消しているが、将来の設定変更や復元で戻らない為の保険
 * ===============================
 */
add_action('bcn_after_fill', function ($trail) {
    if (!function_exists('bcn_display')) {
        return;
    }
    // 製品（product）のシングル以外は対象外
    if (!is_singular('product')) {
        return;
    }
    if (!is_object($trail) || !isset($trail->breadcrumbs) || !is_array($trail->breadcrumbs)) {
        return;
    }

    // taxonomy/term タイプのパンくずを全除去
    // （将来タクソノミー名が増減しても壊れない汎用版）
    foreach ($trail->breadcrumbs as $i => $crumb) {
        if (isset($crumb->type) && is_array($crumb->type)) {
            // 例：['post', 'taxonomy', 'product_cat'] など
            if (in_array('taxonomy', $crumb->type, true) || in_array('term', $crumb->type, true)) {
                unset($trail->breadcrumbs[$i]);
            }
        }
    }
    // 削除して“飛び番号”になった配列を、きれいに番号を詰め直して再格納
    $trail->breadcrumbs = array_values($trail->breadcrumbs);
}, 10, 1);

/**
 * =========================================
 * Breadcrumb NavXT：事業紹介（/business）を非リンク化
 * =========================================
 */
add_action('bcn_after_fill', function ($trail) {
  if (!is_singular('business')) return;
  $target = trailingslashit(home_url('/business/'));
  foreach ($trail->breadcrumbs as $crumb) {
    if (method_exists($crumb, 'get_url') && trailingslashit($crumb->get_url()) === $target) {
      $crumb->set_linked(false);
    }
  }
});


/**
 * =========================================
 * archives-sitemap.xml
 * - /news/date/... を除外
 * - /product/ を無ければ追記（プラグイン設定だけではproductが表示されない為）
 *   ※ XML Sitemap Generator の内部仕様に依存しない
 * =========================================
 */
add_action('init', function () {
    $uri = $_SERVER['REQUEST_URI'] ?? '';
    // 末尾が archives-sitemap.xml の時だけフック
    if (is_string($uri) && preg_match('~/archives-sitemap\.xml(\?.*)?$~', $uri)) {
        ob_start(function ($xml) {
            // 文字列以外ならそのまま返す
            if (!is_string($xml) || stripos($xml, '<urlset') === false) {
                return $xml;
            }

            // 1) /news/date/... のURLブロックを除去
            //   <url> ... <loc>https://.../news/date/2025/10/</loc> ... </url> を丸ごと削除
            $xml = preg_replace('/<url>\s*<loc>[^<]*?\/date\/[^<]*<\/loc>.*?<\/url>\s*/si', '', $xml);

            // 2) /product/ を無ければ追記
            $productUrl = rtrim(home_url('/product/'), '/').'/';
            if (strpos($xml, '<loc>' . $productUrl . '</loc>') === false) {
                $lastmod = gmdate('Y-m-d\TH:i:s+00:00');
                $entry = <<<XML
<url>
  <loc>{$productUrl}</loc>
  <priority>0.5</priority>
  <changefreq>weekly</changefreq>
  <lastmod>{$lastmod}</lastmod>
</url>

XML;
                $xml = str_replace('</urlset>', $entry . '</urlset>', $xml);
            }

            return $xml;
        });
    }
});

/**
 * =========================================
 * News個別投稿ページ_エディタの見た目を揃える
 * - ブロックエディタにCSS適応
 * - ブロックエディタ内でGoogle Fontsを読み込む
 * =========================================
 */
add_action("after_setup_theme", function(){
    add_theme_support("editor-styles");
    add_editor_style(array(
        "css/editor-style.css",
        // エディタ iframeにフォントを読み込み
         'https://fonts.googleapis.com/css2?family=Montserrat:wght@500&family=Play:wght@400;700&family=Zen+Kaku+Gothic+New:wght@400;500;700&display=swap',
    ));
});

/**
 * =========================================
 * Newsアーカイブ（/news/...） 年・月・日 & ページネーション
 * 例:
 *  - /news/2025/
 *  - /news/2025/10/
 *  - /news/2025/10/12/
 *  - /news/2025/page/2/
 *  - /news/2025/10/page/2/
 *  - /news/2025/10/12/page/2/
 * =========================================
 */
add_action('init', function () {
    // 年
    add_rewrite_rule(
        '^news/([0-9]{4})/?$',
        'index.php?year=$matches[1]',
        'top'
    );
    // 年: ページ
    add_rewrite_rule(
        '^news/([0-9]{4})/page/([0-9]{1,})/?$',
        'index.php?year=$matches[1]&paged=$matches[2]',
        'top'
    );
    // 年/月
    add_rewrite_rule(
        '^news/([0-9]{4})/([0-9]{1,2})/?$',
        'index.php?year=$matches[1]&monthnum=$matches[2]',
        'top'
    );
    // 年/月: ページ
    add_rewrite_rule(
        '^news/([0-9]{4})/([0-9]{1,2})/page/([0-9]{1,})/?$',
        'index.php?year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]',
        'top'
    );
    // 年/月/日
    add_rewrite_rule(
        '^news/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$',
        'index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]',
        'top'
    );
    // 年/月/日: ページ
    add_rewrite_rule(
        '^news/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/page/([0-9]{1,})/?$',
        'index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&paged=$matches[4]',
        'top'
    );
});

/**
 * =========================================
 * accessのシングルURLをアーカイブへリダイレクト
 * 例: /access/fukuoka/ → /access/
 * =========================================
 */
add_action('template_redirect', function () {
    // 管理画面・preview・REST等は除外
    if (is_admin() || is_preview() ) {
        return;
    }
    // /access/{slug} (=シングル)に来たらアーカイブへリダイレクト(301)
    if (is_singular('access')) {
        $archive = get_post_type_archive_link('access');
        if ($archive) {
            wp_safe_redirect($archive, 301);
            exit;
        }
    // 保険（通常ここは通らない）：取得失敗時は404を返す
        global $wp_query;
        $wp_query->set_404();
        status_header(404);
    }
});

/**
 * =========================================
 * カスタム投稿タイプのアーカイブページのdescriptionを
 * CPT UI の「説明文 (description)」から自動反映させる
 * 今回: access(archive-access.php)と製品一覧(archive-product.php)
 * =========================================
 */
add_filter('ssp_output_description', function( $desc ) {

    // カスタム投稿タイプのアーカイブページの場合のみ
    if ( is_post_type_archive() ) {

        // 現在の投稿タイプスラッグを取得（例：'access'、'product'）
        $post_type = get_query_var('post_type');

        // 投稿タイプオブジェクトを取得
        $post_type_obj = get_post_type_object( $post_type );

        // 投稿タイプに登録されている description が存在すれば、それを meta に反映
        if ( $post_type_obj && ! empty( $post_type_obj->description ) ) {
            return esc_html( $post_type_obj->description );
        }
    }

    // その他はデフォルトの description を返す
    return $desc;
});

/**
 * =========================================
 * WPセキュリティ（露出を減らす・軽量化）
 * - バージョン情報の非表示等
 * =========================================
 */
add_action('init', function () {
    // 露出を減らす（小さなプラス）
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'feed_links_extra', 3);

    // 絵文字（前後とも無効化）
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');

    // ❌ rel_canonical は基本的に消さない（SEO上重要）
    // remove_action('wp_head', 'rel_canonical'); // 非推奨
});