<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */



/* -------------------------------------------------------------------- */
/* Contact                                                       */
/* -------------------------------------------------------------------- */

add_filter( 'wpcf7_validate_configuration', '__return_false' );

 function enqueue_custom_styles() {
    // Enqueue the main stylesheet
    wp_enqueue_style(
        'custom-style', // Handle name
        get_template_directory_uri() . '/css/contact.css', // Path to your stylesheet
        array(), // Dependencies (if any)
        '1.0.0', // Version number
        'all' // Media type
    );
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');


/* -------------------------------------------------------------------- */
/* Page Builder                                                         */
/* -------------------------------------------------------------------- */

function register_hero_content_cpt() {
    $labels = array(
        'name' => 'Hero Content',
        'singular_name' => 'Hero Content',
        'menu_name' => 'Hero Content',
        'name_admin_bar' => 'Hero Content',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Hero Content',
        'new_item' => 'New Hero Content',
        'edit_item' => 'Edit Hero Content',
        'view_item' => 'View Hero Content',
        'all_items' => 'All Hero Content',
        'search_items' => 'Search Hero Content',
        'not_found' => 'No Hero Content found.',
        'not_found_in_trash' => 'No Hero Content found in Trash.',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_position' => 20,
        'menu_icon' => 'dashicons-format-image',
        'show_in_rest' => true,
    );

    register_post_type('hero_content', $args);
}
add_action('init', 'register_hero_content_cpt');


// Enqueue Sticky Header Script
function enqueue_sticky_header_script() {
    wp_enqueue_script(
        'sticky-header-js', // Handle for the script
        get_template_directory_uri() . '/js/sticky-header.js', // Path to sticky-header.js
        array('jquery'), // Dependencies (if it needs jQuery)
        null, // Version (null for no specific versioning)
        true // Load in the footer
    );
}
add_action('wp_enqueue_scripts', 'enqueue_sticky_header_script');


// Enqueue Page Builder Script
function enqueue_page_builder_script() {
    wp_enqueue_script(
        'page-builder-js', // Handle for the script
        get_template_directory_uri() . '/js/page-builder.js', // Path to the file
        array('jquery'), // Dependencies
        null, // Version (null for no specific versioning)
        true // Load in the footer
    );
}
add_action('wp_enqueue_scripts', 'enqueue_page_builder_script');

// Enqueue Page Builder Styles
function enqueue_page_builder_styles() {
    wp_enqueue_style(
        'page-builder-style', 
        get_template_directory_uri() . '/css/page-builder.css', // Adjusted path
        array(), 
        '1.0.0' // Versioning for cache busting
    );
}
add_action('wp_enqueue_scripts', 'enqueue_page_builder_styles');

/* -------------------------------------------------------------------- */
/* Portfolio Customizations                                            */
/* -------------------------------------------------------------------- */
function register_menus() {
    register_nav_menus(
        array(
            'left-menu' => __( 'Left Menu' ),
            'right-menu' => __( 'Right Menu' ),
        )
    );
}
add_action( 'after_setup_theme', 'register_menus' );

// Enqueue Portfolio Styles Globally
function enqueue_portfolio_styles() {
    wp_enqueue_style('portfolio-styles', get_template_directory_uri() . '/css/portfolio.css');
}
add_action('wp_enqueue_scripts', 'enqueue_portfolio_styles');

// Enqueue JavaScript for Tab Functionality
function enqueue_portfolio_scripts() {
    wp_enqueue_script('portfolio', get_template_directory_uri() . '/js/portfolio.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'enqueue_portfolio_scripts');

// Register a custom taxonomy for featured projects
function create_featured_project_taxonomy() {
    register_taxonomy(
        'featured',
        'projects',
        array(
            'label' => 'Featured',
            'rewrite' => array('slug' => 'featured'),
            'hierarchical' => false,
        )
    );
}
add_action('init', 'create_featured_project_taxonomy');

// Register Custom Post Type for Projects
function register_projects_post_type() {
    $labels = array(
        'name'                  => 'Projects',
        'singular_name'         => 'Project',
        'menu_name'             => 'Projects',
        'name_admin_bar'        => 'Project',
        'add_new'               => 'Add New',
        'add_new_item'          => 'Add New Project',
        'edit_item'             => 'Edit Project',
        'new_item'              => 'New Project',
        'view_item'             => 'View Project',
        'search_items'          => 'Search Projects',
        'not_found'             => 'No projects found',
        'not_found_in_trash'    => 'No projects found in Trash',
        'all_items'             => 'All Projects',
        'archives'              => 'Project Archives',
        'insert_into_item'      => 'Insert into project',
        'uploaded_to_this_item' => 'Uploaded to this project',
    );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'has_archive'           => true,
        'rewrite'               => array('slug' => 'projects'),
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest'          => true, // Enables Gutenberg editor
        'menu_icon'             => 'dashicons-portfolio', // Choose an appropriate dashicon
    );

    register_post_type('projects', $args);
}

// Hook into the 'init' action to register the post type
add_action('init', 'register_projects_post_type');

// Add Duplicate Functionality for Projects
function duplicate_project_as_draft() {
    global $wpdb;

    // Verify the post ID
    if (!isset($_GET['post']) || !is_numeric($_GET['post'])) {
        wp_die('Invalid request.');
    }

    $post_id = intval($_GET['post']);
    $post = get_post($post_id);

    // Check if the post exists and is of type 'projects'
    if ($post && $post->post_type === 'projects') {
        $new_post = array(
            'post_title'    => $post->post_title . ' (Copy)',
            'post_content'  => $post->post_content,
            'post_status'   => 'draft',
            'post_type'     => $post->post_type,
            'post_author'   => get_current_user_id(),
        );

        // Insert the duplicated post
        $new_post_id = wp_insert_post($new_post);

        // Duplicate post meta
        $meta_data = get_post_meta($post_id);
        foreach ($meta_data as $key => $value) {
            update_post_meta($new_post_id, $key, maybe_unserialize($value[0]));
        }

        // Duplicate taxonomies
        $taxonomies = get_object_taxonomies($post->post_type);
        foreach ($taxonomies as $taxonomy) {
            $terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'ids'));
            wp_set_object_terms($new_post_id, $terms, $taxonomy);
        }

        // Redirect back to the post list
        wp_redirect(admin_url('edit.php?post_type=projects'));
        exit;
    } else {
        wp_die('Post duplication failed.');
    }
}
add_action('admin_action_duplicate_project_as_draft', 'duplicate_project_as_draft');

