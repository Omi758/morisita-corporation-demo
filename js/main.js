import { initializeHamburgerMenu } from "./component/hamburger-menu.js";
import { switchViewport } from "./component/switch-viewport.js";
import { initializeTopKvSlider } from "./component/top-kv-slider.js"; // KVスライダー
import { initializeTopProductSlider } from "./component/top-product-slider.js"; // 製品紹介スライダー
import { initializeScrollTopButton } from "./component/scroll-top-button.js"; // スクロールトップボタン
import { initializeTocScrollTrigger } from "./component/toc-scrolltrigger.js"; // 現在地を示す目次ナビ
import { initializeProductSingleGallery } from "./component/product-single-gallery.js"; // product-singleのギャラリー表示
import { initializeCtaAutoScroll } from "./component/cta-auto-scroll.js"; // ctaセクション流れる文字

// 全ての初期化を実行
initializeHamburgerMenu();
switchViewport();
window.addEventListener("resize", switchViewport);
initializeTopKvSlider();
initializeTopProductSlider();
initializeScrollTopButton();
initializeTocScrollTrigger();
initializeProductSingleGallery();
initializeCtaAutoScroll();
