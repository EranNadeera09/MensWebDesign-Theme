# MensCreations WordPress Theme

A professional personal portfolio WordPress theme converted from a custom HTML/CSS/JS design.

## Features
- ✅ Light & Dark mode toggle (persists via sessionStorage)
- ✅ Tab switching: Projects, Resume, Contact
- ✅ AJAX contact form with WordPress email
- ✅ Custom Portfolio post type
- ✅ SEO friendly: meta tags, Open Graph, Twitter Card, Schema.org
- ✅ Accessible: ARIA roles, skip link, semantic HTML
- ✅ Responsive: mobile, tablet, desktop
- ✅ WordPress Customizer integration for all content

## Installation

1. Upload the `menscreations-theme` folder to `/wp-content/themes/`
2. Activate via **Appearance → Themes**
3. Go to **Appearance → Customize** to set your name, bio, contact details, and social links
4. Go to **Settings → Reading** → set Front page to "A static page", then create a blank page and select it as your front page
5. Add your projects via **Portfolio** in the admin menu
6. Upload your logo images to `/images/` folder:
   - `Logo_dark.png` (shown in dark mode)
   - `Logo_light.png` (shown in light mode)
   - `profile.png` (hero profile photo)
   - `favicon.svg`

## Customizer Settings

Navigate to **Appearance → Customize** to configure:

### Hero Section
- `hero_name` — Your full name
- `hero_subtitle` — Job title (e.g. "Software Engineer")
- `hero_bio` — Short bio description
- `hero_profile_image` — Profile photo URL

### About Card
- `about_text` — About me paragraph
- `about_location` — City, Country
- `about_job` — Job title & company
- `about_website` — Personal website URL

### Contact Info
- `contact_email` — Email address
- `contact_phone` — Phone number
- `contact_address` — Physical address
- `contact_maps_url` — Google Maps link

### Social Links
- `social_facebook`
- `social_instagram`
- `social_github`

### Resume (JSON format)
- `resume_education` — JSON array of education items
- `resume_experience` — JSON array of experience items
- `resume_skills` — JSON array of skill items

## Adding Projects

1. Go to **Portfolio → Add New**
2. Add title, featured image, excerpt
3. Add custom fields: `project_url` and `github_url`
4. Publish

## SEO
The theme includes built-in SEO without needing a plugin:
- Meta description tag
- Open Graph (Facebook/LinkedIn)
- Twitter Card
- Schema.org Person structured data
- Canonical URLs
- Semantic HTML5

For advanced SEO, you can also install Yoast SEO or Rank Math.

## File Structure
```
menscreations-theme/
├── style.css          ← Theme header + all styles
├── functions.php      ← Theme setup, scripts, SEO, AJAX
├── header.php         ← HTML head + top bar
├── footer.php         ← Footer + wp_footer()
├── front-page.php     ← Main portfolio page template
├── index.php          ← Fallback blog template
├── js/
│   └── main.js        ← Theme toggle + tabs + contact form
└── images/            ← Place your images here
    ├── Logo_dark.png
    ├── Logo_light.png
    ├── profile.png
    └── favicon.svg
```
