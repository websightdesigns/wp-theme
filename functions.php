<?php
/**
 * WordPress Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress_Theme
 */

/**
 * ######################################
 * #              FEATURES              #
 * ######################################
 */

if ( ! function_exists( 'wptheme_theme_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function wptheme_theme_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on WordPress Theme, use a find and replace
	 * to change 'wp-theme' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'wp-theme', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'wp-theme' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'wptheme_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'wptheme_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wptheme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'wptheme_content_width', 640 );
}
add_action( 'after_setup_theme', 'wptheme_content_width', 0 );

/**
 * ######################################
 * #              WIDGETS               #
 * ######################################
 */

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wptheme_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'wp-theme' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'wptheme_widgets_init' );

/**
 * ######################################
 * #              ENQUEUE               #
 * ######################################
 */

/**
 * Enqueue scripts and styles.
 */
function wptheme_scripts() {
	// styles
	wp_enqueue_style( 'style', '/style.css' );

	// scripts
	if( !is_admin()){
		wp_deregister_script('jquery');
	}
	wp_enqueue_script( 'script', '/js/script.js', array(), '1.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wptheme_scripts' );

/**
 * ######################################
 * #              INCLUDES              #
 * ######################################
 */

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * ######################################
 * #              SECURITY              #
 * ######################################
 */

/**
 * Disable XMLRPC
 */
add_filter( 'xmlrpc_enabled', '__return_false' );

/**
 * Disable the XMLRPC HTTP Header
 */
add_filter( 'wp_headers', 'wptheme_disable_xmlrpc' );
function wptheme_disable_xmlrpc( $headers ) {
	unset( $headers['X-Pingback'] );
	return $headers;
}

/**
 * Disable the JSON REST API
 */
add_filter('json_enabled', '__return_false');
add_filter('json_jsonp_enabled', '__return_false');

/**
 * Remove pingback link from document head
 */
remove_action( 'wp_head', 'rsd_link' );

/**
 * Remove manifest link
 */
remove_action( 'wp_head', 'wlwmanifest_link' );

/**
 * Remove the relational link for the first post
 */
remove_action('wp_head', 'start_post_rel_link', 10, 0 );

/**
 * Remove the relational link for the parent post
 */
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0  );

/**
 * Remove previous and next links
 */
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head');

/**
 * Remove meta name generator
 */
remove_action( 'wp_head', 'wp_generator' );

/**
 * Remove shortlink
 */
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

/**
 * Remove rest api output to wp_head()
 */
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );

/**
 * Remove feed link
 */
remove_action( 'wp_head', 'feed_links', 2 );

/**
 * Remove comments feed link
 */
remove_action( 'wp_head', 'feed_links_extra', 3 );

/**
 * Remove the relational link to the site index
 */
remove_action('wp_head', 'index_rel_link');

/**
 * Remove the version query string from js and css
 */
add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );
function _remove_script_version( $src ){
	$parts = explode( '?ver', $src );
	return $parts[0];
}

/**
 * Load the copy of jQuery that comes with WordPress at the bottom of the <body> tag
 */
add_action('init', 'wptheme_jquery_init');
function wptheme_jquery_init() {
    if ( !is_admin() ) {
        wp_deregister_script('jquery');

        // The last parameter set to TRUE states that it should be loaded
        // in the footer.
        wp_register_script('jquery', '/jquery.js', false, '1.11.0', true);

        wp_enqueue_script('jquery');
    }
}

/**
 * Disable emojis
 */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

/**
 * Disable comments on pages, but not posts
 */
add_filter( 'comments_template', 'wptheme_disable_comments_on_pages', 11 );
function wptheme_disable_comments_on_pages( $file ) {
	return is_page() ? __FILE__ : $file;
}

/**
 * Hide the admin bar
 */
add_filter('show_admin_bar', '__return_false');

/**
 * remove _admin_bar_bump_cb() from wp_head()
 * removes the margin-top added to the html element
 */
add_action('get_header', 'wptheme_filter_head');
function wptheme_filter_head() {
	remove_action('wp_head', '_admin_bar_bump_cb');
}

/**
 * Disable REST API oEmbed auto discovery
 */
add_action('init', 'wptheme_disable_embeds_init', 9999);
function wptheme_disable_embeds_init() {

    // Remove the REST API endpoint.
    remove_action('rest_api_init', 'wp_oembed_register_route');

    // Turn off oEmbed auto discovery.
    // Don't filter oEmbed results.
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);

    // Remove oEmbed discovery links.
    remove_action('wp_head', 'wp_oembed_add_discovery_links');

    // Remove oEmbed-specific JavaScript from the front-end and back-end.
    remove_action('wp_head', 'wp_oembed_add_host_js');
}

