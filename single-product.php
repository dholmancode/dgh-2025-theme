<?php
/**
 * Template for displaying a single product
 */
get_header(); ?>

<div class="single-product-container">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            wc_get_template_part( 'content', 'single-product' );
        endwhile;
    endif;
    ?>
</div>

<?php get_footer(); ?>