<?php

/* --- Add Meta Boxes --- */

add_action('admin_init', 'aces_add_meta_boxes');

function aces_add_meta_boxes() {
    add_meta_box('aces_units_short_desc_meta_box', esc_html__('Short description', 'aces'), 'aces_units_short_desc_display_meta_box', 'game', 'normal', 'high');
    add_meta_box('aces_units_detailed_tc_meta_box', esc_html__('Detailed T&Cs', 'aces'), 'aces_units_detailed_tc_display_meta_box', 'game', 'normal', 'high');
    add_meta_box('aces_games_ratings_meta_box', esc_html__('Item Rating', 'aces'), 'aces_games_ratings_display_meta_box', 'game', 'normal', 'high');
    add_meta_box('aces_games_pros_cons_meta_box', esc_html__('Pros/Cons of the Game', 'aces'), 'aces_games_pros_cons_display_meta_box', 'game', 'normal', 'core');
    add_meta_box('aces_games_meta_box', esc_html__('Additional information', 'aces'), 'aces_games_display_meta_box', 'game', 'side', 'high');
    add_meta_box('aces_games_casinos_list_meta_box', esc_html__('Casinos', 'aces'), 'aces_games_display_casinos_list_meta_box', 'game', 'side', 'high');
    add_meta_box('aces_game_background_image_box', esc_html__('Background Image', 'aces'), 'aces_game_background_image_block_show', 'game', 'normal', 'core');
}

/* --- Display and Save Meta Box Fields --- */

function aces_units_short_desc_display_meta_box($game) {
    wp_nonce_field('aces_units_short_desc_box', 'aces_units_short_desc_nonce');
    $game_short_desc = get_post_meta($game->ID, 'game_short_desc', true);
    $editor_args = array(
        'tinymce' => array('toolbar1' => 'bold,italic,underline,bullist,numlist,link,unlink,undo,redo'),
        'quicktags' => array('buttons' => 'em,strong,link,ul,li,ol,close'),
        'media_buttons' => false,
        'textarea_rows' => 6
    );
    echo '<div class="components-base-control game_short_desc"><div class="components-base-control__field">';
    wp_editor($game_short_desc, 'game_short_desc', $editor_args);
    echo '</div></div>';
}

function aces_units_detailed_tc_display_meta_box($game) {
    wp_nonce_field('aces_units_detailed_tc_box', 'aces_units_detailed_tc_nonce');
    $unit_detailed_tc = get_post_meta($game->ID, 'unit_detailed_tc', true);
    $aces_unit_popup_hide = get_post_meta($game->ID, 'aces_unit_popup_hide', true);
    $aces_unit_popup_title = get_post_meta($game->ID, 'aces_unit_popup_title', true);
    $editor_args = array(
        'tinymce' => array('toolbar1' => 'bold,italic,underline,bullist,numlist,link,unlink,undo,redo'),
        'quicktags' => array('buttons' => 'em,strong,link,ul,li,ol,close'),
        'media_buttons' => false,
        'textarea_rows' => 6
    );
    echo '<div class="components-base-control unit_detailed_tc"><div class="components-base-control__field" style="padding-bottom: 30px;">';
    wp_editor($unit_detailed_tc, 'unit_detailed_tc', $editor_args);
    echo '</div></div><div class="components-base-control aces_unit_popup_hide" style="padding: 5px 0 10px 0;"><div class="components-base-control__field">';
    echo '<input type="checkbox" name="aces_unit_popup_hide" ' . checked($aces_unit_popup_hide, true, false) . ' /> ' . esc_html__('Hide the Detailed T&Cs in a popup box', 'aces');
    echo '</div></div><div class="components-base-control aces_unit_popup_title"><div class="components-base-control__field">';
    echo '<label class="components-base-control__label" for="aces_unit_popup_title-0">' . esc_html__('Custom link title for the', 'aces') . ' <strong>' . esc_html__('popup box', 'aces') . '</strong></label>';
    echo '<input type="text" name="aces_unit_popup_title" id="aces_unit_popup_title-0" value="' . esc_attr($aces_unit_popup_title) . '" style="display: block; margin-top: 5px;" />';
    echo '</div></div>';
}

function aces_games_ratings_display_meta_box($game) {
    wp_nonce_field('aces_games_ratings_box', 'aces_games_ratings_nonce');
    $game_rating_one = get_post_meta($game->ID, 'game_rating_one', true);
    $game_rating_stars_number_value = get_option('aces_game_rating_stars_number', '5');
    echo '<style type="text/css">.aces-single-rating-box {padding-bottom: 10px;}.aces-single-rating-box label {padding-right: 12px;}.aces-single-rating-box label:last-child {padding-right: 0;}.aces-single-rating-box label input[type=radio] {margin-right: 0 !important;}</style>';
    echo '<div class="components-base-control game_rating_one"><div class="components-base-control__field"><label class="components-base-control__label">' . esc_html__('Rating', 'aces') . '</label><div class="aces-single-rating-box">';
    for ($i = 1; $i <= $game_rating_stars_number_value; $i++) {
        echo '<label><input type="radio" name="game_rating_one" value="' . esc_attr($i) . '" ' . checked($game_rating_one, $i, false) . '>' . esc_attr($i) . '</label>';
    }
    echo '</div></div></div>';
}

function aces_games_pros_cons_display_meta_box($game) {
    wp_nonce_field('aces_games_pros_cons_box', 'aces_games_pros_cons_nonce');
    $game_pros_desc = get_post_meta($game->ID, 'game_pros_desc', true);
    $game_cons_desc = get_post_meta($game->ID, 'game_cons_desc', true);
    $allowed_html = array('a' => array('href' => true, 'title' => true, 'target' => true, 'rel' => true), 'br' => array(), 'em' => array(), 'strong' => array(), 'span' => array(), 'p' => array(), 'ul' => array(), 'ol' => array(), 'li' => array());
    echo '<div class="components-base-control game_pros_desc"><div class="components-base-control__field"><label class="components-base-control__label" for="game_pros_desc-0">' . esc_html(get_option('casinos_pros_title', 'Pros')) . '</label>';
    echo '<textarea class="components-textarea-control__input" id="game_pros_desc-0" rows="8" name="game_pros_desc" style="display: block; margin-bottom: 10px; width:100%;">' . wp_kses($game_pros_desc, $allowed_html) . '</textarea></div></div>';
    echo '<div class="components-base-control game_cons_desc"><div class="components-base-control__field"><label class="components-base-control__label" for="game_cons_desc-0">' . esc_html(get_option('casinos_cons_title', 'Cons')) . '</label>';
    echo '<textarea class="components-textarea-control__input" id="game_cons_desc-0" rows="8" name="game_cons_desc" style="display: block; margin-bottom: 10px; width:100%;">' . wp_kses($game_cons_desc, $allowed_html) . '</textarea></div></div>';
}

