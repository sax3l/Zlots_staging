<?php

if (!defined('ZLOTS_NONCE_NAME')) {
    define('ZLOTS_NONCE_NAME', 'zlots-nonce');
}

if (!defined('ZLOTS_NONCE_KEY')) {
    define('ZLOTS_NONCE_KEY', wp_create_nonce(ZLOTS_NONCE_NAME));
}

include_once get_stylesheet_directory() . '/classes/casinos/CasinoBonus.php';
include_once get_stylesheet_directory() . '/classes/casinos/Bonus.php';
include_once get_stylesheet_directory() . '/classes/casinos/Casino.php';
include_once get_stylesheet_directory() . '/theme-functions/admin-page.php';
include_once get_stylesheet_directory() . '/theme-functions/form-handler.php';
include_once get_stylesheet_directory() . '/theme-functions/requests.php';
include_once get_stylesheet_directory() . '/theme-functions/shortcodes.php';
include_once get_stylesheet_directory() . '/theme-functions/meta-fields.php';
include_once get_stylesheet_directory() . '/theme-functions/cpt.php';

add_action('wp_enqueue_scripts', 'zlots_theme_enqueue_styles', 1);

function zlots_theme_enqueue_styles() {
    $parenthandle = 'mercury-style';
    $theme = wp_get_theme();
    wp_enqueue_style($parenthandle, get_template_directory_uri() . '/style.css', array(), $theme->parent()->get('Version'));

    // Components styles
    wp_enqueue_style('tabs-style', get_stylesheet_directory_uri() . '/css/tabs.css');
    wp_enqueue_style('slider-style', get_stylesheet_directory_uri() . '/css/slider.css');
    wp_enqueue_style('values-style', get_stylesheet_directory_uri() . '/css/values.css');
    wp_enqueue_style('select-style', get_stylesheet_directory_uri() . '/css/select.css');
    wp_enqueue_style('dropdown-style', get_stylesheet_directory_uri() . '/css/dropdown.css');
    wp_enqueue_style('accordion-style', get_stylesheet_directory_uri() . '/css/accordion.css');
    wp_enqueue_style('load-more-style', get_stylesheet_directory_uri() . '/css/load-more.css');
    wp_enqueue_style('indicators-style', get_stylesheet_directory_uri() . '/css/indicators.css');
    wp_enqueue_style('mobile-menu-style', get_stylesheet_directory_uri() . '/css/mobile-menu.css');
    wp_enqueue_style('links-buttons-style', get_stylesheet_directory_uri() . '/css/links-buttons.css');

    // Widgets styles
    wp_enqueue_style('news-style', get_stylesheet_directory_uri() . '/css/news.css');
    wp_enqueue_style('item-slot-style', get_stylesheet_directory_uri() . '/css/item-slot.css');
    wp_enqueue_style('item-casino-style', get_stylesheet_directory_uri() . '/css/item-casino.css');
    wp_enqueue_style('item-hot-bonus-style', get_stylesheet_directory_uri() . '/css/item-hot-bonus.css');
    wp_enqueue_style('recommended-casinos-style', get_stylesheet_directory_uri() . '/css/recommended-casinos.css');
function enqueue_widget_recommended_casinos_styles() {
    wp_enqueue_style('widget-recommended-casinos', get_template_directory_uri() . '/public_html/wp-content/themes/mercury-child/css/widget-recommended-casinos.css', array(), '1.0.0', 'all');
}
add_action('wp_enqueue_scripts', 'enqueue_widget_recommended_casinos_styles');

    // Pages styles
    wp_enqueue_style('page-home-style', get_stylesheet_directory_uri() . '/css/page-home.css');
    wp_enqueue_style('page-single-game-style', get_stylesheet_directory_uri() . '/css/page-single-game.css');
    wp_enqueue_style('page-single-bonus-style', get_stylesheet_directory_uri() . '/css/page-single-bonus.css');
    wp_enqueue_style('page-single-casino-style', get_stylesheet_directory_uri() . '/css/page-single-casino.css');
    wp_enqueue_style('page-slots-archive-style', get_stylesheet_directory_uri() . '/css/page-slots-archive.css');
    wp_enqueue_style('page-bonuses-archive-style', get_stylesheet_directory_uri() . '/css/page-bonuses-archive.css');
    wp_enqueue_style('page-casinos-archive-style', get_stylesheet_directory_uri() . '/css/page-casinos-archive.css');

    // Themes styles
    wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/css/style.css');
    wp_enqueue_style('media-style', get_stylesheet_directory_uri() . '/css/media.css');

    // jQuery Plugins
    wp_enqueue_script('jquery-ui-slider');

    // Components scripts
    wp_enqueue_script('tabs-script', get_stylesheet_directory_uri() . '/js/tabs.js', ['jquery'], '', true);
    wp_enqueue_script('slider-script', get_stylesheet_directory_uri() . '/js/slider.js', ['jquery'], '', true);
    wp_enqueue_script('dropdown-script', get_stylesheet_directory_uri() . '/js/dropdown.js', ['jquery'], '', true);
    wp_enqueue_script('accordion-script', get_stylesheet_directory_uri() . '/js/accordion.js', ['jquery'], '', true);
    wp_enqueue_script('mobile-menu-script', get_stylesheet_directory_uri() . '/js/mobile-menu.js', ['jquery'], '', true);

    // Filters scripts
    wp_enqueue_script('filter-archive-slots-script', get_stylesheet_directory_uri() . '/js/filter-archive-slots.js', ['jquery'], '', true);
    wp_enqueue_script('filter-archive-casino-script', get_stylesheet_directory_uri() . '/js/filter-archive-casino.js', ['jquery'], '', true);
    wp_enqueue_script('filter-archive-bonuses-script', get_stylesheet_directory_uri() . '/js/filter-archive-bonuses.js', ['jquery'], '', true);
    wp_enqueue_script('theme-script', get_stylesheet_directory_uri() . '/js/script.js', ['jquery'], '', true);

    // Localize the script with the data
    $script_data = array(
        'ajaxurl' => admin_url('admin-ajax.php'), // URL for admin-ajax.php
        'nonce' => wp_create_nonce('ZLOTS_NONCE_NAME'), // Generate a nonce
    );
    wp_localize_script('filter-archive-casino-script', 'helper', $script_data);
    wp_localize_script('theme-script', 'helper', [
        'themeurl' => get_stylesheet_directory_uri(),
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => ZLOTS_NONCE_KEY,
    ]);
}

if (!function_exists('zlots_casinos_recommended_fields')) {
    function zlots_casinos_recommended_fields() {
        add_meta_box('zlots_casinos_recommended_meta_box',
            esc_html__('Is Recommended', 'zlots'),
            'zlots_casinos_recommended_display_meta_box',
            'casino', 'normal', 'high'
        );
    }
    add_action('admin_init', 'zlots_casinos_recommended_fields');
}

