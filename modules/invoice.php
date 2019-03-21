<?php
include plugin_dir_path( __FILE__ ).'../inc/wpdb_tbl.php';

$inv_result = $wpdb->get_results( "SELECT * FROM `{$tbl_posts}` WHERE post_type = 'sa_invoice'" );

foreach ($inv_result as $key) {
	$invoice_id = $key->ID;
	$invoice_name = $key->post_title;
	$invoice_date = $key->post_date;

	$inv_chk = $wpdb->get_results( "SELECT * FROM `{$tbl_invoice}` WHERE invoice_id = {$invoice_id}" );
	$inv_chk = $wpdb->num_rows;	

	if ($inv_chk > 0) {
		//do nothing data already exists
	}else{
		$total_amount = $wpdb->get_row( "SELECT * FROM `{$tbl_postmeta}` WHERE post_id = {$invoice_id} AND meta_key = '_total'" );
		$total_amount = $total_amount->meta_value;

		$deposit_amount = $wpdb->get_row( "SELECT * FROM `{$tbl_postmeta}` WHERE post_id = {$invoice_id} AND meta_key = '_deposit'" );
		$deposit_amount = $deposit_amount->meta_value;

		$due_date = $wpdb->get_row( "SELECT * FROM `{$tbl_postmeta}` WHERE post_id = {$invoice_id} AND meta_key = '_due_date'" );
		$due_date = $due_date->meta_value;
		$due_date = date( 'd-m-Y', $due_date );

		$wpdb->insert(
					$tbl_invoice,
					array(
						'id' => null,
						'invoice_id' => $invoice_id,
						'invoice_name' => $invoice_name,
						'total_amount' => $total_amount,
						'deposit_amount' => $deposit_amount,
						'date' => $invoice_date,
						'due_date' => $due_date
					),
					array(
						'%d',
						'%d',
						'%s',
						'%d',
						'%d',
						'%s',
						'%s'
					)
		);

	}
}