function aces_games_display_meta_box($game) {
    wp_nonce_field('aces_games_box', 'aces_games_nonce');
    $game_external_link = get_post_meta($game->ID, 'game_external_link', true);
    $game_button_title = get_post_meta($game->ID, 'game_button_title', true);
    $game_permalink_button_title = get_post_meta($game->ID, 'game_permalink_button_title', true);
    $game_button_notice = get_post_meta($game->ID, 'game_button_notice', true);
    $units_disable_more_block = get_post_meta($game->ID, 'units_disable_more_block', true);
    $editor_args = array('tinymce' => array('toolbar1' => 'bold,italic,underline,link,unlink,undo,redo'), 'quicktags' => array('buttons' => 'em,strong,link,close'), 'media_buttons' => false, 'textarea_rows' => 8);
    echo '<div class="components-base-control game_external_link"><div class="components-base-control__field"><label class="components-base-control__label" for="game_external_link-0">' . esc_html__('External URL for the', 'aces') . ' <strong>' . esc_html__('Play Now', 'aces') . '</strong> ' . esc_html__('button', 'aces') . '</label>';
    echo '<input type="url" name="game_external_link" id="game_external_link-0" value="' . esc_url($game_external_link) . '" style="display: block; margin-bottom: 10px;" /></div></div>';
    echo '<div class="components-base-control game_button_title"><div class="components-base-control__field"><label class="components-base-control__label" for="game_button_title-0">' . esc_html__('Custom title for the', 'aces') . ' <strong>' . esc_html__('Play Now', 'aces') . '</strong> ' . esc_html__('button', 'aces') . '</label>';
    echo '<input type="text" name="game_button_title" id="game_button_title-0" value="' . esc_attr($game_button_title) . '" style="display: block; margin-bottom: 10px;" /></div></div>';
    echo '<div class="components-base-control game_permalink_button_title"><div class="components-base-control__field"><label class="components-base-control__label" for="game_permalink_button_title-0">' . esc_html__('Custom title for the', 'aces') . ' <strong>' . esc_html__('Read Review', 'aces') . '</strong> ' . esc_html__('button', 'aces') . '</label>';
    echo '<input type="text" name="game_permalink_button_title" id="game_permalink_button_title-0" value="' . esc_attr($game_permalink_button_title) . '" style="display: block; margin-bottom: 10px;" /></div></div>';
    echo '<div class="components-base-control game_button_notice"><div class="components-base-control__field"><label class="components-base-control__label" for="game_button_notice-0">' . esc_html__('Notification under the button', 'aces') . '</label>';
    wp_editor($game_button_notice, 'game_button_notice', $editor_args);
    echo '</div></div><div class="components-base-control units_disable_more_block" style="padding-top:15px;"><div class="components-base-control__field">';
    echo '<input type="checkbox" name="units_disable_more_block" ' . checked($units_disable_more_block, true, false) . ' /> ' . esc_html__('Disable More', 'aces') . ' ' . esc_html(get_option('games_section_name', 'Games')) . ' ' . esc_html__('Block', 'aces') . '</div></div>';
}

function aces_games_display_casinos_list_meta_box($game) {
    wp_nonce_field(basename(__FILE__), 'game_custom_nonce');
    $postmeta = get_post_meta($game->ID, 'parent_casino', true);
    $casinos = get_posts(array('post_type' => 'casino', 'posts_per_page' => -1, 'orderby' => 'post_title', 'order' => 'ASC'));
    if ($casinos) {
        echo '<div style="max-height:200px; overflow-y:auto;"><ul>';
        foreach ($casinos as $casino) {
            $checked = is_array($postmeta) && in_array($casino->ID, $postmeta) ? 'checked=checked' : null;
            echo '<li><label><input type="checkbox" name="casino_item[]" value="' . esc_attr($casino->ID) . '" ' . esc_attr($checked) . '> ' . esc_html($casino->post_title) . '</label></li>';
        }
        echo '</ul></div>';
    } else {
        esc_html_e('No items', 'aces');
    }
}

function aces_game_background_image_block_show($game) {
    wp_nonce_field('aces_game_background_box', 'aces_game_background_nonce');
    $aces_single_game_background_image = get_post_meta($game->ID, 'aces_single_game_background_image', true);
    echo aces_background_image_uploader('aces_single_game_background_image', $aces_single_game_background_image);
}

/* --- Save Meta Box Fields --- */

function aces_save_meta_box($post_id, $nonce_name, $nonce_action, $post_type, $fields) {
    if (!isset($_POST[$nonce_name]) || !wp_verify_nonce($_POST[$nonce_name], $nonce_action) || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || ($post_type == $_POST['post_type'] && !current_user_can('edit_page', $post_id))) return $post_id;

    foreach ($fields as $field) {
        $value = isset($_POST[$field]) ? sanitize_text_field($_POST[$field]) : '';
        update_post_meta($post_id, $value, $field);
    }
}

function aces_units_short_desc_save_fields($post_id) {
    aces_save_meta_box($post_id, 'aces_units_short_desc_nonce', 'aces_units_short_desc_box', 'game', array('game_short_desc'));
}

function aces_units_detailed_tc_save_fields($post_id) {
    aces_save_meta_box($post_id, 'aces_units_detailed_tc_nonce', 'aces_units_detailed_tc_box', 'game', array('unit_detailed_tc', 'aces_unit_popup_hide', 'aces_unit_popup_title'));
}

function aces_games_ratings_save_fields($post_id) {
    aces_save_meta_box($post_id, 'aces_games_ratings_nonce', 'aces_games_ratings_box', 'game', array('game_rating_one'));
}

function aces_games_pros_cons_save_fields($post_id) {
    aces_save_meta_box($post_id, 'aces_games_pros_cons_nonce', 'aces_games_pros_cons_box', 'game', array('game_pros_desc', 'game_cons_desc'));
}

function aces_games_save_fields($post_id) {
    aces_save_meta_box($post_id, 'aces_games_nonce', 'aces_games_box', 'game', array('game_external_link', 'game_button_title', 'game_permalink_button_title', 'game_button_notice', 'units_disable_more_block'));
}

function aces_games_casinos_save_fields($post_id) {
    if (!isset($_POST['game_custom_nonce']) || !wp_verify_nonce($_POST['game_custom_nonce'], basename(__FILE__)) || wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) return;
    $casino_items = isset($_POST['casino_item']) ? $_POST['casino_item'] : array();
    update_post_meta($post_id, 'parent_casino', $casino_items);
}

function aces_game_background_image_block_save($post_id) {
    aces_save_meta_box($post_id, 'aces_game_background_nonce', 'aces_game_background_box', 'game', array('aces_single_game_background_image'));
}

add_action('save_post', 'aces_units_short_desc_save_fields', 10, 2);
add_action('save_post', 'aces_units_detailed_tc_save_fields', 10, 2);
add_action('save_post', 'aces_games_ratings_save_fields', 10, 2);
add_action('save_post', 'aces_games_pros_cons_save_fields', 10, 2);
add_action('save_post', 'aces_games_save_fields', 10, 2);
add_action('save_post', 'aces_games_casinos_save_fields', 10, 2);
add_action('save_post', 'aces_game_background_image_block_save', 10, 2);
// END bonuses ACES

// Recommended Casinos
add_action( 'admin_init', 'zlots_casinos_recommended_fields' );
function zlots_casinos_recommended_fields() {
    add_meta_box( 'zlots_casinos_recommended_meta_box',
        esc_html__( 'Is Recommended', 'zlots' ),
        'zlots_casinos_recommended_display_meta_box',
        'casino', 'normal', 'high'
    );
}

function zlots_casinos_recommended_display_meta_box( $casino ) {
    wp_nonce_field( 'zlots_casinos_recommended_box', 'zlots_casinos_recommended_nonce' );
    $is_casino_recommended = get_post_meta( $casino->ID, 'zlots_is_recommended_casinos', true );
    ?>
    <div class="components-base-control">
        <div class="components-base-control__field">
            <label class="components-base-control__label">
                <?php esc_html_e( 'Show in recommended?', 'zlots' ); ?>
            </label>
            <div class="aces-single-rating-box">
                <input type="checkbox" name="zlotz_is_recommended_casinos" <?php echo $is_casino_recommended ? 'checked="checked"' : '' ?>>
            </div>
        </div>
    </div>
    <?php
}

add_action( 'save_post', 'zlots_casinos_recommended_save_fields', 10, 2 );
function zlots_casinos_recommended_save_fields( $post_id ) {
    $nonce = $_POST['zlots_casinos_recommended_nonce'] ?? null;

    if ( ! $nonce || ! wp_verify_nonce( $nonce, 'zlots_casinos_recommended_box' ) ) {
        return $post_id;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }

    if ( 'casino' == $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return $post_id;
        }
    }

    $is_recommended_casinos = sanitize_text_field( $_POST['zlotz_is_recommended_casinos'] );
    update_post_meta( $post_id, 'zlots_is_recommended_casinos', $is_recommended_casinos );
}
// !END Recommended Casinos

