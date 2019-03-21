<?php
include plugin_dir_path( __FILE__ ).'../inc/wpdb_tbl.php';

$pmt_result = $wpdb->get_results( "SELECT * FROM `{$tbl_posts}` WHERE post_type = 'sa_payment'" );

foreach ($pmt_result as $key) {
	$payment_id = $key->ID;
	$payment_date = $key->post_date;

	$invoice_id = $wpdb->get_row( "SELECT * FROM `{$tbl_postmeta}` WHERE post_id = {$payment_id} AND meta_key = '_payment_invoice'" );
	$invoice_id = $invoice_id->meta_value;

	$payment_amount = $wpdb->get_row( "SELECT * FROM `{$tbl_postmeta}` WHERE post_id = {$payment_id} AND meta_key = '_amount'" );
	$payment_amount = $payment_amount->meta_value;

	$payment_method = $wpdb->get_row( "SELECT * FROM `{$tbl_postmeta}` WHERE post_id = {$payment_id} AND meta_key = '_payment_method'" );
	$payment_method = $payment_method->meta_value;

	$pmt_chk = $wpdb->get_results( "SELECT * FROM `{$tbl_payment}` WHERE payment_id = {$payment_id}" );
	$pmt_chk = $wpdb->num_rows;

	if ($pmt_chk > 0) {
		//do nothing data already exists
	}else{
		$wpdb->insert(
					$tbl_payment,
					array(
						'id' => null,
						'payment_id' => $payment_id,
						'invoice_id' => $invoice_id,
						'payment_amount' => $payment_amount,
						'payment_method' => $payment_method,
						'payment_date' => $payment_date
					),
					array(
						'%d',
						'%d',
						'%d',
						'%d',
						'%s',
						'%s'
					)
		);
	}
}