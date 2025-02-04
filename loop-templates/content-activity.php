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
            <?php  
                $video_url = get_post_meta(get_the_ID(), '_featured_video_url', true);
            if ($video_url):
                echo '<div class="featured-video">';
                if (strpos($video_url, 'youtube.com') !== false || strpos($video_url, 'vimeo.com') !== false) {
                    echo '<iframe width="100%" height="400" src="'. esc_url($video_url) .'" frameborder="0" allowfullscreen></iframe>';
                } else {
                    echo '<video width="100%" height="400" loop="true" autoplay="autoplay" controls muted>
                            <source src="'. esc_url($video_url) .'" type="video/mp4">
                          </video>';
                }
                echo '</div>';
            else:
               echo get_the_post_thumbnail( $post->ID, 'full',  array('class' => 'img-fluid active-img') );
            endif;
             ?>
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
