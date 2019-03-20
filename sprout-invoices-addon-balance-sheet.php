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
		
	}

	function deactivate() {

	}

	function unistall() {

	}
}

if (class_exists('si_balance_sheet')) {
	$si_balance_sheet = new si_balance_sheet();
}


############################ Activation ############################

register_activation_hook( __FILE__, array($si_balance_sheet, 'activate') );


############################ Deactivation ############################

register_activation_hook( __FILE__, array($si_balance_sheet, 'deactivate') );

############################ Unistall ############################