if (!function_exists('zlots_casinos_recommended_display_meta_box')) {
    function zlots_casinos_recommended_display_meta_box($casino) {
        wp_nonce_field('zlots_casinos_recommended_box', 'zlots_casinos_recommended_nonce');
        $is_casino_recommended = get_post_meta($casino->ID, 'zlots_is_recommended_casinos', true);
        ?>
        <div class="components-base-control">
            <div class="components-base-control__field">
                <label class="components-base-control__label">
                    <?php esc_html_e('Show in recommended?', 'zlots'); ?>
                </label>
                <div class="aces-single-rating-box">
                    <input type="checkbox" name="zlotz_is_recommended_casinos"
                        <?php echo $is_casino_recommended ? 'checked="checked"' : ''; ?>>
                </div>
            </div>
        </div>
        <?php
    }
}

if (!function_exists('zlots_casinos_recommended_save_fields')) {
    function zlots_casinos_recommended_save_fields($post_id) {
        $nonce = $_POST['zlots_casinos_recommended_nonce'] ?? null;

        if (!$nonce || !wp_verify_nonce($nonce, 'zlots_casinos_recommended_box')) {
            return $post_id;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        if ('casino' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        }

        $is_recommended_casinos = sanitize_text_field($_POST['zlotz_is_recommended_casinos']);
        update_post_meta($post_id, 'zlots_is_recommended_casinos', $is_recommended_casinos);
    }
    add_action('save_post', 'zlots_casinos_recommended_save_fields', 10, 2);
}

// Additional functions and hooks
add_action('after_setup_theme', 'zlots_setup');
function zlots_setup() {
    add_image_size('zlots-175-80', 175, 80, true);
    add_image_size('zlots-190-135', 190, 135, true);
    add_image_size('zlots-220-80', 220, 80, true);
    add_image_size('zlots-300-300', 902, 700, true);
    add_image_size('zlots-1980-200', 1040, 200, true);
}

add_filter('wpseo_breadcrumb_links', 'custom_zlots_breadcrumbs');
function custom_zlots_breadcrumbs($links) {
    if (!empty($links)) {
        $links[0] = [
            'url' => home_url('/'),
            'text' => 'Zlots.com',
        ];
    }

    if (strpos(get_the_title(), 'Review') !== false) {
        $last_index = key(array_slice($links, -1, 1, true));
        $links[$last_index]['text'] = get_the_title();
    }

    return $links;
}

// Retrieves related bonuses by casino ID.
function get_related_bonuses_by_casino_id($casino_id) {
    $related_bonuses = get_posts([
        'post_type' => 'bonus',
        'posts_per_page' => -1,
        'meta_query' => [
            ['key' => 'bonus_parent_casino', 'value' => $casino_id, 'compare' => '=']
        ]
    ]);

    $bonuses = [];
    foreach ($related_bonuses as $bonus_post) {
        $bonus = new Bonus($bonus_post->ID);
        $bonuses[] = $bonus;
    }

    return $bonuses;
}

// Enqueue necessary styles and scripts
function enqueue_custom_styles_and_scripts() {
    wp_enqueue_style('custom-style', get_stylesheet_directory_uri() . '/css/custom-style.css');
    wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/js/custom-script.js', ['jquery'], null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles_and_scripts');

// Add meta box for background images
if (!function_exists('add_custom_meta_box')) {
    function add_custom_meta_box() {
        add_meta_box('background_image_meta_box', 'Background Image', 'background_image_meta_box_callback', 'slot', 'side', 'high');
    }
    add_action('add_meta_boxes', 'add_custom_meta_box');
}

if (!function_exists('background_image_meta_box_callback')) {
    function background_image_meta_box_callback($post) {
        wp_nonce_field('save_background_image', 'background_image_nonce');
        $background_image = get_post_meta($post->ID, 'background_image', true);
        ?>
        <p>
            <label for="background_image">Upload Background Image</label>
            <input type="text" id="background_image" name="background_image" value="<?php echo esc_attr($background_image); ?>" style="width: 100%;" />
            <input type="button" id="background_image_button" class="button" value="Upload Image" />
        </p>
        <script>
            jQuery(document).ready(function($){
                var mediaUploader;
                $('#background_image_button').click(function(e) {
                    e.preventDefault();
                    if (mediaUploader) {
                        mediaUploader.open();
                        return;
                    }
                    mediaUploader = wp.media.frames.file_frame = wp.media({
                        title: 'Choose Image',
                        button: {
                            text: 'Choose Image'
                        }, multiple: false });
                    mediaUploader.on('select', function() {
                        var attachment = mediaUploader.state().get('selection').first().toJSON();
                        $('#background_image').val(attachment.url);
                    });
                    mediaUploader.open();
                });
            });
        </script>
        <?php
    }
}

if (!function_exists('save_background_image')) {
    function save_background_image($post_id) {
        if (!isset($_POST['background_image_nonce']) || !wp_verify_nonce($_POST['background_image_nonce'], 'save_background_image')) {
            return;
        }
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        if (isset($_POST['background_image'])) {
            update_post_meta($post_id, 'background_image', sanitize_text_field($_POST['background_image']));
        }
    }
    add_action('save_post', 'save_background_image');
}

// Enqueue SwiperJS and custom styles/scripts
function theme_enqueue_styles_scripts() {
    wp_enqueue_style('swiper-styles', 'https://unpkg.com/swiper/swiper-bundle.min.css', [], null, 'all');
    wp_enqueue_script('swiper-script', 'https://unpkg.com/swiper/swiper-bundle.min.js', [], null, true);
    wp_enqueue_style('tabs-styles', get_stylesheet_directory_uri() . '/css/tabs.css', [], '1.0', 'all');
    wp_enqueue_style('swiper-init-styles', get_stylesheet_directory_uri() . '/css/swiper-init.css', [], '1.0', 'all');
    wp_enqueue_script('tabs-script', get_stylesheet_directory_uri() . '/js/tabs.js', ['jquery'], '1.0', true);
    wp_enqueue_script('swiper-init-script', get_stylesheet_directory_uri() . '/js/swiper-init.js', ['jquery'], '1.0', true);
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles_scripts');

// Funktion för att hantera filter och laddning av fler slots
function filter_slots_handler() {
    // Kontrollera nonce för säkerhet
    check_ajax_referer('zlots-nonce', 'nonce');

    // Hämta och sanitera data
    $game_category = isset($_POST['game-category']) ? sanitize_text_field($_POST['game-category']) : '';
    $vendor = isset($_POST['vendor']) ? sanitize_text_field($_POST['vendor']) : '';
    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    $sort_by = isset($_POST['sort_by']) ? sanitize_text_field($_POST['sort_by']) : '';

    // Bygg WP_Query argument
    $args = array(
        'post_type' => 'slot',
        'posts_per_page' => 12,
        'offset' => $offset,
        'meta_query' => array(
            'relation' => 'AND',
        ),
    );

    if (!empty($game_category)) {
        $args['meta_query'][] = array(
            'key' => 'game_category',
            'value' => $game_category,
            'compare' => 'LIKE'
        );
    }

    if (!empty($vendor)) {
        $args['meta_query'][] = array(
            'key' => 'vendor',
            'value' => $vendor,
            'compare' => 'LIKE'
        );
    }

    if (!empty($sort_by)) {
        $args['orderby'] = $sort_by;
        $args['order'] = 'ASC'; // Eller 'DESC' beroende på dina krav
    }

    $query = new WP_Query($args);

    $slots_html = '';
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            ob_start();
            get_template_part('template-parts/content', 'slot');
            $slots_html .= ob_get_clean();
        }
    } else {
        $slots_html = '<div class="card-nocasfound"><h3 class="card-nocasfoundtext">No Slots Found!</h3><button id="resetParametersBtn" class="mainstylebutton" type="button">Reset Parameters</button></div>';
    }

    wp_send_json_success($slots_html);
}

