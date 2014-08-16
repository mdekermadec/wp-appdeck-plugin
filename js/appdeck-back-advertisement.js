(function($){

function init_ui(config)
{
  $('#ads_enabled').bootstrapSwitch({state: config.ads_enabled});
  $('#banner').bootstrapSwitch({state: config.ads_enable_banner});
  $('#rectangle').bootstrapSwitch({state: config.ads_enable_rectangle});
  $('#interstitial').bootstrapSwitch({state: config.ads_enable_interstitial});

  $('.appdeck-ajax-page-loading').hide();
  $('#ads').fadeIn();
  if (config.ads_enabled)
    $('#ads_options').show();
  else
    $('#ads_options').hide();
}

function save_change()
{
  $.ajax({
    type: "POST",
    url: "http://api.appdeck.mobi/ads",
    data: {
      key: appdeck_api_key,
      secret: appdeck_api_secret,
      ads_enabled: $('#ads_enabled').data('bootstrap-switch').state(),
      ads_enable_banner: $('#banner').data('bootstrap-switch').state(),
      ads_enable_rectangle: $('#rectangle').data('bootstrap-switch').state(),
      ads_enable_interstitial: $('#interstitial').data('bootstrap-switch').state()
    },
    success: function( result ) {
            if (result.success)
            {
              //show_ui(result.value);
            }

    }
  });
}

$(document).ready(function() {

    $.ajax({
        url: "http://api.appdeck.mobi/ads",
        type: "POST",
        daraType: "jsonp",
        data: {
            key: appdeck_api_key,
            secret: appdeck_api_secret
        },
        success: function( result ) {
            console.log(result);
            if (result.success)
            {
              init_ui(result.value);
            }
        }
    });

  $('#ads_enabled').on('switchChange.bootstrapSwitch', function (e, state) {
    if (state)
      $('#ads_options').fadeIn();
    else
      $('#ads_options').fadeOut();    
  });  

  $('#ads').on('switchChange.bootstrapSwitch', function (e, state) {
    save_change();
  });  


});

})( jQuery );