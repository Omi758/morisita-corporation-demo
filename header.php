<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="format-detection" content="telephone=no" />

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  <header class="header l-container">
    <div class="header-inner">
      <h1 class="header-logo">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
          <img src="<?php echo esc_url( get_template_directory_uri() . '/img/logo-color.svg' ); ?>" width="300"
            height="90" alt="MORISHITA Corporation" decoding="async" />
        </a>
      </h1>

      <!-- hamburger-menu -->
      <dialog class="header-menu js-header-menu" aria-label="メニュー">
        <!-- <div class="l-container"> -->
        <div class="header-menu-head">
          <div class="header-logo">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/img/logo-white.svg' ); ?>" width="300"
              height="90" alt="MORISHITA Corporation" decoding="async" />
          </div>
          <button class="header-menu-close-button js-hamburger-close-button" aria-label="メニューを閉じる">
            <span class="header-menu-close-line">
              <span></span>
              <span></span>
            </span>
          </button>
        </div>

        <div class="header-menu-container">
          <nav class="header-menu-nav" aria-label="メインメニュー">
            <ul class="header-menu-list">
              <li class="header-menu-item">
                <a class="header-menu-link js-header-menu-item-link" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                  <span class="header-menu-item-en" lang="en">home</span>
                  <span class="header-menu-item-jp">ホーム</span>
                </a>
              </li>
              <li class="header-menu-item">
                <a class="header-menu-link js-header-menu-item-link"
                  href="<?php echo esc_url( home_url( '/company' ) ); ?>">
                  <span class="header-menu-item-en" lang="en">company</span>
                  <span class="header-menu-item-jp">会社概要</span>
                </a>
              </li>
              <li class="header-menu-item">
                <button class="header-menu-title" type="button" aria-haspopup="true" aria-expanded="false">
                  <span class="header-menu-item-en" lang="en">business</span>
                  <span class="header-menu-item-jp">事業紹介</span>
                </button>
                <!-- sub-link -->
                <ul class="header-menu-sub-list">
                  <?php
                  get_template_part("template-parts/loop", "business", [
                    "context" => "header",
                    "limit"   => -1, // 全件表示
                  ]);
                  ?>
                </ul>
                <!-- sub-link end  -->
              </li>
              <li class="header-menu-item">
                <a class="header-menu-link js-header-menu-item-link"
                  href="<?php echo esc_url( home_url( '/product' ) ); ?>">
                  <span class="header-menu-item-en" lang="en">product</span>
                  <span class="header-menu-item-jp">製品紹介</span>
                </a>
              </li>
              <li class="header-menu-item">
                <a class="header-menu-link js-header-menu-item-link"
                  href="<?php echo esc_url( home_url( '/access' ) ); ?>">
                  <span class="header-menu-item-en" lang="en">access</span>
                  <span class="header-menu-item-jp">アクセス</span>
                </a>
              </li>
              <li class="header-menu-item">
                <a class="header-menu-link js-header-menu-item-link"
                  href="<?php echo esc_url( home_url( '/contact' ) ); ?>">
                  <span class="header-menu-item-en" lang="en">contact</span>
                  <span class="header-menu-item-jp">お問い合わせ</span>
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </dialog>
      <!-- hamburger-menu end -->

      <button class="header-hamburger-button js-hamburger-button" aria-label="メニューを開く">
        <span class="header-hamburger-button-line">
          <span></span>
          <span></span>
          <span></span>
        </span>
      </button>
    </div>
  </header>