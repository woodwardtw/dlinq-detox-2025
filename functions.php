<?php
/**
 * UnderStrap functions and definitions
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// UnderStrap's includes directory.
$understrap_inc_dir = 'inc';

// Array of files to include.
$understrap_includes = array(
	'/theme-settings.php',                  // Initialize theme default settings.
	'/setup.php',                           // Theme setup and custom theme supports.
	'/widgets.php',                         // Register widget area.
	'/enqueue.php',                         // Enqueue scripts and styles.
	'/template-tags.php',                   // Custom template tags for this theme.
	'/pagination.php',                      // Custom pagination for this theme.
	'/hooks.php',                           // Custom hooks.
	'/extras.php',                          // Custom functions that act independently of the theme templates.
	'/acf.php',
	'/customizer.php',                      // Customizer additions.
	'/custom-comments.php',                 // Custom Comments file.
	'/class-wp-bootstrap-navwalker.php',    // Load custom WordPress nav walker. Trying to get deeper navigation? Check out: https://github.com/understrap/understrap/issues/567.
	'/editor.php',                          // Load Editor functions.
	'/block-editor.php',                    // Load Block Editor functions.
	'/deprecated.php',                      // Load deprecated functions.
);

// Load WooCommerce functions if WooCommerce is activated.
if ( class_exists( 'WooCommerce' ) ) {
	$understrap_includes[] = '/woocommerce.php';
}

// Load Jetpack compatibility file if Jetpack is activiated.
if ( class_exists( 'Jetpack' ) ) {
	$understrap_includes[] = '/jetpack.php';
}

// Include files.
foreach ( $understrap_includes as $file ) {
	require_once get_theme_file_path( $understrap_inc_dir . $file );
}


function detox_homepage_posts(){
	$args = array(
		'post_type' 	=> array('activity'),
		'post_status'	=> array('publish'),
		  'orderby' 	=> array(
			'date' =>'ASC',
			/*Other params*/
			)
	);
	$the_query = new WP_Query( $args );

	// The Loop
	if ( $the_query->have_posts() ) :
		while ( $the_query->have_posts() ) : $the_query->the_post();
			global $post;
			$title = get_the_title();
			$link = get_the_permalink();
			$img = get_the_post_thumbnail($post->ID,'full', array('class' => 'img-fluid'));
			$content = get_the_content();
			$excerpt = strip_tags(substr($content, 0, 400)) . ' . . .';
			$bg_colors = array('white', 'white', 'aqua', 'red', 'white', 'white');
			$bg_color = $bg_colors[$the_query->current_post]; //change background color according to array
			$make_seven = array(0, 1, 4, 5, 7 );
			$post_number = $the_query->current_post;
			$class = (in_array( $post_number, $make_seven )) ? 'col-md-7' : 'col-md-5' ; // alternate 5 and 7 column width blocks
			$img_side = ($the_query->current_post % 3 == 0) ? 'order-md-last' : 'order-md-first'; //alter img to go first or last 
			$link = (in_category('active')) ? "<a class='btn btn-more' href='{$link}' aria-lable='Read more about the AI topic: {$title}.'>Explore</a>" : "<div class='btn btn-more'>Coming soon</div>";
			$html = "<div class='{$class}'>
						<div class='row {$bg_color} home-box'>
							<div class='col-md-5 {$img_side}'>
								{$img}
							</div>
							<div class='col-md-7'>
								<h2>{$title}</h2>
								<p>{$excerpt}</p>
								{$link}
							</div>
						
						</div>
				</div>";
		// Do Stuff
		echo $html;
		endwhile;
	endif;

	// Reset Post Data
	wp_reset_postdata();
}


//CHALLENGES
//NEEDS TO BE IN MAIN FUNCTIONS FOR SOME REASON
//add gravity forms to acf field for the daily create challenge option
/**
 * Populate ACF select field options with Gravity Forms forms
 */

//might need something like https://wordpress.org/plugins/categories-for-gravity-forms/
function acf_populate_gf_forms_ids( $field ) {
	if ( class_exists( 'GFFormsModel' ) ) {
		$choices = [''];

		foreach ( \GFFormsModel::get_forms() as $form ) {
			$choices[ $form->id ] = $form->title;
		}

		$field['choices'] = $choices;
	}

	return $field;
}
add_filter( 'acf/load_field/name=form_id', 'acf_populate_gf_forms_ids' );