add_action('wp_ajax_filter_slots', 'filter_slots_handler');
add_action('wp_ajax_nopriv_filter_slots', 'filter_slots_handler');













// Funktion för att hantera filter och laddning av fler casinos
// Function to handle filtering and loading more casinos
function zlots_filter_casinos() {
    check_ajax_referer('zlots_nonce', 'nonce');

    $args = [
        'post_type' => 'casino',
        'posts_per_page' => 12,
        'offset' => isset($_POST['offset']) ? intval($_POST['offset']) : 0,
        'tax_query' => []
    ];

    // ... (process filters)

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        ob_start();
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('theme-parts/item-archive-casino', null, ['casino_id' => get_the_ID()]);
        }
        $content = ob_get_clean();
        wp_send_json_success($content);
    } else {
        wp_send_json_error('No casinos found.');
    }

    wp_die();
}
add_action('wp_ajax_filter_casinos', 'zlots_filter_casinos');
add_action('wp_ajax_nopriv_filter_casinos', 'zlots_filter_casinos');














// ACES plugin integration
global $aces_version;
$aces_version = '3.0.4';

global $aces_options, $aces_plugin_dir, $aces_plugin_url;
$aces_plugin_dir = untrailingslashit(plugin_dir_path(__FILE__));
$aces_plugin_url = untrailingslashit(plugin_dir_url(__FILE__));

function aces_init() {
    load_plugin_textdomain('aces', false, plugin_basename(dirname(__FILE__)) . '/languages/');
}
add_filter('init', 'aces_init');

include_once $aces_plugin_dir . '/settings/index.php';
include_once $aces_plugin_dir . '/settings/casinos.php';
include_once $aces_plugin_dir . '/settings/games.php';
include_once $aces_plugin_dir . '/settings/bonuses.php';
include_once $aces_plugin_dir . '/settings/geolocation.php';

include_once $aces_plugin_dir . '/casinos.php';
include_once $aces_plugin_dir . '/games.php';
include_once $aces_plugin_dir . '/bonuses.php';
include_once $aces_plugin_dir . '/functions/geolocation.php';

// ACES Rating Stars
function aces_star_rating($args = []) {
    $defaults = [
        'rating' => 0,
        'type' => 'rating',
        'stars_number' => 0,
        'echo' => true,
    ];
    $parsed_args = wp_parse_args($args, $defaults);
    $rating = $parsed_args['rating'];

    if ($rating != 0) {
        $rating = (float) str_replace(',', '.', $parsed_args['rating']);
        $stars_number = $parsed_args['stars_number'];

        $full_stars = floor($rating);
        $half_stars = ceil($rating - $full_stars);
        $empty_stars = $stars_number - $full_stars - $half_stars;

        if ($empty_stars >= 0) {
            $output = '<div class="star-rating">';
            $output .= str_repeat('<div class="star star-full" aria-hidden="true"></div>', $full_stars);
            $output .= str_repeat('<div class="star star-half" aria-hidden="true"></div>', $half_stars);
            $output .= str_repeat('<div class="star star-empty" aria-hidden="true"></div>', $empty_stars);
            $output .= '</div>';

            if ($parsed_args['echo']) {
                echo $output;
            }
        }

        return $output;
    }
}

include_once $aces_plugin_dir . '/widgets/casinos-widget-1.php';
include_once $aces_plugin_dir . '/widgets/casinos-widget-2.php';
include_once $aces_plugin_dir . '/widgets/casinos-widget-3.php';
include_once $aces_plugin_dir . '/widgets/casinos-widget-4.php';
include_once $aces_plugin_dir . '/widgets/casinos-widget-5.php';
include_once $aces_plugin_dir . '/widgets/casinos-widget-6.php';
include_once $aces_plugin_dir . '/widgets/casinos-widget-7.php';
include_once $aces_plugin_dir . '/widgets/casinos-widget-8.php';
include_once $aces_plugin_dir . '/widgets/casinos-widget-9.php';
include_once $aces_plugin_dir . '/widgets/casinos-widget-10.php';
include_once $aces_plugin_dir . '/widgets/games-widget-1.php';
include_once $aces_plugin_dir . '/widgets/games-widget-2.php';
include_once $aces_plugin_dir . '/widgets/games-widget-3.php';
include_once $aces_plugin_dir . '/widgets/games-sidebar.php';
include_once $aces_plugin_dir . '/widgets/bonuses-home.php';

include_once $aces_plugin_dir . '/shortcodes/casinos-shortcode-1.php';
include_once $aces_plugin_dir . '/shortcodes/casinos-shortcode-2.php';
include_once $aces_plugin_dir . '/shortcodes/casinos-shortcode-3.php';
include_once $aces_plugin_dir . '/shortcodes/casinos-shortcode-4.php';
include_once $aces_plugin_dir . '/shortcodes/casinos-shortcode-5.php';
include_once $aces_plugin_dir . '/shortcodes/casinos-shortcode-6.php';
include_once $aces_plugin_dir . '/shortcodes/casinos-shortcode-7.php';
include_once $aces_plugin_dir . '/shortcodes/casinos-shortcode-8.php';
include_once $aces_plugin_dir . '/shortcodes/casinos-shortcode-9.php';

include_once $aces_plugin_dir . '/shortcodes/organization-single-1.php';
include_once $aces_plugin_dir . '/shortcodes/organization-single-2.php';
include_once $aces_plugin_dir . '/shortcodes/organization-single-3.php';
include_once $aces_plugin_dir . '/shortcodes/organization-taxonomy-1.php';
include_once $aces_plugin_dir . '/shortcodes/organization-rating-1.php';
include_once $aces_plugin_dir . '/shortcodes/organization-rating-2.php';

include_once $aces_plugin_dir . '/shortcodes/games-shortcode-1.php';
include_once $aces_plugin_dir . '/shortcodes/games-shortcode-2.php';
include_once $aces_plugin_dir . '/shortcodes/games-shortcode-3.php';
include_once $aces_plugin_dir . '/shortcodes/games-shortcode-4.php';
include_once $aces_plugin_dir . '/shortcodes/games-shortcode-5.php';
include_once $aces_plugin_dir . '/shortcodes/vendors-shortcode-1.php';

include_once $aces_plugin_dir . '/shortcodes/unit-single-1.php';
include_once $aces_plugin_dir . '/shortcodes/unit-single-2.php';
include_once $aces_plugin_dir . '/shortcodes/unit-single-3.php';

include_once $aces_plugin_dir . '/shortcodes/bonuses-shortcode-1.php';
include_once $aces_plugin_dir . '/shortcodes/bonuses-shortcode-2.php';

include_once $aces_plugin_dir . '/shortcodes/offer-single-1.php';

include_once $aces_plugin_dir . '/shortcodes/cards-shortcode.php';
include_once $aces_plugin_dir . '/shortcodes/pros-shortcode-1.php';
include_once $aces_plugin_dir . '/shortcodes/cons-shortcode-1.php';

