<?php

/*-----------------------------------------------------------------------------------------------------//
/*	Theme Setup
/*-----------------------------------------------------------------------------------------------------*/


@include "includes/geoip/geoip.php";
@include "includes/utils.php";

// Gravityforms
include "includes/gravityforms/steps.php";
include "includes/gravityforms/gravity.php";
include "includes/gravityforms/payment.php";


if ( ! function_exists( 'purpose_setup' ) ) :

function purpose_setup() {

	// Make theme available for translation
	load_theme_textdomain( 'organicthemes', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Enable support for site title tag
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails
	add_theme_support( 'post-thumbnails' );
	
	add_image_size( 'purpose-featured-large', 2400, 1600 ); // Large Featured Image
	add_image_size( 'purpose-featured-medium', 1800, 1200 ); // Medium Featured Image
	add_image_size( 'purpose-featured-small', 960, 960 ); // Small Featured Image
	add_image_size( 'purpose-featured-square', 720, 720, true ); // Square Featured Image

	// Create Menus
	register_nav_menus( array(
		'header-menu' => __( 'Header Menu', 'organicthemes' ),
	));
	
	// Custom Header
	$defaults = array(
		'width'                 => 1800,
		'height'                => 600,
		'flex-height'           => true,
		'flex-width'            => true,
		'default-text-color'    => 'ffffff',
		'header-text'           => false,
		'uploads'               => true,
	);
	add_theme_support( 'custom-header', $defaults );
	
	// Custom Background
	$defaults = array(
		'default-color'          => 'ffffff',
	);
	add_theme_support( 'custom-background', $defaults );
}
endif; // purpose_setup
add_action( 'after_setup_theme', 'purpose_setup' );


/**
 * @description MD5 for uploaded files
 * @param $filename
 * @return string
 */
function usdv_uploaded_filename_hash( $filename ) {
    $info = pathinfo($filename);
    $ext  = empty($info['extension']) ? '' : '.' . $info['extension'];
    $name = basename($filename, $ext);
    return md5( md5($name) . date('Y-m-d h:i:s') ) . $ext;
}
add_filter('sanitize_file_name', 'usdv_uploaded_filename_hash', 10);


/*-----------------------------------------------------------------------------------------------------//
	Theme Updater
-------------------------------------------------------------------------------------------------------*/

function purpose_theme_updater() {
	require( get_template_directory() . '/updater/theme-updater.php' );
}
add_action( 'after_setup_theme', 'purpose_theme_updater' );

/*-----------------------------------------------------------------------------------------------------//	
	Category ID to Name		       	     	 
-------------------------------------------------------------------------------------------------------*/

function purpose_cat_id_to_name( $id ) {
	$cat = get_category( $id );
	if ( is_wp_error( $cat ) )
		return false;
	return $cat->cat_name;
}

/*-----------------------------------------------------------------------------------------------------//	
	Register Scripts		       	     	 
-------------------------------------------------------------------------------------------------------*/

if ( !function_exists('purpose_enqueue_scripts') ) {
	function purpose_enqueue_scripts() {
	
		// Enqueue Styles
	 	wp_enqueue_style( 'purpose-style', get_stylesheet_uri(), false, '4.4.43' );
		wp_enqueue_style( 'purpose-style-mobile', get_template_directory_uri() . '/css/style-mobile.css', array( 'purpose-style' ), '1.1.4' );
		wp_enqueue_style( 'purpose-style-ie8', get_template_directory_uri() . '/css/style-ie8.css', array( 'purpose-style' ), '1.0' );

        wp_enqueue_style( 'gravity', get_template_directory_uri() . '/css/gravity.css', array(), '1.0' );
		
		// IE Conditional Styles
		global $wp_styles;
		$wp_styles->add_data('purpose-style-ie8', 'conditional', 'lt IE 9');
		
		// Resgister Scripts
		wp_register_script( 'purpose-fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array( 'jquery' ), '20130729' );
		wp_register_script( 'purpose-hover', get_template_directory_uri() . '/js/hoverIntent.js', array( 'jquery' ), '20130729' );
		wp_register_script( 'purpose-superfish', get_template_directory_uri() . '/js/superfish.js', array( 'jquery', 'purpose-hover' ), '20130729' );
		wp_register_script( 'purpose-isotope', get_template_directory_uri() . '/js/jquery.isotope.js', array( 'jquery' ), '20130729' );
	
		// Enqueue Scripts
		wp_enqueue_script( 'purpose-html5shiv', get_template_directory_uri() . '/js/html5shiv.js' );
		wp_enqueue_script( 'purpose-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20130729.2', true );
		wp_enqueue_script( 'purpose-custom', get_template_directory_uri() . '/js/jquery.custom.js', array( 'jquery', 'purpose-superfish', 'purpose-fitvids', 'purpose-isotope', 'jquery-masonry', 'jquery-color' ), '20130729', true );

        // Gravity
        wp_register_script( 'gravity', get_template_directory_uri() . '/js/gravity.js', array( 'jquery' ), '20151221', true );
        wp_enqueue_script( 'gravity' );

        // IE Conditional Scripts
		global $wp_scripts;
		$wp_scripts->add_data( 'purpose-html5shiv', 'conditional', 'lt IE 9' );
		
		// Load Flexslider on front page and slideshow page template
		if ( is_home() || is_front_page() || is_single() || is_archive() || is_page_template('template-slideshow.php') || is_page_template('template-blog.php') ) {
			wp_enqueue_script( 'purpose-flexslider', get_template_directory_uri() . '/js/jquery.flexslider.js', array( 'jquery' ), '20130729' );
		}
	
		// Load single scripts only on single pages
	    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
	    	wp_enqueue_script( 'comment-reply' );
	    }
	}
}
add_action('wp_enqueue_scripts', 'purpose_enqueue_scripts');

/*-----------------------------------------------------------------------------------------------------//	
	WooCommerce Integration			       	     	 
-------------------------------------------------------------------------------------------------------*/

// Declare WooCommerce support
add_theme_support( 'woocommerce' );

// Remove WC sidebar
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

// WooCommerce content wrappers
function mytheme_prepare_woocommerce_wrappers(){
    remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
    remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
}
add_action( 'wp_head', 'mytheme_prepare_woocommerce_wrappers' );

function mytheme_open_woocommerce_content_wrappers() {
	?>  
	<div class="row">
		<div class="content no-thumb">
			<div class="eleven columns">
				<div class="postarea clearfix">
    <?php
}
function mytheme_close_woocommerce_content_wrappers() {
	?>
				</div>
	    	</div>
	 
	        <div class="five columns">
	        	<?php get_sidebar(); ?>
	        </div>
        
        </div>
 	</div>
    <?php
}
add_action( 'woocommerce_before_main_content', 'mytheme_open_woocommerce_content_wrappers', 10 );
add_action( 'woocommerce_after_main_content', 'mytheme_close_woocommerce_content_wrappers', 10 );

// Add the WC sidebar in the right place
add_action( 'woo_main_after', 'woocommerce_get_sidebar', 10 );

// WooCommerce default product columns
function loop_columns() {
    return 3;
}
add_filter('loop_shop_columns', 'loop_columns');

// WooCommerce remove related products
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

/*-----------------------------------------------------------------------------------------------------//	
	Register Sidebars		       	     	 
-------------------------------------------------------------------------------------------------------*/

function organic_widgets_init() {
	register_sidebar(array(
		'name'=> __( "Page Sidebar", 'organicthemes' ),
		'id' => 'page-sidebar',
		'before_widget'=>'<div id="%1$s" class="widget %2$s">',
		'after_widget'=>'</div>',
		'before_title'=>'<h6>',
		'after_title'=>'</h6>'
	));
	register_sidebar(array(
		'name'=> __( "Blog Sidebar", 'organicthemes' ),
		'id' => 'blog-sidebar',
		'before_widget'=>'<div id="%1$s" class="widget %2$s">',
		'after_widget'=>'</div>',
		'before_title'=>'<h6>',
		'after_title'=>'</h6>'
	));
	register_sidebar(array(
		'name'=> __( "Post Sidebar", 'organicthemes' ),
		'id' => 'post-sidebar',
		'before_widget'=>'<div id="%1$s" class="widget %2$s">',
		'after_widget'=>'</div>',
		'before_title'=>'<h6>',
		'after_title'=>'</h6>'
	));
	register_sidebar(array(
		'name'=> __( "Left Sidebar", 'organicthemes' ),
		'id' => 'left-sidebar',
		'before_widget'=>'<div id="%1$s" class="widget %2$s">',
		'after_widget'=>'</div>',
		'before_title'=>'<h6>',
		'after_title'=>'</h6>'
	));
	register_sidebar(array(
		'name'=> __( "Footer Widgets", 'organicthemes' ),
		'id' => 'footer',
		'before_widget'=>'<div id="%1$s" class="widget %2$s"><div class="footer-widget">',
		'after_widget'=>'</div></div>',
		'before_title'=>'<h6>',
		'after_title'=>'</h6>'
	));
}
add_action( 'widgets_init', 'organic_widgets_init' );

/*-----------------------------------------------------------------------------------------------------//	
	Add Stylesheet To Visual Editor       	     	 
-------------------------------------------------------------------------------------------------------*/
	
add_action( 'init', 'purpose_add_editor_styles' );
/**
* Apply theme's stylesheet to the visual editor.
*
* @uses add_editor_style() Links a stylesheet to visual editor
* @uses get_stylesheet_uri() Returns URI of theme stylesheet
*/
function purpose_add_editor_styles() {
	add_editor_style( get_stylesheet_uri() );
}

/*-----------------------------------------------------------------------------------------------------//	
	Add post formats	       	     	 
-------------------------------------------------------------------------------------------------------*/

add_theme_support( 'post-formats', array( 
	'gallery',
	'link',
	'image',
	'audio',
	'status',
	'quote',
	'video'	
	) 
);
	
/*-----------------------------------------------------------------------------------------------------//	
	Post Format Meta Boxes       	     	 
-------------------------------------------------------------------------------------------------------*/

add_action("admin_init", "create_metaboxes");
add_action('save_post', 'save_metaboxes');

$metaboxes = array(
    'link_url' => array(
        'title' => __('Link Information', 'organicthemes'),
        'applicableto' => 'post',
        'location' => 'side',
        'display_condition' => 'post-format-link',
        'priority' => 'default',
        'fields' => array(
            'l_url' => array(
                'title' => __('Link URL: ', 'organicthemes'),
                'type' => 'text',
                'description' => '',
                'size' => 20
            )
        )
    ),
    'quote_author' => array(
        'title' => __('Quote Author', 'organicthemes'),
        'applicableto' => 'post',
        'location' => 'side',
        'display_condition' => 'post-format-quote',
        'priority' => 'default',
        'fields' => array(
            'q_author' => array(
                'title' => __('Author: ', 'organicthemes'),
                'type' => 'text',
                'description' => '',
                'size' => 20
            )
        )
    )
);

function create_metaboxes() {
	global $metaboxes;
	 
    if ( ! empty( $metaboxes ) ) {
        foreach ( $metaboxes as $id => $metabox ) {
            add_meta_box( $id, $metabox['title'], 'show_metaboxes', $metabox['applicableto'], $metabox['location'], $metabox['priority'], $id );
        }
    }
}

function show_metaboxes( $post, $args ) {
    global $metaboxes;
 	
    $custom = get_post_custom( $post->ID );
    $fields = $tabs = $metaboxes[$args['id']]['fields'];
 
    /** Nonce **/
    $output = '<input type="hidden" name="post_format_meta_box_nonce" value="' . wp_create_nonce( basename( __FILE__ ) ) . '" />';
    
    if ( sizeof( $fields ) ) {
        foreach ( $fields as $id => $field ) {
            switch ( $field['type'] ) {
                default:
                case "text":
                
                if ( isset($custom[$id]) ) {
                
                    $output .= '<label for="' . esc_attr( $id ) . '">' . $field['title']  . '</label><input id="' . esc_attr( $id ) . '" type="text" name="' . esc_attr( $id ) . '" value="' . $custom[$id][0] . '" size="' . $field['size'] . '" />';
                    
                } else {
                	
                	$output .= '<label for="' . esc_attr( $id ) . '">' . $field['title']  . '</label><input id="' . esc_attr( $id ) . '" type="text" name="' . esc_attr( $id ) . '" value="" size="' . $field['size'] . '" />';
                	
                }
 
                break;
            }
        }
    }
 
    echo $output;
}

function save_metaboxes( $post_id ) {
    global $metaboxes;
 
    // verify nonce
    if ( isset($_POST['post_format_meta_box_nonce']) && ! wp_verify_nonce( $_POST['post_format_meta_box_nonce'], basename( __FILE__ ) ) )
        return $post_id;
 
    // check autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $post_id;
 
    // check permissions
    if ( 'page' == isset($_POST['post_type']) ) {
        if ( ! current_user_can( 'edit_page', $post_id ) )
            return $post_id;
    } elseif ( ! current_user_can( 'edit_post', $post_id ) ) {
        return $post_id;
    }
 
    $post_type = get_post_type();
 
    // loop through fields and save the data
    foreach ( $metaboxes as $id => $metabox ) {
        // check if metabox is applicable for current post type
        if ( $metabox['applicableto'] == $post_type ) {
            $fields = $metaboxes[$id]['fields'];
 
            foreach ( $fields as $id => $field ) {
                $old = get_post_meta( $post_id, $id, true );
                $new = $_POST[$id];
 
                if ( $new && $new != $old ) {
                    update_post_meta( $post_id, $id, $new );
                }
                elseif ( '' == $new && $old || ! isset( $_POST[$id] ) ) {
                    delete_post_meta( $post_id, $id, $old );
                }
            }
        }
    }
}

	
add_action( 'admin_print_scripts', 'display_metaboxes', 1000 );

function display_metaboxes() {
    global $metaboxes;
    if ( get_post_type() == "post" ) :
        ?>
        <script type="text/javascript">// <![CDATA[
            $ = jQuery;
 
            <?php
            $formats = $ids = array();
            foreach ( $metaboxes as $id => $metabox ) {
                array_push( $formats, "'" . $metabox['display_condition'] . "': '" . $id . "'" );
                array_push( $ids, "#" . $id );
            }
            ?>
 
            var formats = { <?php echo implode( ',', $formats );?> };
            var ids = "<?php echo implode( ',', $ids ); ?>";
            
            function displayMetaboxes() {
                // Hide all post format metaboxes
                $(ids).hide();
                // Get current post format
                var selectedElt = $("input[name='post_format']:checked").attr("id");
 
                // If exists, fade in current post format metabox
                if ( formats[selectedElt] )
                    $("#" + formats[selectedElt]).fadeIn();
            }
 
            $(function() {
                // Show/hide metaboxes on page load
                displayMetaboxes();
 
                // Show/hide metaboxes on change event
                $("input[name='post_format']").change(function() {
                    displayMetaboxes();
                });
            });
 
        // ]]></script>
        <?php
    endif;
}
	
/*----------------------------------------------------------------------------------------------------//
/*	Content Width
/*----------------------------------------------------------------------------------------------------*/

if ( ! isset( $content_width ) )
	$content_width = 640;

/**
 * Adjust content_width value based on the presence of widgets
 */
function purpose_content_width() {
	if ( ! is_active_sidebar( 'post-sidebar' ) || is_active_sidebar( 'page-sidebar' ) || is_active_sidebar( 'blog-sidebar' ) ) {
		global $content_width;
		$content_width = 960;
	}
}
add_action( 'template_redirect', 'purpose_content_width' );
	
/*-----------------------------------------------------------------------------------------------------//	
	Comments Function		       	     	 
-------------------------------------------------------------------------------------------------------*/

if ( ! function_exists( 'purpose_comment' ) ) :
function purpose_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'organicthemes' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'organicthemes' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
		break;
		default :
	?>
	<li <?php comment_class(); ?> id="<?php echo esc_attr( 'li-comment-' . get_comment_ID() ); ?>">
	
		<article id="<?php echo esc_attr( 'comment-' . get_comment_ID() ); ?>" class="comment">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
						$avatar_size = 72;
						if ( '0' != $comment->comment_parent )
							$avatar_size = 48;

						echo get_avatar( $comment, $avatar_size );

						/* translators: 1: comment author, 2: date and time */
						printf( __( '%1$s <br/> %2$s <br/>', 'organicthemes' ),
							sprintf( '<span class="fn">%s</span>', wp_kses_post( get_comment_author_link() ) ),
							sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( __( '%1$s', 'organicthemes' ), get_comment_date(), get_comment_time() )
							)
						);
					?>
				</div><!-- .comment-author .vcard -->
			</footer>

			<div class="comment-content">
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'organicthemes' ); ?></em>
					<br />
				<?php endif; ?>
				<?php comment_text(); ?>
				<div class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'organicthemes' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div><!-- .reply -->
				<?php edit_comment_link( __( 'Edit', 'organicthemes' ), '<span class="edit-link">', '</span>' ); ?>
			</div>

		</article><!-- #comment-## -->

	<?php
	break;
	endswitch;
}
endif; // ends check for purpose_comment()

