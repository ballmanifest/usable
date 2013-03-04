<?php
/**

 * The template for displaying Category

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
        
       // if (have_posts()) : 
        
            //while (have_posts()) : the_post(); 
        
        
        ?>

      <div class="body_right">

        <div class="banner">

          <div class="heading"><?php single_cat_title(); ?></div>

        </div>

        <div class="left">

          <div class="brodcam">

            <ul>

              <li><a href="<?php echo site_url(); ?>">The Cloud</a>>>&nbsp;</li>

              <li><?php single_cat_title(); ?></li>

            </ul>

          </div>

          <div class="heading_section">

            <div class="heding">

              <h1><?php 
			  	
				$myCategory = get_term_by('id', get_query_var('cat'), 'category');
				
				$tax_id = $myCategory->term_taxonomy_id;
				
				$tax_name = get_metadata('taxonomy', $tax_id, "category-subheading", TRUE);
			  	
				echo($tax_name); ?></h1>

            </div>

            <!-- AddThis Button BEGIN -->

            <div class="addthis_toolbox addthis_default_style" style="margin-bottom:10px; padding-top:10px; float:right;">

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

         <?php echo category_description( $category_id ); ?>
          
          
          <!-- tabs begins -->

          <div class="tabsMain">

          	<div id="TabbedPanels1" class="TabbedPanels">

              <ul class="TabbedPanelsTabGroup">
				
                <?php 
				
					$args = array(
							'type'                     => 'post',
							'parent'                   => get_query_var('cat'),
							'orderby'                  => 'name',
							'order'                    => 'ASC',
							'hide_empty'               => 0,
							'pad_counts'               => false );
							
							$categories = get_categories( $args );
							
					foreach ( $categories as $cat ) {		
				?>
                
                <li class="TabbedPanelsTab" tabindex="0"><?=$cat->cat_name?></li>
				
                <?php }?>
                
              </ul>

              
              
              
              <div class="TabbedPanelsContentGroup">

                <?php 
				
					$args = array(
							'type'                     => 'post',
							'parent'                   => get_query_var('cat'),
							'orderby'                  => 'name',
							'order'                    => 'ASC',
							'hide_empty'               => 0,
							'pad_counts'               => false );
							
							$categories = get_categories( $args );
							
					foreach ( $categories as $cat ) {		
				
				?>
                
                <div class="TabbedPanelsContent">

                    <div class="content1">

                        <div class="topic">Topic</div>

                        <div class="type">Type of Article</div>

                        <div class="video">Video</div>

                    </div>
					
                    
                	<?php 
					
					$counter = 0;

					$cat_id = $cat->cat_ID;
					
					$my_query = new WP_Query( "cat=$cat_id" );
					
					if ( $my_query->have_posts() ) { 
			        	
						while ( $my_query->have_posts() ) { 
							
							$my_query->the_post();
							
							//print_r($my_query);die;
							
							if($counter % 2 == 0) {
					
					?>
                
                    <div class="content2">


                        <div class="topic"><a href="<?php the_permalink()?>"><?=the_title();?></a></div>

                        <div class="type"><?php echo get_post_meta(get_the_ID(), "type-of-article", true)?></div>

                        <div class="video"><?php if(get_post_meta(get_the_ID(), "video_embed_code", true) != "") echo('<img src="'.get_bloginfo('template_directory').'/images/vicon.png" width="20" height="14" alt="" border="0" />');?></div>

                    </div>
                
                	<?php 	} else {?>   

                    <div class="content3">

                        <div class="topic"><a href="<?php the_permalink()?>"><?=the_title();?></a></div>

                        <div class="type"><?php echo get_post_meta(get_the_ID(), "type-of-article", true); //print($type);?></div>

                        <div class="video"><?php if(get_post_meta(get_the_ID(), "video_embed_code", true) != "") echo('<img src="'.get_bloginfo('template_directory').'"/images/vicon.png" width="20" height="14" alt="" border="0" />');?></div>

                    </div>
                    
                    <?php 
							} // END ELSE
							
						$counter++;
						
						} // END WHILE
					
					}// END IF
					
					?>

                </div>

                <?php } wp_reset_postdata();?>


              </div>

            </div>

          </div>

          <!-- tabs ends -->

        </div>

        <?php include (TEMPLATEPATH . '/sidebar2.php'); ?>

      </div>
		
        
    </div>

    <!-- body content ends -->
    
<?php get_footer(); ?>