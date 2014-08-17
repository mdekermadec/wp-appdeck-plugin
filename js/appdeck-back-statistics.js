(function($) {

google.load("visualization", "1", {
		packages:["corechart", "geochart", 'table']
	});
google.setOnLoadCallback(initDaterangepicker);

var daterangepicker = null;
var type = null;//"Users";
var chart = null;
var options = null;

var currentStartDate = null;
var currentEndDate = null;
var currentType = null;

function drawChart()
{
  if (type === currentType)
    return;

  console.log("set chart type: " + type + " => " + currentType);

  type = currentType;
  //if (chart != null)
  //  chart.clear();
  $('#chart_div').empty();

	if (type == 'Users')
	{
	    options = {
    	      vAxis: { title: "users" },
        	  hAxis: { title: 'Day' },
          	animation:{
		    	duration: 1000,
        		easing: 'out',
      		}
        };
        chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
    }

	if (type == 'Devices')
	{
	    options = {
    	      vAxis: { title: "nb devices" },
        	  hAxis: { title: 'Day' },
        	  isStacked: true,
          	animation:{
		    	duration: 1000,
        		easing: 'out',
      		}
        };
        chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
    }

	if (type == 'Hours')
	{
	    options = {
    	      vAxis: { title: "visitors" },
        	  hAxis: { title: 'Hour', textStyle: { fontSize: 8 } },
          	animation:{
		    	duration: 1000,
        		easing: 'out',
      		}
        };
        chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
    }

	if (type == 'Countries')
	{
	    options = {
          	animation:{
		    	duration: 1000,
        		easing: 'out',
      		}
        };
        chart = new google.visualization.GeoChart(document.getElementById('chart_div'));
    }

	if (type == 'Visits')
	{
	    options = {
    	      vAxis: { title: "visits" },
        	  hAxis: { title: 'Day' },
          	animation:{
		    	duration: 1000,
        		easing: 'out',
      		}
        };
        chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
    }

	if (type == 'Time')
	{
	    options = {
    	      vAxis: { title: "Time on application" },
        	  hAxis: { title: 'Day' },
          	animation:{
		    	duration: 1000,
        		easing: 'out',
      		}
        };
        chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
    }

	if (type == 'View/Session')
	{
	    options = {
    	      vAxis: { title: "view" },
        	  hAxis: { title: 'Day' },
          	animation:{
		    	duration: 1000,
        		easing: 'out',
      		}
        };
        chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
    }


	if (type == 'View')
	{
	    options = {
    	      vAxis: { title: "view" },
        	  hAxis: { title: 'Day' },
          	animation:{
		    	duration: 1000,
        		easing: 'out',
      		}
        };
        chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
    }

	if (type == 'Share')
	{
	    options = {
    	      //showRowNumber: true,
          	animation:{
		    	duration: 1000,
        		easing: 'out',
      		}
        };
        chart = new google.visualization.Table(document.getElementById('chart_div'));
    }

	if (type == 'Screens')
	{
	    options = {
    	      //showRowNumber: true,
          	animation:{
		    	duration: 1000,
        		easing: 'out',
      		}
        };
        chart = new google.visualization.Table(document.getElementById('chart_div'));
    }

	if (type == 'Version')
	{
	    options = {
          	animation:{
		    	duration: 1000,
        		easing: 'out',
      		}
        };
        chart = new google.visualization.PieChart(document.getElementById('chart_div'));
    }

	if (type == 'Langue')
	{
	    options = {
    	      //showRowNumber: true,
          	animation:{
		    	duration: 1000,
        		easing: 'out',
      		}
        };
        chart = new google.visualization.Table(document.getElementById('chart_div'));
    }

    //refreshStats();
}

function refreshStats()
{
  // refresh UI
  $('#reportrangespan').html(currentStartDate.format('MMMM D, YYYY') + ' - ' + currentEndDate.format('MMMM D, YYYY'));
  drawChart();

  // fetch stats
  var dateFrom = currentStartDate.format("YYYY-MM-DD");
  var dateTo = currentEndDate.format("YYYY-MM-DD");
  var type = currentType;//$('.stats-type .active a').attr('data-type');

	jQuery("#chart_div").hide();
	jQuery("#chart_div_loading").show();
	jQuery.post(	"http://api.appdeck.mobi/statistics",
					{
            key: appdeck_api_key,
            secret: appdeck_api_secret,            
						type: type,
						dateFrom: dateFrom,
					 	dateTo: dateTo
					 },
					function(result) {
              var jsondata = result.value;
  						jQuery("#chart_div_loading").hide();
						  jQuery("#chart_div").show();
  						var newdata = google.visualization.arrayToDataTable(jsondata);
  						chart.draw(newdata, options);
					},
					"jsonp");
}

function initDaterangepicker()
{
  currentStartDate = moment().startOf('month');
  currentEndDate = moment().endOf('month');
  currentType = $('.stats-type .active a').attr('data-type');

  $('#reportrange').daterangepicker(
      {
        parentEl: '.bootstrap-wpadmin',
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
           'Last 7 Days': [moment().subtract('days', 6), moment()],
           'Last 30 Days': [moment().subtract('days', 29), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
        },
        startDate: currentStartDate,
        endDate: currentEndDate
      },
      function(start, end) {
        currentStartDate = start;
        currentEndDate = end;
        refreshStats();
      }
  );
  
  refreshStats();

  // prevent datepicker from hiding
  $('#reportrange').on('hide.daterangepicker', function(ev, picker) {
    ev.preventDefault();
  });  

  $('.stats-type a').click(function(evt) {
    $('.stats-type li').removeClass('active');
    $(this).parent().addClass('active');
    currentType = $(this).attr('data-type');
    refreshStats();
  })

}
//});

})( jQuery );