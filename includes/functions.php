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

	function get_page_type() {

		global $wp_query;
	    $loop = 'Unknown';

	    if ( $wp_query->is_page ) {
	        $loop = is_front_page() ? 'Home' : 'Post';
	    } elseif ( $wp_query->is_home ) {
	        $loop = 'Home';
	    } elseif ( $wp_query->is_single ) {
	        $loop = ( $wp_query->is_attachment ) ? 'Attachment' : 'Post';
	    } elseif ( $wp_query->is_category ) {
	        $loop = 'Search';
	    } elseif ( $wp_query->is_tag ) {
	        $loop = 'Search';
	    } elseif ( $wp_query->is_tax ) {
	        $loop = 'Search';
	    } elseif ( $wp_query->is_archive ) {
	        if ( $wp_query->is_day ) {
	            $loop = 'Search';
	        } elseif ( $wp_query->is_month ) {
	            $loop = 'Search';
	        } elseif ( $wp_query->is_year ) {
	            $loop = 'Search';
	        } elseif ( $wp_query->is_author ) {
	            $loop = 'Search';
	        } else {
	            $loop = 'Search';
	        }
	    } elseif ( $wp_query->is_search ) {
	        $loop = 'Search';
	    } elseif ( $wp_query->is_404 ) {
	        $loop = '404';
	    }

	    return $loop;

	}

}

?>