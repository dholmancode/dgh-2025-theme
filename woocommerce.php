<?php
/* Template Name: WooCommerce */
get_header();
?>

<div class="woocommerce-container">
  <!-- Hero Section -->
  <?php if (get_field('hero_image', 38)): ?>
    <div class="woocommerce-hero">
      <img src="<?php echo esc_url(get_field('hero_image', 38)); ?>" alt="Hero Image" class="hero-image" />
      <div class="woocommerce-hero-content">
          <?php if (get_field('hero_title', 38)): ?>
              <h1><?php echo esc_html(get_field('hero_title', 38)); ?></h1>
          <?php endif; ?>
          <?php if (get_field('hero_subtitle', 38)): ?>
              <p><?php echo esc_html(get_field('hero_subtitle', 38)); ?></p>
          <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>

  <!-- Options Bar -->
  <div class="woocommerce-options-bar">
    <?php if (get_field('options_bar_title')): ?>
      <h2><?php echo esc_html(get_field('options_bar_title')); ?></h2>
    <?php endif; ?>
    <form method="get" action="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="woocommerce-options-form">
      <!-- Search Bar -->
      <input type="search" name="s" placeholder="Search products..." class="woocommerce-search" />


      <!-- Sort By -->
      <select name="orderby" class="woocommerce-sort">
        <option value="menu_order">Sort By</option>
        <option value="date">Sort by Latest</option>
        <option value="price">Sort by Price: Low to High</option>
        <option value="price-desc">Sort by Price: High to Low</option>
      </select>

      <button style="color: black; background-color: #E59C59;"type="submit" class="woocommerce-submit">Apply</button>
    </form>
  </div>

  <!-- WooCommerce Content -->
  <div class="woocommerce-grid">
  <?php woocommerce_content(); ?>
    </div>
</div>

<?php get_footer(); ?>
