<?php

#################################################################################################
#################################################################################################
############################### sprout-invoices-addon-balance-sheet #############################
#################################################################################################
#################################################################################################


/*
Plugin Name: sprout-invoices-addon-balance-sheet
Plugin URI: http://shaki.tk/
Description: A way for customers to keep amount and balance to correlation with each other. The amount is basically the amount of an invoice, or the amount of a payment made.
Author: Syed
Version: 0.0.1
Author URI: http://shaki.tk/
Licence: MIT
*/

############################ main class ############################

class si_balance_sheet
{
	function activate() {
		require_once plugin_dir_path( __FILE__ ).'inc/create_table.php';
	}

	function register() {
		add_action( 'admin_menu', array($this, 'admin_menu_page') );
	}

	public function admin_menu_page() {
		//add menu page
		add_menu_page( 'SI Balance sheet', 'Balance Sheet', 'manage_options', 'sa_balance', array($this, 'admin_menu_index'), 'dashicons-media-spreadsheet', 25 );
	}

	public function admin_menu_index(){
		// add template
		require_once plugin_dir_path( __FILE__ ).'templates/admin/admin.php';
	}

	function deactivate() {

	}

	function unistall() {

	}
}

if (class_exists('si_balance_sheet')) {
	$si_balance_sheet = new si_balance_sheet();
	$si_balance_sheet->register();
}


############################ Activation ############################

register_activation_hook( __FILE__, array($si_balance_sheet, 'activate') );


############################ Deactivation ############################

register_activation_hook( __FILE__, array($si_balance_sheet, 'deactivate') );

############################ Unistall ############################