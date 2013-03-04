<?php
/**

 Template Name: Home Page Template

 * @package WordPress

 * @subpackage Filocity_Blog

 * @since Filocity_Blog 1.0

 * Developed by Shahzad Jameel

 * adnan-jamil@hotmail.com
 
**/

get_header(); 

?>

    
    <!-- body content begins -->
    <div class="body clearfix">
      
	  <?php get_sidebar(); ?>
      
      <div class="body_right">

        <div class="banner">

          <div class="heading">THE CLOUD <h4>Expert Resource</h4></div>

        </div>

        <div class="left">

          <div class="cloud_pan1">

          	<div class="cloud_pan2">

                <h3>Watch a Video</h3>

				<?php 
                
                $my_query = new WP_Query( "cat=18&posts_per_page=3" );
                
                if ( $my_query->have_posts() ) { 
                    
                    while ( $my_query->have_posts() ) { 
                        
                        $my_query->the_post();
                        
                ?>
                
                
                <div class="cloud_pan3">

                  <div class="pic"><?php show_first_image();?></div>

                  <div class="detail">

                      <a href="<?php the_permalink()?>"><?=the_title();?></a><br />

                      Read <a href="<?php the_permalink()?>">full article.</a>

                  </div>

                </div>
				
                <?php 
					
					}
				
				}wp_reset_postdata();
				
				?>
                
                
            </div>

            <div class="cloud_pan2">

                <h3>Read an Article</h3>

				<?php 
                
                $args = array(

					'posts_per_page'=> 3,

					'order'    => 'DESC',
					
					'post__in'  => get_option( 'sticky_posts' ),
	
					'ignore_sticky_posts' => 1
					
				);
				
				query_posts( $args );
                    
                while ( have_posts() ) : the_post();
                        
                ?>

                <div class="cloud_pan3">

                  <div class="pic"><?php show_first_image();?></div>

                  <div class="detail"><a href="<?php the_permalink()?>"><?=the_title();?></a></div>

                </div>

				
                <?php 
					
				
				endwhile;
				
				?>
            </div>

          </div>

          <div class="cloud_pan4">

              <div class="content">

                  <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('home_page') ) : endif;?>
                  
              </div>

              <div class="pic"><img src="<?php bloginfo('template_directory'); ?>/images/pic2.jpg" width="255" height="134" alt="" border="0" /></div>

          </div>

        </div>

        <div class="right">

          <div class="latest_cloud"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('home_image') ) : endif;?></div>

          <div class="right_pan">

            <h2>Latest From the Cloud</h2>  

            <ul class="featured_artical resources">

				<?php 
                
                $args = array(

					'posts_per_page'=> 5,
					
					'post__not_in'  => get_option( 'sticky_posts' ),

					'order'    => 'DESC',
					
				);
				
				query_posts( $args );
                    
                while ( have_posts() ) : the_post();
                        
                ?>

              	<li><a href="<?php the_permalink()?>"><?=the_title();?></a></li>

				<?php endwhile;?>
                
            </ul>

         </div>

        </div>

      </div>

    </div>

    <!-- body content ends -->
    
<?php get_footer(); ?>