// Slots Tab
add_action( 'admin_init', 'zlots_slots_tab_fields' );
function zlots_slots_tab_fields() {
    add_meta_box( 'zlots_slots_tab_meta_box',
        esc_html__( 'Display in Tab', 'zlots' ),
        'zlots_slots_tab_display_meta_box',
        'game', 'side', 'high'
    );
}

function zlots_slots_tab_display_meta_box( $slot ) {
    wp_nonce_field( 'zlots_slots_tab_box', 'zlots_slots_tab_nonce' );
    $slots_show_in_tab = get_post_meta( $slot->ID, 'zlots_slots_show_in_tab', true );

    $select = [
        'new'      => 'New Releases',
        'upcoming' => 'Upcoming Slots',
        'month'    => 'Slots of the month'
    ];
    ?>
    <div class="components-base-control">
        <div class="components-base-control__field">
            <label class="components-base-control__label" for="show-in-tab">
                <?php esc_html_e( 'Display in Tab?', 'zlots' ); ?>
            </label>
            <div>
                <select name="show-in-tab" id="show-in-tab">
                    <option value="">Select a Tab</option>
                    <?php foreach ( $select as $key => $name ): ?>
                        <option value="<?php echo esc_attr($key); ?>" <?php selected($slots_show_in_tab, $key); ?>><?php echo esc_html($name); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
    <?php
}

add_action( 'save_post', 'zlots_slots_tab_save_fields', 10, 2 );
function zlots_slots_tab_save_fields( $post_id ) {
    if ( ! isset( $_POST['zlots_slots_tab_nonce'] ) ) {
        return $post_id;
    }

    $nonce = $_POST['zlots_slots_tab_nonce'];

    if ( ! wp_verify_nonce( $nonce, 'zlots_slots_tab_box' ) ) {
        return $post_id;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }

    if ( 'game' == $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return $post_id;
        }
    }

    $slots_show_in_tab = sanitize_text_field( $_POST['show-in-tab'] );
    update_post_meta( $post_id, 'zlots_slots_show_in_tab', $slots_show_in_tab );
}
// !END Slots Tab

// Withdrawal times
add_action( 'admin_init', 'zlots_casinos_withdrawal_time_fields' );
function zlots_casinos_withdrawal_time_fields() {
    add_meta_box( 'zlots_casinos_withdrawal_time_meta_box',
        esc_html__( 'Withdrawal times', 'zlots' ),
        'zlots_casinos_withdrawal_time_display_meta_box',
        'casino', 'normal', 'high'
    );
}

function zlots_casinos_withdrawal_time_display_meta_box( $casino ) {
    wp_nonce_field( 'zlots_casinos_withdrawal_time_box', 'zlots_casinos_withdrawal_time_nonce' );

    $wt_ewallet            = get_post_meta( $casino->ID, 'casinos_withdrawal_time_ewallet', true );
    $wt_bank_transfers     = get_post_meta( $casino->ID, 'casinos_withdrawal_time_bank_transfers', true );
    $wt_bank_cheques       = get_post_meta( $casino->ID, 'casinos_withdrawal_time_cheques', true );
    $wt_bank_card_payments = get_post_meta( $casino->ID, 'casinos_withdrawal_time_card_payments', true );
    $wt_bank_pending_time  = get_post_meta( $casino->ID, 'casinos_withdrawal_time_pending_time', true );
    ?>

    <div class="components-base-control">
        <div class="components-base-control__field">
            <label class="components-base-control__label">
                <?php esc_html_e( 'EWallets', 'zlots' ); ?>
            </label>
            <div class="aces-single-rating-box">
                <input type="text" name="casinos_withdrawal_time_ewallet" value="<?php esc_attr_e( $wt_ewallet ); ?>">
                <small>24 hours | 0-1 hours</small>
            </div>
        </div>
    </div>

    <div class="components-base-control">
        <div class="components-base-control__field">
            <label class="components-base-control__label">
                <?php esc_html_e( 'Bank Transfers', 'zlots' ); ?>
            </label>
            <div class="aces-single-rating-box">
                <input type="text" name="casinos_withdrawal_time_bank_transfers" value="<?php esc_attr_e( $wt_bank_transfers ); ?>">
                <small>3-7 days | 0-1 hours</small>
            </div>
        </div>
    </div>

    <div class="components-base-control">
        <div class="components-base-control__field">
            <label class="components-base-control__label">
                <?php esc_html_e( 'Cheques', 'zlots' ); ?>
            </label>
            <div class="aces-single-rating-box">
                <input type="text" name="casinos_withdrawal_time_cheques" value="<?php esc_attr_e( $wt_bank_cheques ); ?>">
                <small>Not offered</small>
            </div>
        </div>
    </div>

    <div class="components-base-control">
        <div class="components-base-control__field">
            <label class="components-base-control__label">
                <?php esc_html_e( 'Card Payments', 'zlots' ); ?>
            </label>
            <div class="aces-single-rating-box">
                <input type="text" name="casinos_withdrawal_time_card_payments" value="<?php esc_attr_e( $wt_bank_card_payments ); ?>">
                <small>3-5 days | 0-1 hours</small>
            </div>
        </div>
    </div>

    <div class="components-base-control">
        <div class="components-base-control__field">
            <label class="components-base-control__label">
                <?php esc_html_e( 'Pending Time', 'zlots' ); ?>
            </label>
            <div class="aces-single-rating-box">
                <input type="text" name="casinos_withdrawal_time_pending_time" value="<?php esc_attr_e( $wt_bank_pending_time ); ?>">
                <small>24-48 hours | 0-24 hours</small>
            </div>
        </div>
    </div>
    <?php
}

add_action( 'save_post', 'zlots_casinos_withdrawal_time_save_fields', 10, 2 );
function zlots_casinos_withdrawal_time_save_fields( $post_id ) {
    if ( ! isset( $_POST['zlots_casinos_withdrawal_time_nonce'] ) ) {
        return $post_id;
    }

    $nonce = $_POST['zlots_casinos_withdrawal_time_nonce'];

    if ( ! wp_verify_nonce( $nonce, 'zlots_casinos_withdrawal_time_box' ) ) {
        return $post_id;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }

    if ( 'casino' == $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return $post_id;
        }
    }

    if ( isset( $_POST['casinos_withdrawal_time_ewallet'] ) ) {
        update_post_meta( $post_id, 'casinos_withdrawal_time_ewallet', sanitize_text_field( wp_unslash( $_POST['casinos_withdrawal_time_ewallet'] ) ) );
    }

    if ( isset( $_POST['casinos_withdrawal_time_bank_transfers'] ) ) {
        update_post_meta( $post_id, 'casinos_withdrawal_time_bank_transfers', sanitize_text_field( wp_unslash( $_POST['casinos_withdrawal_time_bank_transfers'] ) ) );
    }

    if ( isset( $_POST['casinos_withdrawal_time_cheques'] ) ) {
        update_post_meta( $post_id, 'casinos_withdrawal_time_cheques', sanitize_text_field( wp_unslash( $_POST['casinos_withdrawal_time_cheques'] ) ) );
    }

    if ( isset( $_POST['casinos_withdrawal_time_card_payments'] ) ) {
        update_post_meta( $post_id, 'casinos_withdrawal_time_card_payments', sanitize_text_field( wp_unslash( $_POST['casinos_withdrawal_time_card_payments'] ) ) );
    }

    if ( isset( $_POST['casinos_withdrawal_time_pending_time'] ) ) {
        update_post_meta( $post_id, 'casinos_withdrawal_time_pending_time', sanitize_text_field( wp_unslash( $_POST['casinos_withdrawal_time_pending_time'] ) ) );
    }
}
// !END Withdrawal times

