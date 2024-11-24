<?php
$title = get_field('photography_collections_title');
$home_collections = new WP_Query(array(
    'post_type' => 'home_collections',
    'posts_per_page' => -1,
));
?>

<section class="photography-collections" style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url($home_collections->posts[0]->ID, 'full')); ?>');">
    <div class="collection-wrapper">
        <!-- Active Collection (Left Side) -->
        <div class="active-collection" id="active-collection">
            <?php
            if (!empty($home_collections->posts)) :
                $first_post = $home_collections->posts[0];
                $collection_title = get_field('collection_title', $first_post->ID);
                $collection_description = get_field('collection_description', $first_post->ID);
                $collection_cta = get_field('collection_cta', $first_post->ID);
                ?>
                <div class="active-info">
                    <h2><?php echo esc_html($collection_title ? $collection_title : $first_post->post_title); ?></h2>
                    <p><?php echo esc_html($collection_description); ?></p>

                    <?php if ($collection_cta): ?>
                        <a href="<?php echo esc_url($collection_cta['url']); ?>" class="cta-button">
                            <?php echo esc_html($collection_cta['title']); ?>
                        </a>
                    <?php else: ?>
                        <p>CTA Button text or link is missing.</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Collection Cards (Right Side) -->
        <div class="collections-list">
            <?php
            foreach ($home_collections->posts as $index => $post) {
                $collection_title = get_field('collection_title', $post->ID);
                $collection_description = get_field('collection_description', $post->ID);
                $collection_cta = get_field('collection_cta', $post->ID);
                ?>
                <div class="collection-card animate"
                     data-background="<?php echo esc_url(get_the_post_thumbnail_url($post->ID, 'full')); ?>"
                     data-description="<?php echo esc_attr($collection_description); ?>"
                     data-link="<?php echo esc_url($collection_cta['url']); ?>"
                     data-cta-text="<?php echo esc_html($collection_cta['title']); ?>">
                    <?php if (has_post_thumbnail($post->ID)) : ?>
                        <img src="<?php echo esc_url(get_the_post_thumbnail_url($post->ID, 'full')); ?>" alt="<?php echo esc_attr($collection_title ? $collection_title : $post->post_title); ?>" />
                    <?php endif; ?>
                    <h3><?php echo esc_html($collection_title ? $collection_title : $post->post_title); ?></h3>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<?php wp_reset_postdata(); ?>
