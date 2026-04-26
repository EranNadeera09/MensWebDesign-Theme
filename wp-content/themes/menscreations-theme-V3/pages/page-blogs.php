<?php

/**
 * Blog Archive Page Template
 * @package MensCreations
 */

get_header();

// Get all post categories
$blog_categories = get_categories(['hide_empty' => true]);

// Pagination
$paged       = max(1, get_query_var('paged'), get_query_var('page'));
$posts_per_page = 9;

$blog_query = new WP_Query([
  'post_type'      => 'post',
  'post_status'    => 'publish',
  'posts_per_page' => $posts_per_page,
  'paged'          => $paged,
  'orderby'        => 'date',
  'order'          => 'DESC',
]);

// Featured post (latest)
$featured_query = new WP_Query([
  'post_type'      => 'post',
  'post_status'    => 'publish',
  'posts_per_page' => 1,
  'orderby'        => 'date',
  'order'          => 'DESC',
]);
$featured_post = $featured_query->have_posts() ? $featured_query->posts[0] : null;
wp_reset_postdata();
?>

<main id="main-content" role="main">
  <div class="container">
    <section class="section archive-page blog-archive">

      <!-- Page Header -->
      <div class="archive-header">
        <h1 class="display-small"><?php _e('Blogs', 'menscreations'); ?></h1>
        <p class="body-large section-subtitle">
          <?php _e('Insights on web development, SEO, and digital design.', 'menscreations'); ?>
        </p>
      </div>

  <!-- Category Filter -->
      <?php if (!empty($blog_categories)): ?>
        <div class="filter-tabs" id="blog-filter-tabs">
          <!-- "All" Button -->
          <a href="<?php echo esc_url(get_post_type_archive_link('post')); ?>"
            class="filter-btn <?php echo !$is_cat ? 'active' : ''; ?>">
            <span class="label-large"><?php _e('All', 'menscreations'); ?></span>
          </a>

          <?php foreach ($blog_categories as $cat): ?>
            <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"
              class="filter-btn <?php echo ($cat_id === $cat->term_id) ? 'active' : ''; ?>">
              <span class="label-large"><?php echo esc_html($cat->name); ?></span>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <?php if ($blog_query->have_posts()): ?>

        <!-- Featured Post (first post, full width) -->
        <?php if ($paged === 1 && $featured_post):
          $feat_cats = get_the_category($featured_post->ID);
          $feat_date = get_the_date('M j, Y', $featured_post->ID);
          $feat_read = ceil(str_word_count(strip_tags(get_post_field('post_content', $featured_post->ID))) / 200);
        ?>
          <article class="blog-featured" itemscope itemtype="https://schema.org/BlogPosting">
            <?php if (has_post_thumbnail($featured_post->ID)): ?>
              <figure class="blog-featured-img">
                <a href="<?php echo esc_url(get_permalink($featured_post->ID)); ?>">
                  <?php echo get_the_post_thumbnail($featured_post->ID, 'large', ['loading' => 'eager', 'itemprop' => 'image']); ?>
                </a>
              </figure>
            <?php endif; ?>
            <div class="blog-featured-content">
              <?php if (!empty($feat_cats)): ?>
                <a href="<?php echo esc_url(get_category_link($feat_cats[0]->term_id)); ?>" class="article-cat-badge label-small">
                  <?php echo esc_html($feat_cats[0]->name); ?>
                </a>
              <?php endif; ?>
              <h2 class="headline-small" itemprop="headline">
                <a href="<?php echo esc_url(get_permalink($featured_post->ID)); ?>" itemprop="url">
                  <?php echo esc_html(get_the_title($featured_post->ID)); ?>
                </a>
              </h2>
              <p class="body-large blog-excerpt" itemprop="description">
                <?php echo esc_html(wp_trim_words(get_the_excerpt($featured_post->ID), 25)); ?>
              </p>
              <div class="blog-meta">
                <time class="label-medium" datetime="<?php echo esc_attr(get_the_date('c', $featured_post->ID)); ?>" itemprop="datePublished">
                  <?php echo esc_html($feat_date); ?>
                </time>
                <span class="blog-meta-dot">·</span>
                <span class="label-medium"><?php echo esc_html($feat_read); ?> <?php _e('min read', 'menscreations'); ?></span>
              </div>
              <a href="<?php echo esc_url(get_permalink($featured_post->ID)); ?>" class="btn blog-read-btn">
                <span class="label-large"><?php _e('Read Article', 'menscreations'); ?></span>
                <span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span>
                <div class="state-layer"></div>
              </a>
            </div>
          </article>

          <div class="blog-section-divider">
            <span class="label-medium"><?php _e('All Posts', 'menscreations'); ?></span>
          </div>
        <?php endif; ?>

        <!-- Posts Grid -->
        <div class="archive-card-grid" id="blogs-grid">
          <?php while ($blog_query->have_posts()): $blog_query->the_post();
            $post_cats  = get_the_category();
            $read_time  = ceil(str_word_count(strip_tags(get_the_content())) / 200);
          ?>
            <article class="card" itemscope itemtype="https://schema.org/BlogPosting">

              <?php if (has_post_thumbnail()): ?>
                <figure class="card-banner img-holder" style="--width:334; --height:200;">
                  <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                    <?php the_post_thumbnail('medium_large', ['class' => 'img-cover', 'loading' => 'lazy', 'itemprop' => 'image']); ?>
                  </a>
                </figure>
              <?php else: ?>
                <div class="card-banner-placeholder">
                  <span class="material-symbols-outlined">image</span>
                </div>
              <?php endif; ?>

              <div class="card-content">

                <?php if (!empty($post_cats)): ?>
                  <a href="<?php echo esc_url(get_category_link($post_cats[0]->term_id)); ?>" class="tag label-small bottom-margin-10">
                    <?php echo esc_html($post_cats[0]->name); ?>
                  </a>
                <?php endif; ?>

                <h2 class="card-title title-medium" itemprop="headline">
                  <a href="<?php the_permalink(); ?>" itemprop="url"><?php the_title(); ?></a>
                </h2>

                <p class="card-subtitle body-small" itemprop="description">
                  <?php echo esc_html(wp_trim_words(get_the_excerpt(), 18)); ?>
                </p>

                <div class="blog-meta">
                  <time class="label-small" datetime="<?php echo esc_attr(get_the_date('c')); ?>" itemprop="datePublished">
                    <?php echo esc_html(get_the_date('M j, Y')); ?>
                  </time>
                  <span class="blog-meta-dot">·</span>
                  <span class="label-small"><?php echo esc_html($read_time); ?> <?php _e('min', 'menscreations'); ?></span>
                </div>

              </div>
            </article>
          <?php endwhile;
          wp_reset_postdata(); ?>
        </div>

        <!-- Pagination -->
        <?php if ($blog_query->max_num_pages > 1): ?>
          <nav class="blog-pagination" aria-label="<?php _e('Blog pagination', 'menscreations'); ?>">
            <?php
            echo paginate_links([
              'base'      => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
              'format'    => '?paged=%#%',
              'current'   => $paged,
              'total'     => $blog_query->max_num_pages,
              'prev_text' => '<span class="material-symbols-outlined">chevron_left</span>',
              'next_text' => '<span class="material-symbols-outlined">chevron_right</span>',
              'type'      => 'list',
            ]);
            ?>
          </nav>
        <?php endif; ?>

      <?php else: ?>
        <div class="blog-empty">
          <span class="material-symbols-outlined">article</span>
          <p class="body-large"><?php _e('No posts yet. Check back soon!', 'menscreations'); ?></p>
          <a href="<?php echo esc_url(home_url('/')); ?>" class="btn">
            <span class="label-large"><?php _e('Back to Home', 'menscreations'); ?></span>
            <div class="state-layer"></div>
          </a>
        </div>
      <?php endif; ?>

    </section>
  </div>
</main>

<?php get_footer(); ?>