<!doctype html>
<html <?php language_attributes(); ?> data-theme="dark">

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <!-- Favicon -->
  <?php if (has_site_icon()): ?>
    <?php wp_site_icon(); ?>
  <?php else: ?>
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/menscreations-site-icon.svg" type="image/svg+xml">
  <?php endif; ?>

  <?php wp_head(); ?>
  
  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-M7ZBW8JM');</script>
  <!-- End Google Tag Manager -->
  
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M7ZBW8JM"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

  <!-- SKIP TO CONTENT -->
  <a class="skip-link screen-reader-text" href="#main-content"><?php _e('Skip to content', 'menscreations'); ?></a>

  <!-- HEADER -->
  <header role="banner">
    <div class="container">
      <div class="topbar">

        <!-- Logo -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="logo" aria-label="<?php bloginfo('name'); ?> - Home">
          <img src="<?php echo get_template_directory_uri(); ?>/images/Logo-dark.svg" alt="<?php bloginfo('name'); ?>" width="190" height="50" class="dark">
          <img src="<?php echo get_template_directory_uri(); ?>/images/Logo-light.svg" alt="<?php bloginfo('name'); ?>" width="190" height="50" class="light">
        </a>

        <!-- Desktop Navigation -->
        <nav class="nav-menu" id="nav-menu" aria-label="Primary Navigation">
          <?php wp_nav_menu([
            'theme_location' => 'primary',
            'menu_class'     => 'nav-list',
            'container'      => false,
            'depth'          => 1,
            'fallback_cb'    => function() {
              echo '<ul class="nav-list">
                <li><a href="#">Projects</a></li>
                <li><a href="#">Blogs</a></li>
                <li><a href="#">Contact</a></li>
              </ul>';
            },
          ]); ?>
        </nav>

        <!-- Right Actions -->
        <div class="topbar-actions">

          <!-- Theme Toggle -->
          <button class="icon-btn theme-btn" data-theme-btn aria-label="<?php _e('Toggle dark/light mode', 'menscreations'); ?>">
            <span class="material-symbols-outlined dark" aria-hidden="true">dark_mode</span>
            <span class="material-symbols-outlined light" aria-hidden="true">light_mode</span>
            <div class="state-layer"></div>
          </button>

          <!-- Mobile Menu Button -->
          <button class="icon-btn mobile-menu-btn" id="mobile-menu-btn"
            aria-label="<?php _e('Toggle menu', 'menscreations'); ?>"
            aria-expanded="false"
            aria-controls="nav-menu">
            <span class="material-symbols-outlined menu-open" aria-hidden="true">menu</span>
            <span class="material-symbols-outlined menu-close" aria-hidden="true">close</span>
            <div class="state-layer"></div>
          </button>

        </div>
      </div>
    </div>
  </header>
  <!-- /HEADER -->