<?php
/* Template Name: Checkout */

get_header(); ?>

<div class="checkout-container">
    <?php echo do_shortcode('[woocommerce_checkout]'); ?>
</div>

<?php get_footer(); ?>