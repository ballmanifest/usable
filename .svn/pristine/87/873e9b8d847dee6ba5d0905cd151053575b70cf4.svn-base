<?php
function wmp_get_popular( $args = array() ) {
	global $wpdb;
	
	// Default arguments
	$limit = 5;
	$post_type = array( 'post' );
	$range = 'all_time';
	
	if ( isset( $args['limit'] ) ) {
		$limit = $args['limit'];
	}
	
	if ( isset( $args['post_type'] ) ) {
		if ( is_array( $args['post_type'] ) ) {
			$post_type = $args['post_type'];
		} else {
			$post_type = array( $args['post_type'] );
		}
	}
	
	if ( isset( $args['range'] ) ) {
		$range = $args['range'];
	}
	
	switch( $range ) {
		CASE 'all_time':
			$order = "ORDER BY all_time_stats DESC";
			break;
		CASE 'monthly':
			$order = "ORDER BY 30_day_stats DESC";
			break;
		CASE 'weekly':
			$order = "ORDER BY 7_day_stats DESC";
			break;
		CASE 'daily':
			$order = "ORDER BY 1_day_stats DESC";
			break;
		DEFAULT:
			$order = "ORDER BY all_time_stats DESC";
			break;
	}

	$holder = implode( ',', array_fill( 0, count( $post_type ), '%s') );
	
	$sql = "
		SELECT
			p.*
		FROM
			{$wpdb->prefix}most_popular mp
			INNER JOIN {$wpdb->prefix}posts p ON mp.post_id = p.ID
		WHERE
			p.post_type IN ( $holder ) AND
			p.post_status = 'publish'
		{$order}
		LIMIT %d
	";

	$result = $wpdb->get_results( $wpdb->prepare( $sql, array_merge( $post_type, array( $limit ) ) ), OBJECT );
	
	if ( ! $result) {
		return array();
	}
	
	return $result;
}


function display_wmp_get_popular(){
	
	global $str_get_popular;
	
	global $post;
	
	$str_get_popular = '<ul>';
	
	$posts = wmp_get_popular( array( 'limit' => 20, 'post_type' => 'post', 'range' => 'all_time' ) );
	
	if ( count( $posts ) > 0 ): foreach ( $posts as $post ):
		
		setup_postdata( $post );

		$str_get_popular .= '<li><a href="'.get_permalink().'" title="'. esc_attr(get_the_title() ? get_the_title() : get_the_ID()) .'">'. get_the_title() .'</a></li>';

	endforeach; endif;
	
	$str_get_popular .= '</ul>';

	return $str_get_popular;

}
