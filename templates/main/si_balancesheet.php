<?php

/*
Template Name: si-balance-sheet
*/

require_once plugin_dir_path( __FILE__ ).'../../inc/wpdb_tbl.php';

if (!isset($_GET['cid'])) {
	header('Location:'.site_url( '', null ));
}

include plugin_dir_path( __FILE__ ).'../../modules/sibs_main.php';

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
					<?php $balance = 0; ?>
					<?php foreach($sibs_result as $key){ ?>
					<?php
						$transaction = $key->sibs_key;
						if ($transaction == 'deposit') {
							$transaction = 'Balance';
							$amount = $key->amount;
							$balance = $balance + $amount;
						}elseif ($transaction == 'inv') {
							$transaction = 'INV';
							$amount = $key->amount;
							$balance = $balance + $amount;
						}elseif ($transaction == 'pmt') {
							$transaction = 'PMT';
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
					<?php echo $amount;  ?>
					<?php echo "</td>";  ?>
					<?php echo "<td>";  ?>
					<?php echo $balance;  ?>
					<?php echo "</td>";  ?>
					<?php echo "</tr>";  ?>
					<?php } ?>	
				</table>
			</div>
		</div>
	</div>
</div>