/*-----------------------------------------------------------------------------------------------------//	
	Comments Disabled On Pages By Default		       	     	 
-------------------------------------------------------------------------------------------------------*/

function purpose_default_comments_off( $data ) {
    if( $data['post_type'] == 'page' && $data['post_status'] == 'auto-draft' ) {
        $data['comment_status'] = 0;
    } 

    return $data;
}
add_filter( 'wp_insert_post_data', 'purpose_default_comments_off' );

/*-----------------------------------------------------------------------------------------------------//	
	Custom Excerpt Length		       	     	 
-------------------------------------------------------------------------------------------------------*/

function purpose_excerpt_length( $length ) {
	return 38;
}
add_filter( 'excerpt_length', 'purpose_excerpt_length', 999 );

function purpose_excerpt_more( $more ) {
	return '... <a class="read-more" href="'. get_permalink( get_the_ID() ) . '">'. __('Read More', 'organicthemes') .'</a>';
}
add_filter('excerpt_more', 'purpose_excerpt_more');

/*-----------------------------------------------------------------------------------------------------//	
	Add Excerpt To Pages		       	     	 
-------------------------------------------------------------------------------------------------------*/

add_action( 'init', 'purpose_add_excerpts_to_pages' );
function purpose_add_excerpts_to_pages() {
     add_post_type_support( 'page', 'excerpt' );
}

