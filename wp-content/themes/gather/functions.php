<?php
  
// Load main options panel file  
if ( !function_exists( 'optionsframework_init' ) ) {
	define('OPTIONS_FRAMEWORK_URL', TEMPLATEPATH . '/admin/');
	define('OPTIONS_FRAMEWORK_DIRECTORY', get_bloginfo('template_directory') . '/admin/');
	require_once (OPTIONS_FRAMEWORK_URL . 'options-framework.php');
}
// for customizer
require_once (TEMPLATEPATH . '/options.php');



// Enable translation
// Translations can be put in the /languages/ directory
load_theme_textdomain( 'themetrust', TEMPLATEPATH . '/languages' );

// Widgets
require_once (TEMPLATEPATH . '/admin/widgets.php');



// Mobile device detection
if( !function_exists('mobile_user_agent_switch') ){
	function is_mobile(){
		$device = '';
 
		if( stristr($_SERVER['HTTP_USER_AGENT'],'ipad') ) {
			$device = "ipad";
		} else if( stristr($_SERVER['HTTP_USER_AGENT'],'iphone') || strstr($_SERVER['HTTP_USER_AGENT'],'iphone') ) {
			$device = "iphone";
		} else if( stristr($_SERVER['HTTP_USER_AGENT'],'blackberry') ) {
			$device = "blackberry";
		} else if( stristr($_SERVER['HTTP_USER_AGENT'],'android') ) {
			$device = "android";
		}
 
		if( $device ) {
			return $device; 
		} return false; {
			return false;
		}
	}
}

//////////////////////////////////////////////////////////////
// Theme Header
/////////////////////////////////////////////////////////////
	
add_action('wp_enqueue_scripts', 'ttrust_scripts');

function ttrust_scripts() {	
	
	wp_enqueue_script('jquery');
	
	wp_enqueue_script('superfish', get_bloginfo('template_url').'/js/superfish.js', array('jquery'), '1.4.8', true);
	wp_enqueue_style('superfish', get_bloginfo('template_url').'/css/superfish.css', false, '1.4.8', 'all' );
	wp_enqueue_style('woocommerce', get_bloginfo('template_url').'/css/woocommerce.css', false, '1', 'all' );
	
	
	if(is_active_widget(false,'','ttrust_flickr')) :	
    	wp_enqueue_script('flickrfeed', get_bloginfo('template_url').'/js/jflickrfeed.js', array('jquery'), '0.8', true);
	endif;
	
	if(is_active_widget(false,'','ttrust_twitter')) :	
    	wp_enqueue_script('jquery_twitter', get_bloginfo('template_url').'/js/jquery.twitter.js', array('jquery'), '1.5', true);
	endif;
	
	wp_enqueue_script('fitvids', get_bloginfo('template_url').'/js/jquery.fitvids.js', array('jquery'), '1.0', true);
	
	wp_enqueue_script('isotope', get_bloginfo('template_url').'/js/jquery.isotope.min.js', array('jquery'), '1.3.110525', true);	
	
	wp_enqueue_style('slideshow', get_bloginfo('template_url').'/css/flexslider.css', false, '1.8', 'all' );
	wp_enqueue_script('slideshow', get_bloginfo('template_url').'/js/jquery.flexslider-min.js', array('jquery'), '1.8', true);	
	
	wp_enqueue_script('theme_trust_js', get_bloginfo('template_url').'/js/theme_trust.js', array('jquery'), '1.0', true);	
	
}

add_action('wp_head','ttrust_theme_head');

function ttrust_theme_head() { ?>
<meta name="generator" content="<?php global $ttrust_theme, $ttrust_version; echo $ttrust_theme.' '.$ttrust_version; ?>" />

<style type="text/css" media="screen">

<?php $heading_font = of_get_option('ttrust_heading_font'); ?>
<?php $body_font = of_get_option('ttrust_body_font'); ?>
<?php $home_message_font = of_get_option('ttrust_home_message_font'); ?>
<?php if ($heading_font) : ?>
	h1, h2, h3, h4, h5, h6 { font-family: '<?php echo $heading_font; ?>'; }
<?php endif; ?>

<?php if ($body_font) : ?>
	body { font-family: '<?php echo $body_font; ?>'; }
<?php endif; ?>

<?php if ($home_message_font) : ?>
	#homeMessage p { font-family: '<?php echo $home_message_font; ?>'; }
<?php endif; ?>

<?php if(of_get_option('ttrust_color_accent')) : ?>
	.flex-caption h2 {background: <?php echo(of_get_option('ttrust_color_accent')); ?>!important;}
	
	#homeSlideshow .preloading span {background: <?php echo(of_get_option('ttrust_color_accent')); ?>;}
	#fancybox-close:hover {background: <?php echo(of_get_option('ttrust_color_accent')); ?>;}
	span.onsale {background: <?php echo(of_get_option('ttrust_color_accent')); ?>;}
	.product .price	{color: <?php echo(of_get_option('ttrust_color_accent')); ?> !important;}
<?php endif; ?>

<?php if(of_get_option('ttrust_color_menu')) : ?>#header .inside .top p, .sf-menu a, #mainNav ul a, .sf-menu li.sfHover ul a, #mainNav ul li.sfHover ul a { color: <?php echo(of_get_option('ttrust_color_menu')); ?> !important;	}<?php endif; ?>

<?php if(of_get_option('ttrust_color_header')) : ?>
	#header, #mainNav ul ul { background-color: <?php echo(of_get_option('ttrust_color_header')); ?> !important;	}
<?php endif; ?>

<?php if(of_get_option('ttrust_color_menu_hover')) : ?>
	#mainNav ul li.current a,
	#mainNav ul li.current-cat a,
	#mainNav ul li.current_page_item a,
	#mainNav ul li.current-menu-item a,
	#mainNav ul li.current-post-ancestor a,	
	.single-post #mainNav ul li.current_page_parent a,
	#mainNav ul li.current-category-parent a,
	#mainNav ul li.current-category-ancestor a,
	#mainNav ul li.current-portfolio-ancestor a,
	#mainNav ul li.current-projects-ancestor a {
		color: <?php echo(of_get_option('ttrust_color_menu_hover')); ?> !important;		
	}
	.sf-menu li a:hover,
	#mainNav ul li.sfHover a,
	#mainNav ul li a:hover,
	#mainNav ul li:hover {
		color: <?php echo(of_get_option('ttrust_color_menu_hover')); ?> !important;	
	}
	.sf-menu li.sfHover ul a:hover, #mainNav ul li.sfHover ul a:hover { color: <?php echo(of_get_option('ttrust_color_menu_hover')); ?> !important;}	
