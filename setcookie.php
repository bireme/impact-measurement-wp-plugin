<?php
/*
    if ( isset($_GET['im_cookie']) && isset($_GET['im_code']) && isset($_GET['im_api']) ) {
        $request = base64_decode($_GET['im_api']);
        $content = file_get_contents($request.$_GET['im_code']);
        $response = json_decode($content, true);

        if ( $response && count($response['objects']) > 0 ) {
            setcookie("impact_measurement", $_GET['im_cookie'], (time() + (10 * 365 * 24 * 60 * 60)), '/');
        }
    }
*/
?>