/**
 * CTAセクションの流れる文字
 * - splide-extension-auto-scrollを使用
 */
// cta-auto-scroll.js
export function initializeCtaAutoScroll() {
  const nodes = document.querySelectorAll(".js-cta-marquee");
  if (!nodes.length) return;

  const reduced = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  nodes.forEach((el) => {
    const splide = new window.Splide(el, {
      type: "loop",
      arrows: false,
      pagination: false,
      drag: false,
      autoWidth: true, // テキスト長に応じて可変幅
      gap: 0,
      autoScroll: {
        speed: reduced ? 0 : 1.2, // 三項演算子_「ユーザーが動きを減らす設定なら止める、そうでなければ流す」
        pauseOnHover: false,
        pauseOnFocus: false,
      },
    });

    // 拡張機能をセットする
    splide.mount(window.splide.Extensions);
  });
}
