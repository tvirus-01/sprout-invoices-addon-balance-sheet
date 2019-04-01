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
	public $templates;

	function activate() {
		require_once plugin_dir_path( __FILE__ ).'inc/create_table.php';
		require_once plugin_dir_path( __FILE__ ).'inc/create_page.php';
	}

	function register() {
		add_action( 'admin_menu', array($this, 'admin_menu_page') );

		$this->templates =array(
			'templates/main/si_balancesheet.php' => 'si-balance-sheet'
		);

		add_filter( 'theme_page_templates', array( $this, 'balancesheet_template' ) );
		add_filter( 'template_include', array( $this, 'load_balancesheet' ) );
	}

	public function admin_menu_page() {
		//add menu page
		add_menu_page( 'SI Balance sheet', 'Balance Sheet', 'manage_options', 'sa_balance', array($this, 'admin_menu_index'), 'dashicons-media-spreadsheet', 25 );
	}

	public function admin_menu_index(){
		// add template, module
		require_once plugin_dir_path( __FILE__ ).'templates/admin/admin.php';
	}

	function deactivate() {

		global $wpdb;
		$prefix = $wpdb->prefix;
		$tbl_client = "{$prefix}sibs_client";
		$tbl_posts = "{$prefix}posts";
		//delete page
		//$page = get_posts( 'post_tpe' => 'page', 'post_title' => 'si-balance-sheet' );							
		$page = $wpdb->get_row( "SELECT * FROM {$tbl_posts} WHERE post_type = 'page' AND post_title = 'si-balance-sheet'" );							

			$post_id = $page->ID;
			delete_post_meta( $post_id, '_wp_page_template' );
			delete_post_meta( $post_id, '_edit_lock' );
			wp_delete_post( $post_id, true );

		//delte table

		$tbl_sheet = "{$prefix}sibs_sheet";
		$wpdb->query( "DROP TABLE {$tbl_client}" );
		$wpdb->query( "DROP TABLE {$tbl_sheet}" );
	}

	public function balancesheet_template( $templates ) {
		$templates = array_merge($templates, $this->templates);

		return $templates;
	}

	public function load_balancesheet( $template ) {
		global $post;

		if (!$post) {
			return $template;
		}

		$template_name = get_post_meta( $post->ID, '_wp_page_template', true );

		if (!isset($this->templates[$template_name])) {
			return $template;
		}

		$file = plugin_dir_path( __FILE__ ) . $template_name;

		if (file_exists($file)) {
			return $file;
		}

		return $template;

	}

}

if (class_exists('si_balance_sheet')) {
	$si_balance_sheet = new si_balance_sheet();
	$si_balance_sheet->register();
}


############################ Activation ############################

register_activation_hook( __FILE__, array($si_balance_sheet, 'activate') );


############################ Deactivation ############################

register_deactivation_hook( __FILE__, array($si_balance_sheet, 'deactivate') );