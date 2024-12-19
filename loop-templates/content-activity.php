<?php
/**
 * Activity post partial template
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
    <div class="row topic-row white d-flex align-items-center">
        <div class="col-md-5">
            <?php echo get_the_post_thumbnail( $post->ID, 'large',  array('class' => 'img-fluid active-img') ); ?>
        </div>
        <div class="col-md-5">
	        <header class="entry-header">

		        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

	        </header><!-- .entry-header -->       


            <div class="entry-content">
                <?php echo dd_lead_quote();?>
                <?php
                the_content();
                understrap_link_pages();
                ?>

            </div><!-- .entry-content -->
     </div>
</div>

	<footer class="entry-footer">

		<?php understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
