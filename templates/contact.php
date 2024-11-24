<?php
/* Template Name: Contact */

get_header();
?>

<div class="contact-page">
    <div class="container">
        <div class="contact-content">
            <!-- Left: Contact Image -->
            <div class="contact-image">
                <?php
                $image = get_field('contact_image');
                if ($image): ?>
                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
                <?php endif; ?>
            </div>

            <!-- Right: Form and Contact Details -->
            <div class="contact-info">
                <div class="contact-form">
                    <?php
                    $contact_form_shortcode = get_field('contact_form_shortcode');
                    if ($contact_form_shortcode) {
                        echo do_shortcode($contact_form_shortcode);
                    } else {
                        echo '<p>Please add a Contact Form 7 shortcode in the ACF field.</p>';
                    }
                    ?>
                </div>

                <div class="contact-details">
                    <p><strong>Contact:<br></strong> <?php the_field('contact_email'); ?></p>
                    <p><strong>Based in:<br></strong> <?php the_field('contact_location'); ?></p>

                    <div class="social-icons">
                        <ul>
                            <?php
                            $social_links = [
                                [
                                    'url' => get_field('instagram_link'),
                                    'icon' => get_field('instagram_icon'),
                                    'alt' => 'Instagram',
                                ],
                                [
                                    'url' => get_field('linkedin_link'),
                                    'icon' => get_field('linkedin_icon'),
                                    'alt' => 'LinkedIn',
                                ],
                                [
                                    'url' => get_field('github_link'),
                                    'icon' => get_field('github_icon'),
                                    'alt' => 'GitHub',
                                ],
                            ];

                            foreach ($social_links as $social) {
                                if ($social['url'] && $social['icon']): ?>
                                    <li>
                                        <a href="<?php echo esc_url($social['url']); ?>" target="_blank" rel="noopener">
                                            <img src="<?php echo esc_url($social['icon']['url']); ?>" alt="<?php echo esc_attr($social['alt']); ?>" />
                                        </a>
                                    </li>
                                <?php endif;
                            } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>
