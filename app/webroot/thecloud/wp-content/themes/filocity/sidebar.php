<div class="body_left">
 
  <div class="most_popular">
 
    <h3><a href="<?php echo site_url(); ?>/most-popular-posts/">Most Popular</a></h3>
 
  </div>
 
  <div class="most_popular">
 
    <h3><a href="<?php echo site_url(); ?>/most-shared-posts/">Most Shared</a></h3>
 
  </div>
 
  <div class="newsletter">
 
    <h3>Get The Cloud Newsletter</h3>
 
    <?php nsu_signup_form();?>
    
  </div>
 
  <div class="the_cloud clearfix">
 
    <h4>The Cloud</h4>
 
    <ul>
 
      <li><a href="<?php echo site_url(); ?>/what-is-the-cloud">What is The Cloud</a>?</li>
 
    </ul>
 
  </div>
 
  <div class="industry_service clearfix">
 
    <h5>Industry Sector</h5>
 
    <?php wp_nav_menu( array( 'menu' => 'industry-sector', 'menu_class'=> '' ) );?>
 
  </div>
 
  <div class="industry_service clearfix">
 
    <h5>Feature Articles</h5>
 
    <ul>
 
      <?php 
		
		$args = array( 'numberposts' => '6', 'post__in'  => get_option( 'sticky_posts' ) );
		
		$recent_posts = wp_get_recent_posts($args);
		
		foreach( $recent_posts as $recent ){
		
			echo '<li><a href="'.get_permalink($recent["ID"]).'" title="Look '.esc_attr($recent["post_title"]).'">'.$recent["post_title"].'</a></li>';		  
	  
	   }
	  
	  ?>
 
    </ul>
 
  </div>
 
  <div class="testimonials">
 
    <h3><a href="<?php echo site_url(); ?>/category/testimonials/">Testimonials</a></h3>
 
    <h4><a href="<?php echo site_url(); ?>/category/videos/">Videos </a></h4>
 
    <h5><a href="<?php echo site_url(); ?>/category/archives/">Archives</a></h5>
 
    <h6><a href="<?php echo site_url(); ?>/category/filocity-training-series/">Filocity Training Series</a></h6>
 
  </div>

</div>