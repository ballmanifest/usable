<div class="right">
  <div class="share"><a href="#"><img src="<?php bloginfo('template_directory'); ?>/images/share_btn.jpg" alt="" width="222" height="22" border="0" /></a></div>
  <div class="right_pan">
    <h2>Featured Articles</h2>
    <ul class="featured_artical">
      <?php 
		
		$args = array( 'numberposts' => '8', 'post__in'  => get_option('sticky_posts'), 'category' => get_query_var('cat') );
		
		$recent_posts = wp_get_recent_posts($args);
		
		foreach( $recent_posts as $recent ){
		
			echo '<li><a href="'.get_permalink($recent["ID"]).'" title="Look '.esc_attr($recent["post_title"]).'">'.$recent["post_title"].'</a></li>';		  
	  
	   }
	  
	  ?>
    </ul>
    <h2>Recent Articles in this Category</h2>
    <ul class="featured_artical">
      <?php 
		
		$args = array( 'numberposts' => '8', 'category' =>get_query_var('cat') );
		
		$recent_posts = wp_get_recent_posts($args);
		
		foreach( $recent_posts as $recent ){
		
			echo '<li><a href="'.get_permalink($recent["ID"]).'" title="Look '.esc_attr($recent["post_title"]).'">'.$recent["post_title"].'</a></li>';		  
	  
	   }
	  
	  ?>
    </ul>
    <h2>Resources</h2>
    
    <?php wp_nav_menu( array( 'menu' => 'resources', 'menu_class'=> 'featured_artical resources' ) );?>

  </div>

</div>