// Add "Duplicate" link to the row actions
function add_duplicate_project_link($actions, $post) {
    if ($post->post_type === 'projects' && current_user_can('edit_posts')) {
        $duplicate_url = wp_nonce_url(
            admin_url('admin.php?action=duplicate_project_as_draft&post=' . $post->ID),
            'duplicate_project'
        );
        $actions['duplicate'] = '<a href="' . $duplicate_url . '" title="Duplicate this project">Duplicate</a>';
    }
    return $actions;
}
add_filter('post_row_actions', 'add_duplicate_project_link', 10, 2);


// Custom Image Size for Portfolio Thumbnails
function custom_image_sizes() {
    add_image_size('portfolio-thumbnail', 400, 300, true); // Cropped to exact size
}
add_action('after_setup_theme', 'custom_image_sizes');

// Enable Thumbnail Support
function theme_setup() {
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'theme_setup');

/* -------------------------------------------------------------------- */
/* WooCommerce Customizations                                           */
/* -------------------------------------------------------------------- */



// Add WooCommerce support
function dannyholmanmedia_add_woocommerce_support() {
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'dannyholmanmedia_add_woocommerce_support');

// Remove WooCommerce page title on the shop page
add_filter('woocommerce_show_page_title', '__return_false');

// Remove the default WooCommerce ordering dropdown
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

