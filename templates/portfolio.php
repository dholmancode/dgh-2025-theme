<?php
/* Template Name: Portfolio */
get_header();
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

<div class="portfolio-masthead">
    <div class="masthead-left">
        <!-- Headshot and Intro -->
        <div class="headshot">
            <img src="<?php the_field('headshot'); ?>" alt="Danny's Headshot" class="circle-headshot">
        </div>
        <div class="intro-text">
        <?php if (get_field('intro')): ?>
                    <div class="intro">
                        <?php the_field('intro'); ?>
                    </div>
                <?php endif; ?>
        </div>
        <?php if (get_field('view_projects_button_text')): ?>
        <a href="<?php echo esc_url(get_field('view_projects_link')); ?>" class="view-projects-button" id="view-projects-button">
            <?php echo esc_html(get_field('view_projects_button_text')); ?>
        </a>
    <?php endif; ?>
    <div class="certifications">
            <h2>Certifications</h2>
                <?php if (get_field('certification_1')): ?>
                    <div class="certification">
                        <?php the_field('certification_1'); ?>
                    </div>
                <?php endif; ?>
                <?php if (get_field('certification_2')): ?>
                    <div class="certification">
                        <?php the_field('certification_2'); ?>
                    </div>
                <?php endif; ?>
            </div>
    </div>


    <!-- Featured Projects ---------------------------------------------------------------------->
  
    <?php
/*
<div class="masthead-right">

$featured_args = array(
    'post_type' => 'projects',
    'posts_per_page' => 3, // Adjust as needed
    'tax_query' => array(
        array(
            'taxonomy' => 'featured',
            'field'    => 'slug',
            'terms'    => 'featured',
        ),
    ),
);
$featured_query = new WP_Query($featured_args);

if ($featured_query->have_posts()) :
    while ($featured_query->have_posts()) : $featured_query->the_post(); ?>
        <div class="featured-project">
            <?php if (has_post_thumbnail()) : ?>
                <img src="<?php the_post_thumbnail_url('portfolio-thumbnail'); ?>" alt="<?php the_title(); ?>">
            <?php endif; ?>
            <div class="featured-details">
                <h2><?php the_title(); ?></h2>
                <p><?php the_excerpt(); ?></p>
                <a href="#<?php echo sanitize_title(get_the_title()); ?>" class="learn-more-button">Learn More</a>
            </div>
        </div>
    <?php endwhile;
    wp_reset_postdata();
else :
    echo '<p>No featured projects found.</p>';
endif;
*/
?>
</div>

<div id="project-feed" class="main-project-feed" style="overflow-x: none;">
    <?php
    // Custom Query for All Projects
    $args = array(
        'post_type' => 'projects',
        'posts_per_page' => -1, // Retrieve all projects
    );
    $project_query = new WP_Query($args);
    
    if ($project_query->have_posts()) :
        while ($project_query->have_posts()) : $project_query->the_post(); ?>
            <div class="project-item animate-2" id="project-<?php the_ID(); ?>">
                <div class="project-image">
                    <?php if (has_post_thumbnail()) : ?>
                        <img src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php the_title(); ?>">
                    <?php endif; ?>
                </div>
                <div class="project-content">
                    <h3><?php the_title(); ?></h3>
                    <p class="tools-used"><?php the_field('tools_used'); ?></p>
                    <p><?php the_field('short_description'); ?></p>

                    <!-- Project Details (Tabs) -->
                    <div class="project-details-tabs">
                        <div class="tab-titles">
                            <?php if (get_field('goals')): ?>
                                <div class="tab active" data-tab="goals-<?php the_ID(); ?>"><?php the_field('1_title'); ?></div>
                            <?php endif; ?>
                            <?php if (get_field('challenges')): ?>
                                <div class="tab" data-tab="challenges-<?php the_ID(); ?>"><?php the_field('2_title'); ?></div>
                            <?php endif; ?>
                            <?php if (get_field('process')): ?>
                                <div class="tab" data-tab="process-<?php the_ID(); ?>"><?php the_field('3_title'); ?></div>
                            <?php endif; ?>
                            <?php if (get_field('results')): ?>
                                <div class="tab" data-tab="results-<?php the_ID(); ?>"><?php the_field('4_title'); ?></div>
                            <?php endif; ?>
                            <?php if (get_field('future_work')): ?>
                                <div class="tab" data-tab="future_work-<?php the_ID(); ?>"><?php the_field('5_title'); ?></div>
                            <?php endif; ?>
                            <div class="tab-underline"></div>
                        </div>

                        <!-- Add Unique IDs Here for Content -->
                        <div class="tab-content" id="goals-<?php the_ID(); ?>"><?php the_field('1'); ?></div>
                        <div class="tab-content" id="challenges-<?php the_ID(); ?>"><?php the_field('2'); ?></div>
                        <div class="tab-content" id="process-<?php the_ID(); ?>"><?php the_field('3'); ?></div>
                        <div class="tab-content" id="results-<?php the_ID(); ?>"><?php the_field('4'); ?></div>
                        <div class="tab-content" id="future_work-<?php the_ID(); ?>"><?php the_field('5'); ?></div>
                    </div>

                    <div class="project-buttons">
                        <?php if(get_field('project_link')): ?>
                            <a href="<?php the_field('project_link'); ?>" target="_blank" class="view-project-button">View Project</a>
                        <?php endif; ?>
                        <?php if(get_field('github_link')): ?>
                            <a href="<?php the_field('github_link'); ?>" target="_blank" class="github-button">View Code on GitHub</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endwhile;
        wp_reset_postdata();
    else :
        echo '<p>No projects found.</p>';
    endif;
    ?>
</div>


<?php get_footer(); ?>