<?php endif; ?>

<?php if(of_get_option('ttrust_color_link')) : ?>a { color: <?php echo(of_get_option('ttrust_color_link')); ?>;}<?php endif; ?>

<?php if(of_get_option('ttrust_color_link_hover')) : ?>a:hover {color: <?php echo(of_get_option('ttrust_color_link_hover')); ?>;}<?php endif; ?>

<?php if(of_get_option('ttrust_color_btn')) : ?>a.button, .widget_price_filter .button, .cart .button, #searchsubmit, input[type="submit"], button {background-color: <?php echo(of_get_option('ttrust_color_btn')); ?> !important;}<?php endif; ?>

<?php if(of_get_option('ttrust_color_btn_hover')) : ?>.button:hover, .widget_price_filter .button:hover, .cart .button:hover, #searchsubmit:hover, input[type="submit"]:hover, button:hover {background-color: <?php echo(of_get_option('ttrust_color_btn_hover')); ?> !important;}<?php endif; ?>

<?php if ( is_archive() ): ?> html {height: 101%;} <?php endif; ?>
<?php echo(of_get_option('ttrust_custom_css')); ?>


</style>

<!--[if IE 7]>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/ie7.css" type="text/css" media="screen" />
<![endif]-->
<!--[if IE 8]>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/ie8.css" type="text/css" media="screen" />
<![endif]-->

<?php echo "\n".of_get_option('ttrust_analytics')."\n"; ?>

<?php }

add_action('init', 'remheadlink');
function remheadlink() {
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
}


//////////////////////////////////////////////////////////////
// Body Class
/////////////////////////////////////////////////////////////

function ttrust_body_classes($classes) {	
	
	$classes[] = of_get_option('ttrust_background');	
	return $classes;
}
add_filter('body_class','ttrust_body_classes');


//////////////////////////////////////////////////////////////
// Theme Footer
/////////////////////////////////////////////////////////////

add_action('wp_footer','ttrust_footer');

function ttrust_footer() {		
	wp_reset_query(); 	
	if(is_front_page()){
		if (of_get_option('ttrust_slideshow_enabled')) {	
			include(TEMPLATEPATH . '/js/slideshow.php');			
		}
		
	}elseif ( is_singular() ) {
		global $wp_query;
		global $post;
		
		if ( false !== strpos($post->post_content, '[slideshow') ) {	
			include(TEMPLATEPATH . '/js/slideshow.php');			
		}
	}	
}


//////////////////////////////////////////////////////////////
// Remove
/////////////////////////////////////////////////////////////

// #more from more-link
function ttrust_remove($content) {
	global $id;
	return str_replace('#more-'.$id.'"', '"', $content);
}
add_filter('the_content', 'ttrust_remove');


//////////////////////////////////////////////////////////////
// Custom Excerpt
/////////////////////////////////////////////////////////////

function excerpt_ellipsis($text) {
	return str_replace('[...]', '...', $text);
}
add_filter('the_excerpt', 'excerpt_ellipsis');

//////////////////////////////////////////////////////////////
// Custom Background Support
/////////////////////////////////////////////////////////////

add_theme_support( 'custom-background');


//////////////////////////////////////////////////////////////
// Get Meta Box Value
/////////////////////////////////////////////////////////////

function get_meta_box_value($m) {
	global $wp_query;
	global $post;
	$meta_box_value = get_post_meta($post->ID, $m, true);
	return $meta_box_value;
}

//////////////////////////////////////////////////////////////
// Pagination Styles
/////////////////////////////////////////////////////////////

add_action( 'wp_print_styles', 'ttrust_deregister_styles', 100 );
function ttrust_deregister_styles() {
	wp_deregister_style( 'wp-pagenavi' );
}
remove_action('wp_head', 'pagenavi_css');
remove_action('wp_print_styles', 'pagenavi_stylesheets');


//////////////////////////////////////////////////////////////
// Navigation Menus
/////////////////////////////////////////////////////////////

add_theme_support('menus');
register_nav_menu('main', 'Main Navigation Menu');
register_nav_menu('top', 'Top Menu');

function default_nav() {
	echo '<ul class="sf-menu clearfix" >';					
		wp_list_pages('sort_column=menu_order&title_li='); 
	echo '</ul>';
}


//////////////////////////////////////////////////////////////
// Feature Images (Post Thumbnails)
/////////////////////////////////////////////////////////////

add_theme_support('post-thumbnails');

set_post_thumbnail_size(100, 100, true);
add_image_size('ttrust_post_thumb_big', 720, 220, true);
add_image_size('ttrust_post_thumb_small', 150, 150, true);
add_image_size('ttrust_post_thumb_tiny', 50, 50, true);
add_image_size('ttrust_one_fourth_cropped', 220, 170, true);
add_image_size('ttrust_one_fourth_short', 220, 100, true);
add_image_size('ttrust_one_fourth', 220, 9999);
add_image_size('ttrust_slide_big', 940, 370, true);



//////////////////////////////////////////////////////////////
// Button Shortcode
/////////////////////////////////////////////////////////////

function ttrust_button($a) {
	extract(shortcode_atts(array(
		'label' 	=> 'Button Text',
		'id' 	=> '1',
		'url'	=> '',
		'target' => '_parent',		
		'size'	=> '',
		'ptag'	=> false
	), $a));
	
	$link = $url ? $url : get_permalink($id);	
	
	if($ptag) :
		return  wpautop('<a href="'.$link.'" target="'.$target.'" class="button '.$size.'">'.$label.'</a>');
	else :
		return '<a href="'.$link.'" target="'.$target.'" class="button '.$size.'">'.$label.'</a>';
	endif;
	
}

add_shortcode('button', 'ttrust_button');

//////////////////////////////////////////////////////////////
// Column Shortcodes
/////////////////////////////////////////////////////////////

