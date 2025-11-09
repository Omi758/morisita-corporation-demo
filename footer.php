  <?php if ( !is_page("contact") ) : ?>
  <!-- cta -->
  <div class="c-cta c-cta--has-marquee">
    <div class="splide c-cta-marquee js-cta-marquee" aria-hidden="true">
      <div class="splide__track">
        <ul class="splide__list">
          <li class="splide__slide">contact us</li>
          <li class="splide__slide">contact us</li>
          <li class="splide__slide">contact us</li>
          <li class="splide__slide">contact us</li>
        </ul>
      </div>
    </div>

    <div class="c-cta-wrapper l-container">
      <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="c-cta-button">
        <div class="c-cta-button-text">
          <p class="c-cta-button-text--en" lang="en">contact</p>
          <p class="c-cta-button-text--jp">お問い合わせ</p>
        </div>
      </a>
    </div>
  </div>
  <!-- cta end -->
  <?php endif; ?>

  <!-- footer -->
  <footer class="footer">
    <button type="button" class="footer-scroll-button js-scroll-top-button">
      <span class="u-visually-hidden">トップへ</span>
    </button>
    <div class="footer-wrapper l-container">
      <div class="footer-inner">
        <a class="footer-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img
            src="<?php echo esc_url( get_template_directory_uri() . '/img/logo-white@2x.png' ); ?>" width="300"
            height="90" alt="MORISHITA Corporation" decoding="async" />
        </a>
        <div class="footer-company-info">
          <span class="footer-address">〒123-4567 東京都春日区青葉町2-11-7</span>
          <div class="footer-tel">
            <span class="footer-tel-text" lang="en">Tel.</span><span class="footer-tel-number">03-1234-5678</span>
          </div>
        </div>
      </div>

      <div class="footer-content">
        <nav class="footer-nav" aria-label="サブメニュー">
          <ul class="footer-nav-list-main">
            <li class="footer-nav-item-main">
              <a class="footer-nav-link-main" href="<?php echo esc_url( home_url( '/' ) ); ?>" lang="en">home</a>
            </li>
            <li class="footer-nav-item-main">
              <a class="footer-nav-link-main" href="<?php echo esc_url( home_url( '/company' ) ); ?>">会社概要</a>
            </li>
            <li class="footer-nav-item-main">
              <a class="footer-nav-link-main" href="<?php echo esc_url( home_url( '/message' ) ); ?>">代表挨拶</a>
            </li>
            <li class="footer-nav-item-main">
              <a class="footer-nav-link-main" href="<?php echo esc_url( home_url( '/access' ) ); ?>">アクセス</a>
            </li>
          </ul>

          <ul class="footer-nav-list-works">
            <li class="footer-nav-item-works">事業紹介</li>
            <li class="footer-nav-item-works">
              <ul class="footer-nav-sub-list-works">
                <li class="footer-nav-sub-item-works">
                  <a href="<?php echo esc_url( home_url( '/business/design' ) ); ?>">特殊ボルトナットの設計・製造</a>
                </li>
                <li class="footer-nav-sub-item-works">
                  <a href="<?php echo esc_url( home_url( '/business/order-made' ) ); ?>">特殊ボルトナットのオーダーメイド</a>
                </li>
                <li class="footer-nav-sub-item-works">
                  <a href="<?php echo esc_url( home_url( '/business/quality-control' ) ); ?>">ISO 9001 認証取得の品質管理</a>
                </li>
              </ul>
            </li>
            <li class="footer-nav-item-works">
              <a class="footer-nav-link-works" href="<?php echo esc_url( home_url( '/product' ) ); ?>">製品紹介</a>
            </li>
          </ul>

          <ul class="footer-nav-list-info">
            <li class="footer-nav-item-info">
              <a class="footer-nav-link-info" href="<?php echo esc_url( home_url( '/news' ) ); ?>">お知らせ</a>
            </li>
            <li class="footer-nav-item-info">
              <a class="footer-nav-link-info" href="<?php echo esc_url( home_url( '/contact' ) ); ?>">お問い合わせ</a>
            </li>
            <li class="footer-nav-item-info">
              <a class="footer-nav-link-info" href="<?php echo esc_url( home_url( '/privacy' ) ); ?>">プライバシーポリシー</a>
            </li>
          </ul>
        </nav>
      </div>
      <small class="footer-copyright">&copy; 2024 MORISHITA inc.</small>
    </div>
  </footer>
  <!-- footer end -->
  <?php wp_footer(); ?>
  </body>

  </html>