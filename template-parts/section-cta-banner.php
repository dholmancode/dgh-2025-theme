<?php
$title = get_field('cta_title');
$description = get_field('cta_description');
$cta = get_field('cta_button');
?>

<section class="cta-banner">
    <?php if ($title): ?>
        <h2><?php echo esc_html($title); ?></h2>
    <?php endif; ?>
    
    <?php if ($description): ?>
        <p><?php echo esc_html($description); ?></p>
    <?php endif; ?>
    
    <?php if ($cta): ?>
        <a href="<?php echo esc_url($cta['url']); ?>" class="button">
            <?php echo esc_html($cta['title'] ? $cta['title'] : 'Click Here'); ?>
        </a>
    <?php endif; ?>
</section>
