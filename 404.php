    <?php get_header(); ?>
    <!-- error404-kv -->

    <section class="c-subkv">
      <div class="l-container">
        <div class="c-subkv-title">
          <span class="c-subkv-title--en" lang="en">404 Not Found</span>
          <h1 class="c-subkv-title--ja">お探しのページは見つかりませんでした</h1>
        </div>
      </div>
    </section>

    <!-- ====== パンくず ====== -->
    <?php get_template_part( "template-parts/breadcrumb" ); ?>

    <!-- error404-kv end -->

    <!-- error404 -->
    <main>
      <div class="error404">
        <div class="l-container">
          <div class="error404-wrapper">
            <p class="error404-text">
              <span>申し訳ございません。</span>
              <span>入力したアドレスが間違っているか、ページが移動・削除された可能性があります。</span>
              <span>トップページに戻って目的の情報をお探しください。</span>
            </p>
            <a href="<?php echo esc_url( home_url("/") ); ?>"
              class="error404-button c-button c-button--lightest-blue">TOP</a>
          </div>
        </div>

      </div>
    </main>

    <!-- error404 end -->

    <?php get_footer(); ?>