<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://reddes.bvsalud.org/
 * @since      1.0.0
 *
 * @package    Impact_Measurement
 * @subpackage Impact_Measurement/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php

// check user capabilities
if ( !current_user_can('manage_options') ) {
    return;
}

$im_config = get_option('impact_measurement_config');

$current_language = strtolower(get_bloginfo('language'));
$site_lang = substr($current_language, 0,2);

if ( defined( 'POLYLANG_VERSION' ) ) {
    $languages = pll_languages_list();
} else {
    $languages = array($site_lang);
}

?>

<div class="wrap">

    <h1><?php _e('Impact Measurement Settings', 'impact-measurement'); ?></h1>

    <form method="post" action="options.php">

        <?php settings_fields('impact-measurement-settings-group'); ?>

        <?php do_settings_sections('impact-measurement-settings-group'); ?>

        <table class="form-table" role="presentation">
            <tbody>
                <tr>
                    <th scope="row">
                        <label for="im-code"><?php _e('Code', 'impact-measurement'); ?></label>
                    </th>
                    <td>
                        <input type="text" id="im-code" name="impact_measurement_config[code]" value="<?php echo $im_config['code']; ?>" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php _e('Status', 'impact-measurement'); ?>
                    </th>
                    <td>
                        <?php if ( $im_config['status'] ) : ?>
                            <div class="im-notice notice inline notice-alt notice-info"><p><?php _e('Active', 'impact-measurement'); ?></p></div>
                        <?php else : ?>
                            <div class="im-notice notice inline notice-alt notice-warning"><p><?php _e('Inactive', 'impact-measurement'); ?></p></div>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="im-survey"><?php _e('Survey Link', 'impact-measurement'); ?></label>
                    </th>
                    <td>
                        <input type="text" id="im-survey" name="impact_measurement_config[survey]" value="<?php echo $im_config['survey']; ?>" class="regular-text">
                    </td>
                </tr>
            </tbody>
        </table>

        <?php submit_button(); ?>
    
    </form>

</div>