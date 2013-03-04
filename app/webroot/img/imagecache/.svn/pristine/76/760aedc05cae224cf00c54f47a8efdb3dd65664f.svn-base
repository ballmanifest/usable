<?php
/**

 * The Template for displaying all single posts.

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

		<?php 
        
        if (have_posts()) : 
        
            while (have_posts()) : the_post(); 
        
        
			$getthecategory = get_the_category(); //print_r($getthecategory);die;
      ?>

      <div class="body_right">

        <div class="banner">

          <div class="heading"><?php echo $getthecategory[0]->cat_name; ?></div>

        </div>

        <div class="left">

          <div class="brodcam">

            <ul>

              <li><a href="<?php echo site_url(); ?>">The Cloud</a>>>&nbsp;</li>

              <li><?php echo $getthecategory[0]->cat_name; ?></li>

            </ul>

          </div>

          <div class="heading_section">

            <div class="heding">

              <h1><?php the_title(); ?></h1>

            </div>

            <!-- AddThis Button BEGIN -->

            <div class="addthis_toolbox addthis_default_style" style="margin-bottom:20px; padding-top:10px;">

            <a class="addthis_button_preferred_1"></a>

            <a class="addthis_button_preferred_2"></a>

            <a class="addthis_button_preferred_3"></a>

            <a class="addthis_button_preferred_4"></a>

            <a class="addthis_button_compact"></a>

            <a class="addthis_counter addthis_bubble_style"></a>

            </div>

            <script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=xa-509e46e92fd11c77"></script>

            <!-- AddThis Button END -->

          </div>

          <?php echo get_the_content();?>
          
          <br />
          
          <p><?php echo get_post_meta(get_the_ID(), "video_embed_code", true)?></p>
        
          <a name="postcomments"></a><?php comments_template( '', true ); ?>
        
        </div>

        
        <!-- Right Column-->
        
        <div class="right">
        
          <div class="share"><a href="#"><img src="<?php bloginfo('template_directory'); ?>/images/share_btn.jpg" alt="" width="222" height="22" border="0" /></a></div>
        
          <div class="right_pan">
        
            <h2>By <?php the_author();?></h2>  
        
            <ul class="article">
        
              <li><a href="#">Read <?php the_author();?></a></li>
        
              <li>Last updated: <?php the_modified_date('F j, Y'); ?> <?php the_modified_date('g:i a'); ?> <br />EDT <?php the_modified_date('Y'); ?></li>
        
            </ul>
        
          <h2>Recent Articles in this Category</h2>
        
          <ul class="featured_artical">
        
		  <?php 
            
			
            $args = array( 'numberposts' => '8', 'category' => $getthecategory[0]->cat_ID);
            
            $recent_posts = wp_get_recent_posts($args);
            
            foreach( $recent_posts as $recent ){
            
                echo '<li><a href="'.get_permalink($recent["ID"]).'" title="Look '.esc_attr($recent["post_title"]).'">'.$recent["post_title"].'</a></li>';		  
          
           }
          
          ?>
        
          </ul>
        
          <h2>Article Rating</h2>
        
          <ul class="article">
        
            <li><?php GetWtiLikePost();?><!--<img src="<?php bloginfo('template_directory'); ?>/images/like.jpg" alt="" width="12" height="12" border="0" /> (1) <img src="<?php bloginfo('template_directory'); ?>/images/unlike.jpg" alt="" width="12" height="12" border="0" /> (0)--></li>
        
            <li><a href="#postcomments">Read Comments</a></li>
        
            <li><a href="#postcomments">Post a Comments</a></li>
        
          </ul>
        
         </div>
        
        </div>
        
        <!-- END Right Column-->
		
        
      </div>
		
        
        
        <?php 
        
            endwhile;
    
        endif; 
    
        ?>

    </div>
    
    

    <!-- body content ends -->
    
<?php get_footer(); ?>