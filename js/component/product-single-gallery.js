/**
 * product-singleのギャラリー部分サムネイル表示
 * サムネイルをクリックでギャラリーのメイン部分に表示
 */
export function initializeProductSingleGallery() {
  const mainImage = document.querySelector(
    ".js-product-single-main-thumbnail img"
  );
  const thumbs = document.querySelectorAll(".js-product-single-sub-thumbnail");

  thumbs.forEach((thumb) => {
    const img = thumb.querySelector("img");

    img.addEventListener("click", (event) => {
      event.preventDefault();

      // メイン画像切替
      if (mainImage) {
        mainImage.src = img.src;
        mainImage.removeAttribute("srcset");
        mainImage.removeAttribute("sizes");
        mainImage.animate({ opacity: [0, 1] }, 500);
      }

      // aria-selected を付け替え
      thumbs.forEach((thumbItem) =>
        thumbItem.setAttribute("aria-selected", "false")
      );
      thumb.setAttribute("aria-selected", "true");
    });
  });
}
