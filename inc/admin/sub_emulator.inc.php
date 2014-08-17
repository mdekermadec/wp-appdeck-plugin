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
          Emulator
        </div>
    </div>
</nav>

<div class="container">

<p>As AppDeck create real native app, to test your app, you must use either a real phone or an emulator.</p>

<h4>From your Internet browser</h4>

<p>You can use this online emulator. It's a real device emulator provided by app.io. It's very easy to use, but not as fast as a real device or a local emulator.</p>

<button target="_blank" class="btn btn-large btn-primary" onclick="javascript:window.open('http://testapp.appdeck.mobi/emulator/<?php print htmlspecialchars($this->appdeck_credentials['api_key']); ?>','AppDeck Emulator','height=800, width=800, top=500, left=200,scrollable=yes, menubar=yes, resizable=yes'); return false;" href="#"><i class="fa fa-external-link"></i> Open AppDeck Online Emulator</button>

<h4>From your phone or tablet</h4>

<p>
	If you have an iPhone, an iPad or an Android device; Download <b>AppDeck Test App</b> in <i>AppStore</i> or <i>Play Store</i>: search <i>appdeck</i>, install app and enter your appdeck cloud services login/password.<br />
	You should see your app and should be able to run it from your device. To reset the app, shake your device.
</p>

<h4>From your computer</h4>

<p>
	<b>iPhone/iPad:</b> <b><u>OSX only</u></b> Download XCodes from <i>AppStore</i>. download <a href="http://www.appdeck.mobi/">appdeck for iOS</a>. then open <i>AppDeck.xcodeproj</i> and run app (CMD+R or Product/Run or push the big play button on top left).<br />
	<b>Android:</b> Download <a href="http://developer.android.com/sdk/index.html">Android SDK</a>, download <a href="http://www.appdeck.mobi/">appdeck for Android</a>, open project in eclipse and run AppDeck.
</p>


</div><!--  // / container -->
</div><!--  // / bootstrap-wpadmin -->

</div><!-- 	// / postbox -->
</div><!--  // / wrap -->
<div class="clear"></div>
</div><!--  // / metabox-holder  -->