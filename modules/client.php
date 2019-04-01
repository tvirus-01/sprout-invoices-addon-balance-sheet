<?php
include plugin_dir_path( __FILE__ ).'../inc/wpdb_tbl.php';

$sibs_query1 = "SELECT * FROM `{$tbl_posts}` WHERE post_type = 'sa_client'";
$sibs_result1 = $wpdb->get_results($sibs_query1);

foreach ($sibs_result1 as $key) {
	$client_id = $key->ID;
	$client_name = $key->post_title;

	$sibs_query2 = "SELECT * FROM `{$tbl_client}` WHERE client_id = {$client_id}";
	$sibs_result2 = $wpdb->get_results($sibs_query2);
	$sibs_numrows = $wpdb->num_rows;

	$sibs_str = '1234567890qwertyahgszxhgstedhi';
	//strlen($str);
	$sibs_str = str_shuffle($sibs_str);

	if ($sibs_numrows > 0) {
		//no need to insert already inserted
	}else{
		$client_address = $wpdb->get_row( "SELECT * FROM `{$tbl_postmeta}` WHERE post_id = {$client_id} AND meta_key = '_address'" );
		$client_address = $client_address->meta_value;
		$client_address = explode(':', $client_address);

		$street = $client_address[6];
		$street = explode('"', $street);
		$street = $street[1];
		$city = $client_address[10];
		$city = explode('"', $city);
		$city = $city[1];

		$client_address = $street.','.$city;

		$client_website = $wpdb->get_row( "SELECT * FROM `{$tbl_postmeta}` WHERE post_id = {$client_id} AND meta_key = '_website'" );
		$client_website = $client_website->meta_value;

		// $wpdb->insert(
		// 			$tbl_client,
		// 			array(
		// 				'id' => null,
		// 				'client_id' => $client_id,
		// 				'client_name' => $client_name,
		// 				'client_address' => $client_address,
		// 				'client_website' => $client_website
		// 			),
		// 			array(
		// 				'%d',
		// 				'%d',
		// 				'%s',
		// 				'%s',
		// 				'%s'
		// 			)
		// );

		$wpdb->query("INSERT INTO `{$tbl_client}` (`id`, `client_id`, `client_name`, `client_address`, `client_website`, `client_slug`) VALUES (NULL, '{$client_id}', '{$client_name}', '{$client_address}', '{$client_website}', '{$sibs_str}')");


	}

}