// Responsible Gambling
add_action( 'admin_init', 'zlots_casinos_responsible_gambling_fields' );
function zlots_casinos_responsible_gambling_fields() {
    add_meta_box( 'zlots_casinos_responsible_gambling_meta_box',
        esc_html__( 'Responsible Gambling', 'zlots' ),
        'zlots_casinos_responsible_gambling_display_meta_box',
        'casino', 'normal', 'high'
    );
}

function zlots_casinos_responsible_gambling_display_meta_box( $casino ) {
    wp_nonce_field( 'zlots_casinos_recommended_box', 'zlots_casinos_recommended_nonce' );

    $is_deposit       = get_post_meta( $casino->ID, 'zlotz_rg_is_deposit', true );
    $is_wager         = get_post_meta( $casino->ID, 'zlotz_rg_is_wager', true );
    $is_loss          = get_post_meta( $casino->ID, 'zlotz_rg_is_loss', true );
    $is_time          = get_post_meta( $casino->ID, 'zlotz_rg_is_time', true );
    $is_exclusion     = get_post_meta( $casino->ID, 'zlotz_rg_is_exclusion', true );
    $is_cool          = get_post_meta( $casino->ID, 'zlotz_rg_is_cool', true );
    $is_reality       = get_post_meta( $casino->ID, 'zlotz_rg_is_reality', true );
    $is_assessment    = get_post_meta( $casino->ID, 'zlotz_rg_is_assessment', true );
    $is_withdrawal    = get_post_meta( $casino->ID, 'zlotz_rg_is_withdrawal', true );
    $is_participation = get_post_meta( $casino->ID, 'zlotz_rg_is_participation', true );
    ?>
    <div class="components-base-control">
        <div class="components-base-control__field">
            <label class="components-base-control__label" for="zlotz_rg_is_deposit">
                <?php esc_html_e( 'Deposit limit Tool', 'zlots' ); ?>
            </label>
            <div class="aces-single-rating-box">
                <input type="checkbox" name="zlotz_rg_is_deposit" id="zlotz_rg_is_deposit" <?php echo $is_deposit ? 'checked="checked"' : '' ?>>
            </div>
        </div>

        <div class="components-base-control__field">
            <label class="components-base-control__label" for="zlotz_rg_is_wager">
                <?php esc_html_e( 'Wager Limit Tool', 'zlots' ); ?>
            </label>
            <div class="aces-single-rating-box">
                <input type="checkbox" name="zlotz_rg_is_wager" id="zlotz_rg_is_wager" <?php echo $is_wager ? 'checked="checked"' : '' ?>>
            </div>
        </div>

        <div class="components-base-control__field">
            <label class="components-base-control__label" for="zlotz_rg_is_loss">
                <?php esc_html_e( 'Loss Limit Tool', 'zlots' ); ?>
            </label>
            <div class="aces-single-rating-box">
                <input type="checkbox" name="zlotz_rg_is_loss" id="zlotz_rg_is_loss" <?php echo $is_loss ? 'checked="checked"' : '' ?>>
            </div>
        </div>

        <div class="components-base-control__field">
            <label class="components-base-control__label" for="zlotz_rg_is_time">
                <?php esc_html_e( 'Time/Session Limit Tool', 'zlots' ); ?>
            </label>
            <div class="aces-single-rating-box">
                <input type="checkbox" name="zlotz_rg_is_time" id="zlotz_rg_is_time" <?php echo $is_time ? 'checked="checked"' : '' ?>>
            </div>
        </div>

        <div class="components-base-control__field">
            <label class="components-base-control__label" for="zlotz_rg_is_exclusion">
                <?php esc_html_e( 'Self-Exclusion Tool', 'zlots' ); ?>
            </label>
            <div class="aces-single-rating-box">
                <input type="checkbox" name="zlotz_rg_is_exclusion" id="zlotz_rg_is_exclusion" <?php echo $is_exclusion ? 'checked="checked"' : '' ?>>
            </div>
        </div>

        <div class="components-base-control__field">
            <label class="components-base-control__label" for="zlotz_rg_is_cool">
                <?php esc_html_e( 'Cool Off/Time-Out Tool', 'zlots' ); ?>
            </label>
            <div class="aces-single-rating-box">
                <input type="checkbox" name="zlotz_rg_is_cool" id="zlotz_rg_is_cool" <?php echo $is_cool ? 'checked="checked"' : '' ?>>
            </div>
        </div>

        <div class="components-base-control__field">
            <label class="components-base-control__label" for="zlotz_rg_is_reality">
                <?php esc_html_e( 'Reality Check Tool', 'zlots' ); ?>
            </label>
            <div class="aces-single-rating-box">
                <input type="checkbox" name="zlotz_rg_is_reality" id="zlotz_rg_is_reality" <?php echo $is_reality ? 'checked="checked"' : '' ?>>
            </div>
        </div>

        <div class="components-base-control__field">
            <label class="components-base-control__label" for="zlotz_rg_is_assessment">
                <?php esc_html_e( 'Self-Assessment Test', 'zlots' ); ?>
            </label>
            <div class="aces-single-rating-box">
                <input type="checkbox" name="zlotz_rg_is_assessment" id="zlotz_rg_is_assessment" <?php echo $is_assessment ? 'checked="checked"' : '' ?>>
            </div>
        </div>

        <div class="components-base-control__field">
            <label class="components-base-control__label" for="zlotz_rg_is_withdrawal">
                <?php esc_html_e( 'Withdrawal Lock', 'zlots' ); ?>
            </label>
            <div class="aces-single-rating-box">
                <input type="checkbox" name="zlotz_rg_is_withdrawal" id="zlotz_rg_is_withdrawal" <?php echo $is_withdrawal ? 'checked="checked"' : '' ?>>
            </div>
        </div>

        <div class="components-base-control__field">
            <label class="components-base-control__label" for="zlotz_rg_is_participation">
                <?php esc_html_e( 'Self-Exclusion Register Participation', 'zlots' ); ?>
            </label>
            <div class="aces-single-rating-box">
                <input type="checkbox" name="zlotz_rg_is_participation" id="zlotz_rg_is_participation" <?php echo $is_participation ? 'checked="checked"' : '' ?>>
            </div>
        </div>
    </div>
    <?php
}

add_action( 'save_post', 'zlots_casinos_responsible_gambling_save_fields', 10, 2 );
function zlots_casinos_responsible_gambling_save_fields( $post_id ) {
    $nonce = $_POST['zlots_casinos_recommended_nonce'] ?? null;

    if ( ! $nonce || ! wp_verify_nonce( $nonce, 'zlots_casinos_recommended_box' ) ) {
        return $post_id;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }

    if ( 'casino' == $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return $post_id;
        }
    }

    $is_deposit       = sanitize_text_field( $_POST['zlotz_rg_is_deposit'] ?? null );
    $is_wager         = sanitize_text_field( $_POST['zlotz_rg_is_wager'] ?? null );
    $is_loss          = sanitize_text_field( $_POST['zlotz_rg_is_loss'] ?? null );
    $is_time          = sanitize_text_field( $_POST['zlotz_rg_is_time'] ?? null );
    $is_exclusion     = sanitize_text_field( $_POST['zlotz_rg_is_exclusion'] ?? null );
    $is_cool          = sanitize_text_field( $_POST['zlotz_rg_is_cool'] ?? null );
    $is_reality       = sanitize_text_field( $_POST['zlotz_rg_is_reality'] ?? null );
    $is_assessment    = sanitize_text_field( $_POST['zlotz_rg_is_assessment'] ?? null );
    $is_withdrawal    = sanitize_text_field( $_POST['zlotz_rg_is_withdrawal'] ?? null );
    $is_participation = sanitize_text_field( $_POST['zlotz_rg_is_participation'] ?? null );

    update_post_meta( $post_id, 'zlotz_rg_is_deposit', $is_deposit );
    update_post_meta( $post_id, 'zlotz_rg_is_wager', $is_wager );
    update_post_meta( $post_id, 'zlotz_rg_is_loss', $is_loss );
    update_post_meta( $post_id, 'zlotz_rg_is_time', $is_time );
    update_post_meta( $post_id, 'zlotz_rg_is_exclusion', $is_exclusion );
    update_post_meta( $post_id, 'zlotz_rg_is_cool', $is_cool );
    update_post_meta( $post_id, 'zlotz_rg_is_reality', $is_reality );
    update_post_meta( $post_id, 'zlotz_rg_is_assessment', $is_assessment );
    update_post_meta( $post_id, 'zlotz_rg_is_withdrawal', $is_withdrawal );
    update_post_meta( $post_id, 'zlotz_rg_is_participation', $is_participation );
}
// !END Responsible Gambling

