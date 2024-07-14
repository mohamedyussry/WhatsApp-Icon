<?php
/*
Plugin Name: WhatsApp Icon
Description: Adds a WhatsApp icon to the main page for easy communication.
Version: 1.0
Author: mohamed yussry
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Add settings menu
add_action( 'admin_menu', 'whatsapp_icon_menu' );

function whatsapp_icon_menu() {
    add_options_page(
        'WhatsApp Icon Settings',
        'WhatsApp Icon',
        'manage_options',
        'whatsapp-icon',
        'whatsapp_icon_settings_page'
    );
}

function whatsapp_icon_settings_page() {
    ?>
    <div class="wrap">
        <h1>WhatsApp Icon Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields( 'whatsapp_icon_settings' );
            do_settings_sections( 'whatsapp-icon' );
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register settings
add_action( 'admin_init', 'whatsapp_icon_settings_init' );

function whatsapp_icon_settings_init() {
    register_setting( 'whatsapp_icon_settings', 'whatsapp_icon_number' );
    register_setting( 'whatsapp_icon_settings', 'whatsapp_icon_position' );

    add_settings_section(
        'whatsapp_icon_section',
        'Settings',
        '',
        'whatsapp-icon'
    );

    add_settings_field(
        'whatsapp_icon_number',
        'WhatsApp Number',
        'whatsapp_icon_number_render',
        'whatsapp-icon',
        'whatsapp_icon_section'
    );

    add_settings_field(
        'whatsapp_icon_position',
        'Icon Position',
        'whatsapp_icon_position_render',
        'whatsapp-icon',
        'whatsapp_icon_section'
    );
}

function whatsapp_icon_number_render() {
    $number = get_option( 'whatsapp_icon_number' );
    ?>
    <p>Enter the WhatsApp number without the + sign</p>
    <input type="number" name="whatsapp_icon_number" value="<?php echo esc_attr( $number ); ?>" placeholder="123456789" />
    <?php
}

function whatsapp_icon_position_render() {
    $position = get_option( 'whatsapp_icon_position' );
    ?>
    <select name="whatsapp_icon_position">
        <option value="right" <?php selected( $position, 'right' ); ?>>Right</option>
        <option value="left" <?php selected( $position, 'left' ); ?>>Left</option>
    </select>
    <?php
}

// Add WhatsApp icon to the front end
add_action( 'wp_footer', 'add_whatsapp_icon' );

function add_whatsapp_icon() {
    $number = get_option( 'whatsapp_icon_number' );
    $position = get_option( 'whatsapp_icon_position', 'right' );
    if ( ! $number ) {
        return;
    }
    ?>
    <style>
        .whatsapp-icon {
            position: fixed;
            bottom: 20px;
            <?php echo esc_attr( $position ); ?>: 20px;
            z-index: 1000;
            cursor: pointer;
        }
    </style>
    <a href="https://wa.me/<?php echo esc_attr( $number ); ?>" target="_blank">
        <img src="<?php echo plugin_dir_url( __FILE__ ) . 'whatsapp-icon.png'; ?>" class="whatsapp-icon" alt="WhatsApp" width="40" height="40">
    </a>
    <?php
}
