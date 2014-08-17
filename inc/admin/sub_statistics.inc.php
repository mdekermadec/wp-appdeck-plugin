<?php

wp_enqueue_script('appdeck-back-statistics');
//wp_enqueue_script('bs-switch');
//wp_enqueue_style( 'bs-switch' );

wp_enqueue_script('daterangepicker');
wp_enqueue_style( 'daterangepicker-bs3' );

//wp_enqueue_script( 'GoogleOrgChartScript', 'https://www.google.com/jsapi');

?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
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
          Statistics
        </div>
    </div>
</nav>

<div class="container">

<ul class="nav nav-tabs stats-type" role="tablist">
  <li class="active"><a href="#" data-type="Users">Users</a></li>
  <li><a href="#" data-type="Devices">Devices</a></li>
  <li><a href="#" data-type="Hours">Hours</a></li>
  <li><a href="#" data-type="Countries">Countries</a></li>
  <li><a href="#" data-type="Visits">Visits</a></li>
  <li><a href="#" data-type="Time">Time</a></li>
  <li><a href="#" data-type="View">View/Session</a></li>
  <li><a href="#" data-type="View">View</a></li>
  <li><a href="#" data-type="Share">Share</a></li>
  <li><a href="#" data-type="Screens">Screens</a></li>
  <li><a href="#" data-type="Version">Version</a></li>
  <li><a href="#" data-type="Langue">Langue</a></li>
  <li><a href="#" data-type="Installation">Installation</a></li>
  <li><a href="#" data-type="Revenue">Revenue</a></li>
</ul>

<p>&nbsp;</p>

<div class="panel panel-default">
  <div class="panel-body">
    <div id="reportrange" class="pull-right">
  		<i class="fa fa-calendar"></i>
		<span id="reportrangespan">&nbsp;</span> <b class="caret"></b>
    </div>
  </div>
</div>

<div id="chart_div" style="width: 100%; height: 600px;"></div>
<div id="chart_div_loading" style="width: 100%; height: 600px;text-align: center;"><img src="http://static.appdeck.mobi/lib/imgs/loadingtxt.gif" /></div>


</div><!--  // / container -->
</div><!--  // / bootstrap-wpadmin -->

</div><!-- 	// / postbox -->
</div><!--  // / wrap -->
<div class="clear"></div>
</div><!--  // / metabox-holder  -->