/**
 * ######################################
 * #             PERMALINKS             #
 * ######################################
 */

/**
 * Custom URL for the WordPress admin
 */
define('WP_ADMIN_DIR', 'site-admin');
define( 'ADMIN_COOKIE_PATH', SITECOOKIEPATH . WP_ADMIN_DIR);

/**
 * Change the wp-admin URL
 */
add_filter('site_url', 'wpadmin_filter', 10, 3);
function wpadmin_filter( $url, $path, $orig_scheme ) {
	$old  = array( "/(wp-admin)/");
	$admin_dir = WP_ADMIN_DIR;
	$new  = array($admin_dir);
	$result = preg_replace( $old, $new, $url, 1);
	return $result;
}

/**
 * Rewrite theme directory paths in .htaccess
 */
add_action('generate_rewrite_rules', 'themes_dir_add_rewrites');
function themes_dir_add_rewrites() {
	$theme_parts = explode( '/themes/', get_stylesheet_directory() );
	$theme_name = $theme_parts[1];
	global $wp_rewrite;
	$new_non_wp_rules = array(
		'css/(.*)'              => 'wp-content/themes/'. $theme_name . '/css/$1',
		'js/(.*)'               => 'wp-content/themes/'. $theme_name . '/js/$1',
		'scripts/(.*)'          => 'wp-content/themes/'. $theme_name . '/scripts/$1',
		'images/(.*)'           => 'wp-content/themes/'. $theme_name . '/images/$1',
		'fonts/(.*)'            => 'wp-content/themes/'. $theme_name . '/fonts/$1',
		'style.css'             => 'wp-content/themes/'. $theme_name . '/style.css',
		'favicon.ico'           => 'wp-content/themes/'. $theme_name . '/favicon.ico',
		'jquery.js'             => 'wp-includes/js/jquery/jquery.js',
		'site-admin/index.php$' => 'site-admin/ [R=301,L]',
		'site-admin/(.*)'       => 'wp-admin/$1',
	);
	$wp_rewrite->non_wp_rules += $new_non_wp_rules;
}

/**
 * Modify rewrite rules
 */
add_filter('mod_rewrite_rules', 'mod_rewrite_rules');
function mod_rewrite_rules($rules) {
	global $wp_rewrite;
	$rules = str_replace("[R=301,L] [QSA,L]", "[R=301,L]", $rules);
	return $rules;
}

/**
 * Flush rewrite rules
 */
add_action('admin_init', 'wptheme_flush_rewrites');
function wptheme_flush_rewrites() {
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}

/* ******************************************************************** */
/*                      BOOTSTRAP CUSTOMIZATIONS                        */
/* ******************************************************************** */

/**
 * Add the bootstrap menu navwalker
 */
require_once('wp_bootstrap_navwalker.php');

/**
 * Add 'active' class to active menu list item
 */
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
if ( ! function_exists( 'special_nav_class' ) ) :
	function special_nav_class($classes, $item){
		if( in_array('current-menu-item', $classes) ){
			$classes[] = 'active ';
		}
		return $classes;
	}
endif;

/**
 * Remove the automatic '<p>' tags around '<button>' tags
 */
add_filter('the_content', 'filter_ptags_on_buttons');
if ( ! function_exists( 'filter_ptags_on_buttons' ) ) :
	function filter_ptags_on_buttons($content) {
		$content = str_ireplace('</button></p>', '</button>', $content);
		return str_ireplace('<p><button', '<button', $content);
	}
endif;

/**
 * Remove unwanted '<br>' tags from inside of '<form>' tags
 */
add_filter('the_content', 'remove_bad_br_tags');
if ( ! function_exists( 'remove_bad_br_tags' ) ) :
	function remove_bad_br_tags($content) {
		$content = str_ireplace("</label>\n<br />", "</label>", $content);
		$content = str_ireplace("</label><br />", "</label>", $content);
		$content = str_ireplace("</button>\n<br />", "</button>", $content);
		$content = str_ireplace("</button><br />", "</button>", $content);
		return $content;
	}
endif;

/**
 * ######################################
 * #               OUTPUT               #
 * ######################################
 */

