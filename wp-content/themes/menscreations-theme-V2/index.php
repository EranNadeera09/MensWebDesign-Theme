<?php
/**
 * Main index template fallback
 * @package MensCreations
 */
get_header();
?>

<main id="main-content" role="main">
  <div class="container">
    <?php if (have_posts()): ?>
      <?php while (have_posts()): the_post(); ?>
        <article <?php post_class(); ?>>
          <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
          <?php the_excerpt(); ?>
          
          <?php the_content(); ?>
        </article>
      <?php endwhile; ?>
      <?php the_posts_pagination(); ?>
    <?php else: ?>
      <p><?php _e('No content found.', 'menscreations'); ?></p>
    <?php endif; ?>
  </div>
</main>

<?php get_footer(); ?>
