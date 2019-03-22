<?php
global $wpdb;
$prefix = $wpdb->prefix;
$tbl_posts = "{$prefix}posts";

$post_id = $wpdb->get_row( "SELECT * FROM `{$tbl_posts}` WHERE post_type = 'page' AND post_title = 'si-balance-sheet'" );
$chk_post = $wpdb->num_rows;

if ($chk_post > 0) {
	//nothing to do
}else{
$sibs_post = array();
$sibs_post['post_title'] = 'si-balance-sheet';
$sibs_post['post_status'] = 'publish';
$sibs_post['comment_status'] = 'closed';
$sibs_post['ping_status'] = 'closed';
$sibs_post['post_name'] = 'si-balance-sheet';
$sibs_post['post_type'] = 'page';

wp_insert_post( $sibs_post );

$post_id = $wpdb->get_row( "SELECT * FROM `{$tbl_posts}` WHERE post_type = 'page' AND post_title = 'si-balance-sheet'" );
$post_id = $post_id->ID;
$meta_key = '_wp_page_template';
$meta_value = 'templates/main/si_balancesheet.php';

add_post_meta( $post_id, $meta_key, $meta_value );
}