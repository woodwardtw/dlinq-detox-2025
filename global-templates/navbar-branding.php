<?php
/**
 * Navbar branding
 *
 * @package Understrap
 * @since 1.2.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! has_custom_logo() ) { ?>
 <div class="main-title">
 	<a href="<?php echo get_home_url(); ?>"><img src="<?php echo get_template_directory_uri();?>/imgs/bpbq-title.svg" class="img-fluid dd-title" alt="Demystifying AI: Big promises, big questions."></a>
    <h1 id="mag-title" class="sr-only"><a href="<?php echo get_home_url(); ?>"><?php echo get_bloginfo('name')?></a></h1>
    <div class="sub-title"><?php echo get_bloginfo('description')?></div>
</div>

	<?php
} else {
	the_custom_logo();
}
