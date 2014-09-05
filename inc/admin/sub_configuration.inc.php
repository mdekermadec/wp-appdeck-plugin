<div class="wrap">
<div id="icon-options-general" class="icon32"><br/></div>
<h2><?php echo __('Appdeck configuration', 'appdeck' ); ?></h2>

<form method="post">

<div class="metabox-holder has-right-sidebar">

<!-- /** WP standard admin block ( div postbox / h3 hndle / div inside / p ) **/ -->
<div class="postbox" id="control">
<h3 id="main_settings" class="hndle"><?php echo __('Appdeck account credentials', 'appdeck' ); ?></h3>
<div class="inside">

<?php 

/** Traitement du formulaire **/
if ( isset( $_POST['appdeck_account'] ) ) {

	if( ! wp_verify_nonce( $_POST['appdeck_account'], 'appdeck_account' ) ) 
		wp_die( __('WordPress back-office security error (nonce did not verify).', 'appdeck') );

	$this->appdeck_credentials = array(
		'api_secret'	=> sanitize_text_field( $_POST['api_secret'] ),
		'api_key'		=> sanitize_text_field( $_POST['api_key'] )
	);

	$this->appdeck_settings = array_merge(
		$this->appdeck_settings,
		array(
			'theme'	=> sanitize_text_field( $_POST['appdeck_theme'] )
		)
	);

	update_option( 'appdeck_credentials',	$this->appdeck_credentials );
	update_option( 'appdeck_settings',		$this->appdeck_settings );
}

?>
<table class="form-table">
<tbody>
<tr valign="top">
<th scope="row">
<label for="api_secret"><?php echo __('Appdeck API Secret', 'appdeck'); ?></label>
</th>
<td>
<input type="text" name="api_secret" id="api_secret" value="<?php echo htmlspecialchars( $this->appdeck_credentials['api_secret'] ); ?>" class="regular-text" />
</td>
</tr>
<tr valign="top">
<th scope="row">
<label for="api_key"><?php echo __('Appdeck API Key', 'appdeck'); ?></label>
</th>
<td>
<input type="text" name="api_key" id="api_key" value="<?php echo htmlspecialchars( $this->appdeck_credentials['api_key'] ); ?>" class="regular-text" />
</td>
</tr>
<tr valign="top">
<th>&nbsp;</th>
<td>
<input type="submit" value="<?php echo __('Submit'); ?>" />
</td>
</tr>
</tbody>
</table>

</div><!--  // / inside -->
</div><!-- 	// / postbox -->


<!-- /** WP standard admin block ( div postbox / h3 hndle / div inside / p ) **/ -->
<div class="postbox" id="control">
<h3 id="main_settings" class="hndle"><?php echo __( 'Theme choice and preview', 'appdeck' ); ?></h3>
<div class="inside">

<table class="form-table">
<tbody>
<tr valign="top">
<th scope="row">
<label for="theme" class="coltab"><?php echo __( 'Theme', 'appdeck' ); ?></label>
</th>
<td>
<select id="theme" name="appdeck_theme">
<?php

/** Sélecteur de thèmes **/

		$all_themes = (array)$this->themeLister();
		wp_localize_script( 'appdeck-back', 'themes', $all_themes );
		
		if( isset($this->appdeck_settings['theme']) )
			$theme_selected[$this->appdeck_settings['theme']] = ' selected="selected"';
		
		//var_dump( $all_themes );	//Debug
		foreach( $all_themes as $dir=>$theme ) {
			echo '<option value="' . $dir . '" ' . $theme_selected[$dir] . '>';
			echo $theme['name'];
			echo '</option>';	
		}
		echo '</select></td>';
		
		echo '<td rowspan="2">';	//fields
		echo '<div class="appdeck_theme_preview" style="width:100px;height:200px;">';
		
		/** enforce default (first found theme) **/
		if( !isset($this->appdeck_settings['theme']) || 'default' == $this->appdeck_settings['theme'] ) {
			reset($all_themes);
			$this->appdeck_settings['theme'] = key($all_themes);
		}
		
		if( isset($all_themes[$this->appdeck_settings['theme']]['theme_url']) ) {
			$screenshot_file_url = $all_themes[$this->appdeck_settings['theme']]['theme_url'] . '/screenshot.png';
			$screenshot_file_path = $all_themes[$this->appdeck_settings['theme']]['theme_root'] . '/screenshot.png';
		} else {
			$screenshot_file = false;
		}
		//echo 'screenshot file: ' . $screenshot_file . '<br/>';	//Debug
		if( $screenshot_file_path && file_exists( $screenshot_file_path ) ) {
			echo '<img id="appdeck_preview_img" alt="preview" src="' . $screenshot_file_url . 
				'" style="width:100%;height:100%;" />';
		}
		
		echo '</div>';

?>
</td>
</tr>
<tr valign="top">
<th>&nbsp;</th>
<td>
<input type="submit" value="<?php echo __('Submit'); ?>" />
</td>
</tr>
</tbody>
</table>
		
</div><!--  // / inside -->


<div class="bootstrap-wpadmin">

<!-- Bootstrap navbar with Title and AppDeck logo -->
<nav class="navbar navbar-default navbar-appdeck" role="navigation">
    <div class="pull-right">
        <div class="appdeck-logo" ></div>
    </div>
    <div class="navbar-header">
        <div class="navbar-brand">
          App Config
        </div>
    </div>
</nav>

<div class="container">

<p>ici</p>

</div><!--  // / container -->
</div><!--  // / bootstrap-wpadmin -->



</div><!-- 	// / postbox -->

</div><!--  // / wrap -->
<div class="clear"></div>

</div><!--  // / metabox-holder  -->

<?php wp_nonce_field('appdeck_account','appdeck_account'); ?>
</form>