function ttrust_one_third( $atts, $content = null ) {
   return '<div class="one_third">' . do_shortcode(wpautop($content)) . '</div>';
}
add_shortcode('one_third', 'ttrust_one_third');

function ttrust_one_third_last( $atts, $content = null ) {
   return '<div class="one_third last">' . do_shortcode(wpautop($content)) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_third_last', 'ttrust_one_third_last');

function ttrust_two_third( $atts, $content = null ) {
   return '<div class="two_third">' . do_shortcode(wpautop($content)) . '</div>';
}
add_shortcode('two_third', 'ttrust_two_third');

function ttrust_two_third_last( $atts, $content = null ) {
   return '<div class="two_third last">' . do_shortcode(wpautop($content)) . '</div><div class="clearboth"></div>';
}
add_shortcode('two_third_last', 'ttrust_two_third_last');

function ttrust_one_half( $atts, $content = null ) {
   return '<div class="one_half">' . do_shortcode(wpautop($content)) . '</div>';
}
add_shortcode('one_half', 'ttrust_one_half');

function ttrust_one_half_last( $atts, $content = null ) {
   return '<div class="one_half last">' . do_shortcode(wpautop($content)) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_half_last', 'ttrust_one_half_last');


//////////////////////////////////////////////////////////////
// Slideshow Shortcode
/////////////////////////////////////////////////////////////

function ttrust_slideshow( $atts, $content = null ) {
    $content = str_replace('<br />', '', $content);
	$content = str_replace('<img', '<li><img', $content);
	$content = str_replace('/>', '/></li>', $content);
	return '<div class="flexslider clearfix"><ul class="slides">' . $content . '</ul></div>';
}
add_shortcode('slideshow', 'ttrust_slideshow');

//////////////////////////////////////////////////////////////
// Elastic Video
/////////////////////////////////////////////////////////////

function ttrust_elasticVideo( $atts, $content = null ) {    
	return '<div class="videoContainer">' . $content . '</div>';
}
add_shortcode('elastic-video', 'ttrust_elasticVideo');

//////////////////////////////////////////////////////////////
// Add conainers to all videos
/////////////////////////////////////////////////////////////

function add_video_containers($content) { 
	$content = str_replace('<object', '<div class="videoContainer"><object', $content);
	$content = str_replace('</object>', '</object></div>', $content);
	
	$content = str_replace('<embed', '<div class="videoContainer"><embed', $content);
	$content = str_replace('</embed>', '</embed></div>', $content);
	
	$content = str_replace('<iframe', '<div class="videoContainer"><iframe', $content);
	$content = str_replace('</iframe>', '</iframe></div>', $content);
	
	return $content;
}

add_action('the_content', 'add_video_containers');  

//////////////////////////////////////////////////////////////
// Custom More Link
/////////////////////////////////////////////////////////////

function more_link() {
	global $post;	
	$more_link = '<p class="moreLink"><a href="'.get_permalink().'" title="'.get_the_title().'">';
	$more_link .= '<span>'.__('Read More', 'themetrust').'</span>';
	$more_link .= '</a></p>';
	echo $more_link;	
}

//////////////////////////////////////////////////////////////
// Custom Sanitize for Theme Options
/////////////////////////////////////////////////////////////

add_action('admin_init','optionscheck_change_santiziation', 100);
 

function optionscheck_change_santiziation() {
    remove_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );
    add_filter( 'of_sanitize_textarea', 'custom_sanitize_textarea' );
}
 
function custom_sanitize_textarea($input) {
    global $allowedposttags;
    
      $custom_allowedtags["script"] = array();
 
      $custom_allowedtags = array_merge($custom_allowedtags, $allowedposttags);
      $output = wp_kses( $input, $custom_allowedtags);
    return $output;
}


//////////////////////////////////////////////////////////////
// Custom Post Types and Custom Taxonamies
/////////////////////////////////////////////////////////////

add_action( 'init', 'create_post_types' );

function create_post_types() {
	
	$labels = array(
		'name' => __( 'Projects' ),
		'singular_name' => __( 'Project' ),
		'add_new' => __( 'Add New' ),
		'add_new_item' => __( 'Add New Project' ),
		'edit' => __( 'Edit' ),
		'edit_item' => __( 'Edit Project' ),
		'new_item' => __( 'New Project' ),
		'view' => __( 'View Project' ),
		'view_item' => __( 'View Project' ),
		'search_items' => __( 'Search Projects' ),
		'not_found' => __( 'No projects found' ),
		'not_found_in_trash' => __( 'No projects found in Trash' ),
		'parent' => __( 'Parent Project' ),
	);
	
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'menu_icon' => get_template_directory_uri(). '/images/blue-folder-stand.png', 
		'query_var' => true,		
		'rewrite' => array( 'slug' => 'project', 'hierarchical' => true, 'with_front' => false ),
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title', 'editor', 'thumbnail', 'comments', 'revisions', 'excerpt')
	); 	
	
	register_post_type( 'project' , $args );
	flush_rewrite_rules( false );
}

add_action( 'init', 'create_taxonomies' );
function create_taxonomies() {
	$labels = array(
    	'name' => __( 'Skills' ),
    	'singular_name' => __( 'Skill' ),
    	'search_items' =>  __( 'Search Skills' ),
    	'all_items' => __( 'All Skills' ),
    	'parent_item' => __( 'Parent Skill' ),
    	'parent_item_colon' => __( 'Parent Skill:' ),
    	'edit_item' => __( 'Edit Skill' ),
    	'update_item' => __( 'Update Skill' ),
    	'add_new_item' => __( 'Add New Skill' ),
    	'new_item_name' => __( 'New Skill Name' )
  	); 	

  	register_taxonomy('skill','project',array(
    	'hierarchical' => false,
    	'labels' => $labels
  	));
	flush_rewrite_rules( false );
}
// Add Portfolio  & Thumbnail to Admin Listing
add_action( 'manage_project_posts_custom_column' , 'custom_project_column', 10, 2 );

function set_project_columns($columns) {
    return array(
        'cb' => '<input type="checkbox" />',
		'title' => __('Title'),
        'thumbnail' => __('Thumbnail'),
		'skill' => __('Skill'),
        'author' => __('Author'),
        'date' => __('Date')
    );
}
add_filter('manage_project_posts_columns' , 'set_project_columns');

