<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://reddes.bvsalud.org/
 * @since      1.0.0
 *
 * @package    Impact_Measurement
 * @subpackage Impact_Measurement/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php
	$locale = get_bloginfo('language');
	$site_lang = substr($locale, 0,2);
?>

<!-- Render survey box -->

<div id="boxFeedback" class="bootstrap-iso im-ajax">
    <div id="conteudoFeedback">
        <div class="im-loading">
            <div class="col-md-12 text-center">
                <div class="spinner-border text-center">
                    <span class="sr-only">...</span>
                </div>
            </div>
        </div>
    </div>
    <div id="iconFeedback">
		<img src="<?php echo esc_url( IMPACT_MEASUREMENT_PLUGIN_URL . 'images/iconFeedback-'.$site_lang.'.svg' ); ?>" alt="">
	</div>
    <div class="clear"></div>
</div>