// Enqueue WooCommerce styles and custom scripts
function dannyholmanmedia_enqueue_scripts() {
    // Enqueue WooCommerce styles
    if (class_exists('WooCommerce')) {
        wp_enqueue_style('dannyholmanmedia-woocommerce', get_template_directory_uri() . '/css/woocommerce.css');
    }

    // Enqueue AJAX script for cart count
    wp_enqueue_script('cart-count-update', get_template_directory_uri() . '/js/cart-count-update.js', array('jquery'), null, true);
    wp_localize_script('cart-count-update', 'cart_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));
}
add_action('wp_enqueue_scripts', 'dannyholmanmedia_enqueue_scripts');

// AJAX handler to update the cart count
function update_cart_count() {
    echo WC()->cart->get_cart_contents_count();
    wp_die();
}
add_action('wp_ajax_update_cart_count', 'update_cart_count');
add_action('wp_ajax_nopriv_update_cart_count', 'update_cart_count');

/* -------------------------------------------------------------------- */
/* Photo Rendering Customizations                                       */
/* -------------------------------------------------------------------- */

// Enqueue Custom Scripts for Photo Filtering
function enqueue_custom_scripts() {
    wp_enqueue_script('custom-photo-filter', get_template_directory_uri() . '/js/photo-filter.js', array('jquery'), null, true);
    wp_localize_script('custom-photo-filter', 'ajaxurl', admin_url('admin-ajax.php'));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

// Register the AJAX action for logged-in and non-logged-in users
add_action('wp_ajax_filter_photos', 'filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');

// Handle the Photo Filtering functionality
function filter_photos() {
    // Capture the selected collection from the AJAX request
    $collection_filter = isset($_POST['collection']) ? strtolower($_POST['collection']) : '';

    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => -1,
    );

    // Add collection filter if necessary
    if ($collection_filter && $collection_filter != 'all') {
        $args['meta_query'] = array(
            array(
                'key' => 'collection',
                'value' => '"' . $collection_filter . '"',
                'compare' => 'LIKE'
            )
        );
    }

    $photos = new WP_Query($args);

    if ($photos->have_posts()) :
        while ($photos->have_posts()) : $photos->the_post();
            $photo_title = get_field('photo_title');
            $location = get_field('location');
            $photo_url = get_the_post_thumbnail_url();
            ?>
            <div class="photo-item">
                <img src="<?php echo esc_url($photo_url); ?>" alt="<?php echo esc_attr($photo_title); ?>">
                <div class="photo-info">
                    <h2><?php echo esc_html($photo_title); ?></h2>
                    <p><?php echo esc_html($location); ?></p>
                </div>
            </div>
            <?php
        endwhile;
    else :
        echo '<p>No photos found in this collection.</p>';
    endif;

    wp_reset_postdata();
    wp_die();
}

/* -------------------------------------------------------------------- */
/* Lightbox Customizations                                              */
/* -------------------------------------------------------------------- */

// Enqueue custom Lightbox scripts
function enqueue_custom_lightbox_scripts() {
    wp_enqueue_script('lightbox-js', get_template_directory_uri() . '/js/lightbox.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_lightbox_scripts');

/* -------------------------------------------------------------------- */
/* Register Custom Post Type for Photos                                  */
/* -------------------------------------------------------------------- */

// Register Custom Post Type for Photos
function custom_post_type_photos() {
    $labels = array(
        'name'               => 'Photos',
        'singular_name'      => 'Photo',
        'menu_name'          => 'Photos',
        'name_admin_bar'     => 'Photo',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Photo',
        'new_item'           => 'New Photo',
        'edit_item'          => 'Edit Photo',
        'view_item'          => 'View Photo',
        'all_items'          => 'All Photos',
        'search_items'       => 'Search Photos',
        'not_found'          => 'No Photos found',
        'not_found_in_trash' => 'No Photos found in Trash',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'photos'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-camera',
        'supports'           => array('title', 'thumbnail', 'custom-fields'),
        'taxonomies'         => array('category'),
        'show_in_rest'       => true,
    );

    register_post_type('photos', $args);
}
add_action('init', 'custom_post_type_photos');

/* -------------------------------------------------------------------- */
/* Enqueue Additional Styles                                            */
/* -------------------------------------------------------------------- */

// Enqueue the photo.css file
function my_theme_enqueue_styles() {
    wp_enqueue_style('photo-style', get_template_directory_uri() . '/css/photo.css');
}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');

/* -------------------------------------------------------------------- */
/* Theme Setup Customizations                                           */
/* -------------------------------------------------------------------- */

// Register footer menu
function my_theme_setup() {
    register_nav_menus(array(
        'footer-menu' => __('Footer Menu'),
    ));
}
add_action('after_setup_theme', 'my_theme_setup');


/* -------------------------------------------------------------------------------------------------------------------------------------------------------------- */


// This theme requires WordPress 5.3 or later.
if ( version_compare( $GLOBALS['wp_version'], '5.3', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'twenty_twenty_one_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @since Twenty Twenty-One 1.0
	 *
	 * @return void
	 */
	function twenty_twenty_one_setup() {

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * This theme does not use a hard-coded <title> tag in the document head,
		 * WordPress will provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Add post-formats support.
		 */
		add_theme_support(
			'post-formats',
			array(
				'link',
				'aside',
				'gallery',
				'image',
				'quote',
				'status',
				'video',
				'audio',
				'chat',
			)
		);

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 1568, 9999 );

		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary menu', 'twentytwentyone' ),
				'footer'  => esc_html__( 'Secondary menu', 'twentytwentyone' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
				'navigation-widgets',
			)
		);

		/*
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		$logo_width  = 300;
		$logo_height = 100;

		add_theme_support(
			'custom-logo',
			array(
				'height'               => $logo_height,
				'width'                => $logo_width,
				'flex-width'           => true,
				'flex-height'          => true,
				'unlink-homepage-logo' => true,
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );
		$background_color = get_theme_mod( 'background_color', 'D1E4DD' );
		if ( 127 > Twenty_Twenty_One_Custom_Colors::get_relative_luminance_from_hex( $background_color ) ) {
			add_theme_support( 'dark-editor-style' );
		}

		$editor_stylesheet_path = './assets/css/style-editor.css';

		// Note, the is_IE global variable is defined by WordPress and is used
		// to detect if the current browser is internet explorer.
		global $is_IE;
		if ( $is_IE ) {
			$editor_stylesheet_path = './assets/css/ie-editor.css';
		}

		// Enqueue editor styles.
		add_editor_style( $editor_stylesheet_path );

		// Add custom editor font sizes.
		add_theme_support(
			'editor-font-sizes',
			array(
				array(
					'name'      => esc_html__( 'Extra small', 'twentytwentyone' ),
					'shortName' => esc_html_x( 'XS', 'Font size', 'twentytwentyone' ),
					'size'      => 16,
					'slug'      => 'extra-small',
				),
				array(
					'name'      => esc_html__( 'Small', 'twentytwentyone' ),
					'shortName' => esc_html_x( 'S', 'Font size', 'twentytwentyone' ),
					'size'      => 18,
					'slug'      => 'small',
				),
				array(
					'name'      => esc_html__( 'Normal', 'twentytwentyone' ),
					'shortName' => esc_html_x( 'M', 'Font size', 'twentytwentyone' ),
					'size'      => 20,
					'slug'      => 'normal',
				),
				array(
					'name'      => esc_html__( 'Large', 'twentytwentyone' ),
					'shortName' => esc_html_x( 'L', 'Font size', 'twentytwentyone' ),
					'size'      => 24,
					'slug'      => 'large',
				),
				array(
					'name'      => esc_html__( 'Extra large', 'twentytwentyone' ),
					'shortName' => esc_html_x( 'XL', 'Font size', 'twentytwentyone' ),
					'size'      => 40,
					'slug'      => 'extra-large',
				),
				array(
					'name'      => esc_html__( 'Huge', 'twentytwentyone' ),
					'shortName' => esc_html_x( 'XXL', 'Font size', 'twentytwentyone' ),
					'size'      => 96,
					'slug'      => 'huge',
				),
				array(
					'name'      => esc_html__( 'Gigantic', 'twentytwentyone' ),
					'shortName' => esc_html_x( 'XXXL', 'Font size', 'twentytwentyone' ),
					'size'      => 144,
					'slug'      => 'gigantic',
				),
			)
		);

		// Custom background color.
		add_theme_support(
			'custom-background',
			array(
				'default-color' => 'd1e4dd',
			)
		);

		// Editor color palette.
		$black     = '#000000';
		$dark_gray = '#28303D';
		$gray      = '#39414D';
		$green     = '#D1E4DD';
		$blue      = '#D1DFE4';
		$purple    = '#D1D1E4';
		$red       = '#E4D1D1';
		$orange    = '#E4DAD1';
		$yellow    = '#EEEADD';
		$white     = '#FFFFFF';

		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => esc_html__( 'Black', 'twentytwentyone' ),
					'slug'  => 'black',
					'color' => $black,
				),
				array(
					'name'  => esc_html__( 'Dark gray', 'twentytwentyone' ),
					'slug'  => 'dark-gray',
					'color' => $dark_gray,
				),
				array(
					'name'  => esc_html__( 'Gray', 'twentytwentyone' ),
					'slug'  => 'gray',
					'color' => $gray,
				),
				array(
					'name'  => esc_html__( 'Green', 'twentytwentyone' ),
					'slug'  => 'green',
					'color' => $green,
				),
				array(
					'name'  => esc_html__( 'Blue', 'twentytwentyone' ),
					'slug'  => 'blue',
					'color' => $blue,
				),
				array(
					'name'  => esc_html__( 'Purple', 'twentytwentyone' ),
					'slug'  => 'purple',
					'color' => $purple,
				),
				array(
					'name'  => esc_html__( 'Red', 'twentytwentyone' ),
					'slug'  => 'red',
					'color' => $red,
				),
				array(
					'name'  => esc_html__( 'Orange', 'twentytwentyone' ),
					'slug'  => 'orange',
					'color' => $orange,
				),
				array(
					'name'  => esc_html__( 'Yellow', 'twentytwentyone' ),
					'slug'  => 'yellow',
					'color' => $yellow,
				),
				array(
					'name'  => esc_html__( 'White', 'twentytwentyone' ),
					'slug'  => 'white',
					'color' => $white,
				),
			)
		);

		add_theme_support(
			'editor-gradient-presets',
			array(
				array(
					'name'     => esc_html__( 'Purple to yellow', 'twentytwentyone' ),
					'gradient' => 'linear-gradient(160deg, ' . $purple . ' 0%, ' . $yellow . ' 100%)',
					'slug'     => 'purple-to-yellow',
				),
				array(
					'name'     => esc_html__( 'Yellow to purple', 'twentytwentyone' ),
					'gradient' => 'linear-gradient(160deg, ' . $yellow . ' 0%, ' . $purple . ' 100%)',
					'slug'     => 'yellow-to-purple',
				),
				array(
					'name'     => esc_html__( 'Green to yellow', 'twentytwentyone' ),
					'gradient' => 'linear-gradient(160deg, ' . $green . ' 0%, ' . $yellow . ' 100%)',
					'slug'     => 'green-to-yellow',
				),
				array(
					'name'     => esc_html__( 'Yellow to green', 'twentytwentyone' ),
					'gradient' => 'linear-gradient(160deg, ' . $yellow . ' 0%, ' . $green . ' 100%)',
					'slug'     => 'yellow-to-green',
				),
				array(
					'name'     => esc_html__( 'Red to yellow', 'twentytwentyone' ),
					'gradient' => 'linear-gradient(160deg, ' . $red . ' 0%, ' . $yellow . ' 100%)',
					'slug'     => 'red-to-yellow',
				),
				array(
					'name'     => esc_html__( 'Yellow to red', 'twentytwentyone' ),
					'gradient' => 'linear-gradient(160deg, ' . $yellow . ' 0%, ' . $red . ' 100%)',
					'slug'     => 'yellow-to-red',
				),
				array(
					'name'     => esc_html__( 'Purple to red', 'twentytwentyone' ),
					'gradient' => 'linear-gradient(160deg, ' . $purple . ' 0%, ' . $red . ' 100%)',
					'slug'     => 'purple-to-red',
				),
				array(
					'name'     => esc_html__( 'Red to purple', 'twentytwentyone' ),
					'gradient' => 'linear-gradient(160deg, ' . $red . ' 0%, ' . $purple . ' 100%)',
					'slug'     => 'red-to-purple',
				),
			)
		);

		/*
		* Adds starter content to highlight the theme on fresh sites.
		* This is done conditionally to avoid loading the starter content on every
		* page load, as it is a one-off operation only needed once in the customizer.
		*/
		if ( is_customize_preview() ) {
			require get_template_directory() . '/inc/starter-content.php';
			add_theme_support( 'starter-content', twenty_twenty_one_get_starter_content() );
		}

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Add support for custom line height controls.
		add_theme_support( 'custom-line-height' );

		// Add support for link color control.
		add_theme_support( 'link-color' );

		// Add support for experimental cover block spacing.
		add_theme_support( 'custom-spacing' );

		// Add support for custom units.
		// This was removed in WordPress 5.6 but is still required to properly support WP 5.5.
		add_theme_support( 'custom-units' );

		// Remove feed icon link from legacy RSS widget.
		add_filter( 'rss_widget_feed_link', '__return_empty_string' );
	}
}
add_action( 'after_setup_theme', 'twenty_twenty_one_setup' );

/**
 * Registers widget area.
 *
 * @since Twenty Twenty-One 1.0
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 *
 * @return void
 */
function twenty_twenty_one_widgets_init() {

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer', 'twentytwentyone' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'twentytwentyone' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'twenty_twenty_one_widgets_init' );

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @since Twenty Twenty-One 1.0
 *
 * @global int $content_width Content width.
 *
 * @return void
 */
function twenty_twenty_one_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'twenty_twenty_one_content_width', 750 );
}
add_action( 'after_setup_theme', 'twenty_twenty_one_content_width', 0 );

