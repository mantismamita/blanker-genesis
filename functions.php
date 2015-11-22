<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Even Blanker Genesis' );
define( 'CHILD_THEME_URL', 'http://www.studiopress.com/' );
define( 'CHILD_THEME_VERSION', '2.2.3.1' );

//* Enqueue Google Fonts
add_action( 'wp_enqueue_scripts', 'genesis_sample_google_fonts' );
function genesis_sample_google_fonts() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:300,400,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css', array(), CHILD_THEME_VERSION );

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

//* Changes wording
add_filter( 'genesis_post_meta', 'kc_entry_meta_filter' );
//add_filter( 'genesis_post_meta', 'kc_entry_meta_labels' );

function kc_entry_meta_filter( $post_meta ) {
	$post_meta = '[post_categories sep="" before="Categories: "][post_tags sep="" before="Tags: "]';
	return $post_meta;
}
function kc_entry_meta_labels( $post_meta ) {
	$post_meta = '[post_categories "][post_tags ]';
	return $post_meta;
}

add_filter( 'genesis_post_info', 'post_info_filter' );
function post_info_filter($post_info) {
	if ( !is_page() ) {
		$post_info = '[post_date] by [post_author_posts_link] [post_comments zero=" Comment " one=" 1 " more=" % "]';
		return $post_info;
	}}


//add_filter( 'genesis_post_comments_shortcode', 'prefix_post_comments_shortcode' );
/**
 * Amend the post comments shortcode to add extra markup for styling.
 *
 * @author Gary Jones
 * @link   http://gamajo.com/style-comment-number/
 *
 * @param string $output HTML markup.
 *
 * @return string HTML markup.
 */
function prefix_post_comments_shortcode( $output ) {
	return preg_replace( '/#comments"\>(\d+) Comment/', '#comments"><span class="entry-comments-number">$1</span> Comment', $output );
}