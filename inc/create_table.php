<?php

global $wpdb;
$prefix = $wpdb->prefix;

$tbl_client = "CREATE TABLE IF NOT EXISTS `{$prefix}sibs_client`(
				`id` int(50) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				`client_id` int(50) NOT NULL,
				`client_name` varchar(100) NOT NULL,
				`client_address` varchar(150) NOT NULL,
				`client_website` varchar(50) NOT NULL,
				`client_slug` varchar(50) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=latin1";

$tbl_sheet = "CREATE TABLE IF NOT EXISTS `{$prefix}sibs_sheet`(
				`id` int(50) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				`invoice_id` int(50) NOT NULL,
				`client_id` int(50) NOT NULL,
				`sibs_key` varchar(100) NOT NULL,
				`amount` int(100) NOT NULL,
				`date` varchar(100) NOT NULL,
				`due_date` varchar(100) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=latin1";

$wpdb->query($tbl_client);
$wpdb->query($tbl_sheet);