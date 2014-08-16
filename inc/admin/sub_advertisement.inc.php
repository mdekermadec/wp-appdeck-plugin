<?php

wp_enqueue_script('appdeck-back-advertisement');
wp_enqueue_script('bs-switch');
wp_enqueue_style( 'bs-switch' );

?>

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
          Advertisement
        </div>
    </div>
</nav>

<div class="container">

<ul class="nav nav-tabs" role="tablist">
  <li class="active"><a href="#">Configuration</a></li>
  <li><a href="#">Revenue</a></li>
</ul>

<div class="appdeck-ajax-page-loading">
	<i class="fa fa-cog fa-spin fa-5x"></i>
</div>

<form role="form-horizontal" id="ads" style="display: none;">

  <div class="form-group">
    <p class="help-block">Click to enable/disable Advertisement in your application.</p>
  </div>
  <div class="checkbox" >
    <div>
    	<input type="checkbox" data-size="large" data-label-text="Ads" data-on-color="success" data-off-color="danger" id="ads_enabled">
	</div>
  </div>


  <div id="ads_options">

	  <h2>Ads Format</h2>

	  <div class="form-group">
	    <label for="banner" class="col-sm-2 control-label">Banner</label>
	    <div class="make-switch" >
	    	<input name="banner" type="checkbox" id="banner">
	    </div>
	  </div>
	  <div class="form-group">
	    <label for="rectangle" class="col-sm-2 control-label">Rectangle</label>
	    <div>
	    	<input name="rectangle" type="checkbox" id="rectangle">
		</div>
	  </div>
	  <div class="form-group">
	    <label for="interstitial" class="col-sm-2 control-label">Interstitial</label>
	    <div class="make-switch">
	    	<input name="interstitial" type="checkbox" id="interstitial">
		  </div>	
	  </div>

  </div>

</form>

</div><!--  // / container -->
</div><!--  // / bootstrap-wpadmin -->

</div><!-- 	// / postbox -->
</div><!--  // / wrap -->
<div class="clear"></div>
</div><!--  // / metabox-holder  -->