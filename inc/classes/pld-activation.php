<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!!' );
if ( !class_exists( 'PLD_Activation' ) ) {

	class PLD_Activation extends PLD_Library {

		/**
		 * Includes all the activation tasks
		 * 
		 * @since 1.0.0
		 */
		function __construct() {
			register_activation_hook( PLD_PATH . 'posts-like-dislike.php', array( $this, 'activation_tasks' ) );
		}
		
		/**
		 * Store default settings in database on activation
		 * 
		 * @since 1.0.0
		 */
		function activation_tasks() {
			$default_settings = $this->get_default_settings();
			if(!get_option('pld_settings')){
				update_option('pld_settings',$default_settings);
			}
		}

		

	}

	new PLD_Activation();
}