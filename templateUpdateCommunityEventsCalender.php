<?php
/* 
Template Name: Update Community Event Calender Page
*/
///////////////////
//Start Calender //
///////////////////
//$_GET['updateYear']= '2015'; 
//$_GET['updateMonth'] = '2';
$currentDate = strtotime($_GET['updateYear'] . '-' . $_GET['updateMonth'] . '-1');
global $wpdb;
$currentDayOfMonth = date('j', $currentDate);
$month = date('n', $currentDate);
$monthFullName = date('F', $currentDate); 
$year = date('Y', $currentDate);
$dayOfWeek = date('w', $currentDate);
$stopDay = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$query = 'SELECT post_id, meta_value FROM wp_postmeta, wp_posts WHERE post_id = ID AND post_status != "trash" AND meta_key = "dteDate" AND meta_value LIKE "' . $year . '-' . $month . '-%" ORDER BY meta_value REGEXP "^[A-Za-z]+$",CAST(meta_value as SIGNED INTEGER),CAST(REPLACE(meta_value,"-","")AS SIGNED INTEGER),meta_value';
$results = $wpdb->get_results($query,ARRAY_A);
$eventIndex = 0;
echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>
<calender>
	<header>
		<textMonth><?php echo $monthFullName; ?></textMonth>
		<year><?php echo $_GET['updateYear']; ?></year>
		<month><?php echo $_GET['updateMonth']; ?></month>
	</header>
<?php
	$numberOfWeeks = 6;
	$currentDay = 0;
	for($x = 0; $x < $numberOfWeeks; $x++){
?>
	<week>
<?php
		for($y = 0; $y < 7; $y++){
			if($currentDay == 0){
				if($y == $dayOfWeek){
					$currentDay++;
				}
?>
		<day>
			<dayNumber><?php echo $currentDay; ?></dayNumber>
<?php
				$query = 'SELECT post_id FROM wp_postmeta, wp_posts WHERE post_id = ID AND post_status != "trash" AND meta_key = "dteDate" AND meta_value = "' . $year . '-' . $month . '-' . $currentDay . '"';
				$currentDayResults = $wpdb->get_results($query,ARRAY_A);
				$resultStop = count($currentDayResults);
				if($resultStop > 0){
					for($r = 0; $r < $resultStop; $r++){
						$query = 'SELECT meta_value FROM wp_postmeta WHERE meta_key = "txtCommunityEvent" AND post_id = ' . $currentDayResults[$r]['post_id'];
						$t = $wpdb->get_results($query,ARRAY_A);
						$eventIndex++;
?>
				<daysEvent>
					<eventId><?php echo $eventIndex; ?></eventId>
					<event><?php echo $t[0]['meta_value']; ?></event>
				</daysEvent>
<?php
					}
				}
?>
		</day>
<?php
			}else if($currentDay < $stopDay){
				$currentDay++;
				if($currentDayOfMonth == $currentDay){
?>
		<day>
			<dayNumber><?php echo $currentDay; ?></dayNumber>
<?php
				$query = 'SELECT post_id FROM wp_postmeta, wp_posts WHERE post_id = ID AND post_status != "trash" AND meta_key = "dteDate" AND meta_value = "' . $year . '-' . $month . '-' . $currentDay . '"';
			$currentDayResults = $wpdb->get_results($query,ARRAY_A);
			$resultStop = count($currentDayResults);
			if($resultStop > 0){
				for($r = 0; $r < $resultStop; $r++){
					$query = 'SELECT meta_value FROM wp_postmeta WHERE meta_key = "txtCommunityEvent" AND post_id = ' . $currentDayResults[$r]['post_id'];
					$t = $wpdb->get_results($query,ARRAY_A);
						$eventIndex++;
?>
				<daysEvent>
					<eventId><?php echo $eventIndex; ?></eventId>
					<event><?php echo $t[0]['meta_value']; ?></event>
				</daysEvent>
<?php
				}
			}
?>
		</day>
<?php
		}else{
?>
		<day>
			<dayNumber><?php echo $currentDay; ?></dayNumber>
<?php
				$query = 'SELECT post_id FROM wp_postmeta, wp_posts WHERE post_id = ID AND post_status != "trash" AND meta_key = "dteDate" AND meta_value = "' . $year . '-' . $month . '-' . $currentDay . '"';
			$currentDayResults = $wpdb->get_results($query,ARRAY_A);
			$resultStop = count($currentDayResults);
			if($resultStop > 0){
				for($r = 0; $r < $resultStop; $r++){
					$query = 'SELECT meta_value FROM wp_postmeta WHERE meta_key = "txtCommunityEvent" AND post_id = ' . $currentDayResults[$r]['post_id'];
					$t = $wpdb->get_results($query,ARRAY_A);
						$eventIndex++;
?>
				<daysEvent>
					<eventId><?php echo $eventIndex; ?></eventId>
					<event><?php echo $t[0]['meta_value']; ?></event>
				</daysEvent>
<?php
				}
			}
?>
		</day>
<?php
				}
			}else{
?>
		<day>
			<dayNumber>0</dayNumber>
		</day>
<?php
			}
		}
?>
	</week>
<?php
	}
	$stop = count($results);
	if($stop > 0){
?>
	<events>
<?php
		for($x = 0; $x < $stop; $x++){
			$query = 'SELECT meta_value FROM wp_postmeta WHERE meta_key = "txtCommunityEventLocation" AND post_id = ' . $results[$x]['post_id'];
			$txtCommunityEventLocation = $wpdb->get_results($query,ARRAY_A);
			$query = 'SELECT meta_value FROM wp_postmeta WHERE meta_key = "startTime" AND post_id = ' . $results[$x]['post_id'];
			$startTime = $wpdb->get_results($query,ARRAY_A);
			$query = 'SELECT meta_value FROM wp_postmeta WHERE meta_key = "endTime" AND post_id = ' . $results[$x]['post_id'];
			$endTime = $wpdb->get_results($query,ARRAY_A);
			$query = 'SELECT meta_value FROM wp_postmeta WHERE meta_key = "txtCommunityEventDescription" AND post_id = ' . $results[$x]['post_id'];
			$txtCommunityEventDescription = $wpdb->get_results($query,ARRAY_A);
			$query = 'SELECT meta_value FROM wp_postmeta WHERE meta_key = "txtCommunityEvent" AND post_id = ' . $results[$x]['post_id'];
			$eventName = $wpdb->get_results($query,ARRAY_A);
?>
	<eventDetail>
		<eventId><?php echo $x + 1; ?></eventId>
		<eventName><?php echo $eventName[0]['meta_value']; ?></eventName>
		<eventLocation><?php echo $txtCommunityEventLocation[0]['meta_value']; ?></eventLocation>
		<eventDate><?php echo $results[$x]['meta_value']; ?></eventDate>
		<startTime><?php echo $startTime[0]['meta_value']; ?></startTime>
		<endTime><?php echo $endTime[0]['meta_value']; ?></endTime>
		<eventDescription><?php echo $txtCommunityEventDescription[0]['meta_value']; ?></eventDescription>
	</eventDetail>
<?php
		}
?>
	</events>
<?php
	}
	/////////////////
	//End Calender //
	/////////////////
?>
</calender>