/**
 * Enqueues scripts and styles.
 *
 * @since Twenty Twenty-One 1.0
 *
 * @global bool       $is_IE
 * @global WP_Scripts $wp_scripts
 *
 * @return void
 */
function twenty_twenty_one_scripts() {
	// Note, the is_IE global variable is defined by WordPress and is used
	// to detect if the current browser is internet explorer.
	global $is_IE, $wp_scripts;
	if ( $is_IE ) {
		// If IE 11 or below, use a flattened stylesheet with static values replacing CSS Variables.
		wp_enqueue_style( 'twenty-twenty-one-style', get_template_directory_uri() . '/assets/css/ie.css', array(), wp_get_theme()->get( 'Version' ) );
	} else {
		// If not IE, use the standard stylesheet.
		wp_enqueue_style( 'twenty-twenty-one-style', get_template_directory_uri() . '/style.css', array(), wp_get_theme()->get( 'Version' ) );
	}

	// RTL styles.
	wp_style_add_data( 'twenty-twenty-one-style', 'rtl', 'replace' );

	// Print styles.
	wp_enqueue_style( 'twenty-twenty-one-print-style', get_template_directory_uri() . '/assets/css/print.css', array(), wp_get_theme()->get( 'Version' ), 'print' );

	// Threaded comment reply styles.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Register the IE11 polyfill file.
	wp_register_script(
		'twenty-twenty-one-ie11-polyfills-asset',
		get_template_directory_uri() . '/assets/js/polyfills.js',
		array(),
		wp_get_theme()->get( 'Version' ),
		array( 'in_footer' => true )
	);

	// Register the IE11 polyfill loader.
	wp_register_script(
		'twenty-twenty-one-ie11-polyfills',
		null,
		array(),
		wp_get_theme()->get( 'Version' ),
		array( 'in_footer' => true )
	);
	wp_add_inline_script(
		'twenty-twenty-one-ie11-polyfills',
		wp_get_script_polyfill(
			$wp_scripts,
			array(
				'Element.prototype.matches && Element.prototype.closest && window.NodeList && NodeList.prototype.forEach' => 'twenty-twenty-one-ie11-polyfills-asset',
			)
		)
	);

	// Main navigation scripts.
	if ( has_nav_menu( 'primary' ) ) {
		wp_enqueue_script(
			'twenty-twenty-one-primary-navigation-script',
			get_template_directory_uri() . '/assets/js/primary-navigation.js',
			array( 'twenty-twenty-one-ie11-polyfills' ),
			wp_get_theme()->get( 'Version' ),
			array(
				'in_footer' => false, // Because involves header.
				'strategy'  => 'defer',
			)
		);
	}

	// Responsive embeds script.
	wp_enqueue_script(
		'twenty-twenty-one-responsive-embeds-script',
		get_template_directory_uri() . '/assets/js/responsive-embeds.js',
		array( 'twenty-twenty-one-ie11-polyfills' ),
		wp_get_theme()->get( 'Version' ),
		array( 'in_footer' => true )
	);
}
add_action( 'wp_enqueue_scripts', 'twenty_twenty_one_scripts' );

