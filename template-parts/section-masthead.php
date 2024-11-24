<?php
$title = get_field('masthead_title');
$image = get_field('masthead_image');
?>
<section class="masthead" style="background-image: url('<?php echo esc_url($image['url']); ?>');">
    <!-- Overlay div -->
    <div class="overlay"></div>
    <div class="hero-content">
    <?php if ($title) : ?>
            <h1><?php echo esc_html($title); ?></h1>
        <?php endif; ?>
        <div class="columns">
            <?php
            // Query for Hero Content posts
            $args = array(
                'post_type' => 'hero_content',
                'posts_per_page' => 3,
            );
            $hero_query = new WP_Query($args);

            // Loop through Hero Content posts
            if ($hero_query->have_posts()) :
                while ($hero_query->have_posts()) : $hero_query->the_post();
                    // Get ACF fields
                    $hero_title = get_field('hero_title');
                    $hero_icon = get_field('hero_icon');
                    $hero_description = get_field('hero_description');
                    $hero_cta = get_field('hero_cta');
                    $hero_link = get_field('hero_link'); // New ACF field for whole column link
            ?>
                    <a href="<?php echo esc_url($hero_link['url']); ?>" class="column" <?php if ($hero_link['target']) echo 'target="_blank"'; ?>>
                        <?php if ($hero_title) : ?>
                            <h2><?php echo esc_html($hero_title); ?></h2>
                        <?php endif; ?>
                        
                        <?php if ($hero_icon) : ?>
                            <img src="<?php echo esc_url($hero_icon['url']); ?>" alt="<?php echo esc_attr($hero_icon['alt']); ?>">
                        <?php endif; ?>

                        <?php if ($hero_description) : ?>
                            <p><?php echo esc_html($hero_description); ?></p>
                        <?php endif; ?>

                        <?php if ($hero_cta) : ?>
                            <span class="cta-button"><?php echo esc_html($hero_cta['title']); ?></span>
                        <?php endif; ?>
                    </a>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p>No hero content available.</p>';
            endif;
            ?>
        </div>
    </div>
</section>