function aces_image_uploader() {
    global $typenow;
    if ($typenow == 'casino' || $typenow == 'game' || $typenow == 'bonus') {
        if (!did_action('wp_enqueue_media')) {
            wp_enqueue_media();
        }
        wp_register_script('aces-image-uploader', plugin_dir_url(__FILE__) . 'js/image-uploader.js', ['jquery'], '2.4');
        wp_enqueue_script('aces-image-uploader');
    }
}
add_action('admin_enqueue_scripts', 'aces_image_uploader');

function aces_stylesheets() {
    wp_enqueue_style('aces-style', $GLOBALS['aces_plugin_url'] . '/css/aces-style.css', [], $GLOBALS['aces_version'], 'all');
    wp_enqueue_style('aces-media', $GLOBALS['aces_plugin_url'] . '/css/aces-media.css', [], $GLOBALS['aces_version'], 'all');
}
add_action('wp_enqueue_scripts', 'aces_stylesheets');

// Add a logo image column in the admin panel
function aces_logo_image_column_casino($column_ars) {
    $column_ars = array_slice($column_ars, 0, 1, true)
        + array('featured_logo' => 'Logo')
        + array_slice($column_ars, 1, NULL, true);
    return $column_ars;
}
add_filter('manage_casino_posts_columns', 'aces_logo_image_column_casino');

function aces_logo_image_column_game($column_ars) {
    $column_ars = array_slice($column_ars, 0, 1, true)
        + array('featured_logo' => 'Image')
        + array_slice($column_ars, 1, NULL, true);
    return $column_ars;
}
add_filter('manage_game_posts_columns', 'aces_logo_image_column_game');

function aces_logo_image_column_bonus($column_ars) {
    $column_ars = array_slice($column_ars, 0, 1, true)
        + array('featured_logo' => 'Image')
        + array_slice($column_ars, 1, NULL, true);
    return $column_ars;
}
add_filter('manage_bonus_posts_columns', 'aces_logo_image_column_bonus');

function aces_display_logo_column($column_name, $post_id) {
    if ($column_name == 'featured_logo') {
        if (has_post_thumbnail($post_id)) {
            $logo_src = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'thumbnail');
            $logo_id = get_post_thumbnail_id($post_id);
            echo '<img data-id="' . $logo_id . '" src="' . esc_url($logo_src[0]) . '" />';
        }
    }
}
add_action('manage_posts_custom_column', 'aces_display_logo_column', 10, 2);

function aces_custom_logo_css() {
    echo '<style>
        #featured_logo {
            width: 100px;
        }
        td.featured_logo.column-featured_logo img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
    </style>';
}
add_action('admin_head', 'aces_custom_logo_css');

// Add item ID column in the admin panel
function aces_item_id_column_organization($column_ars) {
    $column_ars = array_slice($column_ars, 0, 3, true)
        + array('aces_item_id' => 'Item ID')
        + array_slice($column_ars, 1, NULL, true);
    return $column_ars;
}
add_filter('manage_casino_posts_columns', 'aces_item_id_column_organization');

function aces_item_id_column_unit($column_ars) {
    $column_ars = array_slice($column_ars, 0, 3, true)
        + array('aces_item_id' => 'Item ID')
        + array_slice($column_ars, 1, NULL, true);
    return $column_ars;
}
add_filter('manage_game_posts_columns', 'aces_item_id_column_unit');

function aces_item_id_column_offer($column_ars) {
    $column_ars = array_slice($column_ars, 0, 3, true)
        + array('aces_item_id' => 'Item ID')
        + array_slice($column_ars, 1, NULL, true);
    return $column_ars;
}
add_filter('manage_bonus_posts_columns', 'aces_item_id_column_offer');

function aces_display_item_id_column($column_name, $post_id) {
    if ($column_name == 'aces_item_id') {
        if ($post_id) {
            echo '<strong>' . $post_id . '</strong>';
        }
    }
}
add_action('manage_posts_custom_column', 'aces_display_item_id_column', 10, 2);

// Standard field for uploading background image of casino/game single page
function aces_background_image_uploader($name, $value = '') {
    $image = ' button">' . esc_html__('Upload image', 'aces');
    $display = 'none';

    if ($image_attributes = wp_get_attachment_image_src($value, 'mercury-2000-400')) {
        $image = '"><img src="' . $image_attributes[0] . '" style="max-width: 100%; width: auto; display: block;" />';
        $display = 'block';
    }

    return '
    <div style="margin-top: 1em;">
        <a href="#" style="display: inline-block;" class="aces_upload_background_button' . $image . '</a>
        <input type="hidden" name="' . $name . '" id="' . $name . '" value="' . esc_attr($value) . '" />
        <a href="#" class="aces_remove_background_button components-button is-link is-destructive" style="margin-top: 1em; display:' . $display . '">' . esc_html__('Remove background image', 'aces') . '</a>
    </div>';
}

// Change classes for custom post types in the body
function aces_change_casino_body_classes($classes, $class) {
    global $post;
    if ($post) {
        $post_type = $post->post_type;
    } else {
        $post_type = '';
    }

    if ($post_type != 'casino') {
        return $classes;
    } else {
        foreach ($classes as &$str) {
            if (strpos($str, 'single-casino') > -1) {
                $str = 'single-organization';
            }
            if (strpos($str, 'casino-template-default') > -1) {
                $str = 'organization-template-default';
            }
        }
    }
    return $classes;
}
add_filter('body_class', 'aces_change_casino_body_classes', 10, 2);

function aces_change_game_body_classes($classes, $class) {
    global $post;
    if ($post) {
        $post_type = $post->post_type;
    } else {
        $post_type = '';
    }

    if ($post_type != 'game') {
        return $classes;
    } else {
        foreach ($classes as &$str) {
            if (strpos($str, 'single-game') > -1) {
                $str = 'single-unit';
            }
            if (strpos($str, 'game-template-default') > -1) {
                $str = 'unit-template-default';
            }
        }
    }
    return $classes;
}
add_filter('body_class', 'aces_change_game_body_classes', 10, 2);

function aces_change_bonus_body_classes($classes, $class) {
    global $post;
    if ($post) {
        $post_type = $post->post_type;
    } else {
        $post_type = '';
    }

    if ($post_type != 'bonus') {
        return $classes;
    } else {
        foreach ($classes as &$str) {
            if (strpos($str, 'single-bonus') > -1) {
                $str = 'single-offer';
            }
            if (strpos($str, 'bonus-template-default') > -1) {
                $str = 'offer-template-default';
            }
        }
    }
    return $classes;
}
add_filter('body_class', 'aces_change_bonus_body_classes', 10, 2);

// ACES Options Page
function aces_options_page() {
    add_menu_page(
        esc_html__('Inställningar Tema', 'aces'),
        esc_html__('Inställningar Tema', 'aces'),
        'manage_options',
        'aces',
        'aces_options_page_html',
        plugins_url('aces/images/menu-icon.png'),
        59
    );
}
add_action('admin_menu', 'aces_options_page');