/**
 * Enqueues block editor script.
 *
 * @since Twenty Twenty-One 1.0
 *
 * @return void
 */
function twentytwentyone_block_editor_script() {

	wp_enqueue_script( 'twentytwentyone-editor', get_theme_file_uri( '/assets/js/editor.js' ), array( 'wp-blocks', 'wp-dom' ), wp_get_theme()->get( 'Version' ), array( 'in_footer' => true ) );
}

add_action( 'enqueue_block_editor_assets', 'twentytwentyone_block_editor_script' );

/**
 * Fixes skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @since Twenty Twenty-One 1.0
 * @deprecated Twenty Twenty-One 1.9 Removed from wp_print_footer_scripts action.
 *
 * @link https://git.io/vWdr2
 */
function twenty_twenty_one_skip_link_focus_fix() {

	// If SCRIPT_DEBUG is defined and true, print the unminified file.
	if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
		echo '<script>';
		include get_template_directory() . '/assets/js/skip-link-focus-fix.js';
		echo '</script>';
	} else {
		// The following is minified via `npx terser --compress --mangle -- assets/js/skip-link-focus-fix.js`.
		?>
		<script>
		/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",(function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())}),!1);
		</script>
		<?php
	}
}

/**
 * Enqueues non-latin language styles.
 *
 * @since Twenty Twenty-One 1.0
 *
 * @return void
 */
