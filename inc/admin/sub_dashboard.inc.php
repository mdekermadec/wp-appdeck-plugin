<?php

wp_enqueue_script('appdeck-back-dashboard');
wp_enqueue_script('morris');
wp_enqueue_style( 'morris' );

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
          Dashboard
        </div>
    </div>
</nav>

<div class="container">

    <div id="main-stats">
        <div class="row stats-row">
            <div class="col-xs-3 stat">
                <div class="data">
                    <span class="number" id="appdeck_stats_today_user"><i class="fa fa-cog fa-spin"></i></span>
                    users
                </div>
                <span class="date">Today</span>
                <span class="plus" id="appdeck_stats_today_new_user">+ <i class="fa fa-cog fa-spin"></i></span>
            </div>
            <div class="col-xs-3 stat">
                <div class="data">
                    <span class="number" id="appdeck_stats_month_visits"><i class="fa fa-cog fa-spin"></i></span>
                    visits
                </div>
                <span class="date">This month</span>
            </div>
            <div class="col-xs-3 stat">
                <div class="data">
                    <span class="number" id="appdeck_stats_week_push"><i class="fa fa-cog fa-spin"></i></span>
                    push
                </div>
                <span class="date">This week</span>
            </div>
            <div class="col-xs-3 stat last">
                <div class="data">
                    <span class="number" id="appdeck_stats_30days_ca"><i class="fa fa-cog fa-spin"></i></span>
                    ads
                </div>
                <span class="date">last 30 days</span>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <h4 class="clearfix">
            Visits
                <div class="btn-group pull-right">
                    <button data-unit="visits" data-period="week" class="refresh-stats btn btn-default btn-sm active">Week</button>
                    <button data-unit="visits" data-period="month" class="refresh-stats btn btn-default btn-sm">Month</button>
                    <button data-unit="visits" data-period="year" class="refresh-stats btn btn-default btn-sm">Year</button>
                    <button data-unit="visits" data-period="all" class="refresh-stats btn btn-default btn-sm">All</button>
                </div>
        </h4>
    </div>
    <div class="col-xs-12">
        <div id="visitschart" style="height: 250px;"></div>
    </div>

    <div class="col-xs-12">
        <h4 class="clearfix">
            Users
            	<div class="btn-group pull-right">
    				<button data-unit="users" data-unit-extra="newusers" data-period="week" class="refresh-stats btn btn-default btn-sm active">Week</button>
    				<button data-unit="users" data-unit-extra="newusers" data-period="month" class="refresh-stats btn btn-default btn-sm">Month</button>
    			</div>
        </h4>
    </div>
    <div class="col-xs-6">
        <div id="userschart" style="height: 250px;"></div>
    </div>
    <div class="col-xs-6">
        <div id="newuserschart" style="height: 250px;"></div>
    </div>

</div><!--  // / container -->
</div><!--  // / bootstrap-wpadmin -->

</div><!-- 	// / postbox -->
</div><!--  // / wrap -->
<div class="clear"></div>
</div><!--  // / metabox-holder  -->