function aces_options_page_html() {
    if (!current_user_can('manage_options')) {
        return;
    }

    if (isset($_GET['settings-updated'])) {
        add_settings_error('aces_messages', 'aces_message', esc_html__('Settings Saved', 'aces'), 'updated');
    }

    settings_errors('aces_messages');

    $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'casinos_tab';

    $organizations_tab_name = esc_html__('Casinos', 'aces');
    if (get_option('casinos_section_name')) {
        $organizations_tab_name = get_option('casinos_section_name');
    }

    $units_tab_name = esc_html__('Games', 'aces');
    if (get_option('games_section_name')) {
        $units_tab_name = get_option('games_section_name');
    }

    $offers_tab_name = esc_html__('Bonuses', 'aces');
    if (get_option('bonuses_section_name')) {
        $offers_tab_name = get_option('bonuses_section_name');
    }

    ?>
    <div class="wrap">
        <style type="text/css">
            #aces_casinos_tab_titles,
            #aces_casinos_tab_slugs,
            #aces_casinos_tab_rating_titles,
            #aces_casinos_tab_other_settings,
            #aces_games_tab_titles,
            #aces_games_tab_slugs,
            #aces_games_tab_other_settings,
            #aces_bonuses_tab_titles,
            #aces_bonuses_tab_slugs,
            #aces_bonuses_tab_other_settings,
            #aces_geolocation_tab_title,
            #aces_geolocation_tab_api {
                border-top: 1px solid #ccc;
                padding-top: 5px;
            }
            form h2 {
                color: #e74c3c;
            }
        </style>
        <h1 class="wp-heading-inline"><?php echo esc_html(get_admin_page_title()); ?><span class="title-count theme-count"><?php echo esc_html($GLOBALS['aces_version']); ?></span></h1>
        <div style="padding-bottom: 10px;">
            <?php esc_html_e('Tema plugin by', 'Simon Axelsson'); ?> <a href="<?php echo esc_url(__('https://Zlots.com/', 'aces')); ?>" title="<?php esc_attr_e('Zlots.com', 'aces'); ?>" target="_blank"><?php esc_html_e('Zlots.com', 'aces'); ?></a>
        </div>

        <h2 class="nav-tab-wrapper">
            <a href="?page=aces&tab=casinos_tab" class="nav-tab <?php echo $active_tab == 'casinos_tab' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Organizations', 'aces'); ?> (<?php echo esc_html($organizations_tab_name); ?>)</a>
            <a href="?page=aces&tab=games_tab" class="nav-tab <?php echo $active_tab == 'games_tab' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Units', 'aces'); ?> (<?php echo esc_html($units_tab_name); ?>)</a>
            <a href="?page=aces&tab=bonuses_tab" class="nav-tab <?php echo $active_tab == 'bonuses_tab' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Offers', 'aces'); ?> (<?php echo esc_html($offers_tab_name); ?>)</a>
            <a href="?page=aces&tab=geolocation_tab" class="nav-tab <?php echo $active_tab == 'geolocation_tab' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Geolocation', 'aces'); ?></a>
        </h2>

        <form method="post" action="options.php">
            <?php
            submit_button(esc_html__('Save Settings', 'aces'));

            if ($active_tab == 'casinos_tab') {
                settings_fields('aces_casinos_tab');
                do_settings_sections('aces_casinos_tab');
            } else if ($active_tab == 'games_tab') {
                settings_fields('aces_games_tab');
                do_settings_sections('aces_games_tab');
            } else if ($active_tab == 'bonuses_tab') {
                settings_fields('aces_bonuses_tab');
                do_settings_sections('aces_bonuses_tab');
            } else if ($active_tab == 'geolocation_tab') {
                settings_fields('aces_geolocation_tab');
                do_settings_sections('aces_geolocation_tab');
            }

            submit_button(esc_html__('Save Settings', 'aces'));
            ?>
        </form>
    </div>
    <?php
}

// Register custom post type and taxonomies
add_action('init', 'aces_games', 0);

function aces_games() {
    $game_slug = get_option('games_section_slug', 'game');
    $game_name = get_option('games_section_name', 'Games');

    $args = [
        'labels' => [
            'name' => $game_name,
            'add_new' => esc_html__('Add New', 'aces'),
            'edit_item' => esc_html__('Edit Item', 'aces'),
            'add_new_item' => esc_html__('Add New', 'aces'),
            'view_item' => esc_html__('View Item', 'aces'),
        ],
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'menu_icon' => plugins_url('aces/images/icon.png'),
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => ['title', 'editor', 'author', 'comments', 'thumbnail', 'excerpt', 'revisions'],
        'has_archive' => false,
        'rest_base' => 'unit',
        'rewrite' => [
            'slug' => $game_slug,
            'with_front' => false
        ]
    ];

    register_post_type('game', $args);
    aces_register_taxonomies();
}

function aces_register_taxonomies() {
    $games_category_title = get_option('games_category_title', 'Categories');
    $games_vendor_title = get_option('games_vendor_title', 'Vendors');

    $category_labels = [
        'name' => $games_category_title,
        'singular_name' => $games_category_title,
        'search_items' => esc_html__('Find Taxonomy', 'aces'),
        'all_items' => esc_html__('All ', 'aces') . $games_category_title,
        'edit_item' => esc_html__('Edit Taxonomy', 'aces'),
        'view_item' => esc_html__('View Taxonomy', 'aces'),
        'update_item' => esc_html__('Update Taxonomy', 'aces'),
        'add_new_item' => esc_html__('Add New Taxonomy', 'aces'),
        'new_item_name' => esc_html__('Taxonomy', 'aces'),
        'menu_name' => $games_category_title
    ];

    $vendor_labels = [
        'name' => $games_vendor_title,
        'singular_name' => $games_vendor_title,
        'search_items' => esc_html__('Find Taxonomy', 'aces'),
        'all_items' => esc_html__('All ', 'aces') . $games_vendor_title,
        'edit_item' => esc_html__('Edit Taxonomy', 'aces'),
        'view_item' => esc_html__('View Taxonomy', 'aces'),
        'update_item' => esc_html__('Update Taxonomy', 'aces'),
        'add_new_item' => esc_html__('Add New Taxonomy', 'aces'),
        'new_item_name' => esc_html__('Taxonomy', 'aces'),
        'menu_name' => $games_vendor_title
    ];

    $tax_args = [
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'show_tagcloud' => true,
        'show_admin_column' => true,
        'hierarchical' => true,
        'rewrite' => true,
        'query_var' => '',
        '_builtin' => false
    ];

    register_taxonomy('game-category', 'game', array_merge($tax_args, ['labels' => $category_labels]));
    register_taxonomy('vendor', 'game', array_merge($tax_args, ['labels' => $vendor_labels]));
}

// Include meta box fields
require_once get_stylesheet_directory() . '/theme-functions/meta-fields.php';