/*-----------------------------------------------------------------------------------------------------//
/*	Pagination Function
/*-----------------------------------------------------------------------------------------------------*/

function purpose_get_pagination_links() {
	global $wp_query;
	$big = 999999999;
	echo paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, get_query_var('paged') ),
		'prev_text' => __('&laquo;', 'organicthemes'),
		'next_text' => __('&raquo;', 'organicthemes'),
		'total' => $wp_query->max_num_pages
	) );
}

/*-----------------------------------------------------------------------------------------------------//
/*	Custom Page Links
/*-----------------------------------------------------------------------------------------------------*/

function purpose_wp_link_pages_args_prevnext_add($args) {
    global $page, $numpages, $more, $pagenow;

    if (!$args['next_or_number'] == 'next_and_number') 
        return $args; 

    $args['next_or_number'] = 'number'; // Keep numbering for the main part
    if (!$more)
        return $args;

    if($page-1) // There is a previous page
        $args['before'] .= _wp_link_page($page-1)
            . $args['link_before']. $args['previouspagelink'] . $args['link_after'] . '</a>';

    if ($page<$numpages) // There is a next page
        $args['after'] = _wp_link_page($page+1)
            . $args['link_before'] . $args['nextpagelink'] . $args['link_after'] . '</a>'
            . $args['after'];

    return $args;
}

