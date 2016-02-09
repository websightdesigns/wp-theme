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

// remove divi builder styles
function wp_theme_remove_divi_builder_styles() {
	$styles = array(
		'et-builder-modules-style',
		'magnific-popup',
	);
	// wp_dequeue_script( $styles );

	wp_dequeue_style( 'et-builder-modules-style' );
	wp_dequeue_style( 'magnific-popup' );

}
add_action( 'wp_enqueue_scripts', 'wp_theme_remove_divi_builder_styles', 100 );
