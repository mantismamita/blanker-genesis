<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Even Blanker Genesis' );
define( 'CHILD_THEME_URL', 'http://www.studiopress.com/' );
define( 'CHILD_THEME_VERSION', '2.2.2' );

//* Enqueue Google Fonts
add_action( 'wp_enqueue_scripts', 'genesis_sample_google_fonts' );
function genesis_sample_google_fonts() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:300,400,700', array(), CHILD_THEME_VERSION );

}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add Accessibility support
add_theme_support( 'genesis-accessibility', array( 'headings', 'drop-down-menu',  'search-form', 'skip-links', 'rems' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

add_action( 'wp_enqueue_scripts', 'kc_enqueue_script' );
function kc_enqueue_script() {
	wp_enqueue_script( 'main-scripts', get_bloginfo( 'stylesheet_directory' ) . '/js/scripts.js', array( 'jquery' ), '1.0.0' );
}

//* Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header_right', 'genesis_do_nav', 1 );

//* Remove entry content from genesis loop

add_action( 'get_header', 'remove_titles_blog_page' );
function remove_titles_blog_page() {
	if ( is_home() && is_front_page() ) {
		remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
	}
}