add_filter('wp_link_pages_args', 'purpose_wp_link_pages_args_prevnext_add');

/*-----------------------------------------------------------------------------------------------------//	
	Featured Video Meta Box		       	     	 
-------------------------------------------------------------------------------------------------------*/

add_action("admin_init", "admin_init_featurevid");
add_action('save_post', 'save_featurevid');

function admin_init_featurevid(){
	add_meta_box("featurevid-meta", __("Featured Video Embed Code", 'organicthemes'), "meta_options_featurevid", "post", "normal", "high");
}

function meta_options_featurevid(){
	global $post;
	$custom = get_post_custom($post->ID);
	$featurevid = isset( $custom["featurevid"] ) ? esc_attr( $custom["featurevid"][0] ) : '';

	echo '<textarea name="featurevid" cols="60" rows="4" style="width:97.6%" />'.$featurevid.'</textarea>';
}

function save_featurevid($post_id){
	global $post;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }
	if ( isset($_POST["featurevid"]) ) { 
		update_post_meta($post->ID, "featurevid", $_POST["featurevid"]); 
	}
}

/*-----------------------------------------------------------------------------------------------------//	
	Add Home Link To Custom Menu		       	     	 
-------------------------------------------------------------------------------------------------------*/

function home_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter('wp_page_menu_args', 'home_page_menu_args');

