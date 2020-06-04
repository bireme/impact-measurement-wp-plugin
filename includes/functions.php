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

if ( ! function_exists('is_plugin') ) {
    function is_plugin() {
        global $wp, $lis_plugin_slug, $direve_plugin_slug, $biblio_plugin_slug, $oer_plugin_slug, $leisref_plugin_slug, $mm_plugin_slug, $ths_plugin_slug;
        $pos_slug = false;
        $type = false;

        $lis_pos_slug     = strpos($wp->request, $lis_plugin_slug);     // LIS
        $direve_pos_slug  = strpos($wp->request, $direve_plugin_slug);  // DirEve
        $biblio_pos_slug  = strpos($wp->request, $biblio_plugin_slug);  // Bibliographic
        $oer_pos_slug     = strpos($wp->request, $oer_plugin_slug);     // Open Educational Resource
        $leisref_pos_slug = strpos($wp->request, $leisref_plugin_slug); // LeisRef 
        $mm_pos_slug      = strpos($wp->request, $mm_plugin_slug);      // FI-Multimedia
        $ths_pos_slug     = strpos($wp->request, $ths_plugin_slug);     // Thesaurus

        if ( $lis_pos_slug !== false ){
            $slug     = $lis_plugin_slug;
            $pos_slug = $lis_pos_slug;
            $pagename = substr($wp->request, $pos_slug);
        } elseif ( $direve_pos_slug !== false ){
            $slug     = $direve_plugin_slug;
            $pos_slug = $direve_pos_slug;
            $pagename = substr($wp->request, $pos_slug);
        } elseif ( $biblio_pos_slug !== false ){
            $slug     = $biblio_plugin_slug;
            $pos_slug = $biblio_pos_slug;
            $pagename = substr($wp->request, $pos_slug);
        } elseif ( $oer_pos_slug !== false ){
            $slug     = $oer_plugin_slug;
            $pos_slug = $oer_pos_slug;
            $pagename = substr($wp->request, $pos_slug);
        } elseif ( $leisref_pos_slug !== false ){
            $slug     = $leisref_plugin_slug;
            $pos_slug = $leisref_pos_slug;
            $pagename = substr($wp->request, $pos_slug);
        } elseif ( $mm_pos_slug !== false ){
            $slug     = $mm_plugin_slug;
            $pos_slug = $mm_pos_slug;
            $pagename = substr($wp->request, $pos_slug);
        } elseif ( $ths_pos_slug !== false ){
            $slug     = $ths_plugin_slug;
            $pos_slug = $ths_pos_slug;
            $pagename = substr($wp->request, $pos_slug);
        }

        if ( is_404() && $pos_slug !== false ){
            if ($pagename == $slug || $pagename == $slug . '/resource') {
                if ($pagename == $slug) {
                    $type = 'wp-plugin-search';
                } else {
                    $type = 'wp-plugin-document';
                }
            }
        }

        return $type;
    }
}

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
        } elseif ( is_plugin() ) {
            $type = is_plugin();
        } elseif ( $wp_query->is_404 ) {
            $type = 'wp-404';
        }

        $page = ( $slug ) ? $type : $pages[$type];
        return $page;
    }
}

?>