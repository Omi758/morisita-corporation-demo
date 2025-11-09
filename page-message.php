    <?php get_header(); ?>
    <!-- message-kv -->
    <?php if ( have_posts() ) :while ( have_posts() ) : the_post(); ?>

    <section class="c-subkv">
      <div class="l-container">
        <div class="c-subkv-title">
          <span class="c-subkv-title--en" lang="en"><?php echo esc_html (strtoupper($post->post_name)); ?></span>
          <h1 class="c-subkv-title--ja"><?php the_title(); ?></h1>
        </div>
      </div>
    </section>

    <!-- パンくず -->
    <?php get_template_part( "template-parts/breadcrumb" ); ?>

    <!-- message-kv end -->

    <!-- message -->
    <main>
      <div class="message">
        <div class="message-wrapper l-container-s">
          <?php
          // ----- 画像の取得（ACF：ID返り値想定）-----
          $img_sp_id =get_field("message_image_sp"); //SP用
          $img_pc_id =get_field("message_image_pc"); //PC用(必須)
          
          // ALT(PC優先→SP→既定)
          $alt_pc = $img_pc_id ? get_post_meta($img_pc_id, "_wp_attachment_image_alt", true) : "";
          $alt    = $alt_pc !== "" ? $alt_pc : "代表挨拶の写真";
          
          // SPのsrcset(<source>用)
          $sp_srcset = $img_sp_id ? wp_get_attachment_image_srcset($img_sp_id, "message_sp") : "";
          
          // ----- 見出し（最大3行 : 改行で分割） -----
          // string=キャスト演算子でnull対策、trim=前後空白除去
          // preg_split(分割する関数)_正規表現 /\r\n|\r|\n/ = CRLF(win) / LF(mac/linux/unix) / CR(古いmac)
          $heading_raw = trim((string) get_field("message_heading"));
          $lines = preg_split("/\r\n|\r|\n/", $heading_raw);
          $lines = array_values(array_filter(array_map("trim", $lines), fn($v)=>$v!==""));
          $line1 = $lines[0] ?? "";
          $line2 = $lines[1] ?? "";
          $line3 = $lines[2] ?? "";

          // ----- 本文・役職・氏名 -----
          $body = get_field("message_body");
          $role = get_field("message_role");
          $name = get_field("message_name");
?>

          <figure class="message-image">
            <picture>
              <?php if ( $sp_srcset ) : ?>
              <source media="(max-width: 1079px)" srcset="<?php echo esc_attr( $sp_srcset ); ?>"
                sizes="(max-width: 1079px) 100vw, 484px">
              <?php endif; ?>

              <?php
              // PC画像_必須前提
              echo wp_get_attachment_image($img_pc_id, "message_pc", false, [
                "alt"     => $alt,
                "loading" => "lazy",
                "decoding"=> "async",
                "width"   => "400",
                "height"  => "533",
              ]);
              ?>
            </picture>
          </figure>

          <div class="message-text-wrapper">
            <div class="message-text-container">
              <p class="message-heading">
                <?php if ($line1 !== ""): ?>
                <span class="message-heading-first"><?php echo esc_html($line1); ?></span>
                <?php endif; ?>
                <?php if ($line2 !== "" || $line3 !== ""): ?>
                <span class="message-heading-second">
                  <?php if ($line2 !== ''): ?><span><?php echo esc_html($line2); ?></span><?php endif; ?>
                  <?php if ($line3 !== ''): ?><span><?php echo esc_html($line3); ?></span><?php endif; ?>
                </span>
                <?php endif; ?>
              </p>

              <div class="message-text">
                <?php echo wp_kses_post($body); ?>
              </div>
            </div>
            <div class="message-name-container">
              <p class="message-role"><?php echo esc_html($role); ?></p>
              <p class="message-name"><?php echo esc_html($name); ?></p>
            </div>
          </div>
        </div>
      </div>
    </main>
    <?php endwhile; ?>
    <?php endif; ?>

    <!-- message end -->

    <?php get_footer(); ?>