// Pros and Cons
add_action( 'admin_init', 'zlots_pros_cons_fields' );
function zlots_pros_cons_fields() {
    add_meta_box( 'zlots_pros_cons_meta_box',
        esc_html__( "What we like and don't like", 'zlots' ),
        'zlots_pros_cons_display_meta_box',
        'casino', 'normal', 'high'
    );
}

function zlots_pros_cons_display_meta_box( $casino ) {
    wp_nonce_field( 'zlots_pros_cons_box', 'zlots_pros_cons_nonce' );

    $casino_pros_desc = get_post_meta( $casino->ID, 'casino_pros_desc', false );
    $casino_cons_desc = get_post_meta( $casino->ID, 'casino_cons_desc', false );

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

    <div class="components-base-control casino_pros_desc" style="max-width: 49%; display: inline-block; width: 100%;">
        <div class="components-base-control__field">
            <small>What we like</small>
            <?php
            if ( empty( $casino_pros_desc[0] ) ) {
                $casino_pros_desc[0] = '';
            }
            wp_editor( $casino_pros_desc[0], 'casino_pros_desc', $editor_args );
            ?>
        </div>
    </div>

    <div class="components-base-control casino_cons_desc" style="max-width: 49%; display: inline-block; width: 100%;">
        <div class="components-base-control__field">
            <small>What we don't like</small>
            <?php
            if ( empty( $casino_cons_desc[0] ) ) {
                $casino_cons_desc[0] = '';
            }
            wp_editor( $casino_cons_desc[0], 'casino_cons_desc', $editor_args );
            ?>
        </div>
    </div>

    <?php
}

add_action( 'save_post', 'zlots_pros_cons_save_fields', 10, 2 );
function zlots_pros_cons_save_fields( $post_id ) {
    $nonce = $_POST['zlots_pros_cons_nonce'] ?? null;

    if ( ! wp_verify_nonce( $nonce, 'zlots_pros_cons_box' ) ) {
        return $post_id;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }

    if ( 'casino' == $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return $post_id;
        }
    }

    $casino_pros_desc = $_POST['casino_pros_desc'];
    $casino_cons_desc = $_POST['casino_cons_desc'];

    update_post_meta( $post_id, 'casino_pros_desc', $casino_pros_desc );
    update_post_meta( $post_id, 'casino_cons_desc', $casino_cons_desc );
}
// !END Pros and Cons

// Bonus Meta Fields
add_action( 'admin_init', 'zlots_bonus_meta_fields' );
function zlots_bonus_meta_fields() {
    add_meta_box( 'zlots_bonus_meta_box',
        esc_html__( 'Bonus Information', 'zlots' ),
        'zlots_bonus_display_meta_box',
        'bonus', 'normal', 'high'
    );
}

function zlots_bonus_display_meta_box( $casino ) {
    wp_nonce_field( 'zlots_bonus_box', 'zlots_bonus_nonce' );
    $bonus_amount     = get_post_meta( $casino->ID, 'zlots_bonus_amount', true );
    $bonus_percentage = get_post_meta( $casino->ID, 'zlots_bonus_percentage', true );
    $bonus_wager      = get_post_meta( $casino->ID, 'zlots_bonus_wager', true );
    $bonus_spins      = get_post_meta( $casino->ID, 'zlots_bonus_spins', true );

    ?>
    <div class="components-base-control">
        <div class="components-base-control__field">
            <label class="components-base-control__label" for="zlots_bonus_amount">
                <?php esc_html_e( 'Bonus Amount', 'zlots' ); ?>
            </label>
            <div class="aces-single-rating-box">
                <input type="text" name="zlots_bonus_amount" id="zlots_bonus_amount" value="<?php esc_attr_e( $bonus_amount ); ?>">
            </div>
        </div>

        <div class="components-base-control__field">
            <label class="components-base-control__label" for="zlots_bonus_percentage">
                <?php esc_html_e( 'Bonus Percentage', 'zlots' ); ?>
            </label>
            <div class="aces-single-rating-box">
                <input type="text" name="zlots_bonus_percentage" id="zlots_bonus_percentage" value="<?php esc_attr_e( $bonus_percentage ); ?>">
            </div>
        </div>

        <div class="components-base-control__field">
            <label class="components-base-control__label" for="zlots_bonus_wager">
                <?php esc_html_e( 'Bonus Wager', 'zlots' ); ?>
            </label>
            <div class="aces-single-rating-box">
                <input type="text" name="zlots_bonus_wager" id="zlots_bonus_wager" value="<?php esc_attr_e( $bonus_wager ); ?>">
            </div>
        </div>

        <div class="components-base-control__field">
            <label class="components-base-control__label" for="zlots_bonus_spins">
                <?php esc_html_e( 'Bonus Free Spins', 'zlots' ); ?>
            </label>
            <div class="aces-single-rating-box">
                <input type="text" name="zlots_bonus_spins" id="zlots_bonus_spins" value="<?php esc_attr_e( $bonus_spins ); ?>">
            </div>
        </div>
    </div>
    <?php
}

