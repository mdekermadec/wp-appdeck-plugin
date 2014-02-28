<style>
#nav-config
{
  background-color: white !important;
  font-size: 14px;
  z-index: 1000;
  border-bottom: 1px solid #eee;
  width: 100%;
  max-width: 1140px;
  padding-top: 10px;
    margin-left: auto;
    margin-right: auto;
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
<div id="icon-options-general" class="icon32"><br/></div>
<h2>Appdeck setup</h2>

<div class="metabox-holder has-right-sidebar">

<!-- /** WP standard admin block ( div postbox / h3 hndle / div inside / p ) **/ -->
<div class="postbox" id="control">
<h3 id="main_settings" class="hndle">Main settings</h3>
<div class="inside">

<?php 

include( dirname( dirname( __FILE__ ) ) . '/config/app_config.php' );
include( dirname( dirname( __FILE__ ) ) . '/config/app_config_template.php' );

?>

</div><!--  // / inside -->
</div><!-- 	// / postbox -->

</div><!--  // / wrap -->
<div class="clear"></div>

</div><!--  // / metabox-holder  -->