function set_custom_edit_project_columns($columns) {
    return $columns
         + array('skill' => __('Skill'));
         + array('thumbnail' => __('Thumbnail'));
}

function custom_project_column( $column, $post_id ) {
    switch ( $column ) {
      case 'skill':
        $terms = get_the_term_list( $post_id , 'skill' , '' , ',' , '' );
        if ( is_string( $terms ) ) {
            echo $terms;
        } else {
            echo 'Unable to get skill(s)';
        }
        break;
	  case 'thumbnail':
        $thumbnail = get_the_post_thumbnail($post->ID, array(70,70));
        if ( is_string( $thumbnail ) ) {
            echo $thumbnail;
        } else {
            echo 'Unable to get thumbnail(s)';
        }
        break;	
    }
}

// Slide post type
function register_slides() {
	register_post_type( 'slide',
		array(
			'labels' => array(
				'name' => __( 'Slides', 'themetrust'),
				'menu_name' => __( 'Slides', 'themetrust'),
				'singular_name' => __( 'Slide', 'themetrust'),
				'all_items' => __( 'All Slides', 'themetrust'),
		        'add_new' => __( 'Add New', 'themetrust' ),
				'add_new_item' => __( 'Add New Slide', 'themetrust' ),
				'edit_item' => __( 'Edit Slide', 'themetrust' ),
				'new_item' => __( 'New Slide', 'themetrust' ),
				'view_item' => __( 'View Slide', 'themetrust' ),
				'search_items' => __( 'Search Slides', 'themetrust' ),
				'not_found' => __( 'No slides found', 'themetrust' ),
				'not_found_in_trash' => __( 'No slides found in Trash', 'themetrust' )
			),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'menu_icon' => get_template_directory_uri(). '/images/image-empty.png', 
			'show_in_menu' => true,
			'show_in_nav_menus' => false,
			'menu_position ' => 20,
			'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
			'hierarchical' => false,
			'taxonomies' => array( 'section' ),
			'has_archive' => true,
			'rewrite' => 'slide'
		)
	);

}
add_action( 'init', 'register_slides' );


// List custom post type taxonomies

function ttrust_get_terms( $id = '' ) {
  global $post;

  if ( empty( $id ) )
    $id = $post->ID;

  if ( !empty( $id ) ) {
    $post_taxonomies = array();
    $post_type = get_post_type( $id );
    $taxonomies = get_object_taxonomies( $post_type , 'names' );

    foreach ( $taxonomies as $taxonomy ) {
      $term_links = array();
      $terms = get_the_terms( $id, $taxonomy );

      if ( is_wp_error( $terms ) )
        return $terms;

      if ( $terms ) {
        foreach ( $terms as $term ) {
          $link = get_term_link( $term, $taxonomy );
          if ( is_wp_error( $link ) )
            return $link;
          $term_links[] = '<li><span><a href="'.$link.'">' . $term->name . '</a></span></li>';
        }
      }

      $term_links = apply_filters( "term_links-$taxonomy" , $term_links );
      $post_terms[$taxonomy] = $term_links;
    }
    return $post_terms;
  } else {
    return false;
  }
}

function ttrust_get_terms_list( $id = '' , $echo = true ) {
  global $post;

  if ( empty( $id ) )
    $id = $post->ID;

  if ( !empty( $id ) ) {
    $my_terms = ttrust_get_terms( $id );
    if ( $my_terms ) {
      $my_taxonomies = array();
      foreach ( $my_terms as $taxonomy => $terms ) {
        $my_taxonomy = get_taxonomy( $taxonomy );
        if ( !empty( $terms ) ) $my_taxonomies[] = implode( $terms);
      }

      if ( !empty( $my_taxonomies ) ) {
	    $output = "";
        foreach ( $my_taxonomies as $my_taxonomy ) {
          $output .= $my_taxonomy . "\n";
        }        
      }

      if ( $echo )
        if(isset($output)) echo $output;
      else
        if(isset($output)) return $output;
    } else {
      return;
    }
  } else {
    return false;
  }
}

//////////////////////////////////////////////////////////////
// Meta Box
/////////////////////////////////////////////////////////////

$prefix = "_ttrust_";

$project_details = array(		

		"url" => array(
    	"type" => "textfield",
		"name" => $prefix."url",
    	"std" => "",
    	"title" => __('URL','themetrust'),
    	"description" => __('Enter the URL of your project.','themetrust')),

		"url_label" => array(
		"type" => "textfield",
		"name" => $prefix."url_label",
		"std" => "",
		"title" => __('URL Label','themetrust'),
		"description" => __('Enter a label for the URL.','themetrust'))		
);

$page_options = array(	
		"description" => array(
    	"type" => "textarea",
		"name" => $prefix."page_description",
    	"std" => "",
    	"title" => __('Description','themetrust'),
    	"description" => __('Enter a description about this page.','themetrust'))		
);

$portfolio_options = array(	
		"page_skills" => array(
    	"type" => "textarea",
		"name" => $prefix."page_skills",
    	"std" => "",
    	"title" => __('Skills','themetrust'),
    	"description" => __('For use with the Portfolio page template. <br/><br/>Enter the names of the skills (separated by commas) you want shown on this page. If left blank, all skills will be used.','themetrust'))
);

$slide_options = array(	
		"description" => array(
    	"type" => "textarea",
		"name" => $prefix."slide_description",
    	"std" => "",
    	"title" => __('Description','themetrust'),
    	"description" => __('Enter a description about this slide.','themetrust')),

		"show_slide_text" => array(
		"type" => "checkbox",
		"name" => $prefix."show_slide_text",
		"std" => "",
		"title" => __('Show Text','themetrust'),
		"description" => __('Show title and description.','themetrust'))	
);


$meta_box_groups = array($project_details, $page_options, $portfolio_options, $slide_options);

