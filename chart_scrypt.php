<?php 
	$current_user = wp_get_current_user();
	if ($current_user->user_login == NULL)
	{
		$current_user->user_login = guest;
	}
	echo 'Current user: ' . $current_user->user_login . '<br />'; 
	echo '<br />';
?>	
	
<?php	
	//retreive data photo from db nosql cloudant
	$login = 'aundlessuguiersuseversel'; //sense_1(API_KEY)
	$password = 'b579cdf4d322468db3b99272c0277124221eec14';
	$url = 'https://358bc398-e503-48e4-a80a-bb3975c68ea4-bluemix.cloudant.com/sense_1/_find';
	$query_hum = array(
					'selector' => array(
						'payload' => array(
							'd' => array(
								'type' => "camera_pic"
							)
						)
					)
				);
	$query_hum_string = json_encode($query_hum);
	$ch = curl_init();  
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");       
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                  
	curl_setopt($ch, CURLOPT_POSTFIELDS, $query_hum_string); 
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-type: application/json',
			'Accept: */*'
		));
	$output_3=curl_exec($ch);
	curl_close($ch);
	//------------------------------------------------
	
	$dir_img = "http://santisoft.ru/wp-content/orchids/photo_db_1/";

	$fields_3 = json_decode($output_3);
	foreach($fields_3->docs as $doc)
	{
        $t = strtotime($doc->payload->d->TimeStamp);
        //$doc->payload->d->TimeStamp_1 = date('Y,m,d,H,i,s', strtotime("-1 month", $t));
		$doc->payload->d->TimeStamp_1 = date('c', $t);
	}

	// SORTING
	foreach($fields_3->docs as $key => $row)
	{
	  $vc_array_name_3[$key] = $row->payload->d->TimeStamp_1;
	}
	//array_multisort($vc_array_name_3, SORT_DESC, $fields_3->docs);
	array_multisort($vc_array_name_3, SORT_ASC, $fields_3->docs);
	//------------------------------
?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="http://santisoft.ru/wp-includes/js/responsiveslides.min.js"></script>


    <!-- Slideshow 4 -->
    <div class="callbacks_container" style = "float: right">
      <ul class="rslides" id="slider4">
		<?php
			foreach($fields_3->docs as $doc)
			{
				echo '<li>';
				$file_img = $doc->payload->d->filename;
				echo '<p class="caption">'.$file_img.'</p>';
				echo '<img src="'.$dir_img.'/'.$file_img.'.jpg" alt="'.$file_img.'" width="250" />';
				echo '</li>';
			}
		?>
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
	
	
	
	
	
