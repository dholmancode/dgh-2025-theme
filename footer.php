<footer>
    <div class="footer-container" style="display: flex; justify-content: space-between; align-items: center;">

        <!-- Logo on the left -->
        <div class="footer-logo">
            <?php if (has_custom_logo()) : ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                    <?php the_custom_logo(); ?>
                </a>
            <?php endif; ?>
        </div>

        <!-- Scroll to top button (hardcoded) -->
        <div class="scroll-to-top">
            <a href="#top" class="scroll-top-link">
                Back to Top
            </a>
        </div>

        <!-- Primary Navigation Menu on the right -->
        <div class="footer-navigation">
            <?php
            // Display the primary menu set in the WordPress dashboard
            wp_nav_menu(array(
                'theme_location' => 'primary', // Ensure you register this location in functions.php
                'menu_id' => 'footer-primary-menu',
                'container' => false, // No container around the menu
                'items_wrap' => '<ul class="footer-menu">%3$s</ul>', // Optional: You can style the menu list here
            ));
            ?>
<div class="social-links">
        <?php
        // Get the page where the ACF fields are assigned
        $footer_page = get_page_by_title('footer');

        // Get the Instagram link and icon from ACF
        $instagram_link = get_field('instagram_link', $footer_page->ID);
        $instagram_icon = get_field('instagram_icon', $footer_page->ID);

        // Get the LinkedIn link and icon from ACF
        $linkedin_link = get_field('linkedin_link', $footer_page->ID);
        $linkedin_icon = get_field('linkedin_icon', $footer_page->ID);
       
        // Get the GitHub link and icon from ACF
        $github_link = get_field('github_link', $footer_page->ID);
        $github_icon = get_field('github_icon', $footer_page->ID);

        // Display the Instagram link and icon if they exist
        if ($instagram_link && $instagram_icon) : ?>
            <a href="<?php echo esc_url($instagram_link); ?>" target="_blank" >
                <img src="<?php echo esc_url($instagram_icon); ?>" alt="Instagram" />
            </a>
        <?php endif; ?>

        <!-- Display the LinkedIn link and icon if they exist -->
        <?php if ($linkedin_link && $linkedin_icon) : ?>
            <a href="<?php echo esc_url($linkedin_link); ?>" target="_blank">
                <img src="<?php echo esc_url($linkedin_icon); ?>" alt="LinkedIn"/>
            </a>
        <?php endif; ?>

     <!-- Display the GitHub link and icon if they exist -->
                <?php if ($github_link && $github_icon) : ?>
            <a href="<?php echo esc_url($github_link); ?>" target="_blank">
                <img src="<?php echo esc_url($github_icon); ?>" alt="GitHub"/>
            </a>
        <?php endif; ?>



          </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