function twenty_twenty_one_non_latin_languages() {
	$custom_css = twenty_twenty_one_get_non_latin_css( 'front-end' );

	if ( $custom_css ) {
		wp_add_inline_style( 'twenty-twenty-one-style', $custom_css );
	}
}
add_action( 'wp_enqueue_scripts', 'twenty_twenty_one_non_latin_languages' );

// SVG Icons class.
require get_template_directory() . '/classes/class-twenty-twenty-one-svg-icons.php';

// Custom color classes.
require get_template_directory() . '/classes/class-twenty-twenty-one-custom-colors.php';
new Twenty_Twenty_One_Custom_Colors();

// Enhance the theme by hooking into WordPress.
require get_template_directory() . '/inc/template-functions.php';

// Menu functions and filters.
require get_template_directory() . '/inc/menu-functions.php';

// Custom template tags for the theme.
require get_template_directory() . '/inc/template-tags.php';

// Customizer additions.
require get_template_directory() . '/classes/class-twenty-twenty-one-customize.php';
new Twenty_Twenty_One_Customize();

// Block Patterns.
require get_template_directory() . '/inc/block-patterns.php';

// Block Styles.
require get_template_directory() . '/inc/block-styles.php';

// Dark Mode.
require_once get_template_directory() . '/classes/class-twenty-twenty-one-dark-mode.php';
new Twenty_Twenty_One_Dark_Mode();

