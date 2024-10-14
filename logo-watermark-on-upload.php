<?php  
/**  
 * Plugin Name: Logo Watermark on Upload  
 * Plugin URI:  
 * Description: Automatically adds a watermark to uploaded images using the site's logo. The plugin provides options to enable watermarking, set the watermark size, choose the position, adjust the opacity, define the margin from the edge, and set a custom logo URL.  
 * Version:     1.2  
 * Author:      Md Raihan Hossain  
 * Author URI:  https://hossainya.com/  
 * License:     GPLv2 or later  
 * License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html  
 * Text Domain: logo-watermark-on-upload  
 * Requires at least: 4.9  
 * Requires PHP: 5.6 or later  
 */  

// Exit if accessed directly  
if ( ! defined( 'ABSPATH' ) ) {  
    exit;  
}  

/**  
 * Register the settings menu  
 */  
function lwu_register_settings_menu() {  
    add_options_page(  
        'Logo Watermark Settings',  
        'Logo Watermark',  
        'manage_options',  
        'lwu-settings',  
        'lwu_settings_page'  
    );  
}  
add_action( 'admin_menu', 'lwu_register_settings_menu' );  

/**  
 * Register settings  
 */  
function lwu_register_settings() {  
    register_setting( 'lwu_settings_group', 'lwu_settings' );  
}  
add_action( 'admin_init', 'lwu_register_settings' );  

/**  
 * Settings page content  
 */  
function lwu_settings_page() {  
    $options = get_option( 'lwu_settings' );  
    ?>  

    <div class="wrap">  
        <h1>Logo Watermark Settings</h1>  
        <form method="post" action="options.php">  
            <?php settings_fields( 'lwu_settings_group' ); ?>  
            <?php do_settings_sections( 'lwu_settings_group' ); ?>  

            <table class="form-table">  
                <tr valign="top">  
                    <th scope="row">Enable Watermark</th>  
                    <td>  
                        <input type="checkbox" name="lwu_settings[enabled]" value="1" <?php checked( isset( $options['enabled'] ) ? $options['enabled'] : 0, 1 ); ?> />  
                        <label for="lwu_settings[enabled]">Enable watermarking on image upload</label>  
                    </td>  
                </tr>  

                <?php if ( isset( $options['enabled'] ) && $options['enabled'] ) : ?>  

                <tr valign="top">  
                    <th scope="row">Watermark Size (Width in pixels)</th>  
                    <td>  
                        <input type="number" name="lwu_settings[size]" value="<?php echo isset( $options['size'] ) ? esc_attr( $options['size'] ) : '100'; ?>" min="10" max="1000" />  
                    </td>  
                </tr>  

                <tr valign="top">  
                    <th scope="row">Watermark Position</th>  
                    <td>  
                        <select name="lwu_settings[position]">  
                            <?php  
                            $positions = array(  
                                'bottom-right' => 'Bottom Right',  
                                'bottom-left'  => 'Bottom Left',  
                                'top-right'    => 'Top Right',  
                                'top-left'     => 'Top Left',  
                                'center'       => 'Center',  
                            );  
                            $current_position = isset( $options['position'] ) ? $options['position'] : 'bottom-right';  
                            foreach ( $positions as $value => $label ) {  
                                echo '<option value="' . esc_attr( $value ) . '"' . selected( $current_position, $value, false ) . '>' . esc_html( $label ) . '</option>';  
                            }  
                            ?>  
                        </select>  
                    </td>  
                </tr>  

                <tr valign="top">  
                    <th scope="row">Watermark Opacity (0-100)</th>  
                    <td>  
                        <input type="number" name="lwu_settings[opacity]" value="<?php echo isset( $options['opacity'] ) ? esc_attr( $options['opacity'] ) : '100'; ?>" min="0" max="100" />  
                    </td>  
                </tr>  

                <tr valign="top">  
                    <th scope="row">Margin from Edge (pixels)</th>  
                    <td>  
                        <input type="number" name="lwu_settings[margin]" value="<?php echo isset( $options['margin'] ) ? esc_attr( $options['margin'] ) : '10'; ?>" min="0" max="500" />  
                    </td>  
                </tr>  

                <tr valign="top">  
                    <th scope="row">Custom Logo URL</th>  
                    <td>  
                        <input type="url" name="lwu_settings[logo_url]" value="<?php echo isset( $options['logo_url'] ) ? esc_url( $options['logo_url'] ) : 'https://stockout.store/wp-content/uploads/2024/10/site-23080-logo-1.png'; ?>" class="regular-text" />  
                        <p class="description">Enter the URL of your logo image for watermarking.</p>  
                    </td>  
                </tr>  

                <?php endif; ?>  
            </table>  

            <?php submit_button(); ?>  
        </form>  
    </div>  
    <?php  
}  

/**  
 * Handle the watermark on image upload  
 */  
function lwu_add_watermark( $metadata, $attachment_id ) {  
    $options = get_option( 'lwu_settings' );  

    if ( ! isset( $options['enabled'] ) || ! $options['enabled'] ) {  
        return $metadata; // If watermark is not enabled, exit  
    }  

    // You can replace 'lwu_add_watermark_logic' with your logic to add the watermark  
    lwu_add_watermark_logic( $attachment_id, $options );  

    return $metadata;  
}  
add_filter( 'wp_generate_attachment_metadata', 'lwu_add_watermark', 10, 2 );  

/**  
 * Logic to add the watermark based on the settings  
 */  
function lwu_add_watermark_logic( $attachment_id, $options ) {  
    // Retrieve the logo URL from the settings  
    $logo_url = isset( $options['logo_url'] ) ? esc_url( $options['logo_url'] ) : '';  

    // Here you would add your logic to watermark the images  
    // Example:  
    if ( !empty( $logo_url ) ) {  
        // Load the image and watermark and apply the watermark based on provided options  
        // For example, you can use the GD library or ImageMagick to achieve this  

        // Example (this is a placeholder):  
        // 1. Load uploaded image  
        // 2. Load logo from $logo_url  
        // 3. Resize/move the logo based on $options  
        // 4. Save the final image with the watermark applied  
    }  
}  
