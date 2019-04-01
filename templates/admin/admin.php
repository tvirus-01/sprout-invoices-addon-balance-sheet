
<?php include plugin_dir_path( __FILE__ ).'../../modules/client.php'; ?>
<?php include plugin_dir_path( __FILE__ ).'../../modules/invoice.php'; ?>
<?php include plugin_dir_path( __FILE__ ).'../../modules/payment.php'; ?>
<?php $view_page = site_url( 'index.php/si-balance-sheet', null ); ?>
<?php
	$sibs_clires = $wpdb->get_results( "SELECT * FROM {$tbl_client}" );
	$sibs_clires_chk = $wpdb->num_rows;
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<style type="text/css">
	/*th{
		font-size: 22px !important;
	    font-weight: 600 !important;
	}
	td{
		font-size: 18px !important;
		font-weight: 400px !important;
	}
	tr{
		height: 52px !important;
	}*/
</style>

<div class="container-fluid p-3">
	<span class="text-dark h2">Balance Sheet</span>
	<br>
	<br>
	<div class="row justify-content-center">
		<div class="col">
			<?php if ($sibs_clires_chk == 0) { ?>
				<div class="text-center">
					<h3 class="alert alert-warning">No client data is available</h3>
				</div>
			<?php }else{ ?>
			<table class="table table-striped">
				<tr>
					<th>Client</th>
					<th>Address</th>
					<th>View</th>
				</tr>
				<?php foreach ($sibs_clires as $key) { ?>
				<tr>
					<td><?php echo $key->client_name; ?></td>
					<td><?php echo $key->client_address; ?></td>
					<td><a href="<?php echo $view_page.'?'.$key->client_slug; ?>" class="btn btn-sm btn-success" target="blank">View</a></td>
				</tr>		
				<?php } ?>
			</table>
		<?php } ?>
		</div>
	</div>
</div>
