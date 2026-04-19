<?php
/**
 * Single Project Template — Modern Layout with Sidebar
 * @package MensCreations
 */

get_header();
?>

<main id="main-content" role="main">
  <div class="container">
    <div class="single-project-layout">

      <?php while (have_posts()): the_post(); ?>

      <article class="portfolio-single">

        <!-- Back Button -->
        <a href="<?php echo esc_url(home_url('/projects/')); ?>" class="back-btn chip">
          <span class="material-symbols-outlined" aria-hidden="true">arrow_back</span>
          <span class="label-large"><?php _e('Back to Projects', 'menscreations'); ?></span>
          <div class="state-layer"></div>
        </a>

        <!-- Category Tags -->
        <?php $post_cats = get_the_terms(get_the_ID(), 'project-category'); ?>
        <?php if ($post_cats && !is_wp_error($post_cats)): ?>
          <div class="card-tags" style="margin-top: 16px;">
            <?php foreach ($post_cats as $pcat): ?>
              <a href="<?php echo esc_url(get_term_link($pcat)); ?>" class="tag label-small">
                <?php echo esc_html($pcat->name); ?>
              </a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <!-- Title & Excerpt -->
        <div class="portfolio-header">
          <h1 class="display-small"><?php the_title(); ?></h1>
          <p class="body-large section-subtitle"><?php the_excerpt(); ?></p>
        </div>

        <!-- Action Buttons -->
        <?php
        $project_url = function_exists('get_field') ? get_field('project_url') : get_post_meta(get_the_ID(), 'project_url', true);
        $github_url  = function_exists('get_field') ? get_field('github_url')  : get_post_meta(get_the_ID(), 'github_url', true);
        $tech_stack  = function_exists('get_field') ? get_field('tech_stack')  : get_post_meta(get_the_ID(), 'tech_stack', true);
        ?>
        <div class="portfolio-actions">
          <?php if ($project_url): ?>
            <a href="<?php echo esc_url($project_url); ?>" target="_blank" rel="noopener noreferrer" class="btn">
              <span class="material-symbols-outlined" aria-hidden="true">open_in_new</span>
              <span class="label-large"><?php _e('Live Demo', 'menscreations'); ?></span>
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
          <?php if ($tech_stack): ?>
            <div class="chip">
              <span class="material-symbols-outlined" aria-hidden="true">build</span>
              <span class="label-large"><?php echo esc_html($tech_stack); ?></span>
            </div>
          <?php endif; ?>
        </div>

        <!-- Featured Image -->
        <?php if (has_post_thumbnail()): ?>
          <figure class="portfolio-hero">
            <?php the_post_thumbnail('full', ['class' => 'portfolio-hero-img', 'loading' => 'eager']); ?>
          </figure>
        <?php endif; ?>

        <!-- Full Content -->
        <div class="portfolio-content">
          <?php the_content(); ?>
        </div>

        <!-- Prev / Next Navigation -->
        <nav class="project-nav" aria-label="<?php _e('Project navigation', 'menscreations'); ?>">
          <?php
          $prev = get_previous_post(false, '', 'project-category');
          $next = get_next_post(false, '', 'project-category');
          ?>

          <?php if ($prev): ?>
            <a href="<?php echo esc_url(get_permalink($prev)); ?>" class="project-nav-item project-nav-prev">
              <span class="nav-label label-small">
                <span class="material-symbols-outlined" aria-hidden="true">arrow_back</span>
                <?php _e('Previous Project', 'menscreations'); ?>
              </span>
              <span class="nav-title title-small"><?php echo esc_html(get_the_title($prev)); ?></span>
            </a>
          <?php else: ?>
            <div class="project-nav-item project-nav-empty"></div>
          <?php endif; ?>

          <?php if ($next): ?>
            <a href="<?php echo esc_url(get_permalink($next)); ?>" class="project-nav-item project-nav-next">
              <span class="nav-label label-small">
                <?php _e('Next Project', 'menscreations'); ?>
                <span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span>
              </span>
              <span class="nav-title title-small"><?php echo esc_html(get_the_title($next)); ?></span>
            </a>
          <?php else: ?>
            <div class="project-nav-item project-nav-empty"></div>
          <?php endif; ?>

        </nav>

      </article>

      <!-- ═══════════════════════════
           SIDEBAR COLUMN
      ═══════════════════════════ -->
      <aside class="project-sidebar" aria-label="<?php _e('Project sidebar', 'menscreations'); ?>">

        <!-- Project Details Card -->
        <div class="sidebar-card">
          <h3 class="sidebar-title title-small"><?php _e('Project Details', 'menscreations'); ?></h3>
          <ul class="sidebar-meta-list">

            <?php if ($tech_stack): ?>
              <li class="sidebar-meta-item">
                <span class="material-symbols-outlined" aria-hidden="true">build</span>
                <div>
                  <p class="label-small info-title"><?php _e('Technologies', 'menscreations'); ?></p>
                  <p class="label-medium"><?php echo esc_html($tech_stack); ?></p>
                </div>
              </li>
            <?php endif; ?>

            <?php if ($post_cats && !is_wp_error($post_cats)): ?>
              <li class="sidebar-meta-item">
                <span class="material-symbols-outlined" aria-hidden="true">category</span>
                <div>
                  <p class="label-small info-title"><?php _e('Category', 'menscreations'); ?></p>
                  <p class="label-medium">
                    <?php echo esc_html(implode(', ', wp_list_pluck($post_cats, 'name'))); ?>
                  </p>
                </div>
              </li>
            <?php endif; ?>

            <?php if ($project_url): ?>
              <li class="sidebar-meta-item">
                <span class="material-symbols-outlined" aria-hidden="true">link</span>
                <div>
                  <p class="label-small info-title"><?php _e('Live URL', 'menscreations'); ?></p>
                  <a href="<?php echo esc_url($project_url); ?>" target="_blank" rel="noopener noreferrer" class="label-medium sidebar-link">
                    <?php echo esc_html(str_replace(['https://', 'http://'], '', rtrim($project_url, '/'))); ?>
                  </a>
                </div>
              </li>
            <?php endif; ?>

          </ul>
        </div>

        <!-- Categories -->
        <div class="sidebar-card">
          <h3 class="sidebar-title title-small"><?php _e('Categories', 'menscreations'); ?></h3>
          <?php
          $all_cats = get_terms(['taxonomy' => 'project-category', 'hide_empty' => true]);
          if ($all_cats && !is_wp_error($all_cats)):
          ?>
            <ul class="sidebar-cat-list">
              <?php foreach ($all_cats as $cat):
                $count = $cat->count;
              ?>
                <li class="sidebar-cat-item">
                  <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="sidebar-cat-link label-medium">
                    <span class="material-symbols-outlined" aria-hidden="true">folder</span>
                    <?php echo esc_html($cat->name); ?>
                  </a>
                  <span class="cat-count label-small"><?php echo esc_html($count); ?></span>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </div>

        <!-- Recent Projects -->
        <div class="sidebar-card">
          <h3 class="sidebar-title title-small"><?php _e('Recent Projects', 'menscreations'); ?></h3>
          <?php
          $recent = new WP_Query([
            'post_type'      => 'project',
            'posts_per_page' => 4,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
            'post__not_in'   => [get_the_ID()],
          ]);
          if ($recent->have_posts()):
          ?>
            <ul class="sidebar-recent-list">
              <?php while ($recent->have_posts()): $recent->the_post(); ?>
                <li class="sidebar-recent-item">
                  <?php if (has_post_thumbnail()): ?>
                    <figure class="recent-thumb">
                      <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('thumbnail', ['loading' => 'lazy']); ?>
                      </a>
                    </figure>
                  <?php endif; ?>
                  <div class="recent-info">
                    <a href="<?php the_permalink(); ?>" class="recent-title label-medium">
                      <?php the_title(); ?>
                    </a>
                    <?php
                    $r_cats = get_the_terms(get_the_ID(), 'project-category');
                    if ($r_cats && !is_wp_error($r_cats)):
                    ?>
                      <span class="recent-cat label-small"><?php echo esc_html($r_cats[0]->name); ?></span>
                    <?php endif; ?>
                  </div>
                </li>
              <?php endwhile; ?>
              <?php wp_reset_postdata(); ?>
            </ul>
          <?php endif; ?>
        </div>

      </aside>

      <?php endwhile; ?>

    </div><!-- /.single-project-layout -->
  </div><!-- /.container -->
</main>

<?php get_footer(); ?>