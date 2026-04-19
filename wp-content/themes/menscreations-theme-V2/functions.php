<?php
/**
 * MensCreations Theme Functions
 * @package MensCreations
 */

if (!defined('ABSPATH')) exit;

/**
 * ACF Helper — moved here from front-page.php to prevent fatal error
 * "Cannot redeclare mc_field()" when ACF is active
 */
if (!function_exists('mc_field')) {
    function mc_field($key, $fallback = '') {
        return function_exists('get_field') ? (get_field($key) ?: $fallback) : $fallback;
    }
}

/**
 * Theme Setup
 */
function menscreations_setup() {
    load_theme_textdomain('menscreations', get_template_directory() . '/languages');
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    register_nav_menus([
        'primary' => __('Primary Menu', 'menscreations'),
        'footer'  => __('Footer Menu', 'menscreations'),
    ]);
    add_theme_support('html5', [
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script',
    ]);
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
}
add_action('after_setup_theme', 'menscreations_setup');

/**
 * Enqueue Scripts and Styles
 */
function menscreations_scripts() {
    wp_enqueue_style('menscreations-fonts',
        'https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500&family=Open+Sans:wght@400;500&display=swap',
        [], null
    );
    wp_enqueue_style('material-icons',
        'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0',
        [], null
    );
    wp_enqueue_style('menscreations-style',
        get_stylesheet_uri(),
        ['menscreations-fonts', 'material-icons'],
        wp_get_theme()->get('Version')
    );
    wp_enqueue_script('menscreations-script',
        get_template_directory_uri() . '/js/main.js',
        [], wp_get_theme()->get('Version'), true
    );
    if (is_front_page()) {
        wp_localize_script('menscreations-script', 'menscreations_ajax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('menscreations_contact_nonce'),
        ]);
    }
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'menscreations_scripts');

/**
 * SEO: Meta Description
 */
function menscreations_meta_description() {
    if (is_front_page()) {
        $description = get_bloginfo('description');
    } elseif (is_singular()) {
        global $post;
        $description = wp_trim_words(get_the_excerpt(), 25, '...');
    } else {
        $description = get_bloginfo('description');
    }
    if ($description) {
        echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
    }
}
add_action('wp_head', 'menscreations_meta_description', 1);

/**
 * SEO: Open Graph Tags
 */
function menscreations_open_graph() {
    global $post;
    $site_name   = get_bloginfo('name');
    $title       = is_singular() ? get_the_title() : $site_name;
    $description = is_singular() ? wp_trim_words(get_the_excerpt(), 25) : get_bloginfo('description');
    $url         = is_singular() ? get_permalink() : home_url('/');
    $image       = is_singular() && has_post_thumbnail()
                    ? get_the_post_thumbnail_url(null, 'large')
                    : get_template_directory_uri() . '/images/og-image.png';

    echo '<meta property="og:site_name" content="'   . esc_attr($site_name)   . '">' . "\n";
    echo '<meta property="og:title" content="'       . esc_attr($title)       . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($description) . '">' . "\n";
    echo '<meta property="og:url" content="'         . esc_url($url)          . '">' . "\n";
    echo '<meta property="og:image" content="'       . esc_url($image)        . '">' . "\n";
    echo '<meta property="og:type" content="website">'                               . "\n";
    echo '<meta name="twitter:card" content="summary_large_image">'                  . "\n";
    echo '<meta name="twitter:title" content="'      . esc_attr($title)       . '">' . "\n";
    echo '<meta name="twitter:description" content="'. esc_attr($description) . '">' . "\n";
    echo '<meta name="twitter:image" content="'      . esc_url($image)        . '">' . "\n";
}
add_action('wp_head', 'menscreations_open_graph');

/**
 * Widgets / Sidebars
 */
function menscreations_widgets_init() {
    register_sidebar([
        'name'          => __('Footer Widget Area', 'menscreations'),
        'id'            => 'footer-sidebar',
        'description'   => __('Add widgets here to appear in footer.', 'menscreations'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);
}
add_action('widgets_init', 'menscreations_widgets_init');

/**
 * AJAX Contact Form Handler
 */
function menscreations_handle_contact() {
    check_ajax_referer('menscreations_contact_nonce', 'nonce');

    $name    = sanitize_text_field($_POST['name']        ?? '');
    $email   = sanitize_email($_POST['email']            ?? '');
    $subject = sanitize_text_field($_POST['subject']     ?? '');
    $message = sanitize_textarea_field($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        wp_send_json_error(['message' => __('Please fill in all required fields.', 'menscreations')]);
    }
    if (!is_email($email)) {
        wp_send_json_error(['message' => __('Please enter a valid email address.', 'menscreations')]);
    }

    $sent = wp_mail(
        get_option('admin_email'),
        'Portfolio Contact: ' . $subject,
        "Name: $name\nEmail: $email\n\nMessage:\n$message",
        ['Content-Type: text/plain; charset=UTF-8', "Reply-To: $name <$email>"]
    );

    if ($sent) {
        wp_send_json_success(['message' => __('Message sent successfully!', 'menscreations')]);
    } else {
        wp_send_json_error(['message' => __('Failed to send message. Please try again.', 'menscreations')]);
    }
}
add_action('wp_ajax_menscreations_contact',        'menscreations_handle_contact');
add_action('wp_ajax_nopriv_menscreations_contact', 'menscreations_handle_contact');

/**
 * Load templates from /templates/ and /pages/ folders
 */
function menscreations_template_include($template) {

    if (is_singular('project')) {
        $custom = get_template_directory() . '/templates/single-project.php';
        if (file_exists($custom)) return $custom;
    }

    if (is_post_type_archive('project')) {
        $custom = get_template_directory() . '/templates/archive-project.php';
        if (file_exists($custom)) return $custom;
    }

    if (is_tax('project-category')) {
        $custom = get_template_directory() . '/templates/archive-project.php';
        if (file_exists($custom)) return $custom;
    }

    // Projects page
    if (is_page('projects')) {
        $custom = get_template_directory() . '/pages/page-projects.php';
        if (file_exists($custom)) return $custom;
    }

    return $template;
}
add_filter('template_include', 'menscreations_template_include');

/**
 * Customize excerpt length
 */
function menscreations_excerpt_length() { return 20; }
add_filter('excerpt_length', 'menscreations_excerpt_length');

// Remove p tags from excerpts
remove_filter('the_excerpt', 'wpautop');

/**
 * Schema.org structured data for SEO
 */
function menscreations_schema_markup() {
    $schema = [
        '@context' => 'https://schema.org',
        '@type'    => 'Person',
        'name'     => get_bloginfo('name'),
        'url'      => home_url('/'),
        'jobTitle' => 'Web Developer & Technical SEO Specialist',
        'address'  => [
            '@type'           => 'PostalAddress',
            'addressLocality' => 'Kurunegala',
            'addressCountry'  => 'LK',
        ],
        'sameAs' => [
            'https://linkedin.com/in/erannadeera20/',
            'https://github.com/',
        ],
    ];
    echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>' . "\n";
}
add_action('wp_head', 'menscreations_schema_markup');

/**
 * Header scroll effect
 */
function menscreations_header_scroll_script() {
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const header = document.querySelector("header[role='banner']");
        if (header) {
            const handleScroll = () => {
                header.classList.toggle('scrolled', window.scrollY > 10);
            };
            handleScroll();
            window.addEventListener('scroll', handleScroll, { passive: true });
        }
    });
    </script>
    <?php
}
add_action('wp_footer', 'menscreations_header_scroll_script');