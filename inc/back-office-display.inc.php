<style>
#nav-config
{
  background-color: white !important;
  font-size: 14px;
  z-index: 1000;
  border-bottom: 1px solid #eee;
  width: 100%;
  max-width: 1140px;
  padding-top: 50px;
    /*margin-left: auto;
    margin-right: auto;*/

    padding-left: 15px;
    padding-right: 15px;  
}

#nav-config > ul > li > a {
    padding: 10px 14px;
}


#nav-config > ul > li.active > a {
  padding: 6px 10px;
  margin: 4px;
}

.affix {
  width: inherit; //helped keep the content the same size on fluid layouts
  position: fixed;
  top: 0px;  //height of the nav
}
.affix-bottom {
  width: inherit;
  position: absolute;
  top: auto;
  bottom: 51px;  //height of the footer
}
.affix-top {
  //i didn't need this style but you might
}

.advanced
{
  display: none;
}

.nav > li.advanced
{
    display: none;
}

</style>

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

<?php 

wp_enqueue_script('appdeck-back-app-config');
wp_enqueue_script('colorpicker');

include( dirname( dirname( __FILE__ ) ) . '/config/app_config.php' );
include( dirname( dirname( __FILE__ ) ) . '/config/app_config_template.php' );

?>

</div><!--  // / container -->
</div><!--  // / bootstrap-wpadmin -->

</div><!--  // / postbox -->
</div><!--  // / metabox-holder -->
<div class="clear"></div>
</div><!--  // / wrap  -->