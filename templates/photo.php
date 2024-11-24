<?php
/* Template Name: Photo Page */

get_header(); ?>

<?php
$category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
?>

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


<!-- Filter Tabs -->
 <div class="photo-container">
    <h1>Photography Collections</h1>
<ul class="photo-filter-tabs" id="filterTabs">
    <li class="filter-tab active" data-filter="featured"><a href="#" data-collection="featured">Featured</a></li>
    <li class="filter-tab" data-filter="utah"><a href="#" data-collection="utah">Utah</a></li>
    <li class="filter-tab" data-filter="ireland"><a href="#" data-collection="ireland">Ireland</a></li>
    <span class="underline"></span> <!-- This should be inside the `ul` -->
</ul>
<div class="gallery-container">
    <div class="photo-gallery">
    <?php
    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => -1,
    );

    $photos = new WP_Query($args);

    if ($photos->have_posts()) :
        while ($photos->have_posts()) : $photos->the_post();
            // Get custom fields from ACF
            $photo_title = get_field('photo_title');
            $location = get_field('location');
            $photo_url = get_the_post_thumbnail_url();
            $collection = get_field('collection'); // This will be an array

            // Normalize the collection array to lowercase
            if (is_array($collection)) {
                $collection = array_map('strtolower', $collection);
                $collection_string = implode(' ', $collection); // Join for data attribute
            } else {
                $collection_string = strtolower($collection);
            }
   ?>

    <div class="photo-item" 
         data-title="<?php echo esc_attr($photo_title); ?>" 
         data-location="<?php echo esc_attr($location); ?>" 
         data-url="<?php echo esc_url($photo_url); ?>" 
         data-collection="<?php echo esc_attr($collection_string); ?>">
        <img src="<?php echo esc_url($photo_url); ?>" alt="<?php echo esc_attr($photo_title); ?>">
        <div class="photo-info">
            <h2><?php echo esc_html($photo_title); ?></h2>
            <p><?php echo esc_html($location); ?></p>
        </div>
    </div>
    <?php endwhile; else : ?>
        <p>No photos found.</p>
    <?php endif; wp_reset_postdata(); ?>
</div>
</div>

<!-- Lightbox Structure -->
<div id="lightbox" class="lightbox hidden">
    <span class="close">&times;</span>
    <img class="lightbox-img" src="" alt="">
    <div class="lightbox-info">
        <h2 class="lightbox-title"></h2>
        <p class="lightbox-location"></p>
    </div>
    <a class="prev" id="prev">&#10094;</a>
    <a class="next" id="next">&#10095;</a>
</div>
</div>
<?php get_footer(); ?>
