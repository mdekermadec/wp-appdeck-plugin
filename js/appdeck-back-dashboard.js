(function($) {    

function refresh_stats(chart, period, origin)
{
    if (origin)
    {
        $(origin).parent().find('button').removeClass('active');
        $(origin).addClass('active');
    }

    $.ajax({
        url: "http://api.appdeck.mobi/stats",
        type: "POST",
        daraType: "jsonp",
        data: {
            key: appdeck_api_key,
            secret: appdeck_api_secret,
            unit: chart,
            period: period
        },
        success: function( result ) {
            $('#'+chart+'chart').empty();
            console.log(result);
            if (result.success)
            {
                var morris = {element: chart + 'chart',
                             ykeys: [chart],
                             labels: [chart],
                             data: result.value.data};
                if (period == 'week' || period == 'month')
                    morris.xkey = 'day';
                if (period == 'year')
                    morris.xkey = 'month';
                if (period == 'all')
                    morris.xkey = 'year';
                new Morris.Line(morris);
            }
            else
                console.log("failure");
        }
    });
}

$( document ).ready(function() {
    // global stats
    $.ajax({
        url: "http://api.appdeck.mobi/stats",
        type: "POST",
        daraType: "jsonp",
        data: {
            key: appdeck_api_key,
            secret: appdeck_api_secret,
            unit: 'common'
        },
        success: function( result ) {
            console.log(result);
            if (result.success)
            {
                console.log(result.value.data.stats_today.user);
                $('#appdeck_stats_today_user').html(result.value.data.stats_today.user);
                if (result.value.data.stats_today.new_user > 0)
                {
                    $('#appdeck_stats_today_new_user').show();
                    $('#appdeck_stats_today_new_user').html('+ '+result.value.data.stats_today.new_user+' new');
                }
                $('#appdeck_stats_month_visits').html(result.value.data.stats_month.visits);
                $('#appdeck_stats_week_push').html(result.value.data.stats_week.push);
                $('#appdeck_stats_30days_ca').html(result.value.data.stats_30days.ca);
            }
        }
    });

    // morris graph
    refresh_stats('visits', 'week', null);
    refresh_stats('users', 'week', null);
    refresh_stats('newusers', 'week', null);

    $('.refresh-stats').click(function() {
        refresh_stats($(this).attr('data-unit'), $(this).attr('data-period'), this);
    })
});

})( jQuery );

