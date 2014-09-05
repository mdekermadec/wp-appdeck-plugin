<div class="wrap">
<div class="metabox-holder has-right-sidebar">
<div class="postbox" id="control">

<div class="bootstrap-wpadmin">

<!-- Bootstrap navbar with Title and AppDeck logo -->
<nav class="navbar navbar-default navbar-appdeck" role="navigation">
    <div class="pull-right">
        <div class="appdeck-logo" ></div>
    </div>
    <div class="navbar-header">
        <div class="navbar-brand">
          App Configuration
        </div>
    </div>
</nav>

<div class="container">

<?php 

wp_enqueue_script('appdeck-back-app-config');
wp_enqueue_script('colorpicker');

include( dirname(dirname(dirname( __FILE__ ))) . '/config/app_config.php' );
include( dirname(dirname(dirname( __FILE__ ))) . '/config/app_config_template.php' );

?>

</div><!--  // / container -->
</div><!--  // / bootstrap-wpadmin -->

</div><!-- 	// / postbox -->
</div><!--  // / wrap -->
<div class="clear"></div>
</div><!--  // / metabox-holder  -->