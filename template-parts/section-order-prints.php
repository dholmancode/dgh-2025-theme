<?php
$title = get_field('prints_title');
$description = get_field('prints_description');
$cta = get_field('prints_cta');
$featured_prints = get_field('featured_prints');
?>

<section class="order-prints">
    <div class="text-section">
        <?php if ($title): ?>
            <h2><?php echo esc_html($title); ?></h2>
        <?php endif; ?>
        <?php if ($description): ?>
            <p><?php echo esc_html($description); ?></p>
        <?php endif; ?>
        <?php if ($cta): ?>
            <a href="<?php echo esc_url($cta['url']); ?>" class="button"><?php echo esc_html($cta['title']); ?></a>
        <?php endif; ?>
    </div>
    <div class="prints-section">
        <?php if ($featured_prints): ?>
            <ul>
                <?php foreach ($featured_prints as $print): ?>
                    <li><img src="<?php echo esc_url($print['url']); ?>" alt="<?php echo esc_attr($print['alt']); ?>"></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>
