/**
 * トップページの製品紹介スライダー
 * Splideを使用
 */
export const initializeTopProductSlider = () => {
  const splideElement = document.querySelector(".js-product-slider");

  if (!splideElement) {
    return;
  }

  const splide = new Splide(splideElement, {
    type: "loop", // ループモード
    perMove: 1, // 1回の移動で1枚ずつスライド
    fixedWidth: "404px", // ← これが重要_スライドの幅を固定
    gap: "32px",
    arrows: true, // 矢印ナビゲーションを有効化
    pagination: false,
    drag: true, // ドラッグ操作を有効化
    // レスポンシブ設定
    breakpoints: {
      767: {
        fixedWidth: "300px", // レスポンシブ対応_767px以下の設定
        gap: "24px",
      },
    },
  });

  // try...catchで安全にマウント
  try {
    splide.mount();
  } catch (error) {
    console.error("Failed to initialize Product Slider:", error);
  }
};
