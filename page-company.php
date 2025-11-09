<?php get_header(); ?>
<!-- company-kv -->
<section class="c-subkv">
  <div class="l-container">
    <div class="c-subkv-title">
      <span class="c-subkv-title--en" lang="en"><?php echo esc_html (strtoupper($post->post_name)); ?></span>
      <h1 class="c-subkv-title--ja"><?php the_title(); ?></h1>
    </div>
  </div>
</section>

<!-- パンくず -->
<?php get_template_part( "template-parts/breadcrumb" ); ?>

<!-- company-kv end -->

<!-- company-information -->
<main>
  <div class="company-info">
    <div class="company-info-wrapper l-container-s">

      <picture class="company-info-image">
        <source media="(max-width: 767px)"
          srcset="<?php echo esc_url( get_template_directory_uri() ); ?>/img/company-photo@2x.webp" />
        <img width="1000" height="500"
          src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/company-photo-pc@2x.webp"
          alt="青い空にうろこ雲と真っ白な社屋が印象的な株式会社森下の本社ボルトナット製造工場画像" />
      </picture>

      <div>
        <dl class="company-info-list">
          <?php if ( function_exists("get_field") ) : ?>

          <?php if ( get_field("company_name") ) : ?>
          <div class="company-info-item">
            <dt class="company-info-title">会社名</dt>
            <dd class="company-info-data"><?php echo esc_html( get_field('company_name') ); ?></dd>
          </div>
          <?php endif; ?>

          <?php if ( get_field("address") ) : ?>
          <div class="company-info-item">
            <dt class="company-info-title">所在地</dt>
            <dd class="company-info-data">
              <?php echo nl2br( esc_html( get_field('address') ) ); ?>
              <!-- nl2br:改行も反映 -->
            </dd>
          </div>
          <?php endif; ?>

          <?php if ( get_field("representative") ) : ?>
          <div class="company-info-item">
            <dt class="company-info-title">代表者</dt>
            <dd class="company-info-data">
              <?php echo esc_html( get_field('representative') ); ?>
            </dd>
          </div>
          <?php endif; ?>

          <?php if ( get_field("founded") ) : ?>
          <div class="company-info-item">
            <dt class="company-info-title">設立</dt>
            <dd class="company-info-data">
              <?php echo esc_html( get_field('founded') ); ?>
            </dd>
          </div>
          <?php endif; ?>

          <?php if ( get_field("business") ) : ?>
          <div class="company-info-item">
            <dt class="company-info-title">事業内容</dt>
            <dd class="company-info-data">
              <?php echo nl2br( esc_html(get_field('business') ) ); ?>
            </dd>
          </div>
          <?php endif; ?>

          <?php if ( get_field("capital") ) : ?>
          <div class="company-info-item">
            <dt class="company-info-title">資本金</dt>
            <dd class="company-info-data">
              <?php echo esc_html( get_field('capital') ); ?>
            </dd>
          </div>
          <?php endif; ?>

          <?php if ( get_field("employees") ) : ?>
          <div class="company-info-item">
            <dt class="company-info-title">従業員数</dt>
            <dd class="company-info-data">
              <?php echo esc_html( get_field('employees') ); ?>
            </dd>
          </div>
          <?php endif; ?>

          <?php if ( get_field("phone") ) : ?>
          <div class="company-info-item">
            <dt class="company-info-title">連絡先</dt>
            <dd class="company-info-data">
              <?php echo esc_html( get_field('phone') ); ?>
            </dd>
          </div>
          <?php endif; ?>
          <?php endif; ?>
        </dl>
      </div>
    </div>
  </div>
</main>

<!-- company-information end -->

<?php get_footer(); ?>