add_action( 'save_post', 'zlots_bonus_save_fields', 10, 2 );
function zlots_bonus_save_fields( $post_id ) {
    $nonce = $_POST['zlots_bonus_nonce'] ?? null;

    if ( ! $nonce || ! wp_verify_nonce( $nonce, 'zlots_bonus_box' ) ) {
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

    $bonus_amount     = sanitize_text_field( $_POST['zlots_bonus_amount'] ?? null );
    $bonus_percentage = sanitize_text_field( $_POST['zlots_bonus_percentage'] ?? null );
    $bonus_wager      = sanitize_text_field( $_POST['zlots_bonus_wager'] ?? null );
    $bonus_spins      = sanitize_text_field( $_POST['zlots_bonus_spins'] ?? null );

    update_post_meta( $post_id, 'zlots_bonus_amount', $bonus_amount );
    update_post_meta( $post_id, 'zlots_bonus_percentage', $bonus_percentage );
    update_post_meta( $post_id, 'zlots_bonus_wager', $bonus_wager );
    update_post_meta( $post_id, 'zlots_bonus_spins', $bonus_spins );
}
// !END Bonus Meta Fields

// Slot Meta Fields
add_action('admin_init', 'zlots_slot_meta_fields');
function zlots_slot_meta_fields() {
    add_meta_box('zlots_slot_meta_box',
        esc_html__('Slot Information', 'zlots'),
        'zlots_slot_display_meta_box',
        'game', 'normal', 'high'
    );
}

function zlots_slot_display_meta_box($slot) {
    wp_nonce_field('zlots_slot_box', 'zlots_slot_nonce');
    $game_link = get_post_meta($slot->ID, 'zlots_slot_game_link', true);
    $reels = get_post_meta($slot->ID, 'zlots_slot_reels', true);
    $rows = get_post_meta($slot->ID, 'zlots_slot_rows', true);
    $paylines = get_post_meta($slot->ID, 'zlots_slot_paylines', true);
    $rtp = get_post_meta($slot->ID, 'zlots_slot_rtp', true);
    $max_win = get_post_meta($slot->ID, 'zlots_slot_max_win', true);
    $volatility = get_post_meta($slot->ID, 'zlots_slot_volatility', true);
    $bet = get_post_meta($slot->ID, 'zlots_slot_bet', true);

    ?>
    <div class="components-base-control">
        <div class="components-base-control__field">
            <label class="components-base-control__label" for="zlots_slot_game_link">
                <?php esc_html_e('Game Link', 'zlots'); ?>
            </label>
            <div class="aces-single-rating-box">
                <input type="text" style="width: 100%" name="zlots_slot_game_link" id="zlots_slot_game_link" value="<?php echo esc_attr($game_link); ?>">
            </div>
        </div>

        <div class="components-base-control__field">
            <label class="components-base-control__label" for="zlots_slot_reels">
                <?php esc_html_e('Reels', 'zlots'); ?>
            </label>
            <div class="aces-single-rating-box">
                <input type="text" name="zlots_slot_reels" id="zlots_slot_reels" value="<?php echo esc_attr($reels); ?>">
            </div>
        </div>

        <div class="components-base-control__field">
            <label class="components-base-control__label" for="zlots_slot_rows">
                <?php esc_html_e('Rows', 'zlots'); ?>
            </label>
            <div class="aces-single-rating-box">
                <input type="text" name="zlots_slot_rows" id="zlots_slot_rows" value="<?php echo esc_attr($rows); ?>">
            </div>
        </div>

        <div class="components-base-control__field">
            <label class="components-base-control__label" for="zlots_slot_paylines">
                <?php esc_html_e('Paylines', 'zlots'); ?>
            </label>
            <div class="aces-single-rating-box">
                <input type="text" name="zlots_slot_paylines" id="zlots_slot_paylines" value="<?php echo esc_attr($paylines); ?>">
            </div>
        </div>

        <div class="components-base-control__field">
            <label class="components-base-control__label" for="zlots_slot_rtp">
                <?php esc_html_e('RTP', 'zlots'); ?>
            </label>
            <div class="aces-single-rating-box">
                <input type="text" name="zlots_slot_rtp" id="zlots_slot_rtp" value="<?php echo esc_attr($rtp); ?>">
            </div>
        </div>

        <div class="components-base-control__field">
            <label class="components-base-control__label" for="zlots_slot_max_win">
                <?php esc_html_e('Max Win', 'zlots'); ?>
            </label>
            <div class="aces-single-rating-box">
                <input type="text" name="zlots_slot_max_win" id="zlots_slot_max_win" value="<?php echo esc_attr($max_win); ?>">
            </div>
        </div>

        <div class="components-base-control__field">
            <label class="components-base-control__label" for="zlots_slot_volatility">
                <?php esc_html_e('Volatility', 'zlots'); ?>
            </label>
            <div class="aces-single-rating-box">
                <input type="text" name="zlots_slot_volatility" id="zlots_slot_volatility" value="<?php echo esc_attr($volatility); ?>">
            </div>
        </div>

        <div class="components-base-control__field">
            <label class="components-base-control__label" for="zlots_slot_bet">
                <?php esc_html_e('Min/Max Bet', 'zlots'); ?>
            </label>
            <div class="aces-single-rating-box">
                <input type="text" name="zlots_slot_bet" id="zlots_slot_bet" value="<?php echo esc_attr($bet); ?>">
            </div>
        </div>
    </div>
    <?php
}

add_action('save_post', 'zlots_slot_save_fields', 10, 2);
function zlots_slot_save_fields($post_id) {
    $nonce = $_POST['zlots_slot_nonce'] ?? null;

    if (!$nonce || !wp_verify_nonce($nonce, 'zlots_slot_box')) {
        return $post_id;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    if ('game' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    }

    $game_link = sanitize_text_field($_POST['zlots_slot_game_link'] ?? '');
    $reels = sanitize_text_field($_POST['zlots_slot_reels'] ?? '');
    $rows = sanitize_text_field($_POST['zlots_slot_rows'] ?? '');
    $paylines = sanitize_text_field($_POST['zlots_slot_paylines'] ?? '');
    $rtp = sanitize_text_field($_POST['zlots_slot_rtp'] ?? '');
    $max_win = sanitize_text_field($_POST['zlots_slot_max_win'] ?? '');
    $volatility = sanitize_text_field($_POST['zlots_slot_volatility'] ?? '');
    $bet = sanitize_text_field($_POST['zlots_slot_bet'] ?? '');

    update_post_meta($post_id, 'zlots_slot_game_link', $game_link);
    update_post_meta($post_id, 'zlots_slot_reels', $reels);
    update_post_meta($post_id, 'zlots_slot_rows', $rows);
    update_post_meta($post_id, 'zlots_slot_paylines', $paylines);
    update_post_meta($post_id, 'zlots_slot_rtp', $rtp);
    update_post_meta($post_id, 'zlots_slot_max_win', $max_win);
    update_post_meta($post_id, 'zlots_slot_volatility', $volatility);
    update_post_meta($post_id, 'zlots_slot_bet', $bet);
}
// !END Slot Meta Fields

// Providers Taxonomy Meta Fields
add_action( 'vendor_add_form_fields', 'zlots_add_vendor_taxonomy_meta_fields', 10, 2 );
function zlots_add_vendor_taxonomy_meta_fields( $taxonomy ) {
    ?>
    <div class="form-field term-group">
        <label for="taxonomy-established-id">
            <?php esc_html_e( 'Established', 'zlots' ); ?>
        </label>
        <input type="text" id="taxonomy-established-id" name="zlots_taxonomy_established" value="">
    </div>

    <div class="form-field term-group">
        <label for="taxonomy-established-id">
            <?php esc_html_e( 'Website', 'zlots' ); ?>
        </label>
        <input type="text" id="taxonomy-website-id" name="zlots_taxonomy_website" value="">
    </div>

    <div class="form-field term-group">
        <label for="taxonomy-headquarters-id">
            <?php esc_html_e( 'Headquarters', 'zlots' ); ?>
        </label>
        <input type="text" id="taxonomy-headquarters-id" name="zlots_taxonomy_headquarters" value="">
    </div>

    <div class="form-field term-group">
        <label for="taxonomy-licenses-id">
            <?php esc_html_e( 'Licenses', 'zlots' ); ?>
        </label>
        <textarea rows="4" cols="50" id="taxonomy-licenses-id" name="zlots_taxonomy_licenses"></textarea>
    </div>
    <?php
}

add_action( 'created_vendor', 'zlots_save_vendor_taxonomy_meta_fields', 10, 2 );
function zlots_save_vendor_taxonomy_meta_fields( $term_id, $tt_id ) {
    if ( isset( $_POST['zlots_taxonomy_established'] ) && '' !== $_POST['zlots_taxonomy_established'] ) {
        $established = sanitize_text_field( $_POST['zlots_taxonomy_established'] );
        add_term_meta( $term_id, 'zlots_taxonomy_established', $established, true );
    }

    if ( isset( $_POST['zlots_taxonomy_website'] ) && '' !== $_POST['zlots_taxonomy_website'] ) {
        $website = sanitize_text_field( $_POST['zlots_taxonomy_website'] );
        add_term_meta( $term_id, 'zlots_taxonomy_website', $website, true );
    }

    if ( isset( $_POST['zlots_taxonomy_headquarters'] ) && '' !== $_POST['zlots_taxonomy_headquarters'] ) {
        $headquarters = sanitize_text_field( $_POST['zlots_taxonomy_headquarters'] );
        add_term_meta( $term_id, 'zlots_taxonomy_headquarters', $headquarters, true );
    }

    if ( isset( $_POST['zlots_taxonomy_licenses'] ) && '' !== $_POST['zlots_taxonomy_licenses'] ) {
        $licenses = sanitize_text_field( $_POST['zlots_taxonomy_licenses'] );
        add_term_meta( $term_id, 'zlots_taxonomy_licenses', $licenses, true );
    }
}

add_action( 'vendor_edit_form_fields', 'zlots_edit_vendor_meta_fields_upload', 10, 2 );
function zlots_edit_vendor_meta_fields_upload( $term, $taxonomy ) {
    ?>
    <tr class="form-field term-group-wrap">
        <th scope="row">
            <label for="taxonomy-established-id">
                <?php esc_html_e( 'Established', 'zlots' ); ?>
            </label>
        </th>
        <td>
            <?php $established = get_term_meta( $term->term_id, 'zlots_taxonomy_established', true ); ?>
            <input type="text" id="taxonomy-established-id" name="zlots_taxonomy_established"
                   value="<?php echo esc_attr( $established ); ?>">
        </td>
    </tr>

    <tr class="form-field term-group-wrap">
        <th scope="row">
            <label for="taxonomy-website-id">
                <?php esc_html_e( 'Website', 'zlots' ); ?>
            </label>
        </th>
        <td>
            <?php $website = get_term_meta( $term->term_id, 'zlots_taxonomy_website', true ); ?>
            <input type="text" id="taxonomy-website-id" name="zlots_taxonomy_website"
                   value="<?php echo esc_attr( $website ); ?>">
        </td>
    </tr>

    <tr class="form-field term-group-wrap">
        <th scope="row">
            <label for="taxonomy-headquarters-id">
                <?php esc_html_e( 'Headquarters', 'zlots' ); ?>
            </label>
        </th>
        <td>
            <?php $headquarters = get_term_meta( $term->term_id, 'zlots_taxonomy_headquarters', true ); ?>
            <input type="text" id="taxonomy-headquarters-id" name="zlots_taxonomy_headquarters"
                   value="<?php echo esc_attr( $headquarters ); ?>">
        </td>
    </tr>

    <tr class="form-field term-group-wrap">
        <th scope="row">
            <label for="taxonomy-licenses-id">
                <?php esc_html_e( 'Licenses', 'zlots' ); ?>
            </label>
        </th>
        <td>
            <?php $licenses = get_term_meta( $term->term_id, 'zlots_taxonomy_licenses', true ); ?>
            <textarea rows="4" cols="50" id="taxonomy-licenses-id"
                      name="zlots_taxonomy_licenses"><?php echo esc_attr( $licenses ); ?></textarea>
        </td>
    </tr>
    <?php
}

add_action('edited_vendor', 'zlots_update_vendor_meta_fields_upload', 10, 2);
function zlots_update_vendor_meta_fields_upload($term_id, $tt_id) {
    if( isset( $_POST['zlots_taxonomy_established'] ) && '' !== $_POST['zlots_taxonomy_established'] ){
        $established = sanitize_text_field( $_POST['zlots_taxonomy_established'] );
        update_term_meta ( $term_id, 'zlots_taxonomy_established', $established );
    } else {
        update_term_meta ( $term_id, 'zlots_taxonomy_established', '' );
    }

    if( isset( $_POST['zlots_taxonomy_website'] ) && '' !== $_POST['zlots_taxonomy_website'] ){
        $website = sanitize_text_field( $_POST['zlots_taxonomy_website'] );
        update_term_meta ( $term_id, 'zlots_taxonomy_website', $website );
    } else {
        update_term_meta ( $term_id, 'zlots_taxonomy_website', '' );
    }

    if( isset( $_POST['zlots_taxonomy_headquarters'] ) && '' !== $_POST['zlots_taxonomy_headquarters'] ){
        $headquarters = sanitize_text_field( $_POST['zlots_taxonomy_headquarters'] );
        update_term_meta ( $term_id, 'zlots_taxonomy_headquarters', $headquarters );
    } else {
        update_term_meta ( $term_id, 'zlots_taxonomy_headquarters', '' );
    }

    if( isset( $_POST['zlots_taxonomy_licenses'] ) && '' !== $_POST['zlots_taxonomy_licenses'] ){
        $licenses = sanitize_text_field( $_POST['zlots_taxonomy_licenses'] );
        update_term_meta ( $term_id, 'zlots_taxonomy_licenses', $licenses );
    } else {
        update_term_meta ( $term_id, 'zlots_taxonomy_licenses', '' );
    }
}
// !END Providers Taxonomy Meta Fields

// Game Shortcode
function add_game_shortcode_meta_box() {
    add_meta_box(
        'game_shortcode_meta',         // ID på metaboxen
        'Game Shortcode',              // Titel på metaboxen
        'game_shortcode_meta_box_html', // Callback funktion som visar innehållet
        'game',                        // Posttyp som metaboxen ska visas på
        'normal',                      // Kontext (där i admin UI metaboxen ska visas)
        'high'                         // Prioritet för hur högt upp den ska visas
    );
}
add_action('add_meta_boxes', 'add_game_shortcode_meta_box');

function game_shortcode_meta_box_html($post) {
    $shortcode = get_post_meta($post->ID, '_game_shortcode', true);
    ?>
    <label for="game_shortcode_field">Enter Shortcode:</label>
    <input type="text" id="game_shortcode_field" name="game_shortcode_field" value="<?php echo esc_attr($shortcode); ?>" class="widefat">
    <?php
}

function save_game_shortcode_meta_box($post_id) {
    if (array_key_exists('game_shortcode_field', $_POST)) {
        update_post_meta(
            $post_id,
            '_game_shortcode',
            sanitize_text_field($_POST['game_shortcode_field'])
        );
    }
}
add_action('save_post', 'save_game_shortcode_meta_box');

// Casino Bonus Information Meta Box
add_action('add_meta_boxes', 'zlots_casino_bonus_meta_fields');
function zlots_casino_bonus_meta_fields() {
    add_meta_box(
        'zlots_casino_bonus_meta_box',
        esc_html__('Bonus Information', 'zlots'),
        'zlots_casino_bonus_display_meta_box',
        'casino', 
        'normal', 
        'high'
    );
}

function zlots_casino_bonus_display_meta_box($post) {
    wp_nonce_field('zlots_casino_bonus_box', 'zlots_casino_bonus_nonce');
    
    $bonus_amount = get_post_meta($post->ID, 'zlots_bonus_amount', true);
    $bonus_percentage = get_post_meta($post->ID, 'zlots_bonus_percentage', true);
    $bonus_wager = get_post_meta($post->ID, 'zlots_bonus_wager', true);
    $bonus_spins = get_post_meta($post->ID, 'zlots_bonus_spins', true);
    $bonus_description = get_post_meta($post->ID, 'zlots_bonus_description', true);
    $bonus_external_link = get_post_meta($post->ID, 'zlots_bonus_external_link', true);
    ?>
    <div class="components-base-control">
        <div class="components-base-control__field">
            <label class="components-base-control__label" for="zlots_bonus_amount"><?php esc_html_e('Bonus Amount', 'zlots'); ?></label>
            <input type="text" name="zlots_bonus_amount" id="zlots_bonus_amount" value="<?php echo esc_attr($bonus_amount); ?>">
        </div>

        <div class="components-base-control__field">
            <label class="components-base-control__label" for="zlots_bonus_percentage"><?php esc_html_e('Bonus Percentage', 'zlots'); ?></label>
            <input type="text" name="zlots_bonus_percentage" id="zlots_bonus_percentage" value="<?php echo esc_attr($bonus_percentage); ?>">
        </div>

        <div class="components-base-control__field">
            <label class="components-base-control__label" for="zlots_bonus_wager"><?php esc_html_e('Bonus Wager', 'zlots'); ?></label>
            <input type="text" name="zlots_bonus_wager" id="zlots_bonus_wager" value="<?php echo esc_attr($bonus_wager); ?>">
        </div>

        <div class="components-base-control__field">
            <label class="components-base-control__label" for="zlots_bonus_spins"><?php esc_html_e('Bonus Free Spins', 'zlots'); ?></label>
            <input type="text" name="zlots_bonus_spins" id="zlots_bonus_spins" value="<?php echo esc_attr($bonus_spins); ?>">
        </div>

        <div class="components-base-control__field">
            <label class="components-base-control__label" for="zlots_bonus_description"><?php esc_html_e('Bonus Description', 'zlots'); ?></label>
            <textarea name="zlots_bonus_description" id="zlots_bonus_description"><?php echo esc_textarea($bonus_description); ?></textarea>
        </div>

        <div class="components-base-control__field">
            <label class="components-base-control__label" for="zlots_bonus_external_link"><?php esc_html_e('Bonus External Link', 'zlots'); ?></label>
            <input type="url" name="zlots_bonus_external_link" id="zlots_bonus_external_link" value="<?php echo esc_url($bonus_external_link); ?>">
        </div>
    </div>
    <?php
}

add_action('save_post', 'zlots_casino_bonus_save_fields');
function zlots_casino_bonus_save_fields($post_id) {
    if (!isset($_POST['zlots_casino_bonus_nonce']) || !wp_verify_nonce($_POST['zlots_casino_bonus_nonce'], 'zlots_casino_bonus_box')) {
        return $post_id;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    if ('casino' == $_POST['post_type'] && !current_user_can('edit_page', $post_id)) {
        return $post_id;
    }

    $fields = [
        'zlots_bonus_amount',
        'zlots_bonus_percentage',
        'zlots_bonus_wager',
        'zlots_bonus_spins',
        'zlots_bonus_description',
        'zlots_bonus_external_link'
    ];

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        } else {
            delete_post_meta($post_id, $field);
        }
    }
}
// Lägg till metabox för bakgrundsbild
add_action('admin_init', 'zlots_add_background_image_meta_box');
function zlots_add_background_image_meta_box() {
    add_meta_box(
        'zlots_background_image_meta_box', // ID för metaboxen
        'Bild Till Spelet', // Titel på metaboxen
        'zlots_background_image_meta_box_callback', // Callback-funktion som renderar metaboxens innehåll
        'game', // Posttyp där metaboxen ska visas
        'side', // Kontext (side, normal, advanced)
        'high' // Prioritet
    );
}

// Callback-funktion för att visa metaboxen
function zlots_background_image_meta_box_callback($post) {
    wp_nonce_field('zlots_save_background_image', 'zlots_background_image_nonce');
    $background_image = get_post_meta($post->ID, 'zlots_background_image', true);
    ?>
    <p>
        <label for="zlots_background_image">Välj Bakgrundsbild</label>
        <input type="text" id="zlots_background_image" name="zlots_background_image" value="<?php echo esc_attr($background_image); ?>" style="width: 100%;" />
        <input type="button" id="zlots_background_image_button" class="button" value="Ladda upp Bild" />
    </p>
    <script>
        jQuery(document).ready(function($){
            var mediaUploader;
            $('#zlots_background_image_button').click(function(e) {
                e.preventDefault();
                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }
                mediaUploader = wp.media.frames.file_frame = wp.media({
                    title: 'Välj Bakgrundsbild',
                    button: {
                        text: 'Välj Bild'
                    }, multiple: false });
                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#zlots_background_image').val(attachment.url);
                });
                mediaUploader.open();
            });
        });
    </script>
    <?php
}

