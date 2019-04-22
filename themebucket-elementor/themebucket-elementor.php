<?php
/*
Plugin Name: Themebucket Elementor Addon
Plugin URI:
Description: Elementor addon Plugin
Version: 1.0.0
Author: Keramot UL Islam
Author URI: https://abmsourav.com
License: GPLv2 or later
Text Domain: themebucket-elementor
Domain Path: /languages/
*/

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	die( __( "Direct Access is not allowed", 'themebucket-elementor' ) );
}

final class ThemebucketElementor {

	const VERSION = "1.0.0";
	const MINIMUM_ELEMENTOR_VERSION = "2.0.0";
	const MINIMUM_PHP_VERSION = "7.0";

	private static $_instance = null;

	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	public function __construct() {
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	public function init() {

		load_plugin_textdomain( 'themebucket-elementor' );

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		// Register assets for editor
		add_action('elementor/editor/after_enqueue_scripts', function() {
			wp_enqueue_style( 'twentytwenty-css', plugin_dir_url(__FILE__).'/assets/css/twentytwenty.css', array(), '2.0.0' );
		
			wp_enqueue_script( 'twentytwenty-event', plugin_dir_url(__FILE__).'/assets/js/jquery.event.move.js', array( 'jquery' ), '2.0.0', true );
			wp_enqueue_script( 'twentytwenty-js', plugin_dir_url(__FILE__).'/assets/js/jquery.twentytwenty.js', array( 'jquery' ), '2.0.0', true );
			wp_enqueue_script( 'main-js', plugin_dir_url(__FILE__).'/assets/js/main.js', array( 'jquery' ), '1.0.0', true );
		});

		add_action( "elementor/elements/categories_registered", [ $this, 'register_category' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'register_assets' ] );
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );

	}

	//admin panel notice
	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
		/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'themebucket-elementor' ),
			'<strong>' . esc_html__( 'Themebucket Elementor AddOn', 'themebucket-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'themebucket-elementor' ) . '</strong>'
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	// minimum elementor version
	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
		/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'themebucket-elementor' ),
			'<strong>' . esc_html__( 'Themebucket Elementor AddOn', 'themebucket-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'themebucket-elementor' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	// minimum php version
	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
		/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'themebucket-elementor' ),
			'<strong>' . esc_html__( 'Themebucket Elementor AddOn', 'themebucket-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'themebucket-elementor' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	// Register category
	public function register_category( $manager ) {
		$manager->add_category( 'themebucket',[
			'title' => esc_html__( 'Theme bucket', 'themebucket-elementor' ),
			'icon'  => 'fa fa-image'
		]);
	}

	// Register assets for frontend
	public function register_assets() {
		wp_enqueue_style( 'twentytwenty-css', plugin_dir_url(__FILE__).'/assets/css/twentytwenty.css', array(), '2.0.0' );
		
		wp_enqueue_script( 'twentytwenty-event', plugin_dir_url(__FILE__).'/assets/js/jquery.event.move.js', array( 'jquery' ), '2.0.0', true );
		wp_enqueue_script( 'twentytwenty-js', plugin_dir_url(__FILE__).'/assets/js/jquery.twentytwenty.js', array( 'jquery' ), '2.0.0', true );
		wp_enqueue_script( 'main-js', plugin_dir_url(__FILE__).'/assets/js/main.js', array( 'jquery' ), '1.0.0', true );
	}

	// Register widgets
	public function init_widgets() {
		require_once( __DIR__ . '/widgets/themebucket-slider.php' );

		Plugin::instance()->widgets_manager->register_widget_type( new ThemebucketSlider() );
	}

}
ThemebucketElementor::instance();