function new_meta_box($post, $metabox) {	
	
	$meta_boxes_inputs = $metabox['args']['inputs'];

	foreach($meta_boxes_inputs as $meta_box) {
	
		$meta_box_value = get_post_meta($post->ID, $meta_box['name'].'_value', true);
		if($meta_box_value == "") $meta_box_value = $meta_box['std'];
		
		echo'<div class="meta-field">';
		
		echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
		
		echo'<p><strong>'.$meta_box['title'].'</strong></p>';
		
		if(isset($meta_box['type']) && $meta_box['type'] == 'checkbox') {
		
			if($meta_box_value == 'true') {
				$checked = "checked=\"checked\"";
			} elseif($meta_box['std'] == "true") {	
					$checked = "checked=\"checked\"";	
			} else {
					$checked = "";
			}
		
			echo'<p class="clearfix"><input type="checkbox" class="meta-radio" name="'.$meta_box['name'].'_value" id="'.$meta_box['name'].'_value" value="true" '.$checked.' /> ';		
			echo'<label for="'.$meta_box['name'].'_value">'.$meta_box['description'].'</label></p><br />';		
		
		} elseif(isset($meta_box['type']) && $meta_box['type'] == 'textarea')  {			
			
			echo'<textarea rows="4" style="width:98%" name="'.$meta_box['name'].'_value" id="'.$meta_box['name'].'_value">'.$meta_box_value.'</textarea><br />';			
			echo'<p><label for="'.$meta_box['name'].'_value">'.$meta_box['description'].'</label></p><br />';			
		
		} else {
			
			echo'<input style="width:70%"type="text" name="'.$meta_box['name'].'_value" id="'.$meta_box['name'].'_value" value="'.$meta_box_value.'" /><br />';		
			echo'<p><label for="'.$meta_box['name'].'_value">'.$meta_box['description'].'</label></p><br />';			
		
		}
		
		echo'</div>';
		
	} // end foreach
		
	echo'<br style="clear:both" />';
	
} // end meta boxes

function create_meta_box() {	
	global $project_details, $page_options, $portfolio_options, $slide_options;	
	
	if ( function_exists('add_meta_box') ) {
		add_meta_box( 'new-meta-boxes-details', __('Project Options','themetrust'), 'new_meta_box', 'project', 'normal', 'high', array('inputs'=>$project_details) );				
		add_meta_box( 'new-meta-boxes-page-options', __('Page Options','themetrust'), 'new_meta_box', 'page', 'side', 'low', array('inputs'=>$page_options) );	
		add_meta_box( 'new-meta-boxes-portfolio-options', __('Portfolio Options','themetrust'), 'new_meta_box', 'page', 'side', 'low', array('inputs'=>$portfolio_options) );
		add_meta_box( 'new-meta-boxes-slide-options', __('Slide Options','themetrust'), 'new_meta_box', 'slide', 'normal', 'high', array('inputs'=>$slide_options) );		
	}
}



function save_postdata( $post_id ) {
global $post, $new_meta_boxes, $meta_box_groups;

if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
	return $post_id;
}

if( defined('DOING_AJAX') && DOING_AJAX ) { //Prevents the metaboxes from being overwritten while quick editing.
	return $post_id;
}

if( preg_match('/\edit\.php/', $_SERVER['REQUEST_URI']) ) { //Detects if the save action is coming from a quick edit/batch edit.
	return $post_id;
}

foreach($meta_box_groups as $group) {
	foreach($group as $meta_box) {

		// Verify
		if(isset($_POST[$meta_box['name'].'_noncename'])){
			if ( !wp_verify_nonce( $_POST[$meta_box['name'].'_noncename'], plugin_basename(__FILE__) )) {
				return $post_id;
			}
		}

		if ( isset($_POST['post_type']) && 'page' == $_POST['post_type'] ) {
			if ( !current_user_can( 'edit_page', $post_id ))
				return $post_id;
		} else {
			if ( !current_user_can( 'edit_post', $post_id ))
				return $post_id;
		}

		$data = "";
		if(isset($_POST[$meta_box['name'].'_value'])){
			$data = $_POST[$meta_box['name'].'_value'];
		}


		if(get_post_meta($post_id, $meta_box['name'].'_value') == "") 
			add_post_meta($post_id, $meta_box['name'].'_value', $data, true);
		elseif($data != get_post_meta($post_id, $meta_box['name'].'_value', true))
			update_post_meta($post_id, $meta_box['name'].'_value', $data);
		elseif($data == "" )
			delete_post_meta($post_id, $meta_box['name'].'_value', get_post_meta($post_id, $meta_box['name'].'_value', true));
	
		} // end foreach
	} // end foreach
} // end save_postdata

add_action('admin_menu', 'create_meta_box');
add_action('save_post', 'save_postdata');

//////////////////////////////////////////////////////////////
// Comments
/////////////////////////////////////////////////////////////

function ttrust_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>		
	<li id="li-comment-<?php comment_ID() ?>">		
		
		<div class="comment <?php echo get_comment_type(); ?>" id="comment-<?php comment_ID() ?>">						
			
			<?php echo get_avatar($comment,'60',get_bloginfo('template_url').'/images/default_avatar.png'); ?>			
   	   			
   	   		<h5><?php comment_author_link(); ?></h5>
			<span class="date"><?php comment_date(); ?></span>
				
			<?php if ($comment->comment_approved == '0') : ?>
				<p><span class="message"><?php _e('Your comment is awaiting moderation.', 'themetrust'); ?></span></p>
			<?php endif; ?>
				
			<?php comment_text() ?>				
				
			<?php
			if(get_comment_type() != "trackback")
				comment_reply_link(array_merge( $args, array('add_below' => 'comment','reply_text' => '<span>'. __('Reply', 'themetrust') .'</span>', 'login_text' => '<span>'. __('Log in to reply', 'themetrust') .'</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'])))
			
			?>
				
		</div><!-- end comment -->
			
<?php
}

function ttrust_pings($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
		<li class="comment" id="comment-<?php comment_ID() ?>"><?php comment_author_link(); ?> - <?php comment_excerpt(); ?>
<?php
}



// for woocommerce
require_once (TEMPLATEPATH . '/woocommerce/woocommerce-template.php');
remove_action ( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );


// for practice (redirect to the other page)
function __my_login_redirect(){	
	//$location = $_SERVER['HTTP_REFERER'];
	//wp_safe_redirect($location);
	//exit();
	return home_url( '/index.php' );
}
add_filter( 'login_redirect', '__my_login_redirect' );


/**
 * 切換主選單的code
 * */
