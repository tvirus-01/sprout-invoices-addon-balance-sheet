<?php
include plugin_dir_path( __FILE__ ).'../inc/wpdb_tbl.php';

$pmt_result = $wpdb->get_results( "SELECT * FROM `{$tbl_posts}` WHERE post_type = 'sa_payment'" );

foreach ($pmt_result as $key) {
	$payment_id = $key->ID;
	$payment_date = $key->post_date;
	$payment_date = explode(' ', $payment_date);
	$payment_date = $payment_date[0];

	$invoice_id = $wpdb->get_row( "SELECT * FROM `{$tbl_postmeta}` WHERE post_id = {$payment_id} AND meta_key = '_payment_invoice'" );
	$invoice_id = $invoice_id->meta_value;

	$client_id = $wpdb->get_row( "SELECT * FROM `{$tbl_postmeta}` WHERE post_id = {$invoice_id} AND meta_key = '_client_id'" );
	$client_id = $client_id->meta_value;

	$payment_amount = $wpdb->get_row( "SELECT * FROM `{$tbl_postmeta}` WHERE post_id = {$payment_id} AND meta_key = '_amount'" );
	$payment_amount = $payment_amount->meta_value;

	$pmt_chk = $wpdb->get_results( "SELECT * FROM `{$tbl_sheet}` WHERE invoice_id = {$invoice_id} AND sibs_key = 'pmt'" );
	$pmt_chk = $wpdb->num_rows;

	if ($pmt_chk > 0) {
		//do nothing data already exists
	}else{
		$wpdb->query("INSERT INTO `{$tbl_sheet}` (`id`, `invoice_id`, `client_id`, `sibs_key`, `amount`, `date`, `due_date`) VALUES (NULL, '{$invoice_id}', '{$client_id}', 'pmt', '{$payment_amount}', '{$payment_date}', '')");
	}
}