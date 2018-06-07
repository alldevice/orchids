<?php 
	$current_user = wp_get_current_user();
	if ($current_user->user_login == NULL)
	{
		$current_user->user_login = guest;
	}
	echo 'Current user: ' . $current_user->user_login . '<br />'; 
	echo '<br />';
?>	
	
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="http://santisoft.ru/wp-includes/js/responsiveslides.min.js"></script>




<!-- Slideshow 4 -->
<div class="callbacks_container" style = "float: right">
	<ul class="rslides" id="slider4">
		<li>
			<p class="caption"></p>
			<img src="http://santisoft.ru/wp-content/orchids/photo_db_1/2018-06-01-09:20:59.jpg" alt="2018-06-01-09:20:59" width="250" />
		</li>
		<li>
			<p class="caption"></p>
			<img src="http://santisoft.ru/wp-content/orchids/photo_db_1/2018-06-02-13:43:53.jpg" alt="2018-06-02-13:43:53" width="250" />
		</li>		
	</ul>
</div>
<div style = "clear: both">
</div>




<style>
.callbacks_nav.next
  {
  	margin-left: 20px;
  }
  
.rslides {
  position: relative;
  list-style: none;
  overflow: hidden;
  width: 100%;
  padding: 0;
  margin: 0;
  }
  
.rslides li {
  -webkit-backface-visibility: hidden;
  position: absolute;
  display: none;
  width: 100%;
  left: 0;
  top: 0;
  }
  
.rslides li:first-child {
  position: relative;
  display: block;
  float: left;
  }
  
.rslides img {
  display: block;
  height: auto;
  float: left;
  width: 250;
  border: 0;
  }
</style>


<script>
  $(function() {
      $("#slider4").responsiveSlides({
        auto: false,
        pager: false,
        nav: true,
        speed: 500,
        namespace: "callbacks",
        before: function () {
          $('.events').append("<li>before event fired.</li>"); 
        },
        after: function () {
          $('.events').append("<li>after event fired.</li>"); /* */
        }
      });
  });
</script>







<script>
//charts

var tp_back_max = 80000; // seconds
google.charts.load('current', {'packages':['corechart', 'line']});
google.charts.setOnLoadCallback(load_page_data(tp_back_max));


function load_page_data(tp_back) {
var elem = [];
var obj_w = {};
var stat1;

// meteo data
var dest = "weather";
$.get( "https://orchids-3.mybluemix.net/sense_2?dest="+dest+"&tp_back="+tp_back, function( obj ) {
	obj_w = obj;
	for (i = 0; i < obj.length; i++) {
		elem[i] = [ new Date(obj[i].unixtime*1000) , obj_w[i].pressure ]
		//console.log( "Data length 2: " + obj_w[i] );
	};

	// third chart
	drawChart3(elem);
	
// first chart
elem = [];
var dest = "temperature_sensor_001";
$.get( "https://orchids-3.mybluemix.net/sense_2?dest="+dest+"&tp_back="+tp_back, function( obj ) {
	for (i = 0; i < obj.length; i++) {
		elem[i] = [ new Date(obj[i].unixtime*1000) , obj_w[i].temperature , obj[i].value ]
		//console.log( "Data length 2: " + obj_w[i] );
	};
	drawChart1(elem);
});		
	
// second chart
var dest = "humidity_sensor_001";
elem = [];
$.get( "https://orchids-3.mybluemix.net/sense_2?dest="+dest+"&tp_back="+tp_back, function( obj ) {
	for (i = 0; i < obj.length; i++) {
		elem[i] = [ new Date(obj[i].unixtime*1000) , obj_w[i].relativeHumidity , obj[i].value/5 ]  // divide on 5 for norming
		//console.log( "Data length 2: " + obj_w[i] );
	};
	drawChart2(elem);
});	
});
}


function drawChart1(elem) {
	var data = new google.visualization.DataTable();
	data.addColumn('date', 'Date');
	data.addColumn('number', 'temperature');
	data.addColumn('number', 'temperature');
	data.addRows( elem );
	var linearOptions = {
		hAxis: {
			title: 'Time'
		},
        vAxis: {
			title: 'temperature, C'
        }
	};
	var linearChart = new google.visualization.LineChart(document.getElementById('chart_div_temp'));
	linearChart.draw(data, linearOptions);
}

function drawChart2(elem) {
	var data = new google.visualization.DataTable();
	data.addColumn('date', 'Date');
	data.addColumn('number', 'Outdoot_Humidity');
	data.addColumn('number', 'Moisture');
	data.addRows( elem );
	var linearOptions = {
		hAxis: {
			title: 'Time'
		},
        vAxis: {
			title: 'Humidity, %'
        }
	};
	var linearChart = new google.visualization.LineChart(document.getElementById('chart_div_hum'));
	linearChart.draw(data, linearOptions);
}

function drawChart3(elem) {
	var data = new google.visualization.DataTable();
	data.addColumn('date', 'Date');
	data.addColumn('number', 'Pressure');
	//data.addColumn('number', 'Pressure');
	data.addRows( elem );
	var linearOptions = {
		hAxis: {
			title: 'Time'
		},
        vAxis: {
			title: 'Pressure, mb'
        }
	};
	var linearChart = new google.visualization.LineChart(document.getElementById('chart_div_pre'));
	linearChart.draw(data, linearOptions);
}

</script>	
	


	<br />
	<br />	
	Temperature from sensor near plants and data from meteostation:
	<div id="chart_div_temp"></div>
	<br />
	<br />
	Humidity from sensor near plants and data from meteostation:
	<div id="chart_div_hum"></div>
	<br />
	<br />
	Pressure from meteostation:
	<div id="chart_div_pre"></div>
	

	<div id="update-nav">
		<div id="range-selector">
			<input type="button" id="3_days" class="period ui-button" value="3_days"/>
			<input type="button" id="1_week" class="period ui-button" value="1_week"/>
			<input type="button" id="all" class="period ui-button" value="all"/>
		</div>
	</div>

	
<script>
$( ".period" ).click(function () {
	var period = this.id;
    switch(period) {
      case "3_days":
		tp_back = 4000;
        break;
      case "1_week":
		tp_back = 30000;
        break;
      default:
        tp_back = tp_back_max;
    }
load_page_data(tp_back);
});


</script>
