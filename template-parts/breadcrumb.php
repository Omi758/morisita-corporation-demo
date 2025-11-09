<?php
/**
 * パンくずリスト テンプレートパーツ
 * Breadcrumb NavXTプラグイン使用
 */
?>

<nav class="breadcrumbs l-container" aria-label="パンくずリスト">
  <?php
  if(function_exists('bcn_display')) {
    bcn_display();
  }
  ?>
</nav>