// Register custom post type for casinos
function aces_register_casino_post_type() {
    $casino_slug = 'casino';
    if (get_option('casinos_section_slug')) {
        $casino_slug = get_option('casinos_section_slug', 'casino');
    }

    $casino_name = esc_html__('Casinos', 'aces');
    if (get_option('casinos_section_name')) {
        $casino_name = get_option('casinos_section_name', 'Casinos');
    }

    $args = [
        'labels' => [
            'name' => $casino_name,
            'add_new' => esc_html__('Add New', 'aces'),
            'edit_item' => esc_html__('Edit Item', 'aces'),
            'add_new_item' => esc_html__('Add New', 'aces'),
            'view_item' => esc_html__('View Item', 'aces'),
        ],
        'singular_label' => __('casino'),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'menu_icon' => plugins_url('aces/images/icon.png'),
        '_builtin' => false,
        '_edit_link' => 'post.php?post=%d',
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => ['title', 'editor', 'author', 'comments', 'thumbnail', 'excerpt', 'revisions'],
        'has_archive' => false,
        'rest_base' => 'organization',
        'rewrite' => [
            'slug' => $casino_slug,
            'with_front' => false
        ]
    ];

    register_post_type('casino', $args);

    // Register taxonomies
    $taxonomies = [
        'casino-category' => esc_html__('Categories', 'aces'),
        'software' => esc_html__('Software', 'aces'),
        'deposit-method' => esc_html__('Deposit Methods', 'aces'),
        'withdrawal-method' => esc_html__('Withdrawal Methods', 'aces'),
        'location' => esc_html__('Location', 'aces')
    ];

    foreach ($taxonomies as $taxonomy => $title) {
        $labels = [
            'name' => $title,
            'singular_name' => $title,
            'search_items' => esc_html__('Find Taxonomy', 'aces'),
            'all_items' => esc_html__('All ', 'aces') . $title,
            'parent_item' => esc_html__('Parent Taxonomy', 'aces'),
            'parent_item_colon' => esc_html__('Parent Taxonomy:', 'aces'),
            'edit_item' => esc_html__('Edit Taxonomy', 'aces'),
            'view_item' => esc_html__('View Taxonomy', 'aces'),
            'update_item' => esc_html__('Update Taxonomy', 'aces'),
            'add_new_item' => esc_html__('Add New Taxonomy', 'aces'),
            'new_item_name' => esc_html__('Taxonomy', 'aces'),
            'menu_name' => $title
        ];

        $args = [
            'labels' => $labels,
            'public' => true,
            'show_in_nav_menus' => true,
            'show_ui' => true,
            'show_in_rest' => true,
            'show_tagcloud' => true,
            'show_admin_column' => true,
            'hierarchical' => true,
            'rewrite' => true,
            'query_var' => '',
            'capabilities' => [],
            '_builtin' => false
        ];

        register_taxonomy($taxonomy, 'casino', $args);
    }
}
add_action('init', 'aces_register_casino_post_type');


/*  Bonuses - Post Type Start */

add_action('init', 'aces_bonuses', 0 );

function aces_bonuses() {

	$bonus_slug = 'bonus';
	if ( get_option( 'bonuses_section_slug') ) {
		$bonus_slug = get_option( 'bonuses_section_slug', 'bonus' );
	}

	$bonus_name = esc_html__('Bonuses', 'aces');
	if ( get_option( 'bonuses_section_name') ) {
		$bonus_name = get_option( 'bonuses_section_name', 'Bonuses' );
	}

	$args = array(
        'labels' => array(
			'name' => $bonus_name,
			'add_new' => esc_html__('Add New', 'aces'),
            'edit_item' => esc_html__('Edit Item', 'aces'),
            'add_new_item' => esc_html__('Add New', 'aces'),
            'view_item' => esc_html__('View Item', 'aces'),
        ),
        'singular_label' => __('bonus'),
        'public' => true,
		'publicly_queryable' => true,
        'show_ui' => true,
		'show_in_rest' => true,
		'menu_icon' => plugins_url( 'aces/images/icon.png' ),
        '_builtin' => false,
        '_edit_link' => 'post.php?post=%d',
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => array(
        	'title',
        	'editor',
        	'author',
        	'comments',
        	'thumbnail',
        	'excerpt',
        	'revisions'
        ),
		'has_archive' => false,
		'rest_base' => 'offer',
		'rewrite' => array(
			'slug' => $bonus_slug,
			'with_front' => false
		)
    );

register_post_type( 'bonus' , $args );

/* --- Category: Custom Taxonomy --- */

$bonuses_category_title = esc_html__('Categories', 'aces');
if ( get_option( 'bonuses_category_title') ) {
	$bonuses_category_title = get_option( 'bonuses_category_title', 'Categories' );
}

$labels = array(
	'name' => $bonuses_category_title,
	'singular_name' => $bonuses_category_title,
	'search_items' => esc_html__('Find Taxonomy', 'aces'),
	'all_items' => esc_html__('All ', 'aces') . $bonuses_category_title,
	'parent_item' => esc_html__('Parent Taxonomy', 'aces'),
	'parent_item_colon' => esc_html__('Parent Taxonomy:', 'aces'),
	'edit_item' => esc_html__('Edit Taxonomy', 'aces'),
	'view_item' => esc_html__('View Taxonomy', 'aces'),
	'update_item' => esc_html__('Update Taxonomy', 'aces'),
	'add_new_item' => esc_html__('Add New Taxonomy', 'aces'),
	'new_item_name' => esc_html__('Taxonomy', 'aces'),
	'menu_name' => $bonuses_category_title
);  

$args = array(
	'labels' => $labels,
	'public' => true,
	'show_in_nav_menus' => true,
	'show_ui' => true,
	'show_in_rest' => true,
	'show_tagcloud' => true,
	'show_admin_column' => true,
	'hierarchical' => true,
	'update_count_callback' => '',
	'rewrite' => true,
	'query_var' => '',
	'capabilities' => array(),
	'_builtin' => false
);

register_taxonomy('bonus-category', 'bonus', $args);

}

/* --- Add custom slug for taxonomy 'bonus-category' --- */

if ( get_option( 'bonus_category_slug') ) {

	function aces_change_bonus_category_slug( $taxonomy, $object_type, $args ) {

		$bonus_category_slug = 'bonus-category';

		if ( get_option( 'bonus_category_slug') ) {
			$bonus_category_slug = get_option( 'bonus_category_slug', 'bonus-category' );
		}

	    if( 'bonus-category' == $taxonomy ) {
	        remove_action( current_action(), __FUNCTION__ );
	        $args['rewrite'] = array( 'slug' => $bonus_category_slug );
	        register_taxonomy( $taxonomy, $object_type, $args );
	    }

	}
	add_action( 'registered_taxonomy', 'aces_change_bonus_category_slug', 10, 3 );

}

/*  Bonuses - Post Type End */

/*  Bonuses - Short Description Start */

add_action( 'admin_init', 'aces_offers_short_desc_fields' );

function aces_offers_short_desc_fields() {
    add_meta_box( 'aces_offers_short_desc_meta_box',
        esc_html__( 'Short description', 'aces' ),
        'aces_offers_short_desc_display_meta_box',
        'bonus', 'normal', 'high'
    );
}

function aces_offers_short_desc_display_meta_box( $bonus ) {

	wp_nonce_field( 'aces_offers_short_desc_box', 'aces_offers_short_desc_nonce' );
	$bonus_short_desc = get_post_meta( $bonus->ID, 'bonus_short_desc', false );
	
	$editor_args = array(
	    'tinymce'       => array(
	        'toolbar1'  => 'bold,italic,underline,bullist,numlist,link,unlink,undo,redo'
	    ),
	    'quicktags'     => array(
	    	'buttons'   => 'em,strong,link,ul,li,ol,close'
	    ),
	    'media_buttons' => false,
	    'textarea_rows' => 6
	);
?>

<div class="components-base-control bonus_short_desc">
	<div class="components-base-control__field">
		<?php
		if ( empty($bonus_short_desc[0]) ) {
			$bonus_short_desc[0] = '';
		}
		wp_editor( $bonus_short_desc[0], 'bonus_short_desc', $editor_args );
		?>
	</div>
</div>

    <?php
}

