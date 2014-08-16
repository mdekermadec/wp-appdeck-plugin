var switch_banner;

function init_ui(config)
{
  $('#ads_enabled').bootstrapSwitch({state: config.ads_enabled});
  switch_banner = $('#banner').bootstrapSwitch({state: config.ads_enable_banner});
  $('#rectangle').bootstrapSwitch({state: config.ads_enable_rectangle});
  $('#interstitial').bootstrapSwitch({state: config.ads_enable_interstitial});

  $('.appdeck-ajax-page-loading').fadeOut();
  $('#ads').fadeIn();
  if (config.ads_enabled)
    $('#ads_options').show();
  else
    $('#ads_options').hide();
}

function save_change()
{
  console.log(switch_banner.data('bootstrap-switch').state());

  $.ajax({
    type: "POST",
    url: "http://api.appdeck.mobi/ads",
    data: {
      key: appdeck_api_key,
      secret: appdeck_api_secret,
      ads_enabled: 0+$('#ads_enabled').prop('checked'),
      ads_enable_banner: 0+$('#banner').prop('checked'),
      ads_enable_rectangle: 0+$('#rectangle').prop('checked'),
      ads_enable_interstitial: 0+$('#interstitial').prop('checked')
    },
    success: function( result ) {
      console.log(result);
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