<?php	
	//retreive data TEMPERATURE from db nosql cloudant
	$query_temp = array(
					'selector' => array(
						'payload' => array(
							'd' => array(
								'type' => "temperature_sensor_001"
							)
						)
					)
				);
	$query_temp_string = json_encode($query_temp);
	$ch = curl_init();  
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");       
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                  
	curl_setopt($ch, CURLOPT_POSTFIELDS, $query_temp_string); 
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-type: application/json',
			'Accept: */*'
		));
	$output=curl_exec($ch);
	curl_close($ch);
	//------------------------------------------------

	$fields_1 = json_decode($output);
	foreach($fields_1->docs as $doc)
	{
		$t = strtotime($doc->payload->d->TimeStamp);
        $doc->payload->d->TimeStamp_1 = date('c', $t);
	}

	// SORTING
	foreach($fields_1->docs as $key => $row)
	{
	  $vc_array_name_1[$key] = $row->payload->d->TimeStamp_1;
	}
	array_multisort($vc_array_name_1, SORT_ASC, $fields_1->docs);
	//------------------------------


	//retreive outdoor data weather (temperature, pressure, relativeHumidity) from db nosql cloudant
	$query_temp = array(
					'selector' => array(
						'payload' => array(
								'type' => "weather"
							)
					)
				);
	$query_temp_string = json_encode($query_temp);
	$ch = curl_init();  
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");       
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                  
	curl_setopt($ch, CURLOPT_POSTFIELDS, $query_temp_string); 
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-type: application/json',
			'Accept: */*'
		));
	$output=curl_exec($ch);
	curl_close($ch);
	//------------------------------------------------

	$out_data = json_decode($output);
	foreach($out_data->docs as $doc) //get quantity samples from previous array
	{
		$t = strtotime($doc->payload->TimeStamp);
        $doc->payload->TimeStamp_1 = date('c', $t);
	}
	
	// adding missing data
	$res = count($fields_1->docs) - count($out_data->docs);
	$new_array = array();
	for($i=0 ; $i < $res ; $i++)	
	{
		$new_array[$i] = $out_data->docs[0];
		$new_array[$i]->payload->temperature = 10;
		$new_array[$i]->payload->relativeHumidity = 0;
		$new_array[$i]->payload->TimeStamp_1 = '2017-06-03T00:00:00+00:00';
	}
	$out_data->docs = array_merge($new_array, $out_data->docs);
	
	// SORTING
	foreach($out_data->docs as $key => $row)
	{
	  $vc_array_name_1[$key] = $row->payload->TimeStamp_1;
	}
	array_multisort($vc_array_name_1, SORT_ASC, $out_data->docs);
	//------------------------------
	

	//===debug==
	//echo '<pre>';
	//echo $length_1 = count($fields_1->docs);
	//echo '<br />';
	//echo $length_2 = count($out_data->docs);
	//echo '<br />';
	//echo $res = $length_1 - $length_2;
	//echo '</pre>';
	//$new_array = array();
	//for($i=0 ; $i < $res ; $i++)
	//{
	//	echo '<pre>';
    //  echo $doc->payload->d->TimeStamp_1;
    //	echo $doc->payload;
	//	echo $doc->payload->pressure;
	//$new_array[$i] = $out_data->docs[0];
	//$new_array[$i]->payload->temperature = 20;	// [] - add new element
	//$new_array[$i]->payload->TimeStamp_1 = '2017-06-03T14:43:10+00:00';	// [] - add new element
	//	echo '</pre>';
	//	if($out_data->docs[$key]->payload->TimeStamp_1 == )
	//	{
	//		$out_data->docs[$key]->payload->temperature = 1;
	//	}
	//}	
	//$out_data->docs = array_merge($new_array, $out_data->docs);
	//echo '<pre>';
	//print_r($out_data);
	//echo '<br />';
	//echo count($out_data->docs);
	//echo '</pre>';
	//===debug==
	

	
	
		
	
	//retreive data HUMIDITY from db nosql cloudant
	$query_hum = array(
					'selector' => array(
						'payload' => array(
							'd' => array(
								'type' => "humidity_sensor_001"
							)
						)
					)
				);
	$query_hum_string = json_encode($query_hum);
	$ch = curl_init();  
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");       
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                  
	curl_setopt($ch, CURLOPT_POSTFIELDS, $query_hum_string); 
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-type: application/json',
			'Accept: */*'
		));
	$output=curl_exec($ch);
	curl_close($ch);
	//------------------------------------------------

	$fields_2 = json_decode($output);
	foreach($fields_2->docs as $doc)
	{
        $t = strtotime($doc->payload->d->TimeStamp);
        $doc->payload->d->TimeStamp_1 = date('c', $t);
	}
	
	// SORTING
	foreach($fields_2->docs as $key => $row)
	{
	  $vc_array_name_2[$key] = $row->payload->d->TimeStamp_1;
	}
	array_multisort($vc_array_name_2, SORT_ASC, $fields_2->docs);
	//------------------------------
	
?>

	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

	<script>
    google.charts.load('current', {'packages':['corechart', 'line']});
    google.charts.setOnLoadCallback(drawChart1);
    function drawChart1() {
      var data = new google.visualization.DataTable();
      data.addColumn('date', 'Date');
      data.addColumn('number', 'Temperature near plants');
	  data.addColumn('number', 'Temperature outdoor');
      data.addRows([
            <?php
			foreach($fields_1->docs as $key => $doc)
			{
				echo "[new Date('".$doc->payload->d->TimeStamp_1."'),".$doc->payload->d->value.",".$out_data->docs[$key]->payload->temperature."],";
			}
			?>
      ]);
      var linearOptions = {
        hAxis: {
          title: 'Time'
        },
        vAxis: {
          title: 'Temperature, C'
        }//,
      };
      var linearChart = new google.visualization.LineChart(document.getElementById('chart_div_temp'));
       linearChart.draw(data, linearOptions);
    }
    </script>	

    <script>
    google.charts.load('current', {'packages':['corechart', 'line']});
    google.charts.setOnLoadCallback(drawChart2);
    function drawChart2() {
      var data = new google.visualization.DataTable();
      data.addColumn('date', 'Date');
      data.addColumn('number', 'Humidity');
	  data.addColumn('number', 'Rel. Humidity outdoor');
      data.addRows([
            <?php
			foreach($fields_2->docs as $key => $doc)
			{
				$y1 = $doc->payload->d->value/5; // norming to 100%
				echo "[new Date('".$doc->payload->d->TimeStamp_1."'),".$y1.",".$out_data->docs[$key]->payload->relativeHumidity."],";
			}
			?>
      ]);
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
    </script>	
	
	<br />
	<br />	
	Temperature sensor:
	<div id="chart_div_temp"></div>
	<br />
	<br />
	Humidity sensor:
	<div id="chart_div_hum"></div>
	
