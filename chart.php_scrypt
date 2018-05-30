	<?php 
	$current_user = wp_get_current_user();
	if ($current_user->user_login == NULL)
	{
		$current_user->user_login = guest;
	}
	echo 'Пользователь: ' . $current_user->user_login . '<br />'; 
	echo '<br />';
	//retreive data TEMPERATURE from db nosql cloudant
	$login = '358bc398-e503-48e4-a80a-bb3975c68ea4-bluemix';
	$password = 'eab71e7aacba4b8344ecd92707cbbaf969a3193269a5a2aff063e3b99a468fc7';
	$url = 'https://358bc398-e503-48e4-a80a-bb3975c68ea4-bluemix.cloudant.com/sense_1/_find';
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
		//echo '<pre>';
        $t = strtotime($doc->payload->d->TimeStamp);
        $doc->payload->d->TimeStamp_1 = date('Y,m,d,H,i,s', strtotime("-1 month", $t));
        //echo $doc->payload->d->TimeStamp_1;
		//echo '</pre>';
		//$doc->payload->d->TimeStamp_0 = (int)$t;
	}

	// SORTING
	foreach($fields_1->docs as $key => $row)
	{
	  $vc_array_name[$key] = $row->payload->d->TimeStamp_1;
	}
	array_multisort($vc_array_name, SORT_ASC, $fields_1->docs);
	//------------------------------

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
		//echo '<pre>';
        $t = strtotime($doc->payload->d->TimeStamp);
        $doc->payload->d->TimeStamp_1 = date('Y,m,d,H,i,s', strtotime("-1 month", $t));
        //echo $doc->payload->d->TimeStamp_1;
		//echo '</pre>';
		//$doc->payload->d->TimeStamp_0 = (int)$t;
	}

	// SORTING
	foreach($fields_2->docs as $key => $row)
	{
	  $vc_array_name[$key] = $row->payload->d->TimeStamp_1;
	}
	array_multisort($vc_array_name, SORT_ASC, $fields_2->docs);
	//------------------------------
	?>

	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

	<script>
    google.charts.load('current', {'packages':['corechart', 'line']});
    google.charts.setOnLoadCallback(drawChart1);
    function drawChart1() {
      var data = new google.visualization.DataTable();
      data.addColumn('date', 'Date');
      data.addColumn('number', 'Temperature');
      data.addRows([
            <?php
			foreach($fields_1->docs as $doc)
			{
				echo "[new Date(".$doc->payload->d->TimeStamp_1."),".$doc->payload->d->value."],";
			}
			?>
      ]);
      var linearOptions = {
        hAxis: {
          title: 'Time'
        },
        vAxis: {
          title: 'Temperature'
        }
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
      data.addRows([
            <?php
			foreach($fields_2->docs as $doc)
			{
				echo "[new Date(".$doc->payload->d->TimeStamp_1."),".$doc->payload->d->value."],";
			}
			?>
      ]);
      var linearOptions = {
        hAxis: {
          title: 'Time'
        },
        vAxis: {
          title: 'Humidity'
        }
      };
      var linearChart = new google.visualization.LineChart(document.getElementById('chart_div_hum'));
       linearChart.draw(data, linearOptions);
    }
    </script>	
	

	Temperature sensor:
	<div id="chart_div_temp"></div>
	<br />
	<br />
	Humidity sensor:
	<div id="chart_div_hum"></div>
