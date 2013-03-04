<?php
/**

 Template Name: Default Page Template

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
        
        
        ?>

      <div class="body_right">

        <div class="banner">

          <div class="heading">The Cloud Expert</div>

        </div>

        <div class="left">

          <div class="brodcam">

            <ul>

              <li><a href="<?php echo site_url(); ?>">The Cloud</a>>> </li>

              <li><?php the_title(); ?></li>

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

          <?php the_content(); ?>
          
          <br />
          
          <p><?php echo get_post_meta(get_the_ID(), "video_embed_code", true)?></p>
          
        </div>

        <?php include (TEMPLATEPATH . '/sidebar2.php'); ?>

      </div>
		
        
        <?php 
        
            endwhile;
    
        endif; 
    
        ?>

    </div>

    <!-- body content ends -->
    
<?php get_footer(); ?>