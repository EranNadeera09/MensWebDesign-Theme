<!-- FOOTER -->
<footer class="footer" role="contentinfo">
  <div class="container">
    <div class="hr"></div>
    <p class="body-medium top-padding-20 bottom-padding-20">
      &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php _e('All rights reserved.', 'menscreations'); ?>
    </p>

    <?php if (has_nav_menu('footer')): ?>
      <nav aria-label="<?php _e('Footer Navigation', 'menscreations'); ?>">
        <?php wp_nav_menu([
          'theme_location' => 'footer',
          'menu_class'     => 'footer-nav',
          'depth'          => 1,
          'fallback_cb'    => false,
        ]); ?>
      </nav>
    <?php endif; ?>
  </div>
</footer>
<!-- /FOOTER -->

<?php wp_footer(); ?>
</body>
</html>