/**
 * Enqueues scripts for the customizer preview.
 *
 * @since Twenty Twenty-One 1.0
 *
 * @return void
 */
function twentytwentyone_customize_preview_init() {
	wp_enqueue_script(
		'twentytwentyone-customize-helpers',
		get_theme_file_uri( '/assets/js/customize-helpers.js' ),
		array(),
		wp_get_theme()->get( 'Version' ),
		array( 'in_footer' => true )
	);

	wp_enqueue_script(
		'twentytwentyone-customize-preview',
		get_theme_file_uri( '/assets/js/customize-preview.js' ),
		array( 'customize-preview', 'customize-selective-refresh', 'jquery', 'twentytwentyone-customize-helpers' ),
		wp_get_theme()->get( 'Version' ),
		array( 'in_footer' => true )
	);
}
add_action( 'customize_preview_init', 'twentytwentyone_customize_preview_init' );

/**
 * Enqueues scripts for the customizer.
 *
 * @since Twenty Twenty-One 1.0
 *
 * @return void
 */
function twentytwentyone_customize_controls_enqueue_scripts() {

	wp_enqueue_script(
		'twentytwentyone-customize-helpers',
		get_theme_file_uri( '/assets/js/customize-helpers.js' ),
		array(),
		wp_get_theme()->get( 'Version' ),
		array( 'in_footer' => true )
	);
}
add_action( 'customize_controls_enqueue_scripts', 'twentytwentyone_customize_controls_enqueue_scripts' );

