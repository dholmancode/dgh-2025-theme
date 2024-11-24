<?php
/* Template Name: Cart */
get_header(); ?>

<div class="cart-container">
    <?php echo do_shortcode('[woocommerce_cart]'); ?>
</div>

<?php get_footer(); ?>