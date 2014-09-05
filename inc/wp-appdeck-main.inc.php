<?php
/** WP Appdeck Plugin main class **/
class ydApdkPlugin extends YD_Plugin {
	
	const	MENU_ICON	= 'img/rocket.png';
	
	private $submenus	= array(
		'Dashboard' => 'dashboard',
		'Advertisement' => 'advertisement',
		'Statistics' => 'statistics',
		'Configuration' => 'configuration',
		'App Config' => 'app_config',
		'Push' => 'push',
		//'emulator' => 'emulator',
		'Publication' => 'publication'
	);
	
	private $appdeck_credentials = array(
		'api_secret'	=> '',
		'api_key'		=> ''
	);
	
	private $appdeck_settings = array(
		'theme'			=> ''
	);
	
	/**
	 * Headers for style.css files.
	 *
	 * @static
	 * @access private
	 * @var array
	 */
	private static $file_headers = array(
			'Name'        => 'Theme Name',
			'ThemeURI'    => 'Theme URI',
			'Description' => 'Description',
			'Author'      => 'Author',
			'AuthorURI'   => 'Author URI',
			'Version'     => 'Version',
			'Template'    => 'Template',
			'Status'      => 'Status',
			'Tags'        => 'Tags',
			'TextDomain'  => 'Text Domain',
			'DomainPath'  => 'Domain Path',
	);
	
