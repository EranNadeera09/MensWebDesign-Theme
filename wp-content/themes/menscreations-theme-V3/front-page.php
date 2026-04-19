<?php

/**
 * Front Page Template - MensCreations Portfolio
 * @package MensCreations
 */

get_header();

// mc_field() helper is defined in functions.php
?>

<main id="main-content" role="main">
  <div class="container">
    <article>

      <!-- HERO SECTION -->
      <section class="section hero" aria-label="<?php _e('Introduction', 'menscreations'); ?>">
        <div class="hero-container">
          <div class="left-col">
            <span class="headline-medium section-subtitle">Hola, &#128075; I'm,</span>

            <h1 class="display-large">
              <?php echo esc_html(mc_field('hero_name', 'Eran Nadeera')); ?>
            </h1>

            <span class="headline-small section-subtitle">
              <?php echo esc_html(mc_field('job_role', 'Web Developer | Technical SEO Specialist')); ?>
            </span>

            <p class="body-large section-text">
              <?php echo esc_html(mc_field('hero_description', get_bloginfo('description'))); ?>
            </p>

            <div class="btn-wrapper">
              <?php $email = mc_field('contact_email', get_option('admin_email')); ?>
              <a href="mailto:<?php echo esc_attr($email); ?>" class="chip">
                <span class="material-symbols-outlined" aria-hidden="true">mail</span>
                <span class="label-large"><?php echo esc_html($email); ?></span>
                <div class="state-layer"></div>
              </a>
            </div>

            <div class="btn-wrapper">
              <?php // --- PHONE CHIP --- 
              ?>
              <?php $phone = mc_field('contact_phone'); ?>
              <?php if ($phone): ?>
                <?php
                // 1. Remove all spaces and special characters
                $clean_phone = preg_replace('/[^0-9]/', '', $phone);

                // 2. If it starts with '0', replace it with '94'
                if (strpos($clean_phone, '0') === 0) {
                  $clean_phone = '94' . substr($clean_phone, 1);
                }
                ?>
                <a href="tel:+<?php echo esc_attr($clean_phone); ?>" class="chip">
                  <span class="material-symbols-outlined" aria-hidden="true">call</span>
                  <span class="label-large"><?php echo esc_html($phone); ?></span>
                  <div class="state-layer"></div>
                </a>
              <?php endif; ?>

              <?php // --- WHATSAPP CHIP --- 
              ?>
              <?php $wa_phone = mc_field('whatsapp_number'); ?>
              <?php if ($wa_phone): ?>
                <?php
                // 1. Remove spaces
                $wa_clean = preg_replace('/[^0-9]/', '', $wa_phone);

                // 2. Swap leading '0' for '94'
                if (strpos($wa_clean, '0') === 0) {
                  $wa_clean = '94' . substr($wa_clean, 1);
                }
                ?>
                <a href="https://wa.me/+<?php echo esc_attr($wa_clean); ?>" target="_blank" rel="noopener noreferrer" class="chip">
                  <span class="material-symbols-outlined" aria-hidden="true">chat</span>
                  <span class="label-large"><?php _e('WhatsApp', 'menscreations'); ?></span>
                  <div class="state-layer"></div>
                </a>
              <?php endif; ?>

            </div>
          </div>

          <div class="right-col">
            <figure class="hero-banner">
              <?php
              // Fetch the image array from ACF
              $hero_image_data = mc_field('hero_image');

              // Check if ACF returned an array (meaning an image was uploaded)
              if (is_array($hero_image_data)) {
                $hero_img_url = $hero_image_data['url'];
                // Use the alt text from the media library, fallback to hero_name
                $hero_img_alt = !empty($hero_image_data['alt']) ? $hero_image_data['alt'] : mc_field('hero_name', 'Eran Nadeera');
              } else {
                // Fallback if no image is set in the WordPress admin
                $hero_img_url = get_template_directory_uri() . '/images/hero-image.png';
                $hero_img_alt = mc_field('hero_name', 'Eran Nadeera');
              }
              ?>
              <img src="<?php echo esc_url($hero_img_url); ?>" alt="<?php echo esc_attr($hero_img_alt); ?>" class="img-cover">
            </figure>
          </div>

        </div>
      </section>

      <!-- MAIN CONTENT -->
      <div class="article">

        <!-- ABOUT CARD -->
        <div class="about-card" role="complementary" aria-label="<?php _e('About Me', 'menscreations'); ?>">
          <h2 class="card-title title-medium"><?php _e('About', 'menscreations'); ?></h2>

          <?php $about_text = mc_field('about_text'); ?>
          <?php if ($about_text): ?>
            <p class="body-medium card-text"><?php echo wp_kses_post($about_text); ?></p>
          <?php endif; ?>

          <!-- Profile Image -->
          <figure class="about-hero-banner img-holder" style="--width: 200; --height: 200">
            <?php
            // 1. Fetch the ACF image field (Assumes 'Image Array' return type in ACF settings)
            $acf_profile_img = mc_field('hero_profile_image');

            // 2. Define your local fallback URL
            $default_img_url = get_template_directory_uri() . '/images/MensCreations-Profile-Pic.webp';

            // 3. Logic: If ACF is an array and has a URL
            if (is_array($acf_profile_img) && !empty($acf_profile_img['url'])) {
              $final_img_url = $acf_profile_img['url'];
              $final_img_alt = !empty($acf_profile_img['alt']) ? $acf_profile_img['alt'] : get_bloginfo('name');
            } else {
              $final_img_url = $default_img_url;
              $final_img_alt = get_bloginfo('name');
            }
            ?>
            <img
              src="<?php echo esc_url($final_img_url); ?>"
              width="240" height="240"
              alt="<?php echo esc_attr($final_img_alt); ?>"
              class="img-cover"
              loading="eager">
          </figure>

          <ul class="about-list" aria-label="<?php _e('Personal Details', 'menscreations'); ?>">

            <?php $location = mc_field('about_location', 'Kurunegala, Sri Lanka'); ?>
            <?php if ($location): ?>
              <li class="list-item">
                <span class="material-symbols-outlined" aria-hidden="true">location_on</span>
                <span class="label-medium"><?php echo esc_html($location); ?></span>
              </li>
            <?php endif; ?>

            <?php $job = mc_field('about_job', 'Technical SEO Developer at Web Lankan'); ?>
            <?php if ($job): ?>
              <li class="list-item">
                <span class="material-symbols-outlined" aria-hidden="true">work</span>
                <span class="label-medium"><?php echo esc_html($job); ?></span>
              </li>
            <?php endif; ?>

            <?php
            $website_field = mc_field('about_website');

            // Check if it's an array (ACF Link Picker) or fallback to home_url
            if (is_array($website_field) && !empty($website_field['url'])) {
              $url = $website_field['url'];
              $display_name = !empty($website_field['title']) ? $website_field['title'] : $url;
            } else {
              // Fallback if the field is empty
              $url = home_url('');
              $display_name = $url;
            }
            ?>

            <?php if ($url): ?>
              <li class="list-item">
                <span class="material-symbols-outlined" aria-hidden="true">captive_portal</span>
                <a href="<?php echo esc_url($url); ?>" class="label-medium" target="_blank" rel="noopener noreferrer">
                  <?php
                  // Clean the URL for display (remove https:// etc.)
                  echo esc_html(str_replace(['https://', 'http://', 'www.'], '', $display_name));
                  ?>
                </a>
              </li>
            <?php endif; ?>

            <?php
            $social_group = mc_field('social_links');

            $linkedin = isset($social_group['social_linkedin']) ? $social_group['social_linkedin'] : null;
            ?>

            <?php $linkedin = mc_field('social_linkedin'); ?>

            <?php if ($linkedin && is_array($linkedin)) : ?>
              <li class="list-item">
                <span class="material-symbols-outlined" aria-hidden="true">person</span>
                <a href="<?php echo esc_url($linkedin['url']); ?>"
                  class="label-medium"
                  target="<?php echo esc_attr($linkedin['target'] ?: '_blank'); ?>" rel="noopener noreferrer" aria-label="Linkedin">
                  <?php echo esc_html($linkedin['title'] ?: 'Linkedin'); ?>
                </a>
              </li>
            <?php endif; ?>

          </ul>
        </div>

        <!-- TAB SECTION -->
        <div>
          <!-- PRIMARY TABS -->
          <div class="primary-tabs" role="tablist" aria-label="<?php _e('Portfolio sections', 'menscreations'); ?>">
            <button class="tab-btn active" data-tab-btn="project" role="tab" aria-selected="true" aria-controls="tab-project" id="btn-project">
              <span class="tab-text title-small"><?php _e('Projects', 'menscreations'); ?></span>
              <div class="state-layer"></div>
            </button>
            <button class="tab-btn" data-tab-btn="resume" role="tab" aria-selected="false" aria-controls="tab-resume" id="btn-resume">
              <span class="tab-text title-small"><?php _e('Resume', 'menscreations'); ?></span>
              <div class="state-layer"></div>
            </button>
            <button class="tab-btn" data-tab-btn="contact" role="tab" aria-selected="false" aria-controls="tab-contact" id="btn-contact">
              <span class="tab-text title-small"><?php _e('Contact', 'menscreations'); ?></span>
              <div class="state-layer"></div>
            </button>
          </div>

          <!-- PROJECTS TAB -->
          <section class="section tab-content active" data-tab-content="project" id="tab-project" role="tabpanel" aria-labelledby="btn-project">
            <div class="container_2">
              <div class="project-list">
                <?php
                $projects = new WP_Query([
                  'post_type'      => 'project',
                  'posts_per_page' => 12,
                  'post_status'    => 'publish',
                  'orderby'        => 'date',
                  'order'          => 'DESC',
                ]);
                if ($projects->have_posts()):
                  while ($projects->have_posts()): $projects->the_post();
                    $project_url = function_exists('get_field') ? get_field('project_url') : get_post_meta(get_the_ID(), 'project_url', true);
                    $github_url  = function_exists('get_field') ? get_field('github_url')  : get_post_meta(get_the_ID(), 'github_url', true);
                    $tech_stack  = function_exists('get_field') ? get_field('tech_stack')  : get_post_meta(get_the_ID(), 'tech_stack', true);

                    // use correct taxonomy key 'project-category' (underscore)
                    $post_cats = get_the_terms(get_the_ID(), 'project-category');

                    // ✅ build $cat_slugs for data-category filter attribute
                    $cat_slugs = '';
                    if ($post_cats && !is_wp_error($post_cats)) {
                      $cat_slugs = implode(' ', wp_list_pluck($post_cats, 'slug'));
                    }
                ?>
                    <article class="card" data-category="<?php echo esc_attr($cat_slugs); ?>">

                      <?php if (has_post_thumbnail()): ?>
                        <figure class="card-banner img-holder" style="--width:334; --height:200;">
                          <a href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
                            <?php the_post_thumbnail('medium', ['class' => 'img-cover', 'loading' => 'lazy']); ?>
                          </a>
                        </figure>
                      <?php endif; ?>

                      <div class="card-content">

                        <?php if ($post_cats && !is_wp_error($post_cats)): ?>
                          <div class="card-tags">
                            <?php foreach ($post_cats as $pcat): ?>
                              <span class="tag label-small"><?php echo esc_html($pcat->name); ?></span>
                            <?php endforeach; ?>
                          </div>
                        <?php endif; ?>

                        <h3 class="card-title title-medium">
                          <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>

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
                  <p class="body-medium inform-massage">
                    <?php _e('No projects yet. Add projects via Projects in WordPress admin.', 'menscreations'); ?>
                  </p>
                <?php endif; ?>
              </div>
            </div>
          </section>

          <!-- RESUME TAB -->
          <section class="section tab-content resume-tab" data-tab-content="resume" id="tab-resume" role="tabpanel" aria-labelledby="btn-resume">
            <div class="container_2">

              <!-- Education -->
              <h2 class="section-title title-small"><?php _e('Education', 'menscreations'); ?></h2>
              <ul class="list" aria-label="Education">
                <?php
                $education = function_exists('get_field') ? (get_field('resume_education') ?: []) : [];
                if (empty($education)) {
                  $education = [
                    ['title' => 'B.Sc. (Special) in Computer Science & Technology', 'org' => 'Uva Wellassa University of Sri Lanka', 'year' => '2018 – 2022', 'desc' => ''],
                    ['title' => 'Diploma in IT', 'org' => 'Wayamba University – Makandura Premises', 'year' => '2016 – 2017', 'desc' => ''],
                  ];
                }
                foreach ($education as $item):
                ?>
                  <li class="resume-item">
                    <div class="resume-card">
                      <p class="body-large"><?php echo esc_html($item['title']); ?></p>
                      <?php if (!empty($item['org'])): ?><span class="label-medium card-subtitle"><?php echo esc_html($item['org']); ?></span><?php endif; ?>
                      <?php if (!empty($item['year'])): ?><span class="label-medium card-subtitle"><?php echo esc_html($item['year']); ?></span><?php endif; ?>
                      <?php if (!empty($item['desc'])): ?><span class="body-medium card-text"><?php echo esc_html($item['desc']); ?></span><?php endif; ?>
                    </div>
                  </li>
                <?php endforeach; ?>
              </ul>

              <!-- Experience -->
              <h2 class="section-title title-small"><?php _e('Experience', 'menscreations'); ?></h2>
              <ul class="list" aria-label="Experience">
                <?php
                $experience = function_exists('get_field') ? (get_field('resume_experience') ?: []) : [];
                if (empty($experience)) {
                  $experience = [
                    ['title' => 'Technical SEO Developer', 'org' => 'Web Lankan – Nugegoda, Sri Lanka', 'year' => '2025 – Present', 'desc' => 'Designed and developed fully responsive, SEO-driven websites optimized for mobile-first indexing. Implemented technical SEO fixes including Core Web Vitals, schema markup, canonicalization, and HTTPS security.'],
                    ['title' => 'SEO-Focused Web Developer', 'org' => 'The Permalinks – Auckland, New Zealand', 'year' => '2023 – 2025', 'desc' => 'Developed fully responsive landing pages optimized for desktop and mobile. Translated technical SEO audit findings into practical fixes using WordPress, WooCommerce, Webflow, and Shopify.'],
                    ['title' => 'Internship Software Engineer', 'org' => 'Uva Wellassa University – CST Department', 'year' => '2022 (July – October)', 'desc' => 'Designed and developed a Management Information System for student batch, degree, and subject management using Laravel and Bootstrap.'],
                  ];
                }
                foreach ($experience as $item):
                ?>
                  <li class="resume-item">
                    <div class="resume-card">
                      <p class="body-large"><?php echo esc_html($item['title']); ?></p>
                      <?php if (!empty($item['org'])): ?><span class="label-medium card-subtitle"><?php echo esc_html($item['org']); ?></span><?php endif; ?>
                      <?php if (!empty($item['year'])): ?><span class="label-medium card-subtitle"><?php echo esc_html($item['year']); ?></span><?php endif; ?>
                      <?php if (!empty($item['desc'])): ?><span class="body-medium card-text"><?php echo esc_html($item['desc']); ?></span><?php endif; ?>
                    </div>
                  </li>
                <?php endforeach; ?>
              </ul>

              <!-- Skills -->
              <h2 class="section-title title-small"><?php _e('Skills And Technologies', 'menscreations'); ?></h2>
              <ul class="resume-bottom-list" aria-label="Skills">
                <?php
                $skills = function_exists('get_field') ? (get_field('resume_skills') ?: []) : [];
                if (empty($skills)) {
                  $skills = [
                    ['name' => 'HTML',          'icon' => get_template_directory_uri() . '/images/tools-icons/html5.svg'],
                    ['name' => 'CSS',           'icon' => get_template_directory_uri() . '/images/tools-icons/css3.svg'],
                    ['name' => 'JavaScript',    'icon' => get_template_directory_uri() . '/images/tools-icons/javascript.svg'],
                    ['name' => 'React',         'icon' => get_template_directory_uri() . '/images/tools-icons/react.js.svg'],
                    ['name' => 'WordPress',     'icon' => get_template_directory_uri() . '/images/tools-icons/wordpress.svg'],
                    ['name' => 'Webflow',       'icon' => get_template_directory_uri() . '/images/tools-icons/webflow.svg'],
                    ['name' => 'Shopify',       'icon' => get_template_directory_uri() . '/images/tools-icons/shopify.svg'],
                    ['name' => 'WooCommerce',   'icon' => get_template_directory_uri() . '/images/tools-icons/woocommerce.svg'],
                    ['name' => 'MySQL',         'icon' => get_template_directory_uri() . '/images/tools-icons/mysql.svg'],
                    ['name' => 'Screaming Frog', 'icon' => get_template_directory_uri() . '/images/tools-icons/screaming-frog.svg'],
                    ['name' => 'SEMrush',       'icon' => get_template_directory_uri() . '/images/tools-icons/SEMrush.svg'],
                    ['name' => 'Figma',         'icon' => get_template_directory_uri() . '/images/tools-icons/figma.svg'],
                  ];
                }
                foreach ($skills as $skill):
                ?>
                  <li class="resume-bottom-item">
                    <?php if (!empty($skill['icon'])): ?>
                      <img src="<?php echo esc_url($skill['icon']); ?>" width="28" height="28" loading="lazy" alt="<?php echo esc_attr($skill['name']); ?>" class="icon">
                    <?php endif; ?>
                    <span class="label-medium"><?php echo esc_html($skill['name']); ?></span>
                  </li>
                <?php endforeach; ?>
              </ul>

            </div>
          </section>

          <!-- CONTACT TAB -->
          <section class="section tab-content contact-tab" data-tab-content="contact" id="tab-contact" role="tabpanel" aria-labelledby="btn-contact">
            <div class="container_2">
              <div class="contact-info">
                <h3 class="section-title title-small"><?php _e('Contact Info', 'menscreations'); ?></h3>

                <ul class="contact-info-list" aria-label="Contact details">
                  <?php $c_email = mc_field('contact_email', get_option('admin_email')); ?>
                  <li class="contact-info-item">
                    <div class="icon-box" aria-hidden="true"><span class="material-symbols-outlined">mail</span></div>
                    <div class="info-content">
                      <p class="label-small info-title"><?php _e('Mail Us', 'menscreations'); ?></p>
                      <a href="mailto:<?php echo esc_attr($c_email); ?>" class="label-small info-text"><?php echo esc_html($c_email); ?></a>
                    </div>
                  </li>

                  <?php $c_phone = mc_field('contact_phone'); ?>
                  <?php if ($c_phone): ?>
                    <?php
                    // 1. Remove all spaces and special characters
                    $clean_c_phone = preg_replace('/[^0-9]/', '', $c_phone);

                    // 2. If number starts with '0', remove it and add '94'
                    if (strpos($clean_c_phone, '0') === 0) {
                      $clean_c_phone = '94' . substr($clean_c_phone, 1);
                    }
                    ?>
                    <li class="contact-info-item">
                      <div class="icon-box" aria-hidden="true">
                        <span class="material-symbols-outlined">call</span>
                      </div>
                      <div class="info-content">
                        <p class="label-small info-title"><?php _e('Phone Number', 'menscreations'); ?></p>
                        <!-- The link now uses +94 format, the text shows your original input -->
                        <a href="tel:+<?php echo esc_attr($clean_c_phone); ?>" class="label-small info-text">
                          <?php echo esc_html($c_phone); ?>
                        </a>
                      </div>
                    </li>
                  <?php endif; ?>

                  <?php $address = mc_field('contact_address', 'Kurunegala, Sri Lanka'); ?>
                  <?php $maps_url = mc_field('contact_maps_url'); ?>
                  <?php if ($address): ?>
                    <li class="contact-info-item">
                      <div class="icon-box" aria-hidden="true"><span class="material-symbols-outlined">location_on</span></div>
                      <div class="info-content">
                        <p class="label-small info-title"><?php _e('Address', 'menscreations'); ?></p>
                        <?php if ($maps_url): ?>
                          <a href="<?php echo esc_url($maps_url); ?>" class="label-small info-text" target="_blank" rel="noopener noreferrer"><?php echo esc_html($address); ?></a>
                        <?php else: ?>
                          <span class="label-small info-text"><?php echo esc_html($address); ?></span>
                        <?php endif; ?>
                      </div>
                    </li>
                  <?php endif; ?>
                </ul>

                <h3 class="section-title title-small"><?php _e('Social Info', 'menscreations'); ?></h3>
                <div class="social-list" aria-label="Social media links">
                  <?php
                  $social_group = mc_field('social_links');

                  $linkedin = isset($social_group['social_linkedin']) ? $social_group['social_linkedin'] : null;

                  $facebook = isset($social_group['social_facebook']) ? $social_group['social_facebook'] : null;
                  ?>

                  <?php if ($linkedin && is_array($linkedin)) : ?>
                    <a href="<?php echo esc_url($linkedin['url']); ?>"
                      class="social-item chip"
                      target="<?php echo esc_attr($linkedin['target'] ?: '_blank'); ?>"
                      rel="noopener noreferrer"
                      aria-label="Linkedin">

                      <?php echo esc_html($linkedin['title'] ?: 'Linkedin'); ?>
                      <div class="state-layer"></div>
                    </a>
                  <?php endif; ?>

                  <?php if ($facebook && is_array($facebook)) : ?>
                    <a href="<?php echo esc_url($facebook['url']); ?>"
                      class="social-item chip"
                      target="<?php echo esc_attr($facebook['target'] ?: '_blank'); ?>"
                      rel="noopener noreferrer"
                      aria-label="Facebook">

                      <?php echo esc_html($facebook['title'] ?: 'Facebook'); ?>
                      <div class="state-layer"></div>
                    </a>
                  <?php endif; ?>

                </div>
              </div>

              <!-- Contact Form -->
              <div class="contact-form">
                <h3 class="title-large"><?php _e("Let's Work Together.", 'menscreations'); ?></h3>
                <div id="form-message" role="alert" aria-live="polite" style="display:none; margin-top:12px; padding:12px; border-radius:8px;"></div>
                <div class="input-wrapper" id="contact-form">
                  <input type="text" name="name" id="contact-name" placeholder="<?php esc_attr_e('Name*', 'menscreations'); ?>" class="input-field" required aria-required="true" aria-label="<?php esc_attr_e('Your name', 'menscreations'); ?>">
                  <input type="email" name="email" id="contact-email" placeholder="<?php esc_attr_e('Email*', 'menscreations'); ?>" class="input-field" required aria-required="true" aria-label="<?php esc_attr_e('Your email address', 'menscreations'); ?>">
                  <input type="text" name="subject" id="contact-subject" placeholder="<?php esc_attr_e('Subject', 'menscreations'); ?>" class="input-field" aria-label="<?php esc_attr_e('Message subject', 'menscreations'); ?>">
                  <textarea name="message" id="contact-message" placeholder="<?php esc_attr_e('Message*', 'menscreations'); ?>" class="textarea" required aria-required="true" aria-label="<?php esc_attr_e('Your message', 'menscreations'); ?>"></textarea>
                  <button class="btn" id="contact-submit" type="button">
                    <span class="label-large"><?php _e('Send Message', 'menscreations'); ?></span>
                    <div class="state-layer"></div>
                  </button>
                </div>
              </div>

            </div>
          </section>

        </div>
      </div>

    </article>
  </div>
</main>

<?php get_footer(); ?>