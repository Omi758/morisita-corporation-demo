  <?php get_header() ?>
  <!-- top-kv -->
  <main>
    <div class="top-kv">
      <div class="splide js-kv-slider">
        <div class="splide__track">
          <ul class="splide__list">
            <li class="splide__slide top-kv-slide js-slide">
              <div class="splide__slide-overlay"></div>
              <img src="<?php echo esc_url( get_template_directory_uri() . '/img/top-kv-slider1@2x.webp' ); ?>"
                width="882" height="573" alt="技術者による車体の整備作業風景の画像" decoding="async" />
            </li>
            <li class="splide__slide top-kv-slide js-slide">
              <div class="splide__slide-overlay"></div>
              <img src="<?php echo esc_url( get_template_directory_uri() . '/img/top-kv-slider2@2x.webp' ); ?>"
                width="882" height="573" alt="弊社の高品質なボルトとナットの画像" decoding="async" />
            </li>
            <li class="splide__slide top-kv-slide js-slide">
              <div class="splide__slide-overlay"></div>
              <img src="<?php echo esc_url( get_template_directory_uri() . '/img/top-kv-slider3@2x.webp' ); ?>"
                width="882" height="573" alt="車体整備工場内での作業点検用工具一式の画像" decoding="async" />
            </li>
          </ul>
        </div>
      </div>

      <div class="top-kv-content l-container">
        <div class="top-kv-progressbar">
          <svg class="top-kv-progress-circle" viewBox="0 0 146 146">
            <circle class="top-kv-progress-bg" cx="73" cy="73" r="71"></circle>
            <circle class="top-kv-progress-bar js-progress-bar" cx="73" cy="73" r="71"></circle>
          </svg>
          <span class="top-kv-progress-currentnumber js-progress-currentnumber">01</span>
        </div>

        <div class="top-kv-text-container">
          <p class="top-kv-text">
            <span>特殊ボルトナット制作の</span><span>プロフェッショナル</span>
          </p>
          <p class="top-kv-text-english" lang="en">
            <span>Special bolt and nut production </span><span>professionals</span>
          </p>
        </div>
      </div>
    </div>
    <!-- top-kv end -->
    <!-- top-news -->
    <section id="post-<?php the_ID(); ?>" <?php post_class("top-news"); ?>>
      <div class="top-news-wrapper">
        <div class="top-news-title c-section-title">
          <span class="c-section-title--en" lang="en">news</span>
          <h2 class="c-section-title--jp">お知らせ</h2>
        </div>

        <?php
        get_template_part( "template-parts/loop-news", null,[
          "layout"          => "top",
          "posts_per_page"  => 3,
          "with_pagination" => false,
        ] );
        ?>

        <?php
        $news_more_url ="";
        $posts_page_id = (int) get_option( 'page_for_posts' );
        if ( $posts_page_id ) {
          $news_more_url =get_permalink( $posts_page_id );
        }else {
          $news_more_url =home_url( '/news' ); //フォールバック（未設定時の暫定）
        }
        ?>

        <a href="<?php echo esc_url( $news_more_url ); ?>" class="top-news-button c-button c-button--lightest-blue">view
          more</a>
      </div>
    </section>
    <!-- top-news end -->

    <!-- top-business -->
    <section class="top-business">
      <div class="top-business-wrapper l-container">
        <picture class="top-business-image">
          <source media="(max-width:768px)"
            srcset="<?php echo esc_url( get_template_directory_uri() . '/img/top-business-thumb@2x.webp' ); ?>"
            width="340" height="227" />
          <img src="<?php echo esc_url( get_template_directory_uri() . '/img/top-business-thumb-pc@2x.webp' ); ?>"
            width="580" height="600" alt="自動車整備工場にてベテラン技師による車体整備の作業風景" decoding="async" />
        </picture>

        <div class="top-business-text-container">
          <div class="top-business-title c-section-title-small">
            <p class="c-section-title-small--en" lang="en">business</p>
            <h2 class="c-section-title--jp">事業紹介</h2>
          </div>

          <div>
            <p class="top-business-title-text">
              <span>高品質な</span><span>ボルトナットで、</span><span>世界を支える。</span>
            </p>
            <p class="top-business-text">
              <span>どんな環境にも、最適なソリューション。</span>
              <span>豊富な経験と技術力で、お客様のニーズに答える製品づくりをしています。</span>
            </p>
          </div>

          <ul class="top-business-list">
            <?php
            get_template_part("template-parts/loop", "business", [
              "context" => "top",
              "limit"   => -1, //全件表示
            ]);
            ?>
          </ul>
        </div>
      </div>
    </section>
    <!-- top-business end -->

    <!-- top-product -->
    <section class="top-product">
      <div class="l-container">
        <div class="top-product-text-container">
          <div class="top-product-title c-section-title-small">
            <p class="c-section-title-small--en c-section-title-small--white" lang="en">
              product
            </p>
            <h2 class="c-section-title--jp c-section-title-small--white">
              製品紹介
            </h2>
          </div>

          <div>
            <p class="top-product-title-text">確かな品質と技術力</p>
            <p class="top-product-text">
              <span>高品質・高精度のボルトナットを豊富に取り揃え。</span>
              <span>産業の要として、お客様のニーズに応える製品をお届けします。</span>
            </p>
          </div>
        </div>
      </div>

      <div class="top-product-slider-wrapper">
        <div class="splide top-product-slider js-product-slider">
          <div class="splide__track top-product-slider-track">
            <ul class="splide__list top-product-card-list">
              <?php
              $top_products = new WP_Query([
                "post_type"            => "product",
                "posts_per_page"       => -1,
                "ignore_sticky_posts"  => true,
                "no_found_rows"        => true,
                "orderby"              => "date",
                "order"                => "ASC", //昇順
              ]);

              if ( $top_products->have_posts() ) :
                while ( $top_products->have_posts() ) : $top_products->the_post();
              ?>

              <li class="splide__slide top-product-card">
                <?php get_template_part("template-parts/loop", "products"); ?>
              </li>

              <?php endwhile;
                wp_reset_postdata();
                else:
                ?>

              <li class="splide__slide top-product-card">
                <p class="top-product-text">現在、公開中の製品はありません。</p>
              </li>

              <?php endif; ?>

            </ul>
          </div>

          <div class="splide__arrows top-product-arrows">
            <button class="splide__arrow splide__arrow--prev">
              <span class="u-visually-hidden">前へ</span>
            </button>
            <button class="splide__arrow splide__arrow--next">
              <span class="u-visually-hidden">次へ</span>
            </button>
          </div>
        </div>
      </div>

      <div class="top-product-button">
        <a href="<?php echo esc_url( home_url( '/product' ) ); ?>" class="c-button c-button--white" lang="en">view
          more</a>
      </div>
    </section>
    <!-- top-product end -->
    <!-- top-subpages -->
    <div class="top-subpages">
      <div class="top-subpages-wrapper l-container">
        <ul class="top-subpages-list">
          <li class="top-subpage-item">
            <section>
              <a href="<?php echo esc_url( home_url( '/company' ) ); ?>" class="top-subpage-link">
                <div class="top-subpage-title c-section-title">
                  <p class="c-section-title--en" lang="en">company</p>
                  <h2 class="c-section-title--jp">会社概要</h2>
                </div>
                <p class="top-subpage-text">
                  事業内容、経営方針など、当社を深く知っていただくための情報をご紹介します。
                </p>
              </a>
            </section>
          </li>

          <li class="top-subpage-item">
            <section>
              <a href="<?php echo esc_url( home_url( '/message' ) ); ?>" class="top-subpage-link">
                <div class="top-subpage-title c-section-title">
                  <p class="c-section-title--en" lang="en">message</p>
                  <h2 class="c-section-title--jp">代表挨拶</h2>
                </div>
                <p class="top-subpage-text">
                  私たちの理念と未来への展望をお伝えします。社長からのメッセージをご覧ください。
                </p>
              </a>
            </section>
          </li>

          <li class="top-subpage-item">
            <section>
              <a href="<?php echo esc_url( home_url( '/access' ) ); ?>" class="top-subpage-link">
                <div class="top-subpage-title c-section-title">
                  <p class="c-section-title--en" lang="en">access</p>
                  <h2 class="c-section-title--jp">アクセス</h2>
                </div>
                <p class="top-subpage-text">
                  本社工場や営業所の所在地、詳細な地図と交通手段をご確認いただけます。
                </p>
              </a>
            </section>
          </li>
        </ul>
      </div>
    </div>
  </main>
  <!-- top-subpages end -->
  <?php get_footer(); ?>