//SUBMISSIONS
function detox_display_submissions($page_id){
	if( get_row_layout() == 'challenge' ){
			if (get_sub_field('challenge_category', $page_id)){
				$cat = get_sub_field('challenge_category', $page_id)->name;
				//var_dump($cat->name);
			} else{
				$cat = 'page-'.$page_id;	
			}
		}

	$args = array(
		'post_type' 	=> array('post'),
		'post_status'	=> array('publish'),
		'posts_per_page' => -1,
		 'category_name' => $cat
	);
	$the_query = new WP_Query( $args );

	// The Loop
	if ( $the_query->have_posts() ) :
		echo "<div class='submission-holder'><h2 id='submissions'>Submissions</h2><div class='row'>";
		while ( $the_query->have_posts() ) : $the_query->the_post();
			global $post;
			$title = get_the_title();
			$link = get_the_permalink();
			$comment_count = get_comment_count($post->ID)['approved'];
			$plural = ($comment_count === 1) ? '' : 's';
			if(has_post_thumbnail($post->ID)){
						$img = get_the_post_thumbnail($post->ID, 'medium', array('class'=>'img-fluid sub-img'));
			} else {
				$dir = get_template_directory_uri();
				$color = detox_rand_color();
				$img = "<img src='{$dir}/imgs/alien.svg' class='attachment-medium size-medium wp-post-image {$color}' width='100%' height='auto' alt='AI written with a half-tone background.'>";
			}
		echo "<div class='entry col-md-4'>
				<div class='entry-inner'>
					<a href='{$link}'>
						{$img}
						<h3>{$title}</h3>
					</a>
					<div class='comments'>{$comment_count} comment{$plural}</div>
				</div>
			</div>";
		endwhile;
		echo "</div></div>";
	endif;

	// Reset Post Data
	wp_reset_postdata();
}


function detox_rand_color(){
	$colors = array('aqua','yellow','red','orange','black');
	return $colors[array_rand($colors)];
}

function dlinq_detox_signup(){
	global $post;
	$post_id = $post->ID;
	$title = get_field('sign_up_title');
	$content = get_field('sign_up_content');
	echo "<h2>{$title}</h2>";
	echo $content;
}


function dd_lead_quote(){
	$quote = get_field('lead_quote');
	$source = get_field('quote_source');
	$url = get_field('quote_link');
	if($quote){
		return "<div class='lead-quote'>
							<blockquote cite='{$url}'>
									<p>{$quote}</p>
							</blockquote>
							<cite><a href='{$url}'>{$source}</a></cite>
						</div>
						";
	}
}

//fix cut paste drama from https://jonathannicol.com/blog/2015/02/19/clean-pasted-text-in-wordpress/
add_filter('tiny_mce_before_init','configure_tinymce');
 
/**
 * Customize TinyMCE's configuration
 *
 * @param   array
 * @return  array
 */
function configure_tinymce($in) {
  $in['paste_preprocess'] = "function(plugin, args){
    var whitelist = 'p,b,strong,i,em,h2,h3,h4,h5,h6,ul,li,ol,a,href,blockquote,table,td,tr,th,div,br';  // Strip all HTML tags except those we have whitelisted here
    var stripped = jQuery('<div>' + args.content + '</div>');
    var els = stripped.find('*').not(whitelist);
    for (var i = els.length - 1; i >= 0; i--) {
      var e = els[i];
      jQuery(e).replaceWith(e.innerHTML);
    }
    // Strip all class and id attributes
    stripped.find('*').removeAttr('id').removeAttr('class').removeAttr('style');
    args.content = stripped.html();    // Return the clean HTML
  }";
  return $in;
}


//add editor to comments
//add_filter( 'comment_form_defaults', 'rich_text_comment_form' );
function rich_text_comment_form( $args ) {
	ob_start();
	wp_editor( '', 'comment', array(
		'media_buttons' => false, // show insert/upload button(s) to users with permission
		'textarea_rows' => '10', // re-size text area
		'dfw' => false, // replace the default full screen with DFW (WordPress 3.4+)
		'tinymce' => array(
        	'theme_advanced_buttons1' => 'bold,italic,underline,strikethrough,bullist,numlist,code,blockquote,link,unlink,outdent,indent,|,undo,redo',
	        'theme_advanced_buttons2' => '', // 2nd row, if needed
        	'theme_advanced_buttons3' => '', // 3rd row, if needed
        	'theme_advanced_buttons4' => '' // 4th row, if needed
  	  	),
		'quicktags' => array(
 	       'buttons' => 'strong,em,link,block,del,ins,img,ul,ol,li,code,close'
	    )
	) );
	$args['comment_field'] = ob_get_clean();
	return $args;
}