/**
 * KVセクションを抜けたタイミングで、固定ヘッダーを上からスライドダウンさせる
 * - GSAP + ScrollTriggerでKVの底が画面上端を通過した瞬間を検知
 * - スライドイン/アウトはGSAPのtweenで制御（CSS transitionは使わない）
 * - 上に戻ったときもスライドアップで格納してから初期の透明ヘッダーへ戻す
 * - 対象KV: .top-kv（トップ）/ .c-subkv-single（single系）/ .c-subkv（下層KV）
 */
export function initializeHeaderScroll() {
  // GSAPとScrollTriggerプラグインが読み込まれていなければ処理を中断
  if (typeof gsap === "undefined" || typeof ScrollTrigger === "undefined") {
    console.error("GSAP or ScrollTrigger is not loaded.");
    return;
  }

  try {
    gsap.registerPlugin(ScrollTrigger);
  } catch (e) {
    console.warn(e);
  }

  const header = document.querySelector(".header");
  // 前方のページほど優先（top-kv → subkv-single → subkv）
  const kv = document.querySelector(".top-kv, .c-subkv-single, .c-subkv");
  // ヘッダーまたはKVが無いページではスクロール連動を無効化
  if (!header || !kv) return;

  // 進行中のtweenを保持（往復スクロールで途中状態を上書きするため）
  let activeTween = null;

  ScrollTrigger.create({
    trigger: kv,
    start: "bottom top", // KVの底が画面上端に達した瞬間
    onEnter: () => {
      // 既存tweenがあれば破棄してから再開（onCompleteは発火しない）
      activeTween?.kill();
      header.classList.add("is-stuck"); // position:fixed + 白背景が適用される
      // translateY(-100%) から 0 へスライドダウン（減速着地）
      activeTween = gsap.fromTo(
        header,
        { yPercent: -100 },
        { yPercent: 0, duration: 0.45, ease: "power2.out" }
      );
    },
    onLeaveBack: () => {
      // スライドアップで格納（加速退場）
      activeTween?.kill();
      activeTween = gsap.to(header, {
        yPercent: -100,
        duration: 0.45,
        ease: "power2.in",
        onComplete: () => {
          // 退場完了後にtransformをクリア → .is-stuck を外して初期状態(position:absolute)へ戻す
          gsap.set(header, { clearProps: "transform" });
          header.classList.remove("is-stuck");
        },
      });
    },
  });
}
