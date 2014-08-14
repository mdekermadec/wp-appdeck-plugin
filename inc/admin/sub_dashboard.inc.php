<div class="wrap">
<div id="icon-options-general" class="icon32"><br/></div>
<h2>Appdeck setup dashboard</h2>

<div class="metabox-holder has-right-sidebar">

<!-- /** WP standard admin block ( div postbox / h3 hndle / div inside / p ) **/ -->
<div class="postbox" id="control">
<h3 id="main_settings" class="hndle">Dashboard</h3>
<div class="inside">

<p>
Api secret: <?php echo htmlspecialchars( $this->appdeck_credentials['api_secret'] ); ?>
</p>
<p>
Api key: <?php echo htmlspecialchars( $this->appdeck_credentials['api_key'] ); ?>
</p>

<?php 

//TODO

?>

</div><!--  // / inside -->
</div><!-- 	// / postbox -->

</div><!--  // / wrap -->
<div class="clear"></div>

</div><!--  // / metabox-holder  -->