/*
function my_wp_nav_menu_args( $args = '' ) {
	if( is_user_logged_in() ) {
		$args['menu'] = 'LogInMenu';
	} else {
		$args['menu'] = 'Navigation';
	}
	return $args;
}
add_filter( 'wp_nav_menu_args', 'my_wp_nav_menu_args' );
*/


function my_after_setup_theme(){

}
//add_action('after_setup_theme', array($this, 'my_after_setup_theme'));



/**
 * 權限過濾器, 使用時要add_filter( 'template_include', 'nl_template_include' );
 * */
function nl_template_include( $template){
	// need to rewrite(fetch data from DB)
	// for auth
	define('FINAL_MEMBER', '會員頁面');
	define('FINAL_BKTCOURT', '熱門球場');
	define('FINAL_CHATROOM', '聊天室');
	define('FINAL_CHATTERENGINE', 'chatterengine');
	// process with page shown
	define('FINAL_BKT_P', 'popbktcourt');
	define('FINAL_MEM_P', 'memberpage');
	define('FINAL_CHAT_P', 'chatroom');
	define('FINAL_CHATTERENGINE_NP', 'chatterengine');
	// for redirect(process without page shown)
	define('FINAL_UPLOADENTRY', 'uploadentry');
	define('FINAL_FETCHENTRY', 'fetchentry');
	

	
	// showed for loggin only
	$tmpBbk = urlencode(FINAL_BKTCOURT);
	$tmpMember = urlencode(FINAL_MEMBER);
	$tmpChat = urlencode(FINAL_CHATROOM);
	$tmpChatEng = urlencode(FINAL_CHATTERENGINE);
	
	$auth_pages = array($tmpBbk, $tmpMember, $tmpChat, $tmpChatEng);
	
	//取得訪問的連結
	$link = $_SERVER['REQUEST_URI'];
	// check logged in or not
	if (is_user_logged_in()) {
		
		foreach($auth_pages as &$value){
			if(stripos($link, $value)){
				// to bktcourt page
				$template = get_query_template(FINAL_BKT_P);
				return $template;
				
			}else if(stripos($link, $tmpMember)){
				// to member page
				$template = get_query_template(FINAL_MEM_P);
				return $template;
				
			}else if(stripos($link, $tmpChat)){
				// to chatroom
				$template = get_query_template(FINAL_CHAT_P);
				return $template;
				
			}else if(stripos($link, $tmpChatEng)){
				$template = get_query_template(FINAL_CHATTERENGINE_NP);
				return $template;
				
			}else{
				// to default page 
				return $template;
			}
			
		}
	}else{
		//$url_info = get_queried_object();
		foreach($auth_pages as &$value){
			//與不可訪問頁面陣列比較
			$banned = stripos( $link, $value );
			if($banned){
				//返回首頁
				$template = get_query_template('404');
				return $template;
				
			}else if( stripos($link, FINAL_UPLOADENTRY)){
				$template = get_query_template(FINAL_UPLOADENTRY);
				return $template;
				
			}else if( stripos($link, FINAL_FETCHENTRY)){
				$template = get_query_template(FINAL_FETCHENTRY);
				return $template;
				
			}
		}
		return $template;
	}
}
add_filter( 'template_include', 'nl_template_include' );

/*
* get the popular basketball court
* */
function fetch_bkt(){
	//dispatchs constants
	define("MAIN_PAGE",'mainpage');
	define("CHECKIN_PAGE",'checkinpage');
	//return messages constants
	define("RESULT_SUCCESS", 0);
	define("RESULT_FAIL", 1);
	define("RESULT_JSON_FAIL", 2);
	define("RESULT_SQL_ERROR", 3);
	
	//set the timezone
	date_default_timezone_set('Asia/Tokyo');
	$dispatcher = '';
	
	
	$data = json_decode(file_get_contents('php://input'), true);
	//$dispatcher = MAIN_PAGE;
	
	if(isset($data['className'])){
		$dispatcher = $data['className'];
	}else{
		echo RESULT_FAIL;
		//get meta data
		$sss = $_POST['metadata'];
		echo $sss;
		echo $_FILES['uploadfile']['name'];
		echo $_FILES['uploadfile']['tmp_name'];
		//get upload file
		$info = pathinfo($_FILES['uploadfile']['name'] );
		$ext = $info['extension']; // get the extension of the file
		$newname = "newname.".$ext;
		
		$target = "C:\\basketballAPP\\".$newname;
		echo $target;
		move_uploaded_file( $_FILES['uploadfile']['tmp_name'], $target);
		return;
	}
	
	
	//initial DB
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "namimoch_shop";
	
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	$conn->set_charset('utf8');
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	//dispatcher
	if($dispatcher == MAIN_PAGE){
		//sql for query mainpage
		$sql = "SELECT CHECKIN.COURTNAME, CHECKIN.LAT, CHECKIN.LNG, COUNT(CHECKIN.COURTNAME) as CUR_PEOPLE, BKTCOURT.ADDRESS, PHOTO
				FROM CHECKIN LEFT JOIN BKTCOURT ON CHECKIN.idx = BKTCOURT.idx
				GROUP BY CHECKIN.COURTNAME, CHECKIN.LAT, CHECKIN.LNG, BKTCOURT.PHOTO 
				ORDER BY CUR_PEOPLE DESC";
	
		$result = $conn->query($sql);
		$encode = array();
		if ($result->num_rows > 0) {
			// output data of each row to jason object
			while($row = $result->fetch_assoc()) {
				$encode[] = $row;
				//echo " CourtName: " . $row["courtname"]. " lat: " . $row["lat"]. "<br>";
			}
		} else {
			echo RESULT_SQL_NO_RECORD;
			return;
		}
		//add time stamp
		$date = date("m/d/Y h:i:s a", time());
		$max = sizeof($encode);
		$encode[$max]['timestamp'] =  $date;
	
		$conn->close();
	
		echo json_encode($encode);
		return;
	
	}else if($dispatcher = CHECKIN_PAGE){
		//for test, here is the info from android device
		$lat = 24.987675;
		$lng = 121.567101;
		$address ='台北市';
	
		$sql = "SELECT * FROM
			(SELECT COURTNAME, ADDRESS, 
			 TRUNCATE(6378137 * 2 * atan2(sqrt(sin((bktcourt.lat- ? )*pi()/360) * sin((bktcourt.lat- ? )*pi()/360) +
			 cos(bktcourt.lat*pi()/180) * cos( ? *pi()/180) * sin((bktcourt.lng- ? )*pi()/360) * sin((bktcourt.lng- ? )*pi()/360)),
			  sqrt(1-(sin((bktcourt.lat- ? )*pi()/360) * sin((bktcourt.lat- ?)*pi()/360) + cos(bktcourt.lat*pi()/180) * cos( ? *pi()/180) *
			 sin((bktcourt.lng- ? )*pi()/360) * sin((bktcourt.lng- ? )*pi()/360)))),0)as DISTANCE, LAT, LNG , IDX
			 FROM bktcourt WHERE address = ?)a WHERE a.distance < 1000 ORDER BY distance ASC";
	
		$params = array($lat, $lat, $lat, $lng, $lng, $lat, $lat, $lat, $lng, $lng, $address);
		//i=integer, d=double, s=string, b=blob
		$testResult = mysqli_prepared_query($conn, $sql, "dddddddddds", $params);
	
		$encode = array();
		$cnt = sizeof($testResult);
		if ($cnt > 0) {
			for($i = 0; $i<$cnt; $i++){
				$encode[] = $testResult[$i];
			}
		} else {
			echo RESULT_SQL_NO_RECORD;
			return;
		}
		$conn->close();
	
		echo json_encode($encode);
		return;
	}else{
		echo RESULT_FAIL;
	}
}

