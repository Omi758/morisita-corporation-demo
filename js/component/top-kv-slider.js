/**
 * top-kvのメインビジュアルのスライダー
 * splideを使用、プログレスバーの設置
 * JavaScript主導のアニメーション制御版
 */

export const initializeTopKvSlider = () => {
  // トップページはbody に .js-page-top が付く設計なので、それ以外は初期化しない
  if (!document.body.classList.contains("js-page-top")) return;

  // --- 追加2：Splide 本体が未読込なら何もしない（他ページ最適化） ---
  if (typeof Splide === "undefined") return;
  // ========================================
  // 基本設定と要素取得
  // ========================================
  const splideElement = document.querySelector(".js-kv-slider");
  const progressBar = document.querySelector(".js-progress-bar");
  const currentNumberElement = document.querySelector(
    ".js-progress-currentnumber"
  );

  // 要素の存在チェック
  if (!splideElement || !progressBar || !currentNumberElement) {
    console.info("Required elements not found for KV slider");
    return;
  }

  // スライドと画像要素を最初に一度だけ取得（キャッシュ）
  const slides = Array.from(splideElement.querySelectorAll(".js-slide"));
  const slideImages = slides.map((slide) => slide.querySelector("img"));

  // 円周の計算（SVGのr属性に依存）
  const radius = 71;
  const circumference = 2 * Math.PI * radius;

  // ========================================
  // アニメーションと状態管理用の変数
  // ========================================
  let currentProgressAnimation = null;
  let currentImageAnimations = [];

  // ========================================
  // アニメーション制御関数
  // ========================================

  // プログレスバーとスライド番号を更新する関数
  const updateProgress = (slideIndex) => {
    // 現在のスライド番号を更新(1から始まる)
    const displayNumber = String(slideIndex + 1).padStart(2, "0");
    currentNumberElement.textContent = displayNumber;

    // 前のアニメーションを確実に停止
    if (currentProgressAnimation) {
      currentProgressAnimation.cancel();
    }

    // プログレスバーを瞬時にリセット
    progressBar.style.transition = "none";
    progressBar.style.strokeDashoffset = circumference;

    // 強制的にレンダリングを実行
    progressBar.offsetHeight;

    // Web Animations API を使用してプログレスバーをアニメーション
    currentProgressAnimation = progressBar.animate(
      [{ strokeDashoffset: circumference }, { strokeDashoffset: 0 }],
      {
        duration: splide.options.interval, // Splideのオプションから時間を取得
        easing: "linear",
        fill: "forwards",
      }
    );
  };

  // 画像のズームアニメーションを生成するヘルパー関数
  const animateImageZoom = (img, fromScale, toScale, duration) => {
    return img.animate(
      [
        { transform: `scale(${fromScale})` },
        { transform: `scale(${toScale})` },
      ],
      {
        duration: duration,
        easing: "linear",
        fill: "forwards",
      }
    );
  };

  // 画像のズームエフェクトを制御する関数
  const handleImageZoom = (activeIndex) => {
    // 実行中のズームアニメーションがあればすべて停止
    currentImageAnimations.forEach((animation) => {
      if (animation && animation.playState !== "finished") {
        animation.cancel();
      }
    });
    currentImageAnimations = [];

    // キャッシュした画像要素に対して処理を実行
    slideImages.forEach((img, index) => {
      if (img) {
        if (index === activeIndex) {
          // アクティブなスライド：105% -> 100% にズーム
          const animation = animateImageZoom(
            img,
            1.05,
            1,
            splide.options.interval
          );
          currentImageAnimations.push(animation);
        } else {
          // 非アクティブなスライド：105% にリセット
          img.style.transform = "scale(1.05)";
        }
      }
    });
  };

  // アニメーションのための初期スタイルを設定する関数
  const setupInitialImageStyles = () => {
    // キャッシュした画像要素に対して処理を実行
    slideImages.forEach((img) => {
      img.style.transition = "none";
      // 全てのスライドをズームアウト状態（105%）で開始
      img.style.transform = "scale(1.05)";
    });
  };

  // ========================================
  // Splideの初期化
  // ========================================
  const splide = new Splide(splideElement, {
    type: "fade",
    rewind: true,
    autoplay: true,
    speed: 1000, // フェードの時間
    interval: 7000, // スライドが切り替わる間隔
    arrows: false,
    pagination: false,
    pauseOnHover: false,
    pauseOnFocus: false,
    drag: false,
    keyboard: false,
  });

  // ========================================
  // イベントリスナーの設定
  // ========================================

  // スライダーマウント時の処理
  splide.on("mounted", () => {
    setupInitialImageStyles();

    // 初期化完了後、最初のアニメーションを即座に開始
    updateProgress(0);
    handleImageZoom(0);
  });

  // スライド移動時の処理
  splide.on("moved", (newIndex) => {
    updateProgress(newIndex);
    handleImageZoom(newIndex);
  });

  // 自動再生が開始または再開された時の処理
  splide.on("autoplay:play", () => {
    // 一時停止していたアニメーションを再生
    if (
      currentProgressAnimation &&
      currentProgressAnimation.playState === "paused"
    ) {
      currentProgressAnimation.play();
    }
    currentImageAnimations.forEach((animation) => {
      if (animation && animation.playState === "paused") {
        animation.play();
      }
    });
  });

  // 自動再生が一時停止された時の処理
  splide.on("autoplay:pause", () => {
    // 自動再生停止時はアニメーションも一時停止
    if (currentProgressAnimation) {
      currentProgressAnimation.pause();
    }
    currentImageAnimations.forEach((animation) => {
      if (animation) animation.pause();
    });
  });

  // ========================================
  // スライダーをマウント
  // ========================================
  try {
    splide.mount();
  } catch (error) {
    console.error("Failed to initialize Top KV Slider:", error);
  }
};
