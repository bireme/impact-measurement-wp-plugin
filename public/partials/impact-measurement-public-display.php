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

	global $wp;
	global $impact_measurement_cookie;

	$url_parts = parse_url( home_url() );
	$current_url = "{$url_parts['scheme']}://{$url_parts['host']}".add_query_arg( NULL, NULL );
	$im_config = get_option('impact_measurement_config');
	$user = ( $_COOKIE['impact_measurement'] ) ? $_COOKIE['impact_measurement'] : $impact_measurement_cookie;
	$myvhl_user = ( $_COOKIE['userID'] ) ? $_COOKIE['userID'] : '';

	$locale = get_bloginfo('language');
	$site_lang = substr($locale, 0,2);

	$content = file_get_contents(IMPACT_MEASUREMENT_API.$im_config['code']);
	$response = json_decode($content, true);

?>

<!-- Render survey box -->

<?php if ( $response && count($response['objects']) > 0 ) : ?>

<div id="boxFeedback">
	<div id="conteudoFeedback">
		<form action="http://127.0.0.1:8000/send-feedback/" id="feedbackForm">
			<input type="hidden" name="code" value="<?php echo $response['objects'][0]['code']; ?>">
			<input type="hidden" name="user" value="<?php echo $user; ?>">
			<input type="hidden" name="myvhl_user" value="<?php echo $myvhl_user; ?>">
			<input type="hidden" name="page" value="<?php echo $current_url; ?>">
			<input type="hidden" name="page_type" value="<?php echo get_page_type(); ?>">
		</form>
		<div id="feedbackFechar"><i class="fas fa-times"></i></div>
		<h1><?php _e('Your opinion is very important to us!', 'impact-measurement'); ?></h1>
		<h2><?php _e('How satisfied are you?', 'impact-measurement'); ?></h2>
		<hr />
		<div class="im-questions">
			<?php foreach ($response['objects'][0]['questions'] as $key => $question) : $text = $question['question'][$site_lang]; ?>
				<form action="http://127.0.0.1:8000/send-feedback/" id="feedbackForm<?php echo $key; ?>">
					<input type="hidden" name="question" value="<?php echo $question['id']; ?>">
					<?php if ( 'star' == $question['type'] ) : // Star ?>
						<div class="row rowQuestion text-center">
							<input type="hidden" id="rating" name="rating" value="">
							<div class="col-12 feedbackTitulo">
								<b><?php echo ( $text ) ? $text : $question['question'][$locale]; ?></b>
							</div>
							<div class="col-12 feedbackTitulo">
								<i class="far fa-star star1 star-rating" data-rating="1"></i>
								<i class="far fa-star star2 star-rating" data-rating="2"></i>
								<i class="far fa-star star3 star-rating" data-rating="3"></i>
								<i class="far fa-star star4 star-rating" data-rating="4"></i>
								<i class="far fa-star star5 star-rating" data-rating="5"></i>
							</div>
						</div>
					<?php elseif ( 'number' == $question['type'] ) : // Number ?>
						<div class="row rowQuestion text-center">
							<div class="col-12 feedbackTitulo">
								<b><?php echo ( $text ) ? $text : $question['question'][$locale]; ?></b>
							</div>
							<div class="col-12">
								<span class="feedRadio">
									<label for="1b">1</label>
									<input type="radio" id="1a" name="rating" value="1">
								</span>
								<span class="feedRadio">
									<label for="2b">2</label>
									<input type="radio" id="2a" name="rating" value="2">
								</span>
								<span class="feedRadio">
									<label for="3b">3</label>
									<input type="radio" id="3a" name="rating" value="3">
								</span>
								<span class="feedRadio">
									<label for="4b">4</label>
									<input type="radio" id="4a" name="rating" value="4">
								</span>
								<span class="feedRadio">
									<label for="5b">5</label>
									<input type="radio" id="5a" name="rating" value="5">
								</span>
							</div>
						</div>
					<?php elseif ( 'yes-no' == $question['type'] ) : // Yes/No ?>
						<div class="row rowQuestion text-center">
							<div class="col-12 feedbackTitulo">
								<b><?php echo ( $text ) ? $text : $question['question'][$locale]; ?></b>
							</div>
							<div class="col-12">
								<div class="btn-group btn-group-toggle" data-toggle="buttons">
								    <label class="btn btn-secondary">
								    	<input type="radio" name="rating" id="opt1" autocomplete="off" value="1"> <?php _e('Yes'); ?>
								    </label>
								    <label class="btn btn-secondary">
								    	<input type="radio" name="rating" id="opt2" autocomplete="off" value="2"> <?php _e('No'); ?>
								    </label>
								</div>
							</div>
						</div>
					<?php elseif ( 'likert-1' == $question['type'] ) : // Likert 1 ?>
						<div class="row rowQuestion rowLikert">
							<div class="col-12 text-center feedbackTitulo">
								<b><?php echo ( $text ) ? $text : $question['question'][$locale]; ?></b>
							</div>
							<div class="col-12">
								<div>
									<input type="radio" id="5b" name="rating" value="5">
									<label for="5c"><?php _e('Very satisfied', 'impact-measurement'); ?></label>
								</div>
								<div>
									<input type="radio" id="4b" name="rating" value="4">
									<label for="4c"><?php _e('Satisfied', 'impact-measurement'); ?></label>
								</div>
								<div>
									<input type="radio" id="3b" name="rating" value="3">
									<label for="3c"><?php _e('Neither satisfied nor dissatisfied', 'impact-measurement'); ?></label>
								</div>
								<div>
									<input type="radio" id="2b" name="rating" value="2">
									<label for="2c"><?php _e('Dissatisfied', 'impact-measurement'); ?></label>
								</div>
								<div>
									<input type="radio" id="1b" name="rating" value="1">
									<label for="1c"><?php _e('Very dissatisfied', 'impact-measurement'); ?></label>
								</div>
							</div>
						</div>
					<?php elseif ( 'likert-2' == $question['type'] ) : // Likert 2 ?>
						<div class="row rowQuestion rowLikert">
							<div class="col-12 text-center feedbackTitulo">
								<b><?php echo ( $text ) ? $text : $question['question'][$locale]; ?></b>
							</div>
							<div class="col-12">
								<div>
									<input type="radio" id="5c" name="rating" value="5">
									<label for="5c"><?php _e('Strongly agree', 'impact-measurement'); ?></label>
								</div>
								<div>
									<input type="radio" id="4c" name="rating" value="4">
									<label for="4c"><?php _e('Agree', 'impact-measurement'); ?></label>
								</div>
								<div>
									<input type="radio" id="3c" name="rating" value="3">
									<label for="3c"><?php _e('Neither agree nor disagree', 'impact-measurement'); ?></label>
								</div>
								<div>
									<input type="radio" id="2c" name="rating" value="2">
									<label for="2c"><?php _e('Disagree', 'impact-measurement'); ?></label>
								</div>
								<div>
									<input type="radio" id="1c" name="rating" value="1">
									<label for="1c"><?php _e('Strongly disagree', 'impact-measurement'); ?></label>
								</div>
							</div>
						</div>
					<?php endif; ?>
				</form>
			<?php endforeach; ?>
		</div>
		<div class="row im-formdata-submit">
			<div class="col-12 marginT1">
				<button type="button" id="formdata-submit" class="btn btn-block btn-primary" disabled><?php _e('Send', 'impact-measurement'); ?></button>
			</div>
		</div>
		<div class="feedback-message">
            <div class="alert alert-success result-ok" role="alert">
                <?php _e('Thanks for your feedback.', 'impact-measurement'); ?>
            </div>
            <div class="alert alert-warning result-error" role="alert">
                <?php _e('Communication problem.', 'impact-measurement'); ?>
                <br />
                <?php _e('Please try again later.', 'impact-measurement'); ?>
            </div>
        </div>
	</div>
	<div id="iconeFeedback">
		<img src="<?php echo esc_url( IMPACT_MEASUREMENT_PLUGIN_URL . 'images/iconFeedback-'.$site_lang.'.svg' ); ?>" alt="">
	</div>
	<div class="clear"></div>
</div>

<?php endif; ?>