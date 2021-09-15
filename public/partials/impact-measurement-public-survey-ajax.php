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
    $page_type = ( $_POST['page_type'] ) ? $_POST['page_type'] : '';
    $page_type_slug = ( $_POST['page_type_slug'] ) ? $_POST['page_type_slug'] : '';

    $locale = get_bloginfo('language');
    $site_lang = substr($locale, 0,2);

    $request = IMPACT_MEASUREMENT_API.$im_config['code'].'&page='.$page_type_slug;

    $contents = file_get_contents($request);
    $response = json_decode($contents, true);

?>

<!-- Render survey box -->

<?php if ( $response && count($response['objects']) > 0 && array_key_exists('questions', $response['objects'][0]) ) : ?>

<div id="conteudoFeedback">
    <div id="feedbackFechar"><i class="fas fa-times"></i></div>
    <h1><?php _e('Your opinion is very important to us!', 'impact-measurement'); ?></h1>
    <hr />
    <div class="im-questions">
        <form action="<?php echo IMPACT_MEASUREMENT_URL; ?>/send-feedback/" id="feedbackForm">
            <input type="hidden" name="code" value="<?php echo $response['objects'][0]['code']; ?>">
            <input type="hidden" name="user" value="<?php echo $user; ?>">
            <input type="hidden" name="myvhl_user" value="<?php echo $myvhl_user; ?>">
            <input type="hidden" name="page" value="<?php echo wp_get_referer(); ?>">
            <input type="hidden" name="page_type" value="<?php echo $page_type; ?>">
            <input type="hidden" name="page_type_slug" value="<?php echo $page_type_slug; ?>">
        </form>
        <?php foreach ($response['objects'][0]['questions'] as $key => $question) : ?>
            <?php $text = $question['question'][$site_lang]; ?>
            <?php $text = ( $text ) ? $text : $question['question'][$locale]; ?>
            <?php $text = ( $text ) ? $text : $question['question']['en']; ?>
            <?php if ( $text ) : ?>
                <form id="feedbackForm<?php echo $key; ?>">
                    <input type="hidden" name="question" value="<?php echo $question['id']; ?>">
                    <?php if ( 'star' == $question['type'] ) : // Star ?>
                        <div class="row rowQuestion rowStarRating text-center">
                            <input type="hidden" id="rating" name="rating" value="">
                            <div class="col-12 feedbackTitulo">
                                <b><?php echo $text; ?></b>
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
                                <b><?php echo $text; ?></b>
                            </div>
                            <div class="col-12">
                                <span class="feedRadio">
                                    <label for="1a">1</label>
                                    <input type="radio" id="1a" name="rating" value="1">
                                </span>
                                <span class="feedRadio">
                                    <label for="2a">2</label>
                                    <input type="radio" id="2a" name="rating" value="2">
                                </span>
                                <span class="feedRadio">
                                    <label for="3a">3</label>
                                    <input type="radio" id="3a" name="rating" value="3">
                                </span>
                                <span class="feedRadio">
                                    <label for="4a">4</label>
                                    <input type="radio" id="4a" name="rating" value="4">
                                </span>
                                <span class="feedRadio">
                                    <label for="5a">5</label>
                                    <input type="radio" id="5a" name="rating" value="5">
                                </span>
                            </div>
                        </div>
                    <?php elseif ( 'yes-no' == $question['type'] ) : // Yes/No ?>
                        <div class="row rowQuestion text-center">
                            <div class="col-12 feedbackTitulo">
                                <b><?php echo $text; ?></b>
                            </div>
                            <div class="col-12">
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-secondary btn-yesno">
                                        <input type="radio" name="rating" id="opt1" autocomplete="off" value="1"> <?php _e('Yes'); ?>
                                    </label>
                                    <label class="btn btn-secondary btn-yesno">
                                        <input type="radio" name="rating" id="opt2" autocomplete="off" value="2"> <?php _e('No'); ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                    <?php elseif ( 'likert-1' == $question['type'] ) : // Likert 1 ?>
                        <div class="row rowQuestion rowLikert">
                            <div class="col-12 text-center feedbackTitulo">
                                <b><?php echo $text; ?></b>
                            </div>
                            <div class="col-12 rowOptions">
                                <div>
                                    <input type="radio" id="5b" name="rating" value="5">
                                    <label for="5b"><?php _e('Very satisfied', 'impact-measurement'); ?></label>
                                </div>
                                <div>
                                    <input type="radio" id="4b" name="rating" value="4">
                                    <label for="4b"><?php _e('Satisfied', 'impact-measurement'); ?></label>
                                </div>
                                <div>
                                    <input type="radio" id="3b" name="rating" value="3">
                                    <label for="3b"><?php _e('Neither satisfied nor dissatisfied', 'impact-measurement'); ?></label>
                                </div>
                                <div>
                                    <input type="radio" id="2b" name="rating" value="2">
                                    <label for="2b"><?php _e('Dissatisfied', 'impact-measurement'); ?></label>
                                </div>
                                <div>
                                    <input type="radio" id="1b" name="rating" value="1">
                                    <label for="1b"><?php _e('Very dissatisfied', 'impact-measurement'); ?></label>
                                </div>
                            </div>
                        </div>
                    <?php elseif ( 'likert-2' == $question['type'] ) : // Likert 2 ?>
                        <div class="row rowQuestion rowLikert">
                            <div class="col-12 text-center feedbackTitulo">
                                <b><?php echo $text; ?></b>
                            </div>
                            <div class="col-12 rowOptions">
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
                    <?php elseif ( 'likert-3-likely' == $question['type'] ) : // Likert 3 ?>
                        <div class="row rowQuestion rowLikert">
                            <div class="col-12 text-center feedbackTitulo">
                                <b><?php echo $text; ?></b>
                            </div>
                            <div class="col-12 rowOptions">
                                <div>
                                    <input type="radio" id="5d" name="rating" value="5">
                                    <label for="5d"><?php _e('Extremely likely', 'impact-measurement'); ?></label>
                                </div>
                                <div>
                                    <input type="radio" id="4d" name="rating" value="4">
                                    <label for="4d"><?php _e('Very likely', 'impact-measurement'); ?></label>
                                </div>
                                <div>
                                    <input type="radio" id="3d" name="rating" value="3">
                                    <label for="3d"><?php _e('Somewhat likely', 'impact-measurement'); ?></label>
                                </div>
                                <div>
                                    <input type="radio" id="2d" name="rating" value="2">
                                    <label for="2d"><?php _e('Not so likely', 'impact-measurement'); ?></label>
                                </div>
                                <div>
                                    <input type="radio" id="1d" name="rating" value="1">
                                    <label for="1d"><?php _e('Not likely at all', 'impact-measurement'); ?></label>
                                </div>
                            </div>
                        </div>
                    <?php elseif ( 'likert-4-reliable' == $question['type'] ) : // Likert 4 ?>
                        <div class="row rowQuestion rowLikert">
                            <div class="col-12 text-center feedbackTitulo">
                                <b><?php echo $text; ?></b>
                            </div>
                            <div class="col-12 rowOptions">
                                <div>
                                    <input type="radio" id="5e" name="rating" value="5">
                                    <label for="5e"><?php _e('Extremely reliable', 'impact-measurement'); ?></label>
                                </div>
                                <div>
                                    <input type="radio" id="4e" name="rating" value="4">
                                    <label for="4e"><?php _e('Very reliable', 'impact-measurement'); ?></label>
                                </div>
                                <div>
                                    <input type="radio" id="3e" name="rating" value="3">
                                    <label for="3e"><?php _e('Somewhat reliable', 'impact-measurement'); ?></label>
                                </div>
                                <div>
                                    <input type="radio" id="2e" name="rating" value="2">
                                    <label for="2e"><?php _e('Not so reliable', 'impact-measurement'); ?></label>
                                </div>
                                <div>
                                    <input type="radio" id="1e" name="rating" value="1">
                                    <label for="1e"><?php _e('Not reliable at all', 'impact-measurement'); ?></label>
                                </div>
                            </div>
                        </div>
                    <?php elseif ( 'likert-5-well' == $question['type'] ) : // Likert 5 ?>
                        <div class="row rowQuestion rowLikert">
                            <div class="col-12 text-center feedbackTitulo">
                                <b><?php echo $text; ?></b>
                            </div>
                            <div class="col-12 rowOptions">
                                <div>
                                    <input type="radio" id="5f" name="rating" value="5">
                                    <label for="5f"><?php _e('Extremely well', 'impact-measurement'); ?></label>
                                </div>
                                <div>
                                    <input type="radio" id="4f" name="rating" value="4">
                                    <label for="4f"><?php _e('Very well', 'impact-measurement'); ?></label>
                                </div>
                                <div>
                                    <input type="radio" id="3f" name="rating" value="3">
                                    <label for="3f"><?php _e('Somewhat well', 'impact-measurement'); ?></label>
                                </div>
                                <div>
                                    <input type="radio" id="2f" name="rating" value="2">
                                    <label for="2f"><?php _e('Not so well', 'impact-measurement'); ?></label>
                                </div>
                                <div>
                                    <input type="radio" id="1f" name="rating" value="1">
                                    <label for="1f"><?php _e('Not well at all', 'impact-measurement'); ?></label>
                                </div>
                            </div>
                        </div>
                    <?php elseif ( 'likert-6-excellent' == $question['type'] ) : // Likert 6 ?>
                        <div class="row rowQuestion rowLikert">
                            <div class="col-12 text-center feedbackTitulo">
                                <b><?php echo $text; ?></b>
                            </div>
                            <div class="col-12 rowOptions">
                                <div>
                                    <input type="radio" id="4g" name="rating" value="4">
                                    <label for="4g"><?php _e('Excellent', 'impact-measurement'); ?></label>
                                </div>
                                <div>
                                    <input type="radio" id="3g" name="rating" value="3">
                                    <label for="3g"><?php _e('Above average', 'impact-measurement'); ?></label>
                                </div>
                                <div>
                                    <input type="radio" id="2g" name="rating" value="2">
                                    <label for="2g"><?php _e('Average', 'impact-measurement'); ?></label>
                                </div>
                                <div>
                                    <input type="radio" id="1g" name="rating" value="1">
                                    <label for="1g"><?php _e('Below average', 'impact-measurement'); ?></label>
                                </div>
                            </div>
                        </div>
                    <?php elseif ( 'yes-somewhat-no' == $question['type'] ) : // Yes/Somewhat/No ?>
                        <div class="row rowQuestion rowLikert">
                            <div class="col-12 text-center feedbackTitulo">
                                <b><?php echo $text; ?></b>
                            </div>
                            <div class="col-12 rowOptions">
                                <div>
                                    <input type="radio" id="3h" name="rating" value="3">
                                    <label for="3h"><?php _e('Yes', 'impact-measurement'); ?></label>
                                </div>
                                <div>
                                    <input type="radio" id="2h" name="rating" value="2">
                                    <label for="2h"><?php _e('Somewhat', 'impact-measurement'); ?></label>
                                </div>
                                <div>
                                    <input type="radio" id="1h" name="rating" value="1">
                                    <label for="1h"><?php _e('No', 'impact-measurement'); ?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </form>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <div class="row im-formdata-submit">
        <div class="col-12 marginT1">
            <button type="button" id="formdata-submit" class="btn btn-block btn-secondary" disabled><?php _e('Send', 'impact-measurement'); ?></button>
        </div>
    </div>
    <div class="feedback-message">
        <?php if ( $im_config['survey'] ) : ?>
            <div class="alert alert-success im-survey" role="alert">
                <?php _e('Thanks for your feedback!', 'impact-measurement'); ?><br />
                <?php _e('You can help us further by answering other questions. You will not spend more than 3 minutes.', 'impact-measurement'); ?><br />
                <a href="<?php echo $im_config['survey']; ?>" target="_blank"><?php _e('Click here to access the survey', 'impact-measurement'); ?></a>
            </div>
        <?php else : ?>
            <div class="alert alert-success im-survey" role="alert">
                <form action="<?php echo IMPACT_MEASUREMENT_URL; ?>/survey/" id="surveyForm" class="mejs-button" target="_blank">
                    <input type="hidden" name="code" value="<?php echo $response['objects'][0]['code']; ?>">
                    <input type="hidden" name="user" value="<?php echo $user; ?>">
                    <input type="hidden" name="myvhl_user" value="<?php echo $myvhl_user; ?>">
                    <input type="hidden" name="page" value="<?php echo base64_encode(wp_get_referer()); ?>">
                    <input type="hidden" name="page_type" value="<?php echo $page_type; ?>">
                    <input type="hidden" name="page_type_slug" value="<?php echo $page_type_slug; ?>">

                    <?php _e('Thanks for your feedback!', 'impact-measurement'); ?><br />
                    <?php _e('You can help us further by answering other questions. You will not spend more than 3 minutes.', 'impact-measurement'); ?><br />
                    
                    <button type="submit" id="survey-submit" class="btn btn-block btn-success"><?php _e('Click here to access the survey', 'impact-measurement'); ?></button>
                </form>
            </div>
        <?php endif; ?>

        <?php if ( $im_config['survey'] ) : ?>
            <div class="alert alert-success result-ok" role="alert">
                <?php _e('Thanks for your feedback!', 'impact-measurement'); ?><br />
                <?php _e('You can help us further by answering other questions. You will not spend more than 3 minutes.', 'impact-measurement'); ?><br />
                <a href="<?php echo $im_config['survey']; ?>" target="_blank"><?php _e('Click here to access the survey', 'impact-measurement'); ?></a>
            </div>
        <?php else : ?>
            <div class="alert alert-success result-ok" role="alert">
                <?php _e('Thanks for your feedback!', 'impact-measurement'); ?>
            </div>
        <?php endif; ?>

        <div class="alert alert-warning result-error" role="alert">
            <?php _e('Communication problem.', 'impact-measurement'); ?>
            <br />
            <?php _e('Please try again later.', 'impact-measurement'); ?>
        </div>
    </div>
</div>

<?php else : ?>

<div id="conteudoFeedback">
    <div class="im-error text-center">
        <div class="alert alert-secondary" role="alert">
            <?php _e('No search currently found for this page.', 'impact-measurement'); ?>
        </div>
    </div>
</div>

<?php endif; ?>
