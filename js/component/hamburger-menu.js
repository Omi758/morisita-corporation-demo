/**
 * ハンバーガーメニュー開閉制御機能
 *
 * 機能概要：
 * - ハンバーガーメニューの開閉動作を制御
 * - GSAPを使用したフェードイン/アウトアニメーション
 * - 複数の操作でメニューを閉じることが可能（クローズボタン、メニューリンク、Escapeキー、リサイズ）
 *
 * 開閉条件：
 * - 開く：ハンバーガーメニューボタンクリック
 * - 閉じる：クローズボタンクリック、メニューリンククリック、Escapeキー、画面リサイズ（768px以上）
 * - Windows環境でのスクロールバー表示を常に維持するため、html要素にoverflow-y: scrollを設定
 */
export const initializeHamburgerMenu = () => {
  const menu = document.querySelector(".js-header-menu");
  const openButton = document.querySelector(".js-hamburger-button");
  const closeButton = document.querySelector(".js-hamburger-close-button");

  if (!menu || !openButton || !closeButton) return;

  const menuItems = menu.querySelectorAll(".js-header-menu-item-link");

  // メニュー表示時
  const openMenu = () => {
    menu.showModal();

    gsap.fromTo(
      menu,
      { opacity: 0 }, // 開始状態
      {
        opacity: 1, // 終了状態
        duration: 0.3,
        ease: "power2.out",
      }
    );
  };

  // メニュー非表示
  const closeMenu = () => {
    gsap.to(menu, {
      opacity: 0,
      duration: 0.3,
      ease: "power2.out",
      onComplete: () => {
        menu.close();

        // GSAPによって追加されたopacityスタイルをクリア
        gsap.set(menu, { clearProps: "opacity" });
      },
    });
  };

  // リサイズ時
  const closeMenuImmediately = () => {
    gsap.killTweensOf(menu);
    gsap.set(menu, { clearProps: "all" });

    menu.close();
  };

  openButton.addEventListener("click", () => {
    openMenu();
  });

  // 閉じる（クローズボタン + メニュー内リンク）
  [closeButton, ...menuItems].forEach((element) => {
    element.addEventListener("click", () => {
      closeMenu();
    });
  });

  // Escapeキーで閉じる
  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") {
      event.preventDefault(); // デフォルト動作を無効化
      closeMenu();
    }
  });

  // 768px以上になったらメニュー強制クローズ
  window.addEventListener("resize", () => {
    if (menu.open && window.innerWidth >= 768) {
      closeMenuImmediately();
    }
  });
};
