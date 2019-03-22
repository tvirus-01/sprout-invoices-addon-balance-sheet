<?

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

$client_info = $wpdb->get_row( "SELECT * FROM {$tbl_client} WHERE id = {$cid}" );
 $client_id = $client_info->client_id;	
 $client_name = $client_info->client_name;
 $client_address = $client_info->client_address;
 $client_website = $client_info->client_website;

$sibs_query = "SELECT * FROM {$tbl_sheet} WHERE client_id = {$client_id}";
$sibs_result = $wpdb->get_results( $sibs_query );
