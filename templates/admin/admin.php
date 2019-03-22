
<?php include plugin_dir_path( __FILE__ ).'../../modules/client.php'; ?>
<?php include plugin_dir_path( __FILE__ ).'../../modules/invoice.php'; ?>
<?php include plugin_dir_path( __FILE__ ).'../../modules/payment.php'; ?>
<?php $view_page = site_url( 'index.php/si-balance-sheet', null ); ?>

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
			<table class="table table-striped">
				<tr>
					<th>Client</th>
					<th>Address</th>
					<th>View</th>
				</tr>
				<?php foreach ($sibs_result2 as $key) { ?>
				<tr>
					<td><?php echo $key->client_name; ?></td>
					<td><?php echo $key->client_address; ?></td>
					<td><a href="<?php echo $view_page.'?cid='.$key->id; ?>" class="btn btn-sm btn-success" target="blank">View</a></td>
				</tr>		
				<?php } ?>
			</table>
		</div>
	</div>
</div>