/**
* Filter the separator for the document title.
*
* @since 4.4.0
*
* @param string $sep Document title separator. Default '-'.
*/
add_filter('document_title_separator', 'wptheme_document_title_separator', 10);
function wptheme_document_title_separator($sep){
    // change separator
    $sep = '|';
    return $sep;
}

/*
 * Change the search URL to pretty format
 */
add_action( 'template_redirect', 'customtheme_change_search_url_rewrite' );
function customtheme_change_search_url_rewrite() {
	if ( get_option('permalink_structure') != '' && is_search() && ! empty( $_GET['s'] ) ) {
		wp_redirect( home_url( "/search/" ) . urlencode( get_query_var( 's' ) ) );
		exit();
	}
}

/*
 * Show no posts on empty search
 */
add_filter('pre_get_posts','customtheme_search_filter');
function customtheme_search_filter($query) {
	// If 's' request variable is set but empty
	if (isset($_GET['s']) && empty($_GET['s']) && $query->is_main_query()){
		$query->is_search = true;
		$query->is_home = false;
	}
	return $query;
}

/**
 * Minify HTML Output
 */
$minify = false;
if($minify) {
	class WP_HTML_Compression {
	    // Settings
	    protected $compress_css = true;
	    protected $compress_js = true;
	    protected $info_comment = true;
	    protected $remove_comments = true;

	    // Variables
	    protected $html;
	    public function __construct($html) {
	        if (!empty($html)) {
	            $this->parseHTML($html);
	        }
	    }
	    public function __toString() {
	        return $this->html;
	    }
	    protected function minifyHTML($html) {
	        $pattern = '/<(?<script>script).*?<\/script\s*>|<(?<style>style).*?<\/style\s*>|<!(?<comment>--).*?-->|<(?<tag>[\/\w.:-]*)(?:".*?"|\'.*?\'|[^\'">]+)*>|(?<text>((<[^!\/\w.:-])?[^<]*)+)|/si';
	        preg_match_all($pattern, $html, $matches, PREG_SET_ORDER);
	        $overriding = false;
	        $raw_tag = false;
	        // Variable reused for output
	        $html = '';
	        foreach ($matches as $token) {
	            $tag = (isset($token['tag'])) ? strtolower($token['tag']) : null;

	            $content = $token[0];

	            if (is_null($tag)) {
	                if ( !empty($token['script']) ) {
	                    $strip = $this->compress_js;
	                } else if ( !empty($token['style']) ) {
	                    $strip = $this->compress_css;
	                } else if ($content == '<!--wp-html-compression no compression-->') {
	                    $overriding = !$overriding;

	                    // Don't print the comment
	                    continue;
	                } else if ($this->remove_comments) {
	                    if (!$overriding && $raw_tag != 'textarea') {
	                        // Remove any HTML comments, except MSIE conditional comments
	                        $content = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $content);
	                    }
	                }
	            } else {
	                if ($tag == 'pre' || $tag == 'textarea') {
	                    $raw_tag = $tag;
	                } else if ($tag == '/pre' || $tag == '/textarea') {
	                    $raw_tag = false;
	                } else {
	                    if ($raw_tag || $overriding) {
	                        $strip = false;
	                    } else {
	                        $strip = true;

	                        // Remove any empty attributes, except:
	                        // action, alt, content, src
	                        $content = preg_replace('/(\s+)(\w++(?<!\baction|\balt|\bcontent|\bsrc)="")/', '$1', $content);

	                        // Remove any space before the end of self-closing XHTML tags
	                        // JavaScript excluded
	                        $content = str_replace(' />', '/>', $content);
	                    }
	                }
	            }

	            if ($strip) {
	                $content = $this->removeWhiteSpace($content);
	            }

	            $html .= $content;
	        }

	        return $html;
	    }

	    public function parseHTML($html) {
	        $this->html = $this->minifyHTML($html);
	    }

	    protected function removeWhiteSpace($str) {
	        $str = str_replace("\t", ' ', $str);
	        $str = str_replace("\n",  '', $str);
	        $str = str_replace("\r",  '', $str);

	        while (stristr($str, '  ')) {
	            $str = str_replace('  ', ' ', $str);
	        }

	        return $str;
	    }
	}

	function wp_html_compression_finish($html) {
	    return new WP_HTML_Compression($html);
	}

	function wp_html_compression_start() {
	    ob_start( 'wp_html_compression_finish' );
	}
	add_action( 'get_header', 'wp_html_compression_start' );
}
