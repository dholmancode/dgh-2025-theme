<?php
/* Template Name: Page Builder */

get_header();
?>

<main id="primary" class="site-main">
<?php
// Fetch the Loading Animation page by title
$loading_animation_page = get_page_by_title('Loading Animation');

// Get the page content and images
$circle_logo = get_field('circle_logo', $loading_animation_page->ID); // Circle logo (ACF field)
$icon_logo = get_field('icon_logo', $loading_animation_page->ID);     // Icon logo (ACF field)
?>
<div class="loading-animation">
    <div class="logo-container">
        <div class="circle" style="background-image: url('<?php echo esc_url($circle_logo); ?>');"></div>
        <div class="icon" style="background-image: url('<?php echo esc_url($icon_logo); ?>');"></div>
    </div>
</div>
    <?php
    // Masthead Section
    if (get_field('masthead_image') || get_field('masthead_title')) :
        get_template_part('template-parts/section', 'masthead');
    endif;

    // Two Column Image & Text Section
    if (get_field('two_column_title') || get_field('two_column_content') || get_field('two_column_image')) :
        get_template_part('template-parts/section', 'two-column');
    endif;

    // Photography Collections Section
    $home_collections = new WP_Query(array(
        'post_type' => 'home_collections', // This must match the custom post type name
        'posts_per_page' => -1,
    ));

    if ($home_collections->have_posts()) :
        // Include the photography collections template part
        get_template_part('template-parts/section', 'photography-collections');
    else:
        echo 'No Home Collections posts found.';
    endif;
    wp_reset_postdata(); // Ensure to reset after custom query

        // SECOND Two Column Image & Text Section
        if (get_field('two_column_title_2') || get_field('two_column_content') || get_field('two_column_image_2')) :
            get_template_part('template-parts/section', 'two-column-2');
        endif;


    // CTA Banner Section
    if (get_field('cta_title') || get_field('cta_description')) :
        get_template_part('template-parts/section', 'cta-banner');
    endif;
    ?>

</main>

<?php
get_footer();
?>
