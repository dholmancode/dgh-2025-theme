<?php
/* Template Name: Thank You */

get_header(); ?>

<div class="thank-you-container">
    <h1>Thank You for Your Order!</h1>
    <?php
    if ( isset( $order ) ) {
        wc_get_template( 'order/order-details.php', array( 'order' => $order ) );
    }
    ?>
</div>

<?php get_footer(); ?>