/**
 * get the popular basketball court
 * */
function query_bktcourt( ){
	//initial DB
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "ccorgtw_shopdemo";
	
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	$conn->set_charset('utf8');
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql = "SELECT CHECKIN.COURTNAME, CHECKIN.LAT, CHECKIN.LNG, COUNT(CHECKIN.COURTNAME) as CUR_PEOPLE, BKTCOURT.ADDRESS, PHOTO
								FROM CHECKIN LEFT JOIN BKTCOURT ON CHECKIN.idx = BKTCOURT.idx
								GROUP BY CHECKIN.COURTNAME, CHECKIN.LAT, CHECKIN.LNG, BKTCOURT.PHOTO 
								ORDER BY CUR_PEOPLE DESC";
	
	$result = $conn->query($sql);
	global $popCourt;
	
	if ($result->num_rows > 0) {
		// output data of each row to array object
		while($row = $result->fetch_assoc()) {
			$popCourt[] = $row;
		}
	}
	
}
/*
 * 
 * */
function upload_entry(){
	// dispatchs constants
	define("LOCATINO_INFO",'location_info');
	define("GAME_RECORD",'game_record');
	// return messages constants
	define("RESULT_SUCCESS", 0);
	define("RESULT_FAIL", 1);
	define("RESULT_JSON_FAIL", 2);
	define("RESULT_SQL_ERROR", 3);
	define("PARSE_JSON_FAIL", 4);
	
	// set the timezone
	date_default_timezone_set('Asia/Tokyo');
	$insert_dispatcher = '';

	//$dispatcher = 'location_info';//for test
	
	// retrieve json data
	$data = json_decode(file_get_contents('php://input'), true);
	
	if( isset($data['className'])){
		$dispatcher = $data['className'];
	}else{
		echo PARSE_JSON_FAIL;
		return;
	}
	
	//initial DB
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "ccorgtw_shopdemo";
	
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	$conn->set_charset('utf8');
	// Check connection
	if ($conn->connect_error) {
		echo RESULT_SQL_ERROR;
		return;
		//die("Connection failed: " . $conn->connect_error);
	}
	
	//dispatcher
	if($dispatcher == LOCATINO_INFO){
	
		//i=integer, d=double, s=string, b=blob
		$sql = "INSERT INTO checkin (idx, id, courtname, address, lat, lng, checkin_time, msg, valid_flag) VALUES (?,?,?,?,?,?,?,?, true)";
		$stmt = mysqli_prepare($conn, $sql);
		if ( !$stmt ) {
			echo RESULT_SQL_ERROR;
			return;
			//die('mysqli error: '.mysqli_error($conn));
		}
	
		mysqli_stmt_bind_param($stmt, "isssddss", $idx, $id, $courtname, $address, $lat, $lng, $checkin_time, $msg);
	
		//chech the json parameter empty or not
		if(isset($data['idx']) && isset($data['id']) && isset($data['courtname']) &&
		isset($data['address']) && isset($data['lat']) && isset($data['lng']) &&
		isset($data['checkin_time']) && isset($data['msg'])){
				
			$idx = $data['idx'];
			$id = $data['id'];
			$courtname = urldecode($data['courtname']);
			$address = urldecode($data['address']);
			$lat = $data['lat'];
			$lng = $data['lng'];
			$checkin_time = $data['checkin_time'];
			$msg = urldecode($data['msg']);
				
		}else{
			$conn->close();
			echo RESULT_JSON_FAIL;
			return;
		}
	
		//SQL insert
		if($result = mysqli_stmt_execute($stmt)){
			//if insert successed
			echo RESULT_SUCCESS;
		}else{
			//if insert failed
			echo RESULT_SQL_ERROR;
		}
		$conn->close();
		return;
		
		// other route for uploading game records
	}else if($dispatcher == GAME_RECORD){
		$sql = '';
		// wait for implementation
	}
	
}

/*
* using ajax in wp
* */
function add_my_ajaxurl() {
?>
    <script>
        var ajaxurl = '<?php echo admin_url( 'admin-ajax.php'); ?>';
    </script>
<?php
}
add_action( 'wp_head', 'add_my_ajaxurl', 1 );

function view_sitename(){
	echo get_bloginfo( 'name' );
	//require_once (TEMPLATEPATH . '/memberpage.php');
	die();
}
add_action( 'wp_ajax_view_sitename', 'view_sitename' );	// for logged in user
add_action( 'wp_ajax_nopriv_view_sitename', 'view_sitename' ); // for unlogged in user


function view_mes(){
	$mes = $_POST['mes'];
	echo $mes;
	die();
}
add_action( 'wp_ajax_view_mes', 'view_mes' );
add_action( 'wp_ajax_nopriv_view_mes', 'view_mes' );