add_action( 'save_post', 'aces_offers_short_desc_save_fields', 10, 2 );

function aces_offers_short_desc_save_fields( $post_id ) {

		if ( ! isset( $_POST['aces_offers_short_desc_nonce'] ) ) {
            return $post_id;
        }

        $nonce = $_POST['aces_offers_short_desc_nonce'];

        if ( ! wp_verify_nonce( $nonce, 'aces_offers_short_desc_box' ) ) {
            return $post_id;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }

        if ( 'bonus' == $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            }
        }

		$bonus_short_desc = $_POST['bonus_short_desc'];
        update_post_meta( $post_id, 'bonus_short_desc', $bonus_short_desc );
}

/*  Bonuses - Short Description End */

/*  Bonuses - Detailed T&Cs Start */

add_action( 'admin_init', 'aces_offers_detailed_tc_fields' );

function aces_offers_detailed_tc_fields() {
    add_meta_box( 'aces_offers_detailed_tc_meta_box',
        esc_html__( 'Detailed T&Cs', 'aces' ),
        'aces_offers_detailed_tc_display_meta_box',
        'bonus', 'normal', 'high'
    );
}

function aces_offers_detailed_tc_display_meta_box( $bonus ) {

	wp_nonce_field( 'aces_offers_detailed_tc_box', 'aces_offers_detailed_tc_nonce' );

	$custom = get_post_custom($bonus->ID);
	$offer_detailed_tc = get_post_meta( $bonus->ID, 'offer_detailed_tc', false );
	$aces_offer_popup_hide = isset($custom["aces_offer_popup_hide"][0]) ? stripslashes($custom["aces_offer_popup_hide"][0]) : '';
	$aces_offer_popup_title = get_post_meta( $bonus->ID, 'aces_offer_popup_title', true );
	
	$editor_args = array(
	    'tinymce'       => array(
	        'toolbar1'  => 'bold,italic,underline,bullist,numlist,link,unlink,undo,redo'
	    ),
	    'quicktags'     => array(
	    	'buttons'   => 'em,strong,link,ul,li,ol,close'
	    ),
	    'media_buttons' => false,
	    'textarea_rows' => 6
	);
?>

<div class="components-base-control offer_detailed_tc">
	<div class="components-base-control__field" style="padding-bottom: 30px;">
		<?php
		if ( empty($offer_detailed_tc[0]) ) {
			$offer_detailed_tc[0] = '';
		}
		wp_editor( $offer_detailed_tc[0], 'offer_detailed_tc', $editor_args );
		?>
	</div>
</div>

<div class="components-base-control aces_offer_popup_hide" style="padding: 5px 0 10px 0;">
	<div class="components-base-control__field">
		<input type="checkbox" name="aces_offer_popup_hide" <?php if( $aces_offer_popup_hide == true ) { ?>checked="checked"<?php } ?> /> <?php esc_html_e( 'Hide the Detailed T&Cs in a popup box', 'aces' )?>
	</div>
</div>

<div class="components-base-control aces_offer_popup_title">
	<div class="components-base-control__field">
		<label class="components-base-control__label" for="aces_offer_popup_title-0"><?php esc_html_e( 'Custom link title for the', 'aces' ); ?> <strong><?php esc_html_e( 'popup box', 'aces' ); ?></strong></label>
		<input type="text" name="aces_offer_popup_title" id="aces_offer_popup_title-0" value="<?php echo esc_attr($aces_offer_popup_title); ?>" style="display: block; margin-top: 5px;" />
	</div>
</div>

    <?php
}

add_action( 'save_post', 'aces_offers_detailed_tc_save_fields', 10, 2 );

function aces_offers_detailed_tc_save_fields( $post_id ) {

		if ( ! isset( $_POST['aces_offers_detailed_tc_nonce'] ) ) {
            return $post_id;
        }

        $nonce = $_POST['aces_offers_detailed_tc_nonce'];

        if ( ! wp_verify_nonce( $nonce, 'aces_offers_detailed_tc_box' ) ) {
            return $post_id;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }

        if ( 'bonus' == $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            }
        }

		$offer_detailed_tc = $_POST['offer_detailed_tc'];
        update_post_meta( $post_id, 'offer_detailed_tc', $offer_detailed_tc );

        $aces_offer_popup_hide = sanitize_text_field( $_POST['aces_offer_popup_hide'] );
        update_post_meta( $post_id, 'aces_offer_popup_hide', $aces_offer_popup_hide );

        $aces_offer_popup_title = sanitize_text_field( $_POST['aces_offer_popup_title'] );
        update_post_meta( $post_id, 'aces_offer_popup_title', $aces_offer_popup_title );
}

/*  Bonuses - Detailed T&Cs End */

/*  Bonuses - Additional Fields Start */

add_action( 'admin_init', 'aces_bonuses_fields' );

function aces_bonuses_fields() {
    add_meta_box( 'aces_bonuses_meta_box',
        esc_html__( 'Additional information', 'aces' ),
        'aces_bonuses_display_meta_box',
        'bonus', 'side', 'high'
    );
}

