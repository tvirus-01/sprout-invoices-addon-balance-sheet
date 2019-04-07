<?php

/*
Template Name: si-balance-sheet
*/

require_once plugin_dir_path( __FILE__ ).'../../inc/wpdb_tbl.php';

// if (!isset($_GET['cid'])) {
// 	header('Location:'.site_url( '', null ));
// }

$url_slug = substr($_SERVER['REQUEST_URI'],-30);

include plugin_dir_path( __FILE__ ).'../../modules/sibs_main.php';

$sibs_query = "SELECT * FROM {$tbl_sheet} WHERE client_id = {$client_id}";
$sibs_result = $wpdb->get_results( $sibs_query );
$sibs_result_chk = $wpdb->num_rows;
$sibs_result2 = $wpdb->get_results( "SELECT * FROM {$tbl_sheet} WHERE sibs_key = 'inv' AND client_id = {$client_id}" );
							
// echo "<br>";
// if ($due_amount > $pmt) {
// 	$due_amount = $due_amount - $pmt;
// 	echo $due_amount;
// }


?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<div class="container p-3">
	<div class="shadow-lg p-5">
		<div class="row mb-5">
			<div class="col font-weight-bold" style="line-height: 25px;">
				<span><?php echo $company_name; ?></span>
				<br>
				<span><?php echo $company_street; ?></span>
				<br>
				<span><?php echo $company_city.', '.$company_ps; ?></span>
				<br>
				<span><?php echo $company_email; ?></span>
				<br>
				<span><?php echo $company_phone; ?></span>
			</div>
			<div class="col font-weight-bold">
				<span class="float-right h2">Statement</span>
				<br><br>
				<span class="float-right"><?php echo 'Date: '.date('Y-m-d'); ?></span>
			</div>
		</div>
		<div class="row mb-4">
			<div class="col" style="line-height: 25px;">
				<span class="font-weight-bold">To:</span><span> <?php echo $client_name; ?></span>
				<br>
				<span><?php echo $client_address; ?></span>
				<br>
				<span><?php echo $client_website; ?></span>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<table class="table table-bordered">
					<tr>
						<th>Date</th>
						<th>Transaction</th>
						<th>Amount</th>
						<th>Balance</th>
					</tr>
					<?php if($sibs_result_chk == 0) {?>
					<tr>
						<td>----</td>
						<td>----</td>
						<td>----</td>
						<td>----</td>
					</tr>
					<?php }else{ ?>
					<?php $balance = 0; ?>
					<?php foreach($sibs_result as $key){ ?>
					<?php $invoice_id = $key->invoice_id; ?>
					<?php $due_date = $key->due_date; ?>
					<?php
						$transaction = $key->sibs_key;
						if ($transaction == 'deposit') {
							$transaction = 'Balance Forward';
							$amount = $key->amount;
							$balance = $balance + $amount;
						}elseif ($transaction == 'inv') {
							$transaction = "INV #$invoice_id </br>Due {$due_date}";
							$amount = $key->amount;
							$balance = $balance + $amount;
						}elseif ($transaction == 'pmt') {
							$transaction = "PMT </br> INV #{$invoice_id}";
							$amount = '-'.$key->amount;
							$balance = $balance + $amount;
						}
					?>	
					<?php echo "<tr>";  ?>
					<?php echo "<td>";  ?>
					<?php echo $key->date;  ?>
					<?php echo "</td>";  ?>
					<?php echo "<td>";  ?>
					<?php echo $transaction;  ?>
					<?php echo "</td>";  ?>
					<?php echo "<td>";  ?>
					<?php echo $currency_sign . $amount;  ?>
					<?php echo "</td>";  ?>
					<?php echo "<td>";  ?>
					<?php echo $currency_sign . $balance;  ?>
					<?php echo "</td>";  ?>
					<?php echo "</tr>";  ?>
					<?php } }?>
				</table>
				<table class="table table-bordered">
					<tr class="text-capitalize">
						<th>Current</th>
						<th>1-30 days past due</th>
						<th>31-60 days past due</th>
						<th>61-90 days past due</th>
						<th>over 90 days past due</th>
						<th>amount due</th>
					</tr>
					<tr>
						<td>
							<?php if($balance == 0){echo '0.00';}else{ ?>
							<?php echo $currency_sign . $balance;} ?>	
						</td>
						<td>
							<?php
								foreach($sibs_result2 as $key){
									$inv_id = $key->invoice_id;
									$inv_amount = $key->amount;

									//echo $current_date = date('d-m-Y');
									$current_date = strtotime(date('d-m-Y'));
									//$due_dat = $key->due_date;
									$due_dat = strtotime($key->due_date);
									$diff = $current_date - $due_dat; 
									$days_left = abs(floor($diff / (60*60*24)));
									// echo $days_left.' ';

									$sibs_result3 = $wpdb->get_results( "SELECT * FROM {$tbl_sheet} WHERE sibs_key = 'pmt' AND invoice_id = {$inv_id}" );
									$sibs_result3_chk = $wpdb->num_rows;
									if ($sibs_result3_chk == 0) {
										//payment is not created
										$due_amount = $inv_amount;
									}else{
										if ($sibs_result3_chk > 1) {
											foreach ($sibs_result3 as $key) {
												 $pmt2 += $key->amount;
												}
												$due_amount = $inv_amount - $pmt2;
										}else{
											foreach ($sibs_result3 as $key) {
												 $pmt = $key->amount;
												 $due_amount = $inv_amount - $pmt;
												}
											}
									}
									}
									if ($current_date > $due_dat) {
										if ($days_left > 0 && $days_left < 31) {
											// $due_amount += $inv_amount;
											if ($pmt < $inv_amount) {
												$total_due_amount = $due_amount;
												//echo $days_left;
												if ($total_due_amount == 0) {
													echo $currency_sign . "0.00";
												}else{
													echo($currency_sign . $total_due_amount);
													$tdm1 = $total_due_amount;
												}
											}else{
												echo $currency_sign . "0.00";
											}
										}else{
											echo $currency_sign . "0.00";
										}
									}else{
										echo $currency_sign . "0.00";
									}
								
							?>							
						</td>
						<td>
							<?php
								foreach($sibs_result2 as $key){
									$inv_id = $key->invoice_id;
									$inv_amount = $key->amount;

									//echo $current_date = date('d-m-Y');
									$current_date = strtotime(date('d-m-Y'));
									//$due_dat = $key->due_date;
									$due_dat = strtotime($key->due_date);
									$diff = $current_date - $due_dat; 
									$days_left = abs(floor($diff / (60*60*24)));
									// echo $days_left.' ';

									$sibs_result3 = $wpdb->get_results( "SELECT * FROM {$tbl_sheet} WHERE sibs_key = 'pmt' AND invoice_id = {$inv_id}" );
									$sibs_result3_chk = $wpdb->num_rows;
									if ($sibs_result3_chk == 0) {
										//payment is not created
										$due_amount = $inv_amount;
									}else{
										if ($sibs_result3_chk > 1) {
											foreach ($sibs_result3 as $key) {
												 $pmt3 += $key->amount;
												}
												$due_amount = $inv_amount - $pmt3;
										}else{
											foreach ($sibs_result3 as $key) {
												 $pmt = $key->amount;
												 $due_amount = $inv_amount - $pmt;
												}
											}
									}
								}
									
									if ($current_date > $due_dat) {
										if ($days_left > 30 && $days_left < 61) {
											// $due_amount += $inv_amount;
											if ($pmt < $inv_amount) {
												$total_due_amount = $due_amount;
												if ($total_due_amount == 0) {
													echo $currency_sign . "0.00";
												}else{
													echo($currency_sign . $total_due_amount);
													$tdm2 = $total_due_amount;
												}
											}else{
												echo $currency_sign . "0.00";
											}
										}else{
											echo $currency_sign . "0.00";
										}
									}else{
										echo $currency_sign . "0.00";
									}
							?>
						</td>
						<td>
							<?php
								foreach($sibs_result2 as $key){
									$inv_id = $key->invoice_id;
									$inv_amount = $key->amount;

									//echo $current_date = date('d-m-Y');
									$current_date = strtotime(date('d-m-Y'));
									//$due_dat = $key->due_date;
									$due_dat = strtotime($key->due_date);
									$diff = $current_date - $due_dat; 
									$days_left = abs(floor($diff / (60*60*24)));
									// echo $days_left.' ';

									$sibs_result3 = $wpdb->get_results( "SELECT * FROM {$tbl_sheet} WHERE sibs_key = 'pmt' AND invoice_id = {$inv_id}" );
									$sibs_result3_chk = $wpdb->num_rows;
									if ($sibs_result3_chk == 0) {
										//payment is not created
										$due_amount = $inv_amount;
									}else{
										if ($sibs_result3_chk > 1) {
											foreach ($sibs_result3 as $key) {
												 $pmt4 += $key->amount;
												}
												$due_amount = $inv_amount - $pmt4;
										}else{
											foreach ($sibs_result3 as $key) {
												 $pmt = $key->amount;
												 $due_amount = $inv_amount - $pmt;
												}
											}
									}
									}
									if ($current_date > $due_dat) {
										if ($days_left > 60 && $days_left < 91) {
											if ($pmt < $inv_amount) {
												$total_due_amount = $due_amount;
												if ($total_due_amount == 0) {
													echo $currency_sign . "0.00";
												}else{
													echo($currency_sign . $total_due_amount);
													$tdm3 = $total_due_amount;
												}
											}else{
												echo $currency_sign . "0.00";
											}
										}else{
											echo $currency_sign . "0.00";
										}
									}else{
										echo $currency_sign . "0.00";
									}
							?>
								
							</td>
						<td>

							<?php
								foreach($sibs_result2 as $key){
									$inv_id = $key->invoice_id;
									$inv_amount = $key->amount;

									//echo $current_date = date('d-m-Y');
									$current_date = strtotime(date('d-m-Y'));
									//$due_dat = $key->due_date;
									$due_dat = strtotime($key->due_date);
									$diff = $current_date - $due_dat; 
									$days_left = abs(floor($diff / (60*60*24)));
									// echo $days_left.' ';

									$sibs_result3 = $wpdb->get_results( "SELECT * FROM {$tbl_sheet} WHERE sibs_key = 'pmt' AND invoice_id = {$inv_id}" );
									$sibs_result3_chk = $wpdb->num_rows;
									if ($sibs_result3_chk == 0) {
										//payment is not created
										$due_amount = $inv_amount;
									}else{
										if ($sibs_result3_chk > 1) {
											foreach ($sibs_result3 as $key) {
												 $pmt5 += $key->amount;
												}
												$due_amount = $inv_amount - $pmt5;
										}else{
											foreach ($sibs_result3 as $key) {
												 $pmt = $key->amount;
												 $due_amount = $inv_amount - $pmt;
												}
											}
									}
										
								}
								if ($current_date > $due_dat) {
										if ($days_left > 90) {
											// $due_amount += $inv_amount;
											if ($pmt < $inv_amount) {
												$total_due_amount = $due_amount;
												//echo $days_left;
													if ($total_due_amount == 0) {
														echo $currency_sign . "0.00";
													}else{
														echo($currency_sign . $total_due_amount);
														$tdm4 = $total_due_amount;
													}
											}else{
												echo $currency_sign . "0.00";
											}
										}else{
											echo $currency_sign . '0.00';
										}
									}else{
										echo $currency_sign . '0.00';
									}
							?>
						</td>
						<td>
							<?php
								$tdm = $tdm1+$tdm2+$tdm3+$tdm4;
								if ($tdm == 0) {
									echo $currency_sign . '0.00';
								}else{
									echo $currency_sign . $tdm;
								}
							?>
						</td>
					</tr>	
				</table>
			</div>
		</div>
	</div>
</div>

