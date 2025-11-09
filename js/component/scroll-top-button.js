/**
 * トップへスクロールするボタン
 */
export function initializeScrollTopButton() {
  const scrollButton = document.querySelector(".js-scroll-top-button");

  if (!scrollButton) return;

  scrollButton.addEventListener("click", () => {
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });
  });
}
