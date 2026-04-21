<?php
/**
 * Single Blog Post Template
 * @package MensCreations
 */

get_header();
?>

<main id="main-content" role="main">
  <div class="container">
    <div class="single-blog-layout">

      <?php while (have_posts()): the_post();
        $post_cats  = get_the_category();
        $read_time  = ceil(str_word_count(strip_tags(get_the_content())) / 200);
        $author_id  = get_the_author_meta('ID');
      ?>

      <!-- ═══════════════════════════
           MAIN ARTICLE
      ═══════════════════════════ -->
      <article class="single-blog-article" itemscope itemtype="https://schema.org/BlogPosting">

        <!-- SEO: Hidden schema data -->
        <meta itemprop="datePublished" content="<?php echo esc_attr(get_the_date('c')); ?>">
        <meta itemprop="dateModified"  content="<?php echo esc_attr(get_the_modified_date('c')); ?>">
        <meta itemprop="url"           content="<?php echo esc_url(get_permalink()); ?>">

        <!-- Category -->
        <?php if (!empty($post_cats)): ?>
          <div class="article-cat-tags">
            <?php foreach ($post_cats as $cat): ?>
              <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" class="article-cat-badge label-small">
                <?php echo esc_html($cat->name); ?>
              </a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <!-- Title -->
        <h1 class="display-small blog-post-title" itemprop="headline"><?php the_title(); ?></h1>

        <!-- Excerpt / Intro -->
        <?php if (get_the_excerpt()): ?>
          <p class="body-large section-subtitle article-post-intro" itemprop="description">
            <?php echo esc_html(get_the_excerpt()); ?>
          </p>
        <?php endif; ?>

        <!-- Featured Image -->
        <?php if (has_post_thumbnail()): ?>
          <figure class="blog-post-hero" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
            <?php the_post_thumbnail('full', ['loading' => 'eager', 'itemprop' => 'url']); ?>
            <?php if (get_the_post_thumbnail_caption()): ?>
              <figcaption class="blog-img-caption label-small"><?php echo esc_html(get_the_post_thumbnail_caption()); ?></figcaption>
            <?php endif; ?>
          </figure>
        <?php endif; ?>

        <!-- Content -->
        <div class="blog-post-content" itemprop="articleBody">
          <?php the_content(); ?>
        </div>

        <!-- Tags -->
        <?php $tags = get_the_tags(); ?>
        <?php if ($tags): ?>
          <div class="blog-post-tags">
            <span class="label-small" style="color: var(--on-surface-variant);"><?php _e('Tags:', 'menscreations'); ?></span>
            <?php foreach ($tags as $tag): ?>
              <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="blog-tag label-small">
                #<?php echo esc_html($tag->name); ?>
              </a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <!-- Meta Bar -->
        <div class="blog-post-meta-bar">
          <div class="blog-meta">
            <div class="blog-meta-author-info">
              <div class="blog-meta-secondary">
                <time class="label-small" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                  <?php echo esc_html(get_the_date('F j, Y')); ?>
                </time>
                <span class="blog-meta-dot">·</span>
                <span class="label-small"><?php echo esc_html($read_time); ?> <?php _e('min read', 'menscreations'); ?></span>
              </div>
            </div>
          </div>

          <!-- Share Buttons -->
          <div class="blog-share">
            <span class="label-small" style="color: var(--on-surface-variant);"><?php _e('Share:', 'menscreations'); ?></span>
            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" rel="noopener noreferrer" class="blog-share-btn" aria-label="Share on X">
              <span class="material-symbols-outlined">share</span>
            </a>
            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink()); ?>&title=<?php echo urlencode(get_the_title()); ?>" target="_blank" rel="noopener noreferrer" class="blog-share-btn" aria-label="Share on LinkedIn">
              <span class="material-symbols-outlined">person</span>
            </a>
            <button class="blog-share-btn blog-copy-link" data-url="<?php echo esc_attr(get_permalink()); ?>" aria-label="Copy link">
              <span class="material-symbols-outlined">link</span>
            </button>
          </div>
        </div>

        <!-- Back -->
        <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="back-btn chip">
          <span class="material-symbols-outlined" aria-hidden="true">arrow_back</span>
          <span class="label-large"><?php _e('Back to Blog', 'menscreations'); ?></span>
          <div class="state-layer"></div>
        </a>

        <!-- Prev / Next Navigation -->
        <nav class="blog-post-nav" aria-label="<?php _e('Post navigation', 'menscreations'); ?>">
          <?php $prev = get_previous_post(); $next = get_next_post(); ?>

          <?php if ($prev): ?>
            <a href="<?php echo esc_url(get_permalink($prev)); ?>" class="project-nav-item project-nav-prev">
              <span class="nav-label label-small">
                <span class="material-symbols-outlined">arrow_back</span>
                <?php _e('Previous Post', 'menscreations'); ?>
              </span>
              <span class="nav-title title-small"><?php echo esc_html(get_the_title($prev)); ?></span>
            </a>
          <?php else: ?>
            <div class="project-nav-item project-nav-empty"></div>
          <?php endif; ?>

          <?php if ($next): ?>
            <a href="<?php echo esc_url(get_permalink($next)); ?>" class="project-nav-item project-nav-next">
              <span class="nav-label label-small">
                <?php _e('Next Post', 'menscreations'); ?>
                <span class="material-symbols-outlined">arrow_forward</span>
              </span>
              <span class="nav-title title-small"><?php echo esc_html(get_the_title($next)); ?></span>
            </a>
          <?php else: ?>
            <div class="project-nav-item project-nav-empty"></div>
          <?php endif; ?>
        </nav>

      </article>

      <!-- ═══════════════════════════
           SIDEBAR
      ═══════════════════════════ -->
      <aside class="article-page-sidebar" aria-label="<?php _e('Blog sidebar', 'menscreations'); ?>">

        <!-- Categories -->
        <div class="sidebar-card">
          <div class="sidebar-title title-small"><?php _e('Categories', 'menscreations'); ?></div>
          <ul class="sidebar-cat-list">
            <?php foreach (get_categories(['hide_empty' => true]) as $cat): ?>
              <li class="sidebar-cat-item">
                <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" class="sidebar-cat-link label-medium">
                  <span class="material-symbols-outlined">folder</span>
                  <?php echo esc_html($cat->name); ?>
                </a>
                <span class="cat-count label-small"><?php echo esc_html($cat->count); ?></span>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <!-- Recent Posts -->
        <div class="sidebar-card">
          <div class="sidebar-title title-small"><?php _e('Recent Posts', 'menscreations'); ?></div>
          <?php
          $recent = new WP_Query([
            'post_type'      => 'post',
            'posts_per_page' => 4,
            'post_status'    => 'publish',
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
                    <a href="<?php the_permalink(); ?>" class="recent-title label-medium"><?php the_title(); ?></a>
                    <time class="recent-cat label-small" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                      <?php echo esc_html(get_the_date('M j, Y')); ?>
                    </time>
                  </div>
                </li>
              <?php endwhile; wp_reset_postdata(); ?>
            </ul>
          <?php endif; ?>
        </div>

        <!-- Popular Tags -->
        <?php $tags = get_tags(['hide_empty' => true, 'number' => 15]); ?>
        <?php if ($tags): ?>
          <div class="sidebar-card">
            <h3 class="sidebar-title title-small"><?php _e('Popular Tags', 'menscreations'); ?></h3>
            <div class="sidebar-tags">
              <?php foreach ($tags as $tag): ?>
                <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="blog-tag label-small">
                  #<?php echo esc_html($tag->name); ?>
                </a>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>

      </aside>

      <?php endwhile; ?>

    </div>
  </div>
</main>

<?php get_footer(); ?>