/*-----------------------------------------------------------------------------------------------------//	
	Strip inline width and height attributes from WP generated images		       	     	 
-------------------------------------------------------------------------------------------------------*/
 
function remove_thumbnail_dimensions( $html ) { 
	$html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html ); 
	return $html; 
	}
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 ); 
add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );

/*-----------------------------------------------------------------------------------------------------//
	Body Class
-------------------------------------------------------------------------------------------------------*/

function purpose_body_class( $classes ) {
	if ( is_singular() )
		$classes[] = 'purpose-singular';

	if ( is_active_sidebar( 'right-sidebar' ) )
		$classes[] = 'purpose-right-sidebar';

	if ( '' != get_theme_mod( 'background_image' ) ) {
		// This class will render when a background image is set
		// regardless of whether the user has set a color as well.
		$classes[] = 'purpose-background-image';
	} else if ( ! in_array( get_background_color(), array( '', get_theme_support( 'custom-background', 'default-color' ) ) ) ) {
		// This class will render when a background color is set
		// but no image is set. In the case the content text will
		// Adjust relative to the background color.
		$classes[] = 'purpose-relative-text';
	}

	return $classes;
}
add_action( 'body_class', 'purpose_body_class' );

/*---------------------------------------------------------------------------------------------//
	Retrieve email value from Customizer and add mailto protocol
/*---------------------------------------------------------------------------------------------*/

function purpose_get_email_link() {
	$email = get_theme_mod( 'purpose_link_email' );

	if ( ! $email )
		return false;

	return 'mailto:' . sanitize_email( $email );
}

/*-----------------------------------------------------------------------------------------------------//
	Includes
-------------------------------------------------------------------------------------------------------*/

require_once( get_template_directory() . '/includes/customizer.php' );
require_once( get_template_directory() . '/includes/typefaces.php' );
include_once( get_template_directory() . '/organic-shortcodes/organic-shortcodes.php' );

//member registration file
require_once( get_template_directory() . '/includes/member_registration.php' );


register_sidebar( array(
	'name'          => __( 'Disclaimer', 'organicthemes' ),
	'id'            => 'disclaimer',
	'description'   => '',
	'class'         => 'footer-widget',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget'  => '</div>',
	'before_title'  => '<h6>',
	'after_title'   => '</h6>'
) );