function aces_bonuses_display_meta_box( $bonus ) {
	wp_nonce_field( 'aces_bonuses_box', 'aces_bonuses_nonce' );
	$custom = get_post_custom($bonus->ID);
	$bonus_external_link = get_post_meta( $bonus->ID, 'bonus_external_link', true );
	$bonus_button_title = get_post_meta( $bonus->ID, 'bonus_button_title', true );
	$bonus_button_notice = get_post_meta( $bonus->ID, 'bonus_button_notice', false );
	$bonus_code = get_post_meta( $bonus->ID, 'bonus_code', true );
	$bonus_valid_date = get_post_meta( $bonus->ID, 'bonus_valid_date', true );
	$bonus_dark_style = isset($custom["bonus_dark_style"][0]) ? stripslashes($custom["bonus_dark_style"][0]) : '';
	$offers_disable_more_block = isset($custom["offers_disable_more_block"][0]) ? stripslashes($custom["offers_disable_more_block"][0]) : '';

	$editor_args = array(
	    'tinymce'       => array(
	        'toolbar1'  => 'bold,italic,underline,link,unlink,undo,redo'
	    ),
	    'quicktags'     => array(
	    	'buttons'   => 'em,strong,link,close'
	    ),
	    'media_buttons' => false,
	    'textarea_rows' => 8
	);
?>

<div class="components-base-control bonus_external_link">
	<div class="components-base-control__field">
		<label class="components-base-control__label" for="bonus_external_link-0"><?php esc_html_e( 'External URL for the', 'aces' )?> <strong><?php esc_html_e( 'Get Bonus', 'aces' ); ?></strong> <?php esc_html_e( 'button', 'aces' ); ?></label>
		<input type="url" name="bonus_external_link" id="bonus_external_link-0" value="<?php echo esc_url($bonus_external_link); ?>" style="display: block; margin-bottom: 10px;" />
	</div>
</div>

<div class="components-base-control bonus_button_title">
	<div class="components-base-control__field">
		<label class="components-base-control__label" for="bonus_button_title-0"><?php esc_html_e( 'Custom title for the', 'aces' )?> <strong><?php esc_html_e( 'Get Bonus', 'aces' ); ?></strong> <?php esc_html_e( 'button', 'aces' ); ?></label>
		<input type="text" name="bonus_button_title" id="bonus_button_title-0" value="<?php echo esc_attr($bonus_button_title); ?>" style="display: block; margin-bottom: 10px;" />
	</div>
</div>

<div class="components-base-control bonus_code">
	<div class="components-base-control__field">
		<label class="components-base-control__label" for="bonus_code-0"><?php esc_html_e( 'Bonus Code:', 'aces' )?></label>
		<input type="text" name="bonus_code" id="bonus_code-0" value="<?php echo esc_attr($bonus_code); ?>" style="display: block; margin-bottom: 10px;" />
	</div>
</div>

<div class="components-base-control bonus_valid_date">
	<div class="components-base-control__field">
		<label class="components-base-control__label" for="bonus_valid_date-0"><?php esc_html_e( 'Valid until the date:', 'aces' )?></label>
		<input type="date" name="bonus_valid_date" id="bonus_valid_date-0" value="<?php echo esc_attr($bonus_valid_date); ?>" style="display: block; margin-bottom: 10px;" />
	</div>
</div>

<div class="components-base-control bonus_dark_style" style="padding-bottom:20px;">
	<div class="components-base-control__field">
		<input type="checkbox" name="bonus_dark_style" <?php if( $bonus_dark_style == true ) { ?>checked="checked"<?php } ?> /> <?php esc_html_e( 'Dark Style', 'aces' )?>
	</div>
</div>

<div class="components-base-control bonus_button_notice">
	<div class="components-base-control__field">
		<label class="components-base-control__label" for="bonus_button_notice-0"><?php esc_html_e( 'Notification under the button', 'aces' ); ?></label>
		<?php
		if ( empty($bonus_button_notice[0]) ) {
			$bonus_button_notice[0] = '';
		}
		wp_editor( $bonus_button_notice[0], 'bonus_button_notice', $editor_args );
		?>
	</div>
</div>

<?php
$offers_section_name = esc_html__( 'Bonuses', 'aces' );
if ( get_option( 'bonuses_section_name') ) {
	$offers_section_name = esc_html__( get_option( 'bonuses_section_name' ) );
}
?>

<div class="components-base-control offers_disable_more_block" style="padding-top:15px;">
	<div class="components-base-control__field">
		<input type="checkbox" name="offers_disable_more_block" <?php if( $offers_disable_more_block == true ) { ?>checked="checked"<?php } ?> /> <?php esc_html_e( 'Disable More', 'aces' )?> <?php esc_html_e( $offers_section_name );?> <?php esc_html_e( 'Block', 'aces' )?>
	</div>
</div>

    <?php
}

add_action( 'save_post', 'aces_bonuses_save_fields', 10, 2 );

function aces_bonuses_save_fields( $post_id ) {
		if ( ! isset( $_POST['aces_bonuses_nonce'] ) ) {
            return $post_id;
        }

        $nonce = $_POST['aces_bonuses_nonce'];

        if ( ! wp_verify_nonce( $nonce, 'aces_bonuses_box' ) ) {
            return $post_id;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }

        if ( 'bonus' == $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            }
        }

		$bonus_external_link = esc_url( $_POST['bonus_external_link'] );
        update_post_meta( $post_id, 'bonus_external_link', $bonus_external_link );

		$bonus_button_title = sanitize_text_field( $_POST['bonus_button_title'] );
        update_post_meta( $post_id, 'bonus_button_title', $bonus_button_title );

        $bonus_button_notice = $_POST['bonus_button_notice'];
        update_post_meta( $post_id, 'bonus_button_notice', $bonus_button_notice );

        $bonus_code = sanitize_text_field( $_POST['bonus_code'] );
        update_post_meta( $post_id, 'bonus_code', $bonus_code );

        $bonus_valid_date = sanitize_text_field( $_POST['bonus_valid_date'] );
        update_post_meta( $post_id, 'bonus_valid_date', $bonus_valid_date );

        $bonus_dark_style = sanitize_text_field( $_POST['bonus_dark_style'] );
        update_post_meta( $post_id, 'bonus_dark_style', $bonus_dark_style );

        $offers_disable_more_block = sanitize_text_field( $_POST['offers_disable_more_block'] );
        update_post_meta( $post_id, 'offers_disable_more_block', $offers_disable_more_block );
}

/*  Bonuses - Additional Fields End */

/*  Relationship of the Bonus and Casino Start  */

add_action( 'admin_init', 'aces_bonuses_casinos_list' );

function aces_bonuses_casinos_list() {

	$casinos_section_name = esc_html__( 'Casinos', 'aces' );
	if ( get_option( 'casinos_section_name') ) {
		$casinos_section_name = esc_html__( get_option( 'casinos_section_name' ) );
	}

    add_meta_box( 'aces_bonuses_casinos_list_meta_box',
        $casinos_section_name,
        'aces_bonuses_display_casinos_list_meta_box',
        'bonus', 'side', 'high'
    );
}

function aces_bonuses_display_casinos_list_meta_box( $bonus ) {
    wp_nonce_field( basename(__FILE__), 'bonus_custom_nonce' );

    $postmeta = get_post_meta( $bonus->ID, 'bonus_parent_casino', true );
    $casinos = get_posts(array( 'post_type'=>'casino', 'posts_per_page'=>-1, 'orderby'=>'post_title', 'order'=>'ASC' ));

    if( $casinos ) {
    	$elements = [];
    	foreach( $casinos as $casino ) {
    		$elements[$casino->ID] = $casino->post_title;
        }
    ?>
	<div style="max-height:200px; overflow-y:auto;">
		<ul>
	    <?php foreach ( $elements as $id => $element) {

	        if ( is_array( $postmeta ) && in_array( $id, $postmeta ) ) {
	            $checked = 'checked=checked';
	        } else {
	            $checked = null;
	        }

	        ?>

	        <li>
				<label>
	            <input type="checkbox" name="bonus_casino_item[]" value="<?php esc_attr_e($id);?>" <?php esc_attr_e($checked); ?>>
	            <?php esc_html_e($element); ?>
	        	</label>
			</li>

	    <?php } ?>
		</ul>
	</div>
    <?php
	} else {
		esc_html_e( 'No items', 'aces' );
	}
}

add_action( 'save_post', 'aces_bonuses_casinos_save_fields', 10, 2 );

function aces_bonuses_casinos_save_fields( $post_id ) {
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'bonus_custom_nonce' ] ) && wp_verify_nonce( $_POST[ 'bonus_custom_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    // If the checkbox was not empty, save it as array in post meta
    if ( ! empty( $_POST['bonus_casino_item'] ) ) {
        update_post_meta( $post_id, 'bonus_parent_casino', $_POST['bonus_casino_item'] );

    // Otherwise just delete it if its blank value.
    } else {
        delete_post_meta( $post_id, 'bonus_parent_casino' );
    }

};

/*  Relationship of the Bonus and Casino End  */
