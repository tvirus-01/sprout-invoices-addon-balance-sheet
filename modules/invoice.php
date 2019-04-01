<?php
include plugin_dir_path( __FILE__ ).'../inc/wpdb_tbl.php';

$inv_result = $wpdb->get_results( "SELECT * FROM `{$tbl_posts}` WHERE post_type = 'sa_invoice'" );

foreach ($inv_result as $key) {
	$invoice_id = $key->ID;
	$invoice_name = $key->post_title;
	$invoice_date = $key->post_date;
	$invoice_date = explode(' ', $invoice_date);
	$invoice_date = $invoice_date[0];

	$inv_chk = $wpdb->get_results( "SELECT * FROM `{$tbl_sheet}` WHERE invoice_id = {$invoice_id}" );
	$inv_chk = $wpdb->num_rows;
	$tbl_sheet;	

	if ($inv_chk > 0) {
		//do nothing data already exists
	}else{
		$total_amount = $wpdb->get_row( "SELECT * FROM `{$tbl_postmeta}` WHERE post_id = {$invoice_id} AND meta_key = '_total'" );
		$total_amount = $total_amount->meta_value;

		$client_id = $wpdb->get_row( "SELECT * FROM `{$tbl_postmeta}` WHERE post_id = {$invoice_id} AND meta_key = '_client_id'" );
		$client_id = $client_id->meta_value;

		$deposit_amount = $wpdb->get_row( "SELECT * FROM `{$tbl_postmeta}` WHERE post_id = {$invoice_id} AND meta_key = '_deposit'" );
		$deposit_amount = $deposit_amount->meta_value;

		$due_date = $wpdb->get_row( "SELECT * FROM `{$tbl_postmeta}` WHERE post_id = {$invoice_id} AND meta_key = '_due_date'" );
		$due_date = $due_date->meta_value;
		$due_date = date( 'Y-m-d', $due_date );

		//echo '---'.$invoice_id.'---'.$client_id.'---'.$deposit_amount.'---'.$invoice_date.'---'.$due_date.'---'.$total_amount;

		if (!empty($deposit_amount) || $deposit_amount > 0) {
			$inv_due = $total_amount - $deposit_amount;
			$wpdb->query("INSERT INTO `{$tbl_sheet}` (`id`, `invoice_id`, `client_id`, `sibs_key`, `amount`, `date`, `due_date`) VALUES (NULL, '{$invoice_id}', '{$client_id}', 'deposit', '{$deposit_amount}', '{$invoice_date}', '{$due_date}')");

			$wpdb->query("INSERT INTO `{$tbl_sheet}` (`id`, `invoice_id`, `client_id`, `sibs_key`, `amount`, `date`, `due_date`) VALUES (NULL, '{$invoice_id}', '{$client_id}', 'inv', '{$inv_due}', '{$invoice_date}', '{$due_date}')");
		}else{

		$wpdb->query("INSERT INTO `{$tbl_sheet}` (`id`, `invoice_id`, `client_id`, `sibs_key`, `amount`, `date`, `due_date`) VALUES (NULL, '{$invoice_id}', '{$client_id}', 'inv', '{$total_amount}', '{$invoice_date}', '{$due_date}')");
		}
	}
}


