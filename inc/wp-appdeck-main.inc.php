<?php
/** WP Appdeck Plugin main class **/
class ydApdkPlugin extends YD_Plugin {
	
	const	MENU_ICON	= 'img/rocket.png';
		
	/** 
	 * Constructor
	 * 
	 */
	public function __construct( $opts ) {

		parent::YD_Plugin( $opts );
		$this->form_blocks = $opts['form_blocks']; // YD Legacy (was to avoid "backlinkware")
		
		if( is_admin() ) {
			
			/** Create our admin menu and register our stylesheets **/
			add_action( 'admin_menu', array( $this, 'setupCustomMenu' ) );
			
			/** Load admin css **/
			//add_action( 'admin_init',	array( $this, 'addAdminStylesheets' ) );
			
			/** Load admin js **/
			add_action('admin_enqueue_scripts', array( $this, 'loadAdminScripts' ) );
		}
	}
	
	/**
	 * Create our admin menu
	 *
	 */
	public function setupCustomMenu() {
		$page = add_menu_page( 
			'Appdeck', 
			'Appdeck', 
			'activate_plugins', 
			'appdeck-setup', 
			array( $this, 'appdeckSetup'), 
			plugins_url( self::MENU_ICON, dirname( __FILE__ ) ), 
			91
		);
		/** Using registered $page handle to hook stylesheet loading **/
		add_action( 'admin_print_styles-' . $page, array( $this, 'addAdminStylesheets' ) );
	}
	
	/**
	 * Load additional admin stylesheets
	 *
	 */
	function addAdminStylesheets() {
		wp_register_style( 'bs-switch', plugins_url( 'css/bootstrap-switch.css', dirname( __FILE__ ) ) );
		wp_enqueue_style( 'bs-switch' );
	}

	/**
	 * Loads js/ajax scripts
	 *
	 */
	public function loadAdminScripts( $hook ) {
	
		/** Only load on our own admin page **/
		if( 'toplevel_page_appdeck-setup' != $hook )
			return $hook;
	
		wp_enqueue_script('jquery');
		wp_enqueue_script('colorpicker');
		wp_enqueue_script(
			'bs-switch',
			plugins_url( 'js/bootstrap-switch.js', dirname( __FILE__ ) ),
			array( 'jquery' ),
			'0.1',
			true
		);
	}
	
	/**
	 * AppDeck setup screen
	 * 
	 */
	public function appdeckSetup() {
		include( 'back-office-display.inc.php' );
	}
}
?>