	/** 
	 * Constructor
	 * 
	 */
	public function __construct( $opts ) {

		parent::YD_Plugin( $opts );
		$this->form_blocks = $opts['form_blocks']; // YD Legacy (was to avoid "backlinkware")
		
		$this->appdeck_credentials = get_option(
				'appdeck_credentials',
				array(
						'api_secret'	=> '',
						'api_key'		=> ''
				)
		);
		
		$this->appdeck_settings = get_option(
				'appdeck_settings',
				array(
						'theme'			=> 'default'
				)
		);
				
		if( is_admin() ) {
						
			/** Create our admin menu and register our stylesheets **/
			add_action( 'admin_menu', array( $this, 'setupCustomMenu' ) );
			
			/** Load admin css **/
			add_action( 'admin_init',	array( $this, 'addAdminStylesheets' ) );
			
			/** Load admin js **/
			add_action('admin_enqueue_scripts', array( $this, 'loadAdminScripts' ) );

			/** ajax **/
			add_action('wp_ajax_appdeckconfig', array( $this, 'appdeckConfig'));


		} else {
			
			/** Create our own URL prefix for displaying app mobile content **/
			add_filter( 'query_vars', array( $this, 'addQueryVars' ) );
			add_action( 'parse_request', array( $this, 'parseRequests' ) );
			add_action( 'init', array( $this, 'addRewriteRule') );
			//TODO: flush rewrite rules upon plugin install
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
		
		foreach( $this->submenus as $submenu_title => $submenu ) {
			add_submenu_page( 
				'appdeck-setup', 
				$submenu_title, 
				$submenu_title, 
				'activate_plugins', 
				'appdeck-setup/' . $submenu,
				array( $this, 'submenu_' . $submenu )
			);
		}
		
	}
	
	/** 
	 * Submenus
	 * 
	 */
	function submenu_dashboard() {
		include_once( dirname( __FILE__ ) . '/admin/sub_dashboard.inc.php' );
	}
	function submenu_advertisement() {
		include_once( dirname( __FILE__ ) . '/admin/sub_advertisement.inc.php' );
	}
	function submenu_statistics() {
		include_once( dirname( __FILE__ ) . '/admin/sub_statistics.inc.php' );
	}
	function submenu_configuration() {
		include_once( dirname( __FILE__ ) . '/admin/sub_configuration.inc.php' );
	}
	function submenu_app_config() {
		include_once( dirname( __FILE__ ) . '/admin/sub_app_config.inc.php' );
	}
	function submenu_push() {
		include_once( dirname( __FILE__ ) . '/admin/sub_push.inc.php' );
	}
	function submenu_emulator() {
		include_once( dirname( __FILE__ ) . '/admin/sub_emulator.inc.php' );
	}
	function submenu_publication() {
		include_once( dirname( __FILE__ ) . '/admin/sub_publication.inc.php' );
	}
	
	/**
	 * Load additional admin stylesheets
	 *
	 */
	function addAdminStylesheets() {

		// bootstrap wpadmin css from Twitter Bootstrap wordpress plugin
		// http://www.hostliketoast.com/2012/04/twitter-bootstrap-css-libraries-now-available-in-wordpress-admin/
		wp_register_style( 'bootstrap-wpadmin', plugins_url( 'css/bootstrap-wpadmin.css', dirname( __FILE__ ) ) );
		wp_register_style( 'bootstrap-wpadminfix', plugins_url( 'css/bootstrap-wpadmin-fixes.css', dirname( __FILE__ ) ), array( 'bootstrap-wpadmin' ) );		

		wp_register_style( 'bs-switch', plugins_url( 'css/bootstrap-switch.min.css', dirname( __FILE__ ) ) , array( 'bootstrap-wpadminfix' ));
		wp_register_style( 'morris', plugins_url( 'css/morris.css', dirname( __FILE__ ) ) );
		wp_register_style( 'font-awesome', plugins_url( 'css/font-awesome.min.css', dirname( __FILE__ ) ) );
		wp_register_style( 'wp-appdeck', plugins_url( 'css/wp-appdeck.css', dirname( __FILE__ ) ) , array( 'bootstrap-wpadminfix' ));
		
		wp_register_style( 'daterangepicker-bs3', plugins_url( 'css/daterangepicker-bs3.css', dirname( __FILE__ ) ) );

		// always load bootstrap and commons css
		wp_enqueue_style( 'bootstrap-wpadmin' );
		wp_enqueue_style( 'bootstrap-wpadminfix' );
		wp_enqueue_style( 'font-awesome' );
		wp_enqueue_style( 'wp-appdeck' );

	}

	/**
	 * Loads appdeck credential as inline javascript
	 *
	 */
	public function admin_inline_js()
	{
		echo "<script type='text/javascript'>\n";
		echo "var appdeck_api_key = \"{$this->appdeck_credentials['api_key']}\";\r\n";
		echo "var appdeck_api_secret = \"{$this->appdeck_credentials['api_secret']}\";\r\n";
		echo "\n</script>";
	}

	/**
	 * Loads js/ajax scripts
	 *
	 */
	public function loadAdminScripts( $hook ) {
	
		//wp_die($hook);	//Debug
		/** Only load on our own admin page **/
		if( 
			'toplevel_page_appdeck-setup' != $hook &&
			!preg_match( '#^appdeck_page_appdeck-setup/#', $hook )
		)
			return $hook;

		// insert in javascript appdeck credential
		add_action( 'admin_print_scripts', array($this, 'admin_inline_js') );

		// force prototype to not load as we prefer use jquery for $ var and this script is not used by us
		//wp_deregister_script('prototype');
        //wp_deregister_script( 'scriptaculous-effects' );

		wp_enqueue_script( 'jquery' );

		// bootstrap
		wp_register_script(
			'bootstrap',
			plugins_url( 'js/bootstrap.min.js', dirname( __FILE__ ) ),
			array( 'jquery' ),
			'3.2.0',
			true
		);

		wp_register_script(
			'bs-switch',
			plugins_url( 'js/bootstrap-switch.min.js', dirname( __FILE__ ) ),
			array( 'bootstrap' ),
			'3.0.2',
			true
		);

		// appdeck

		wp_register_script(
			'appdeck-back',
			plugins_url( 'js/appdeck-back.js', dirname( __FILE__ ) ),
			array( 'jquery' ),
			'0.1',
			true
		);

		wp_register_script(
			'appdeck-back-dashboard',
			plugins_url( 'js/appdeck-back-dashboard.js', dirname( __FILE__ ) ),
			array( 'appdeck-back' ),
			'0.1',
			true
		);

		wp_register_script(
			'appdeck-back-advertisement',
			plugins_url( 'js/appdeck-back-advertisement.js', dirname( __FILE__ ) ),
			array( 'appdeck-back' ),
			'0.1',
			true
		);

		wp_register_script(
			'appdeck-back-statistics',
			plugins_url( 'js/appdeck-back-statistics.js', dirname( __FILE__ ) ),
			array( 'appdeck-back' ),
			'0.1',
			true
		);

		wp_register_script(
			'appdeck-back-app-config',
			plugins_url( 'js/appdeck-back-app-config.js', dirname( __FILE__ ) ),
			array( 'appdeck-back', 'bootstrap-colorpicker' ),
			'0.1',
			true
		);

		// morris js

		wp_register_script(
			'raphael',
			plugins_url( 'js/raphael-min.js', dirname( __FILE__ ) ),
			array( 'jquery' ),
			'2.1.0',
			true
		);

		wp_register_script(
			'morris',
			plugins_url( 'js/morris.min.js', dirname( __FILE__ ) ),
			array( 'raphael' ),
			'0.5.1',
			true
		);

		// moment

		wp_register_script(
			'moment',
			plugins_url( 'js/moment.js', dirname( __FILE__ ) ),
			array( ),
			'2.8.1',
			true
		);

		// date range picker
		wp_register_script(
			'daterangepicker',
			plugins_url( 'js/daterangepicker.js', dirname( __FILE__ ) ),
			array( 'jquery', 'bootstrap', 'moment'),
			'1.3.11',
			true
		);		


		// color picker
		wp_register_script(
			'bootstrap-colorpicker',
			plugins_url( 'js/bootstrap-colorpicker.min.js', dirname( __FILE__ ) ),
			array( 'jquery', 'bootstrap'),
			'1.0',
			true
		);		

		// always load bootstrap and commons js
		wp_enqueue_script('appdeck-back');
		wp_enqueue_script('bootstrap');
		wp_enqueue_script('jquery');
		wp_enqueue_script('colorpicker');

	}
	
	/**
	 * Builds the drop-down list of available themes
	 * for this plugin
	 *
	 */
	function themeLister() {
		$found_themes = array();
		$theme_root = dirname( dirname( __FILE__ ) ) . '/themes';
		//echo 'theme dir: ' . $theme_root . '<br/>';	//Debug
	
		$dirs = @ scandir( $theme_root );
		foreach ( $dirs as $k=>$v ) {
			if( ! is_dir( $theme_root . '/' . $dir ) || $dir[0] == '.' || $dir == 'CVS' ) {
				unset( $dirs[$k] );
			} else {
				$dirs[$k] = array(
						'path' => $theme_root . '/' . $v,
						'url' => plugins_url( 'themes/' . $v, dirname( __FILE__ ) )
				);
			}
		}
	
		/** Load add-on themes **/
		$dirs = apply_filters( 'appdeck_themedirs', $dirs );

		if ( ! $dirs )
			return false;
		//var_dump( $dirs );	//Debug
		foreach ( $dirs as $dir ) {
			//echo 'dir: ' . $dir . '<br/>';	//debug
			if ( file_exists( $dir['path'] . '/style.css' ) ) {
				$headers = get_file_data( $dir['path'] . '/style.css', self::$file_headers, 'theme' );
				//var_dump( $headers );	//Debug
				$name = $headers['Name'];
				if( 'AppDeck Default Theme' == $name )
					$name = ' ' . $name;	// <- this makes it sort always first
				$found_themes[ $dir['path'] ] = array(
						'name'			=> $name,
						'dir'			=> basename( $dir['path'] ),
						'theme_file'	=> $dir['path'] . '/style.css',
						'theme_root'	=> $dir['path'],
						'theme_url'		=> $dir['url']
				);
			}
		}
		asort( $found_themes );
		return $found_themes;
	}
	
	/**
	 * AppDeck setup screen
	 * 
	 */
	public function appdeckSetup() {
		include( 'back-office-display.inc.php' );
	}
	
	/**
	 * Add our RewriteRule
	 * (mobile app endpoint)
	 * 
	 */
	public function addRewriteRule() {
		add_rewrite_rule( '^appdeck(/.*)?$','index.php?__appdeck=1', 'top' );
	}
	public function addQueryVars( $vars ) {
		$vars[] = '__appdeck';
		return $vars;
	}
	public function parseRequests() {
		global $wp;
		if(isset($wp->query_vars['__appdeck'])){
			$this->handleRequest();
			exit;
		}
	}
	
	/** AJAX **/

	function appdeckConfig()
	{
		print require( dirname(dirname( __FILE__ )) . '/config/app_config.php' );
		exit;
	}


	/**
	 * Process AppDeck content URLs
	 * (meant for the mobile app)
	 * 
	 */
	public function handleRequest() {
		$suffix = preg_replace( '#^/appdeck/?#', '', $_SERVER['REQUEST_URI'] );
		
		if( '' === $suffix )
			$suffix = 'home';
		
		if( preg_match( '/\.css|\.js$/', $suffix ) ) {
			$template_file = $this->appdeck_settings['theme'] . '/' . $suffix;
		} else {
			$template_file = $this->appdeck_settings['theme'] . '/' . $suffix . '.php';
		}
		
		if( file_exists( $template_file ) ) {
			
			load_template( $template_file );
			
		} else {
			
			echo '<p>Error: unknown AppDeck endpoint!</p>';
			
		}
	}
}
?>