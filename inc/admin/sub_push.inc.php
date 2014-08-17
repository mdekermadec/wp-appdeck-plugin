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
          Push Notification
        </div>
    </div>
</nav>

<div class="container">

<h2>New Message <small>Send a Push Notification to all your mobile app users</small></h2>

<form class="form-horizontal" role="form" target="_blank" action="http://push.appdeck.mobi/send?apikey=<?php print htmlspecialchars($this->appdeck_credentials['api_key']); ?>&amp;secret=<?php print htmlspecialchars($this->appdeck_credentials['api_secret']); ?>" method="POST">
  <div class="form-group">
    <label for="title" class="col-xs-2 control-label">Title</label>
    <div class="col-xs-8">
      <input type="text" class="form-control" id="title" name="title" placeholder="Text of your Push Notification">
    </div>
  </div>
  <div class="form-group">
    <label for="url" class="col-xs-2 control-label">URL</label>
    <div class="col-xs-8">
      <input type="text" class="form-control" id="url" name="url" placeholder="http://www.website.com/page.html">
    </div>
  </div>
<!--  <div class="form-group">
    <label for="deviceuid" class="col-xs-2 control-label">UID</label>
    <div class="col-xs-10">
      <input type="text" class="form-control" id="deviceuid" name="deviceuid" placeholder="1A2B3C4D-12B7-419F-8535-8F1C9814ECBC">
      <p class="help-block">Leave UID empty to push all users. Each user as his own UID. This UID is available in <i>AppDeck-User-ID</i> HTTP Header.</p>
    </div>
    
  </div>  -->
  <div class="form-group">
    <div class="col-xs-offset-2 col-xs-8">
      <button type="submit" class="btn btn-primary">Send Push Notification</button>
    </div>
  </div>
</form>

</div><!--  // / container -->
</div><!--  // / bootstrap-wpadmin -->

</div><!-- 	// / postbox -->
</div><!--  // / wrap -->
<div class="clear"></div>
</div><!--  // / metabox-holder  -->