/**
 * Calculates classes for the main <html> element.
 *
 * @since Twenty Twenty-One 1.0
 *
 * @return void
 */
function twentytwentyone_the_html_classes() {
	/**
	 * Filters the classes for the main <html> element.
	 *
	 * @since Twenty Twenty-One 1.0
	 *
	 * @param string The list of classes. Default empty string.
	 */
	$classes = apply_filters( 'twentytwentyone_html_classes', '' );
	if ( ! $classes ) {
		return;
	}
	echo 'class="' . esc_attr( $classes ) . '"';
}

/**
 * Adds "is-IE" class to body if the user is on Internet Explorer.
 *
 * @since Twenty Twenty-One 1.0
 *
 * @return void
 */
function twentytwentyone_add_ie_class() {
	?>
	<script>
	if ( -1 !== navigator.userAgent.indexOf( 'MSIE' ) || -1 !== navigator.appVersion.indexOf( 'Trident/' ) ) {
		document.body.classList.add( 'is-IE' );
	}
	</script>
	<?php
}
add_action( 'wp_footer', 'twentytwentyone_add_ie_class' );

if ( ! function_exists( 'wp_get_list_item_separator' ) ) :
	/**
	 * Retrieves the list item separator based on the locale.
	 *
	 * Added for backward compatibility to support pre-6.0.0 WordPress versions.
	 *
	 * @since 6.0.0
	 */
	function wp_get_list_item_separator() {
		/* translators: Used between list items, there is a space after the comma. */
		return __( ', ', 'twentytwentyone' );
	}
endif;