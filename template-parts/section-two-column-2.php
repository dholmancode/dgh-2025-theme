<?php
$image = get_field('two_column_image_2');
$text = get_field('two_column_text_2');
?>
<section class="two-column">
<div class="two-column-image-2 animate">
        <?php if (get_field('two_column_image_2')) : ?>
            <img src="<?php echo esc_url(get_field('two_column_image_2')['url']); ?>" alt="<?php echo esc_attr(get_field('two_column_image_2')['alt']); ?>">
        <?php endif; ?>
    </div>
    
    <div class="two-column-content animate">
        <?php if (get_field('two_column_title_2')) : ?>
            <h2><?php the_field('two_column_title_2'); ?></h2>
        <?php endif; ?>

        <?php if (get_field('two_column_content_2')) : ?>
            <div class="content">
                <?php the_field('two_column_content_2'); ?>
                <button><?php the_field('two_column_cta_2'); ?></button>
            </div>
        <?php endif; ?>
    </div>
</section>