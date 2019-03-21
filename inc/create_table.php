<?php

global $wpdb;
$prefix = $wpdb->prefix;

$tbl_client = "CREATE TABLE IF NOT EXISTS `{$prefix}sibs_client`(
				`id` int(50) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				`client_id` int(50) NOT NULL,
				`client_name` varchar(100) NOT NULL,
				`client_address` varchar(150) NOT NULL,
				`client_website` varchar(50) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=latin1";

$tbl_invoice = "CREATE TABLE IF NOT EXISTS `{$prefix}sibs_invoice`(
				`id` int(50) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				`invoice_id` int(50) NOT NULL,
				`invoice_name` varchar(100) NOT NULL,
				`total_amount` int(100) NOT NULL,
				`deposit_amount` int(100) NOT NULL,
				`date` varchar(100) NOT NULL,
				`due_date` varchar(100) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=latin1";

$tbl_payment = "CREATE TABLE IF NOT EXISTS `{$prefix}sibs_payment`(
				`id` int(50) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				`payment_id` int(50) NOT NULL,
				`invoice_id` int(50) NOT NULL,
				`payment_amount` int(150) NOT NULL,
				`payment_method` varchar(50) NOT NULL,
				`payment_date` varchar(50) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=latin1";

$wpdb->query($tbl_client);
$wpdb->query($tbl_invoice);
$wpdb->query($tbl_payment);