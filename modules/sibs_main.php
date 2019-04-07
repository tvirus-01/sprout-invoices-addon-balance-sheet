<?php

$cid = $_GET['cid'];

$company_info = $wpdb->get_row( "SELECT * FROM {$tbl_options} WHERE option_name = 'si_address'" );
$company_info = $company_info->option_value;
$company_info = explode('"', $company_info);
 $company_name = $company_info[3];
 $company_email = $company_info[7];
 $company_phone = $company_info[11];
 $company_street = $company_info[27];
 $company_city = $company_info[31];
 $company_ps = $company_info[35];

$client_info = $wpdb->get_row( "SELECT * FROM {$tbl_client} WHERE client_slug = '{$url_slug}'" );
 $client_id = $client_info->client_id;	
 $client_name = $client_info->client_name;
 $client_address = $client_info->client_address;
 $client_website = $client_info->client_website;

$sibs_query = "SELECT * FROM {$tbl_sheet} WHERE client_id = {$client_id}";
$sibs_result = $wpdb->get_results( $sibs_query );
$sibs_result_chk = $wpdb->num_rows;

if($sibs_result_chk > 0){
  foreach($sibs_result as $key){
    $sibs_key = $key->sibs_key;
    $due_dat = $key->due_date; 
    $amt = $key->amount;
    $invoice_id = $key->invoice_id;
    $sibs_id = $key->id;
    
    $deposit_amount = $wpdb->get_row( "SELECT * FROM `{$tbl_postmeta}` WHERE post_id = {$invoice_id} AND meta_key = '_deposit'" );
		$deposit_amount = $deposit_amount->meta_value;
    
		$total_amount = $wpdb->get_row( "SELECT * FROM `{$tbl_postmeta}` WHERE post_id = {$invoice_id} AND meta_key = '_total'" );
    $inv_amt = $total_amount->meta_value;
    
    $due_date = $wpdb->get_row( "SELECT * FROM `{$tbl_postmeta}` WHERE post_id = {$invoice_id} AND meta_key = '_due_date'" );
		$due_date = $due_date->meta_value;
		$due_date = date( 'Y-m-d', $due_date );
    
    if (!empty($deposit_amount) || $deposit_amount > 0) {
			$inv_amt = $inv_amt - $deposit_amount;      
    }
    
    if($sibs_key == 'inv'){
      // change of due date and amount
         if($inv_amt == $amt){
           // it's equal
         }else{
           $wpdb->query("UPDATE {$tbl_sheet} SET amount = {$inv_amt} WHERE id = {$sibs_id}");
         }

        if($due_date == $due_dat){
          // whatever
        }else{
           $wpdb->query("UPDATE {$tbl_sheet} SET due_date = {$due_date} WHERE id = {$sibs_id}");        
        }
    }elseif($sibs_key == 'deposit'){
        if($deposit_amount == $amt){
          // whatever
        }else{
          $wpdb->query("UPDATE {$tbl_sheet} SET amount = {$deposit_amount} WHERE id = {$sibs_id}");
        }

        if($due_date == $due_dat){
          // whatever
        }else{
           $wpdb->query("UPDATE {$tbl_sheet} SET due_date = {$due_date} WHERE id = {$sibs_id}");        
        }
    }
  }
}

// currency sign

$currency = $wpdb->get_row("SELECT * FROM {$tbl_postmeta} WHERE post_id = {$client_id} AND meta_key = '_currency' ");
$currency = $currency->meta_value;

if($currency == 'EUR' || $currency == 'eur'){
  $currency_sign = '€';
}elseif($currency == 'JPY' || $currency == 'jpy'){
  $currency_sign = '¥';
}elseif($currency == 'GBP' || $currency == 'gbp'){
  $currency_sign = '£';
}elseif($currency == 'AUD' || $currency == 'aud'){
  $currency_sign = 'A$';
}elseif($currency == 'CAD' || $currency == 'cad'){
  $currency_sign = 'C$';
}elseif($currency == 'KRW' || $currency == 'krw'){
  $currency_sign = '₩';
}elseif($currency == 'INR' || $currency == 'inr'){
  $currency_sign = '₹';
}elseif($currency == 'RUB' || $currency == 'rub'){
  $currency_sign = '₽';
}else{
  $currency_sign = '$';
}


