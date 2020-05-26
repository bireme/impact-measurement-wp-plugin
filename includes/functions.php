<?php

/**
 * Register all generic functions for the plugin
 *
 * @link       http://reddes.bvsalud.org/
 * @since      1.0.0
 *
 * @package    Impact_Measurement
 * @subpackage Impact_Measurement/includes
 */

if ( ! function_exists('get_page_type') ) {

	function get_page_type($slug=false) {

		global $wp_query;
	    $type = 'wp-unknown';

	    $pages = array(
		    'wp-home' => 'Home',
		    'wp-document' => 'Document',
		    'wp-search' => 'Search',
		    'wp-attachment' => 'Attachment',
		    'wp-404' => '404',
		    'wp-unknown' => 'Unknown'
		);

	    if ( $wp_query->is_page ) {
	        $type = is_front_page() ? 'wp-home' : 'wp-document';
	    } elseif ( $wp_query->is_home ) {
	        $type = 'wp-home';
	    } elseif ( $wp_query->is_single ) {
	        $type = ( $wp_query->is_attachment ) ? 'wp-attachment' : 'wp-document';
	    } elseif ( $wp_query->is_category ) {
	        $type = 'wp-search';
	    } elseif ( $wp_query->is_tag ) {
	        $type = 'wp-search';
	    } elseif ( $wp_query->is_tax ) {
	        $type = 'wp-search';
	    } elseif ( $wp_query->is_archive ) {
	        if ( $wp_query->is_day ) {
	            $type = 'wp-search';
	        } elseif ( $wp_query->is_month ) {
	            $type = 'wp-search';
	        } elseif ( $wp_query->is_year ) {
	            $type = 'wp-search';
	        } elseif ( $wp_query->is_author ) {
	            $type = 'wp-search';
	        } else {
	            $type = 'wp-search';
	        }
	    } elseif ( $wp_query->is_search ) {
	        $type = 'wp-search';
	    } elseif ( $wp_query->is_404 ) {
	        $type = 'wp-404';
	    }

	    $page = ( $slug ) ? $type : $pages[$type];
	    return $page;

	}

}

?>