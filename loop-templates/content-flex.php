<?php if( have_rows('content') ): ?>
    <?php while( have_rows('content') ): the_row(); ?>
    <?php $index = get_row_index(); ?>   
        <!--IMAGE LOOP-->            
        <?php if( get_row_layout() == 'text_with_image' ): 
            $title = get_sub_field('title');
            $slug = sanitize_title($title);
            $content = get_sub_field('content');
            $image = get_sub_field('image');
            $direction = get_sub_field('image_align');
            $color = get_sub_field('color');
            $order_left = ' order-first ';
            $order_right = ' order-last ';
            if($direction == 'right'){
                $order_left = ' order-last ';
                $order_right = ' order-first ';
            }
            ?>
        <div class='row topic-row <?php echo $color;?> d-flex align-items-center'>
				<div class='col-md-5<?php echo $order_left;?>'>    
                    <figure>
                        <?php 
                            if($image){
                               echo wp_get_attachment_image( $image['ID'], 'large', '', array('class'=>'img-fluid aligncenter detox-img') ); 
                                echo "<figcaption>{$image['caption']}</figcaption>";
                           } else {
                               echo 'Please add a picture.';
                           }
                             ?>
                    </figure>
                </div>
            <div class='col-md-1 order-2'></div>
            <div class='col-md-5 <?php echo $order_right;?>'>
                <?php if($title) :?>
                    <h2 id="<?php echo $slug;?>"><?php echo $title; ?></h2>
                <?php endif;?>
                <?php echo $content; ?>
			</div>
        </div>
        <?php endif; ?>
        <!--full block loop-->
         <?php if( get_row_layout() == 'full_block' ): 
            $title = get_sub_field('title');
            $content = get_sub_field('content');
            $color = get_sub_field('color');
            $slug = sanitize_title($title);
        ?>
            <div class='row topic-row full-width-row <?php echo $color;?> d-flex align-items-center'>
				<div class='col-md-8 offset-md-2'>
                    <?php if($title):?>
                        <h2 id="<?php echo $slug?>"><?php echo $title;?></h2>
                    <?php endif;?>
                    <?php echo $content;?>
                </div>
            </div>
        <?php endif;?>
        <!--side by side loop-->
         <?php if( get_row_layout() == 'side_by_side' ): 
            $left_title = get_sub_field('left_title');
            $right_title = get_sub_field('right_title');
            $left_content = get_sub_field('left_side');
            $right_content = get_sub_field('right_side');
            $left_slug = sanitize_title($left_title);
            $right_slug = sanitize_title($right_title);
        ?>
            <div class='row topic-row full-width-row side-by-side-row d-flex align-items-center'>
                <div class='col-md-6'>
                    <?php if($left_title):?>
                        <h2 id="<?php echo $slug?>"><?php echo $left_title;?></h2>
                    <?php endif;?>
                    <?php echo $left_content;?>
                </div>
                <div class='col-md-6'>
                    <?php if($right_title):?>
                        <h2 id="<?php echo $slug?>"><?php echo $right_title;?></h2>
                    <?php endif;?>
                    <?php echo $right_content;?>
                </div>
            </div>
        <?php endif;?>
           <!--activity steps loop-->
         <?php if( get_row_layout() == 'steps' ): 
            $title = get_sub_field('activity_title');
            $steps = get_sub_field('activity_steps');
            $slug = sanitize_title($title);
        ?>
            <div class='row topic-row full-width-row <?php echo $color;?> d-flex align-items-center'>
				<div class='col-md-8 offset-md-2 activity-block'>
                    <?php if($title):?>
                        <h2 class='steps-title' id="<?php echo $slug?>">Activity: <?php echo $title;?></h2>
                    <?php endif;?>
                    <?php 
                        if($steps){
                            foreach ($steps as $key => $step) {
                                $title = $step['title'];
                                $content = $step['content'];
                                $count = $key+1;
                                echo "
                                <div class='step'>
                                    <h3>Step {$count}: {$title}</h3>
                                    <div class='activity-content'>
                                        {$content}
                                    </div>
                                </div>
                                ";
                            }
                        }
                    ?>
                </div>
            </div>
        <?php endif;?>
        <!--Big Quote loop-->
         <?php if( get_row_layout() == 'big_quote' ): 
            $content = get_sub_field('quote');
            $source = get_sub_field('quote_source')
        ?>
            <div class='row topic-row full-width-row d-flex align-items-center'>
                <div class='col-md-6 offset-md-3'>                   
                    <blockquote class="big-quote">
                        <?php echo $content;?>
                        <footer><?php echo $source;?></footer>
                    </blockquote>
                </div>
            </div>
        <?php endif;?>
  
        <!--CUSTOM POSTS BY CATEGORY-->
        <?php if( get_row_layout() == 'posts' ):
            $title = 'Learn more';
            if(get_sub_field('title')){
                 $title =get_sub_field('title');
            }
        $slug = sanitize_title( $title);
        $color = get_sub_field('color');
            echo "<div class='row topic-row full-width-row {$color}'>
                    <div class='col-md-8 offset-md-2'>
                        <h2 id='{$slug}'>{$title}</h2>
                    </div>
                        ";
         
            $cats = get_sub_field('category');
            $type = get_sub_field('post_type');
            $args = array(
                'category__and' => $cats,
                'post_type' => $type,
                'posts_per_page' => 10,
                'paged' => get_query_var('paged')
            );
            $the_query = new WP_Query( $args );

            // The Loop
            if ( $the_query->have_posts() ) :
                while ( $the_query->have_posts() ) : $the_query->the_post();
                // Do Stuff
                $title = get_the_title();
                $url = get_the_permalink();
                $name = get_field('name');
                $class =  substr(get_field('class'), -2);
                $class_span = get_field('class') ? "<span class='class-year'>'{$class}</span>" : '';
                if(get_the_content()){
                     $excerpt = wp_trim_words(get_the_content(), 30);
                }
                if(get_field('project_description') != ''){
                   $excerpt =  wp_trim_words(get_field('project_description'), 30); 
                }
                if(in_category('tree-house-memory')){
                      echo "
                            <div class='col-md-8 offset-md-2'>
                                <div class='post-block memory class-of-{$class}'>
                                        <div class='memory-blurb'><p>{$excerpt}</p></div>
                                        <div class='memory-giver'>{$name} {$class_span}</div>
                                </div>
                            </div>
                        ";

                } else {
                      echo "
                            <div class='col-md-8 offset-md-2'>
                                <div class='post-block'>
                                        <a href='{$url}'><h3>{$title}</h3></a>                           
                                        <p>{$excerpt}</p>
                                </div>
                            </div>
                        ";

                }
               
              
                endwhile;
            endif;

            // Reset Post Data
            wp_reset_postdata();
            echo "</div>";
        ?>
        <?php endif;?>

        <!--challenge loop-->
         <?php if( get_row_layout() == 'challenge' ): 
            $title = get_sub_field('challenge_title');
            $form = get_sub_field('form_id');
            $slug = sanitize_title($title);
        ?>
            <div class='row topic-row full-width-row submissions-row'>
				<div class='col-md-8 offset-md-2'>
                    <?php if($title):?>
                        <h2 id="<?php echo $slug;?>"><?php echo $title;?></h2>
                    <?php endif;?>
                    <?php if ($form > 0) {
                        $form_display = gravity_form($form, false, false, false, null, false, null, false, null, null);
                        echo "
                        <button type='button' class='btn btn-more' id='sub-btn' data-bs-toggle='modal' data-bs-target='#submission'>
                           Submit content
                            </button>
                        <div class='modal modal-lg fade' id='submission' tabindex='-1'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                    <div class='modal-header'>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                    </div>
                                    <div class='modal-body'>
                                        {$form_display}
                                    </div>                                  
                                    </div>
                                </div>
                                </div>";
                        detox_display_submissions($post->ID);
                        }?>
                </div>
            </div>
        <?php endif;?>
      
    <?php endwhile; ?>
<?php endif; ?>

