/**
 * business ページの TOC 現在地ハイライト & アンカー移動
 * - GSAP ScrollTrigger を使用（ハイライト）
 * - クリックでネイティブの smooth スクロール（固定ヘッダー考慮）
 * - 目次リンク: .js-business-toc-link（href="#problem" 等）
 * - 対象セクション: #problem, #feature, #flow（HTMLのIDと対応）
 */

export function initializeTocScrollTrigger() {
  // GSAPとScrollTriggerプラグインが読み込まれていなければ処理を中断
  if (typeof gsap === "undefined" || typeof ScrollTrigger === "undefined") {
    console.error("GSAP or ScrollTrigger is not loaded.");
    return;
  }

  // グローバルにある ScrollTrigger / ScrollToPlugin を register
  try {
    if (typeof ScrollToPlugin !== "undefined") {
      gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);
    } else {
      gsap.registerPlugin(ScrollTrigger);
    }
  } catch (e) {
    console.warn(e);
  }

  // 必要なDOM要素を取得
  const tocLinks = gsap.utils.toArray(".js-business-toc-link");
  const header = document.querySelector(".header"); // 固定ヘッダー

  // 目次リンクが存在しない、または対応するセクションがない場合は処理を中断
  if (tocLinks.length === 0) {
    return;
  }

  // 各リンクに対応するセクション要素を取得
  const sections = tocLinks
    .map((link) => document.querySelector(link.getAttribute("href")))
    .filter(Boolean); // null（対応セクションがない）を除外

  if (sections.length === 0) {
    return;
  }

  // 現在地ハイライト_アクティブなリンクを設定するヘルパー関数
  const setActive = (activeIndex) => {
    tocLinks.forEach((link, i) => {
      if (i === activeIndex) {
        link.classList.add("is-active");
        link.setAttribute("aria-current", "location");
      } else {
        link.classList.remove("is-active");
        link.removeAttribute("aria-current");
      }
    });
  };

  // 各セクションに対してScrollTriggerを設定
  sections.forEach((section, i) => {
    ScrollTrigger.create({
      trigger: section,
      start: "top center", // トリガーの上端が、画面中央に来た時に開始
      end: "bottom center", // トリガーの下端が、画面中央を通過した時に終了
      onEnter: () => setActive(i),
      onEnterBack: () => setActive(i),
      // markers: true, // デバッグ用にマーカー
    });
  });

  // 目次リンククリック時のスムーズスクロール処理
  tocLinks.forEach((link) => {
    link.addEventListener("click", (e) => {
      e.preventDefault(); // デフォルトのアンカーリンク動作を無効化
      const targetId = link.getAttribute("href");
      const headerHeight = header ? header.offsetHeight : 0;

      // GSAPのScrollToPluginを使用してスムーズスクロール
      gsap.to(window, {
        duration: 0.8,
        ease: "power2.inOut",
        scrollTo: { y: targetId, offsetY: headerHeight },
      });
    });
  });
}
