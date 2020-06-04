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
		    'wp-unknown' => 'Unknown',
		    'wp-plugin-search' => 'Search',
		    'wp-plugin-document' => 'Document'
		);

	    if ( $wp_query->is_page ) {
	        $type = ( is_front_page() ) ? 'wp-home' : 'wp-document';
	    } elseif ( $wp_query->is_home ) {
	        $type = 'wp-home';
	    } elseif ( $wp_query->is_single ) {
	        $type = ( $wp_query->is_attachment ) ? 'wp-attachment' : 'wp-document';
	    } elseif ( $wp_query->is_category || $wp_query->is_tag || $wp_query->is_tax || $wp_query->is_archive || $wp_query->is_search ) {
	        $type = 'wp-search';
	    } elseif ( function_exists('is_plugin') && is_plugin() ) {
			$type = is_plugin();
	    } elseif ( $wp_query->is_404 ) {
	        $type = 'wp-404';
	    }

	    $page = ( $slug ) ? $type : $pages[$type];
	    return $page;

	}

}

?>