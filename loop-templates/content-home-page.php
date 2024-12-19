<?php
/**
 * Partial template for content in page.php
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<div class="entry-content contain-fluid home-box" id="home">
		<div class="row">
			
			<div class="col-md-5 home-box yellow">
			<div class="internal-left-block">
				<?php 
					dlinq_detox_signup();
				?>			
			</div>
		</div>
		<?php detox_homepage_posts();?>
		
	</div>
		<?php
		the_content();
		understrap_link_pages();
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php understrap_edit_post_link(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