function chatter_engine(){

	$mode = $_POST['mode'];
	switch($mode){
		case 'get':
			getMessage();
			break;
		case 'post':
			postMessage();
			break;
		default:
			$mode = 'c';
			break;
	}
	die();
}
add_action( 'wp_ajax_chatter_engine', 'chatter_engine' );
add_action( 'wp_ajax_nopriv_chatter_engine', 'chatter_engine' );

/*
* post msg in chat room
**/
function postMessage(){
	
	date_default_timezone_set('Asia/Tokyo');
	$server = 'localhost';
	$username = 'root';
	$password = '';
	$database = 'namimoch_shop';
		
	$user = $_POST['user'];
	$text = $_POST['text'];

	if(empty($user) || empty($text)){
		output(false, 'Username and Chat Text must be inputted.');
	}else{
		$conn = new mysqli($server, $username, $password, $database);
		$conn->set_charset('utf8');
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		$date = date('Y-m-d H:i:s a');
		$uuid = rand(1,10000000000000);	//temp, should be modified
		
		//$sql = "INSERT INTO product_list (product, price, img, upload_date, status) VALUES (?,?,?,?,?)";
		$sql = "INSERT INTO cht_chat(messageId, username, text, insertDate)VALUES(?,?,?,?)";
		$stmt = $conn->prepare($sql);
			
		$stmt->bind_param('ssss', $uuid, $user, $text, $date);
			
		if($stmt->execute()){
			$this->output(true, '');
		}else{
			$this->output(false, 'Chat posting failed. Please try again.');
		}
		$stmt->close();
		$conn->close();
	}
}

/*
 * get latest msg in chat room 
 **/
function getMessage(){
	
	date_default_timezone_set('Asia/Tokyo');
	$server = 'localhost';
	$username = 'root';
	$password = '';
	$database = 'namimoch_shop';
	//leave this as our database connection later
	$conn = null;
	$curtime = null;
	
	$lasttime = $_POST['lastTime'];
	
	$conn = new mysqli($server, $username, $password, $database);
	$conn->set_charset('utf8');
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$endtime = time() + 10;	// plus 10 secends
	// long polling for 10 seconds 
	while(time() <= $endtime){
		$sql = "SELECT * FROM cht_chat ORDER BY insertDate desc LIMIT 0, 30";
		$result = $conn->query($sql);
		if($result){
			$msgs = array();
			while($row = $result->fetch_assoc()){
				$msgs[] = array('user' => $row['username'], 'text' => $row['text'], 'time' => $row['insertDate']);
			}
			// get the latest insertDate 
			$curtime = strtotime($msgs[0]['time']);
		}
		/// is the latest insertDate is not the same
		if(!empty($msgs) && $curtime != $lasttime){
			output(true, '', array_reverse($msgs), $curtime);
			break;
		}else{
			sleep(1);
		}
	}
	//echo date('Y-m-d H:i:s a', $curtime);
	
	$conn->close();
}

function fetch($name){
	$val = isset($_POST[$name]) ? $_POST[$name] : '';
	return mysql_real_escape_string($val, $this->connection);
}

function output($result, $output, $message = null, $latest = null){
	echo json_encode(array('result' => $result, 'message' => $message, 'output' => $output, 'latest' => $latest));
}

/**
 * enqueue style sheet
 * */
function wp_enqueue_styles_nelley(){
	wp_enqueue_style( 'wp_style_nelley', get_template_directory_uri() . '/css/nelley.css' );
	/*
	if ( has_nav_menu( 'secondary' ) ) {
		wp_enqueue_style( 'wpse_89494_style_1', get_template_directory_uri() . '/your-style_1.css' );
	}
	if ( has_nav_menu( 'primary' ) ) {
		wp_enqueue_style( 'wpse_89494_style_2', get_template_directory_uri() . '/your-style_2.css' );
	}
	if ( ! has_nav_menu( 'primary' ) && ! has_nav_menu( 'secondary' ) ) {
		wp_enqueue_style( 'wpse_89494_style_3', get_template_directory_uri() . '/your-style_3.css' );
	}*/
}
add_action( 'wp_enqueue_scripts', 'wp_enqueue_styles_nelley' );



/*
 * function for prepared statement
 **/
function mysqli_prepared_query($link,$sql,$typeDef = FALSE,$params = FALSE){
	if($stmt = mysqli_prepare($link,$sql)){
		if(count($params) == count($params,1)){
			$params = array($params);
			$multiQuery = FALSE;
		} else {
			$multiQuery = TRUE;
		}

		if($typeDef){
			$bindParams = array();
			$bindParamsReferences = array();
			$bindParams = array_pad($bindParams,(count($params,1)-count($params))/count($params),"");
			foreach($bindParams as $key => $value){
				$bindParamsReferences[$key] = &$bindParams[$key];
			}
			array_unshift($bindParamsReferences,$typeDef);
			$bindParamsMethod = new ReflectionMethod('mysqli_stmt', 'bind_param');
			$bindParamsMethod->invokeArgs($stmt,$bindParamsReferences);
		}

		$result = array();
		foreach($params as $queryKey => $query){
			foreach($bindParams as $paramKey => $value){
				$bindParams[$paramKey] = $query[$paramKey];
			}
			$queryResult = array();
			if(mysqli_stmt_execute($stmt)){
				$resultMetaData = mysqli_stmt_result_metadata($stmt);
				if($resultMetaData){
					$stmtRow = array();
					$rowReferences = array();
					while ($field = mysqli_fetch_field($resultMetaData)) {
						$rowReferences[] = &$stmtRow[$field->name];
					}
					mysqli_free_result($resultMetaData);
					$bindResultMethod = new ReflectionMethod('mysqli_stmt', 'bind_result');
					$bindResultMethod->invokeArgs($stmt, $rowReferences);
					while(mysqli_stmt_fetch($stmt)){
						$row = array();
						foreach($stmtRow as $key => $value){
							$row[$key] = $value;
						}
						$queryResult[] = $row;
					}
					mysqli_stmt_free_result($stmt);
				} else {
					$queryResult[] = mysqli_stmt_affected_rows($stmt);
				}
			} else {
				$queryResult[] = FALSE;
			}
			$result[$queryKey] = $queryResult;
		}
		mysqli_stmt_close($stmt);
	} else {
		$result = FALSE;
	}

	if($multiQuery){
		return $result;
	} else {
		return $result[0];
	}
}
?>