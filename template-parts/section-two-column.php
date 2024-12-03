<?php
$image = get_field('two_column_image');
$text = get_field('two_column_text');
?>
<section class="two-column" id ="about" style="padding-top: 100px; padding-bottom: 100px;">
<div class="two-column-image animate">
        <?php if (get_field('two_column_image')) : ?>
            <img src="<?php echo esc_url(get_field('two_column_image')['url']); ?>" alt="<?php echo esc_attr(get_field('two_column_image')['alt']); ?>">
        <?php endif; ?>
    </div>
    
    <div class="two-column-content animate">
        <?php if (get_field('two_column_title')) : ?>
            <h2><?php the_field('two_column_title'); ?></h2>
        <?php endif; ?>

        <?php if (get_field('two_column_content')) : ?>
            <div class="content">
                <?php the_field('two_column_content'); ?>
            </div>
        <?php endif; ?>
    </div>
</section>