<?php
/** WP Appdeck Plugin main class **/
class ydApdkPlugin extends YD_Plugin {
	
	const	MENU_ICON	= 'img/rocket.png';
	
	private $submenus	= array(
		'dashboard',
		'advertisement',
		'statistics',
		'configuration',
		'push',
		'emulator',
		'publication'
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
			//add_action( 'admin_init',	array( $this, 'addAdminStylesheets' ) );
			
			/** Load admin js **/
			add_action('admin_enqueue_scripts', array( $this, 'loadAdminScripts' ) );
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
		
		foreach( $this->submenus as $submenu ) {
			add_submenu_page( 
				'appdeck-setup', 
				$submenu, 
				$submenu, 
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
		wp_register_style( 'bs-switch', plugins_url( 'css/bootstrap-switch.css', dirname( __FILE__ ) ) );
		wp_enqueue_style( 'bs-switch' );
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

		wp_enqueue_script('jquery');
		wp_enqueue_script('colorpicker');
		wp_enqueue_script(
			'bs-switch',
			plugins_url( 'js/bootstrap-switch.js', dirname( __FILE__ ) ),
			array( 'jquery' ),
			'0.1',
			true
		);
		wp_enqueue_script(
			'appdeck-back',
			plugins_url( 'js/appdeck-back.js', dirname( __FILE__ ) ),
			array( 'jquery' ),
			'0.1',
			true
		);
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