// Spara metaboxens data
add_action('save_post', 'zlots_save_background_image_meta');
function zlots_save_background_image_meta($post_id) {
    if (!isset($_POST['zlots_background_image_nonce']) || !wp_verify_nonce($_POST['zlots_background_image_nonce'], 'zlots_save_background_image')) {
        return $post_id;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    if ('game' == $_POST['post_type'] && !current_user_can('edit_page', $post_id)) {
        return $post_id;
    }

    $background_image = sanitize_text_field($_POST['zlots_background_image']);
    update_post_meta($post_id, 'zlots_background_image', $background_image);
}

// Hook för att lägga till meta-box
add_action('add_meta_boxes', 'aces_add_casino_metaboxes');

// Funktion för att lägga till meta-boxar
function aces_add_casino_metaboxes() {
    add_meta_box('casino_details', 'Casino Details', 'aces_casino_details', 'casino', 'normal', 'high');
}

// Funktion för att visa meta-boxen
function aces_casino_details($post) {
    // Skapa nonce för verifiering
    wp_nonce_field(basename(__FILE__), 'casino_nonce');
    $casino_stored_meta = get_post_meta($post->ID);
    ?>
    <p>
        <label for="casino_address"><?php _e('Address', 'aces') ?></label>
        <input type="text" name="casino_address" id="casino_address" value="<?php if (isset($casino_stored_meta['casino_address'])) echo $casino_stored_meta['casino_address'][0]; ?>" />
    </p>
    <p>
        <label for="casino_rating"><?php _e('Rating', 'aces') ?></label>
        <input type="number" name="casino_rating" id="casino_rating" value="<?php if (isset($casino_stored_meta['casino_rating'])) echo $casino_stored_meta['casino_rating'][0]; ?>" step="0.1" min="0" max="5" />
    </p>
    <p>
        <label for="casino_website"><?php _e('Website', 'aces') ?></label>
        <input type="url" name="casino_website" id="casino_website" value="<?php if (isset($casino_stored_meta['casino_website'])) echo $casino_stored_meta['casino_website'][0]; ?>" />
    </p>
    <?php
}

// Hook för att spara meta-data
add_action('save_post', 'aces_save_casino_meta');

// Funktion för att spara meta-data
function aces_save_casino_meta($post_id) {
    // Kontrollera om vår nonce är satt
    if (!isset($_POST['casino_nonce']) || !wp_verify_nonce($_POST['casino_nonce'], basename(__FILE__))) {
        return $post_id;
    }
    // Kontrollera autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    // Kontrollera användarens behörighet
    if ('casino' === $_POST['post_type']) {
        if (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }
    }

    // Spara eller uppdatera fälten
    $fields = ['casino_address', 'casino_rating', 'casino_website'];
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        } else {
            delete_post_meta($post_id, $field);
        }
    }
}// Visa HTML för metaboxen
function display_custom_meta_box($post) {
    // Säkerställ att data sparas korrekt
    wp_nonce_field(basename(__FILE__), 'custom_meta_box_nonce');
    
    // Hämta existerande värden från databasen
    $h2_titles = get_post_meta($post->ID, 'h2_titles', true) ?: [];
    $paragraphs = get_post_meta($post->ID, 'paragraphs', true) ?: [];
    
    // Om det inte finns några värden, skapa tomma arrays
    if (empty($h2_titles)) $h2_titles = array_fill(0, 5, '');
    if (empty($paragraphs)) $paragraphs = array_fill(0, 5, '');
    ?>
    <div>
        <?php for ($i = 0; $i < 5; $i++) : ?>
            <label for="h2_title_<?php echo $i; ?>">H2 Title <?php echo $i + 1; ?></label>
            <input type="text" id="h2_title_<?php echo $i; ?>" name="h2_titles[]" value="<?php echo esc_attr($h2_titles[$i]); ?>" style="width: 100%;" />
            <label for="paragraph_<?php echo $i; ?>">Paragraph <?php echo $i + 1; ?></label>
            <textarea id="paragraph_<?php echo $i; ?>" name="paragraphs[]" rows="4" style="width: 100%;"><?php echo esc_textarea($paragraphs[$i]); ?></textarea>
            <hr>
        <?php endfor; ?>
    </div>
    <?php
}


?>
