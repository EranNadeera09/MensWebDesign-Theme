<?php
/**
 * Blogs Page Template - All Blogss with Category Filter
 * @package MensCreations
 */

get_header();

// Get All Blog categories for filter tabs
$categories = get_terms([
    'taxonomy'   => 'blog-category',
    'hide_empty' => true,
]);
?>

<main id="main-content" role="main">
  <div class="container">
    <section class="section archive-portfolio">

      <!-- Page Header -->
      <div class="archive-header">
        <h1 class="display-small"><?php _e('Projects', 'menscreations'); ?></h1>
        <p class="body-large section-subtitle">
          <?php _e('A Collection of My Work across Web Development, SEO, and Design.', 'menscreations'); ?>
        </p>
      </div>

      <!-- Category Filter Tabs -->
      <?php if (!empty($categories) && !is_wp_error($categories)): ?>
        <div class="filter-tabs" id="filter-tabs">
          <button class="filter-btn active" data-filter="all">
            <span class="label-large"><?php _e('All', 'menscreations'); ?></span>
            <div class="state-layer"></div>
          </button>
          <?php foreach ($categories as $cat): ?>
            <button class="filter-btn" data-filter="<?php echo esc_attr($cat->slug); ?>">
              <span class="label-large"><?php echo esc_html($cat->name); ?></span>
              <div class="state-layer"></div>
            </button>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <!-- Projects Grid -->
      <div class="project-grid" id="projects-grid">
        <?php
        $projects = new WP_Query([
            'post_type'      => 'project',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
        ]);

        if ($projects->have_posts()):
            while ($projects->have_posts()): $projects->the_post();
                $project_url = function_exists('get_field') ? get_field('project_url') : get_post_meta(get_the_ID(), 'project_url', true);
                $github_url  = function_exists('get_field') ? get_field('github_url')  : get_post_meta(get_the_ID(), 'github_url', true);
                $tech_stack  = function_exists('get_field') ? get_field('tech_stack')  : get_post_meta(get_the_ID(), 'tech_stack', true);
                $post_cats   = get_the_terms(get_the_ID(), 'project-category');
                $cat_slugs   = '';
                if ($post_cats && !is_wp_error($post_cats)) {
                    $cat_slugs = implode(' ', wp_list_pluck($post_cats, 'slug'));
                }
        ?>
          <article class="card portfolio-card" data-category="<?php echo esc_attr($cat_slugs); ?>">

            <?php if (has_post_thumbnail()): ?>
              <figure class="card-banner img-holder" style="--width:334; --height:200;">
                <a href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
                  <?php the_post_thumbnail('medium', ['class' => 'img-cover', 'loading' => 'lazy']); ?>
                </a>
              </figure>
            <?php else: ?>
              <div class="card-banner-placeholder">
                <span class="material-symbols-outlined">image</span>
              </div>
            <?php endif; ?>

            <div class="card-content">

              <?php if ($post_cats && !is_wp_error($post_cats)): ?>
                <div class="card-tags">
                  <?php foreach ($post_cats as $pcat): ?>
                    <span class="tag label-small"><?php echo esc_html($pcat->name); ?></span>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>

              <h2 class="card-title title-medium">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
              </h2>

              <p class="card-subtitle body-small"><?php the_excerpt(); ?></p>

              <?php if ($tech_stack): ?>
                <p class="label-small card-tech"><?php echo esc_html($tech_stack); ?></p>
              <?php endif; ?>

              <div class="portfolio-actions">
                <a href="<?php the_permalink(); ?>" class="btn">
                  <span class="label-large"><?php _e('View Project', 'menscreations'); ?></span>
                  <div class="state-layer"></div>
                </a>
                <?php if ($project_url): ?>
                  <a href="<?php echo esc_url($project_url); ?>" target="_blank" rel="noopener noreferrer" class="chip">
                    <span class="material-symbols-outlined" aria-hidden="true">open_in_new</span>
                    <span class="label-large"><?php _e('Live', 'menscreations'); ?></span>
                    <div class="state-layer"></div>
                  </a>
                <?php endif; ?>
                <?php if ($github_url): ?>
                  <a href="<?php echo esc_url($github_url); ?>" target="_blank" rel="noopener noreferrer" class="chip">
                    <span class="material-symbols-outlined" aria-hidden="true">code</span>
                    <span class="label-large">GitHub</span>
                    <div class="state-layer"></div>
                  </a>
                <?php endif; ?>
              </div>

            </div>
          </article>

        <?php
            endwhile;
            wp_reset_postdata();
        else:
        ?>
          <p class="body-medium" style="color: var(--on-surface-variant);">
            <?php _e('No projects found. Add projects via Projects in WordPress admin.', 'menscreations'); ?>
          </p>
        <?php endif; ?>
      </div>

    </section>
  </div>
</main>

<?php get_footer(); ?>