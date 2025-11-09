<?php get_header(); ?>

<!-- business-kv -->
<?php get_template_part("template-parts/subkv-single"); ?>

<!-- パンくずリスト -->
<?php get_template_part( "template-parts/breadcrumb" ); ?>

<!-- business-design-->
<main>
  <div class="l-container">
    <div class="business-design">
      <nav class="business-toc" aria-labelledby="toc-heading">
        <h2 id="toc-heading" class="c-section-title">
          <span class="c-section-title--en" lang="en">menu</span>
          <span class="c-section-title--jp">メニュー</span>
        </h2>
        <ul class="business-toc-list">
          <li class="business-toc-item">
            <a class="business-toc-link js-business-toc-link" href="#problem">お客様の課題</a>
          </li>
          <li class="business-toc-item">
            <a class="business-toc-link js-business-toc-link" href="#feature">特徴</a>
          </li>
          <li class="business-toc-item">
            <a class="business-toc-link js-business-toc-link" href="#flow">納品までの流れ</a>
          </li>
        </ul>
      </nav>

      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

      <!-- お客様の課題(problem) -->
      <div class="business-design-content">
        <section id="problem" class="business-problem">
          <div class="business-problem-text-container">
            <h2 class="c-single-section-title">
              <span class="c-single-section-title--en" lang="en">problem</span>
              <span class="c-single-section-title--jp">お客様の課題</span>
            </h2>
            <?php if (function_exists("get_field")): ?>
            <?php $lead = trim((string) get_field("problem_lead")); ?>
            <?php if ($lead !== ""): ?>
            <p class="business-problem-text"><?php echo esc_html($lead); ?></p>
            <?php endif; ?>
            <?php endif; ?>
          </div>

          <ul class="business-problem-list">
            <?php for ($i = 1; $i <= 5; $i++): ?>
            <?php
                $item = function_exists("get_field") ? trim((string) get_field("problem_" . $i)) : "";
                if ($item === "") continue;
                ?>
            <li class="business-problem-item"><?php echo esc_html($item); ?></li>
            <?php endfor; ?>
          </ul>
        </section>

        <!-- 特徴(feature) -->
        <section id="feature" class="business-feature">
          <div class="business-feature-text-container">
            <h2 class="c-single-section-title">
              <span class="c-single-section-title--en" lang="en">feature</span>
              <span class="c-single-section-title--jp">特徴</span>
            </h2>
          </div>

          <div class="business-feature-card-container">
            <?php for ($i = 1; $i <= 5; $i++): ?>
            <?php
                $img_id = function_exists("get_field") ? (int) get_field("feature_image_" . $i) : 0;
                $title  = function_exists("get_field") ? trim((string) get_field("feature_title_" . $i)) : "";
                $text   = function_exists("get_field") ? trim((string) get_field("feature_text_" . $i)) : "";
                if (!$img_id && $title === "" && $text === "") continue;   // 何も入ってなければスキップ

                $img_url = $img_id ? wp_get_attachment_image_url($img_id, "medium") : "";
                $img_alt = $img_id ? get_post_meta($img_id, "_wp_attachment_image_alt", true) : "";
              ?>

            <section class="business-feature-item">
              <picture class="business-feature-image">
                <?php if ($img_url): ?>
                <img width="240" height="160" src="<?php echo esc_url($img_url); ?>"
                  alt="<?php echo esc_attr($img_alt !== "" ? $img_alt : $title); ?>" />
                <?php endif; ?>
              </picture>
              <div class="business-feature-text">
                <?php if ($title !== ""): ?><h3><?php echo esc_html($title); ?></h3><?php endif; ?>
                <?php if ($text  !== ""): ?><p><?php echo esc_html($text); ?></p><?php endif; ?>
              </div>
            </section>
            <?php endfor; ?>
          </div>
        </section>

        <!-- 納品までの流れ(flow) -->
        <section id="flow" class="business-flow">
          <div class="business-flow-text-container">
            <h2 class="c-single-section-title">
              <span class="c-single-section-title--en" lang="en">flow</span>
              <span class="c-single-section-title--jp">納品までの流れ</span>
            </h2>
          </div>

          <div class="business-flow-wrapper">
            <?php for ($i = 1; $i <= 5; $i++): ?>
            <?php
                $icon_id = function_exists("get_field") ? (int) get_field("flow_icon_" . $i) : 0;
                $title   = function_exists("get_field") ? trim((string) get_field("flow_title_" . $i)) : "";
                $text    = function_exists("get_field") ? trim((string) get_field("flow_text_" . $i)) : "";
                if (!$icon_id && $title === "" && $text  === "") continue;

                $icon_url = $icon_id ? wp_get_attachment_image_url($icon_id, "medium") : "";
                $icon_alt = $icon_id ? get_post_meta($icon_id, "_wp_attachment_image_alt", true) : "";
              ?>
            <section class="business-flow-item">
              <?php if ($icon_url): ?>
              <img class="business-flow-item-img" src="<?php echo esc_url($icon_url); ?>" width="150" height="150"
                alt="<?php echo esc_attr($icon_alt !== "" ? $icon_alt : $title); ?>" decoding="async" />
              <?php endif; ?>
              <div class="business-flow-item-inner">
                <?php if ($title !== ""): ?><h3 class="business-flow-item-title"><?php echo esc_html($title); ?></h3>
                <?php endif; ?>
                <?php if ($text  !== ""): ?><p class="business-flow-item-text"><?php echo esc_html($text); ?></p>
                <?php endif; ?>
              </div>
            </section>
            <?php endfor; ?>
          </div>
        </section>

      </div>

      <?php endwhile; endif; ?>

    </div>
  </div>
</main>

<?php get_footer(); ?>