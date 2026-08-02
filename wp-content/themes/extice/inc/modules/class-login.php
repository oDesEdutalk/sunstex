<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Extice_Login' ) ) :
	class Extice_Login {
		public function __construct() {
			add_action( 'wp_ajax_extice_login', array( $this, 'ajax_login' ) );
			add_action( 'wp_ajax_nopriv_extice_login', array( $this, 'ajax_login' ) );

			add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 10 );
		}

		public function scripts(){

			wp_enqueue_script( 'extice-ajax-login', get_template_directory_uri() . '/assets/js/frontend/login.js', array('jquery'), EXTICE_VERSION, true );
		}

		public function ajax_login() {
			do_action( 'extice_ajax_verify_captcha' );
			check_ajax_referer( 'extice_ajax_nonce', 'nonce' );
			$info                  = array();
			$info['user_login']    = $_REQUEST['username'];
			$info['user_password'] = $_REQUEST['password'];
			$info['remember']      = $_REQUEST['remember'];

			$user_signon = wp_signon( $info, is_ssl() );
			if ( is_wp_error( $user_signon ) ) {
				wp_send_json( array(
					'status' => false,
					'msg'    => esc_html__( 'Wrong username or password. Please try again!!!', 'extice' )
				) );
			} else {
				wp_set_current_user( $user_signon->ID );
				wp_send_json( array(
					'status' => true,
					'msg'    => esc_html__( 'Signin successful, redirecting...', 'extice' )
				) );
			}
		}
	}
new Extice_Login();
endif;
