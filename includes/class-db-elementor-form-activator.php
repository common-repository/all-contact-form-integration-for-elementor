<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 * @author     Your Name <email@example.com>
 */
class DB_Elementor_Form_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function void_db_element_form_activate() {
		self::void_db_element_form_add_table();
		self::void_db_element_form_add_role();
 		self::cssfe_installation_time();

 		 $get_installation_time = strtotime("now");
		 add_option('void_db_element_elementor_activation_time', $get_installation_time ); 
		 update_option( 'dismissed-prefix_deprecated', FALSE ); 
	}

	private static function cssfe_installation_time() {
		update_option( 'cssfe_install_time', '1' );
	}


	private static function void_db_element_form_add_role() {
		add_role(
			'Elementor',
			__( 'Elementor Admin' ),
			array(
				'read'         => false,  // true allows this capability
				'edit_posts'   => false,
			)
		);
		 
	} 	 


	private  static function void_db_element_form_add_table(){

		global $wpdb; 

		$element_form =  $wpdb->prefix. 'db_element_form';

		if($wpdb->get_var("SHOW TABLES LIKE '$element_form'") != $element_form) { 

		$charset_collate = $wpdb->get_charset_collate(); 

			$sql = "CREATE TABLE $element_form (
			id mediumint(9) NOT NULL AUTO_INCREMENT, 
			submitedOn varchar(200) NOT NULL,
			formID varchar(200) NOT NULL,
			postID varchar(200) NOT NULL,
			email varchar(200) NOT NULL,
			message varchar(250) NOT NULL,
			submitedBy varchar(200) NOT NULL,
			formData text, 
			status varchar(200) DEFAULT 'unread', 
			cdate datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
			PRIMARY KEY  (id)
			) $charset_collate;";
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}
	
	}

}