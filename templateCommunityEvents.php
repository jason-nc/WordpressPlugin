<?php
/* 
Template Name: Community Event Page


*/
?>
<?php get_header();?>

<?php
$location = icore_get_location();   
$meta = icore_get_multimeta(array('Subheader')); 
?>

<div id="entry-full">
    <div id="page-top">	 
    	<h1 class="title"><?php /* the_title(); */ ?></h1> 
    	<?php if( isset($meta['Subheader'] ) && $meta['Subheader'] <> '') { ?>
        	<span class="subheader"><?php echo $meta['Subheader']; ?></span>
    	<?php } ?>
    </div> <!-- #page-top  -->

    <div id="left" class="full-width">
        <div class="post-full single full-width">

<div id ="wrapper">
    <div id="loading" style ="position: fixed;top: 50%;left: 50%;margin-top: -50px;"></div>
</div>
<?php
	///////////////////
	//Start Calender //
	///////////////////
		global $wpdb;
		$currentDayOfMonth = date('j', time());
		$month = date('n', time());
		$monthFullName = date('F', time()); 
		$year = date('Y', time());
		$dayOfWeek = date('w', strtotime($year . '-' . $month . '-1'));
		$stopDay = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$query = 'SELECT post_id, meta_value FROM wp_postmeta, wp_posts WHERE post_id = ID AND post_status != "trash" AND meta_key = "dteDate" AND meta_value LIKE "' . $year . '-' . $month . '-%" ORDER BY meta_value REGEXP "^[A-Za-z]+$",CAST(meta_value as SIGNED INTEGER),CAST(REPLACE(meta_value,"-","")AS SIGNED INTEGER),meta_value';
		$results = $wpdb->get_results($query,ARRAY_A);
		$eventIndex = 0;
?>
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type='text/javascript'></script>-->
<script type="text/javascript">
//<![CDATA[  
	var $joker = jQuery.noConflict();
	var constantMonth = <?php echo $month; ?>;
	var constantDay = <?php echo $currentDayOfMonth; ?>;
	var constantYear = <?php echo $year; ?>;
	var currentMonth = <?php echo $month; ?>;
	var currentYear = <?php echo $year; ?>;
	$joker(function(){
		$joker('#backOneYear').click(function(){ 
			currentYear--;
			getNewCalender(currentMonth, currentYear);
		});
		$joker('#backOneMonth').click(function(){ 
			if(currentMonth == 1){
				currentMonth = 12;
				currentYear--;
			}else{
				currentMonth--;
			}
			getNewCalender(currentMonth, currentYear);
		});
		$joker('#aheadOneMonth').click(function(){ 
			if(currentMonth == 12){
				currentMonth = 1;
				currentYear++;
			}else{
				currentMonth++;
			}
			getNewCalender(currentMonth, currentYear);
		});
		$joker('#aheadOneYear').click(function(){ 
			currentYear++;
			getNewCalender(currentMonth, currentYear);
		});
	});
	function getNewCalender(month, year){
		//alert('getNewCalender Month: ' + month + ' Year: ' + year);
		$joker.ajax({
			url: '<?php echo site_url(); ?>/update-community-calender/',
			dataType: 'xml',
			data: 'updateMonth=' + month + '&updateYear=' + year,
                	//beforeSend: function ( xhr ) {
                    	//	var loading = '<img src ="<?php echo site_url(); ?>/wp-content/uploads/2015/01/loader.gif"/>';
                    	//	var urlImage = '<?php echo site_url(); ?>/wp-content/uploads/2015/01/bg4.png';
                    	//	var opacity = "1";
                    	//	$joker('#loading').html(loading);
                    	//	$joker('#wrapper').attr('style','position: fixed;top: 0%; z-index:99999; left: 0%; opacity:'+opacity+'; width:100%;height: 100%; background:url('+urlImage+')');
                	//},
			error: function(jqXHR, textStatus, errorThrown){
				alert('Failed: ' + textStatus + ' thrown: ' + errorThrown);
			},
			success: function(xml){
				//alert('success: ' + $joker(xml).find('calender').text());
                        	$joker('#loading').html('');                        
                        	$joker('#wrapper').removeAttr('style');
				$joker('.week').remove();
				$joker('#eventList ul').remove();
				var tableWeeks;
				var x;
				$joker('#monthHeaderCell').html('<center>' + $joker(xml).find('textMonth').text() + '  ' + $joker(xml).find('year').text() + '</center>');
				$joker(xml).find('week').each(function(){
					tableWeeks = tableWeeks + '<tr class="week">';
					$joker(this).find('day').each(function(){
						x = $joker(this).find('dayNumber').text();
						if(x == 0){
							tableWeeks = tableWeeks + '<td class="notDayOfMonth"></td>';
						}else{
							tableWeeks = tableWeeks + '<td class="dayOfMonth"><p>' + x + '</p><ul>';
							$joker(this).find('daysEvent').each(function(){
								tableWeeks = tableWeeks + '<li><a href="#' + $joker(this).find('eventId').text() +'">' + $joker(this).find('event').text() + '</a></li>';
							});
							tableWeeks = tableWeeks + '</ul></td>';
						}
					});
					tableWeeks = tableWeeks + '</tr>';
				});
				//alert(tableWeeks);
                       		$joker('#eventCalender').append(tableWeeks);
				var eventDetails = '';
				$joker(xml).find('events').each(function(){
					$joker(this).find('eventDetail').each(function(){
						eventDetails = eventDetails + '<ul><li><a name="' + $joker(this).find('eventId').text() + '">' + $joker(this).find('eventName').text() + '</a></li><li>' + $joker(this).find('eventLocation').text() + '</li><li>' + $joker(this).find('eventDate').text() + '</li><li>' + $joker(this).find('startTime').text() + ' to ' + $joker(this).find('endTime').text() + '</li><li>' + $joker(this).find('eventDescription').text() + '</li></ul>';
					});
				});
                       		$joker('#eventList').append(eventDetails);
			}
		});
		return false;
	}
//]]>
</script>
<style>
	#backOneYear:hover{
		cursor: pointer;
		background-color: #CFB53B;
	}
	#backOneMonth:hover{
		cursor: pointer;
		background-color: #CFB53B;
	}
	#aheadOneMonth:hover{
		cursor: pointer;
		background-color: #CFB53B;
	}
	#aheadOneYear:hover{
		cursor: pointer;
		background-color: #CFB53B;
	}
	#aheadOneYear:active{
		cursor: pointer;
		background-color: black;
		color: white;
	}
	#aheadOneMonth:active{
		cursor: pointer;
		background-color: black;
		color: white;
	}
	#backOneMonth:active{
		cursor: pointer;
		background-color: black;
		color: white;
	}
	#backOneYear:active{
		cursor: pointer;
		background-color: black;
		color: white;
	}
	#eventCalender{
		width: 100%;
		border-collapse:collapse;
		border:1px solid black;
	}
	#eventCalender td, th{
		border:1px solid black;
		width: 14.2%;
	}
	.notDayOfMonth{background: 
  		/* On "top" */
  		repeating-linear-gradient(
    			45deg,
    			transparent,
    			transparent 10px,
    			#ccc 10px,
    			#ccc 20px
  		),
  		/* on "bottom" */
  		linear-gradient(
    			to bottom,
    			#eee,
    			#999
  		);
	}
	.currentDayOfMonth p{
    		font-weight: bold;
		color: red;
		float: right;
	}
	.dayOfMonth p{
		float: right;
	}
	#monthHeaderCell{
		font-size: 24px;
		font-weight: bold;
	}
</style>
<table id="eventCalender">
	<tr>
		<td id="backOneYear"><center><<</center></td>
		<td id="backOneMonth"><center><</center></td>
		<td id="monthHeaderCell" colspan="3"><center><?php echo $monthFullName . ' ' . $year; ?><center></td>
		<td id="aheadOneMonth"><center>></center></td>
		<td id="aheadOneYear"><center>>></center></td>
	</tr>
	<tr>
		<th>Sunday</th>
		<th>Monday</th>
		<th>Tuesday</th>
		<th>Wednesday</th>
		<th>Thursday</th>
		<th>Friday</th>
		<th>Saturday</th>
	</tr>
<?php
	$numberOfWeeks = 6;
	$currentDay = 0;
	for($x = 0; $x < $numberOfWeeks; $x++){
?>
	<tr class="week">
<?php
		for($y = 0; $y < 7; $y++){
			if($currentDay == 0){
				if($y == $dayOfWeek){
					$currentDay++;
					if($currentDayOfMonth == $currentDay){
?>
		<td class="currentDayOfMonth">
<?php
					}else{
?>
		<td class="dayOfMonth">
<?php
					}
?>
			<p><?php echo $currentDay; ?></p>
<?php
				$query = 'SELECT post_id FROM wp_postmeta, wp_posts WHERE post_id = ID AND post_status != "trash" AND meta_key = "dteDate" AND meta_value = "' . $year . '-' . $month . '-' . $currentDay . '"';
				$currentDayResults = $wpdb->get_results($query,ARRAY_A);
				$resultStop = count($currentDayResults);
				if($resultStop > 0){
?>
			<ul>
<?php
					for($r = 0; $r < $resultStop; $r++){
						$query = 'SELECT meta_value FROM wp_postmeta WHERE meta_key = "txtCommunityEvent" AND post_id = ' . $currentDayResults[$r]['post_id'];
						$t = $wpdb->get_results($query,ARRAY_A);
						$eventIndex++;
?>
				<li><a href="<?php echo '#'. $eventIndex; ?>"><?php echo $t[0]['meta_value']; ?></a></li>
<?php
					}
?>
			</ul>
<?php
				}
?>
		</td>
<?php
				}else{
?>
		<td class="notDayOfMonth">
			
		</td>
<?php
				}
			}else if($currentDay < $stopDay){
				$currentDay++;
				if($currentDayOfMonth == $currentDay){
?>
		<td class="currentDayOfMonth">
			<p><?php echo $currentDay; ?></p>
<?php
				$query = 'SELECT post_id FROM wp_postmeta, wp_posts WHERE post_id = ID AND post_status != "trash" AND meta_key = "dteDate" AND meta_value = "' . $year . '-' . $month . '-' . $currentDay . '"';
			$currentDayResults = $wpdb->get_results($query,ARRAY_A);
			$resultStop = count($currentDayResults);
			if($resultStop > 0){
?>
			<ul>
<?php
				for($r = 0; $r < $resultStop; $r++){
					$query = 'SELECT meta_value FROM wp_postmeta WHERE meta_key = "txtCommunityEvent" AND post_id = ' . $currentDayResults[$r]['post_id'];
					$t = $wpdb->get_results($query,ARRAY_A);
					$eventIndex++;
?>
				<li><a href="<?php echo '#'. $eventIndex; ?>"><?php echo $t[0]['meta_value']; ?></a></li>
<?php
				}
?>
			</ul>
<?php
			}
?>
		</td>
<?php
				}else{
?>
		<td class="dayOfMonth">
			<p><?php echo $currentDay; ?></p>
<?php
				$query = 'SELECT post_id FROM wp_postmeta, wp_posts WHERE post_id = ID AND post_status != "trash" AND meta_key = "dteDate" AND meta_value = "' . $year . '-' . $month . '-' . $currentDay . '"';
			$currentDayResults = $wpdb->get_results($query,ARRAY_A);
			$resultStop = count($currentDayResults);
			if($resultStop > 0){
?>
			<ul>
<?php
				for($r = 0; $r < $resultStop; $r++){
					$query = 'SELECT meta_value FROM wp_postmeta WHERE meta_key = "txtCommunityEvent" AND post_id = ' . $currentDayResults[$r]['post_id'];
					$t = $wpdb->get_results($query,ARRAY_A);
					$eventIndex++;
?>
				<li><a href="<?php echo '#'. $eventIndex; ?>"><?php echo $t[0]['meta_value']; ?></a></li>
<?php
				}
?>
			</ul>
<?php
			}
?>
		</td>
<?php
				}
			}else{
?>
		<td class="notDayOfMonth">
			
		</td>
<?php
			}
		}
?>
	</tr>
<?php
	}
?>
</table>
<div id="eventList">
<?php
	$stop = count($results);
	if($stop > 0){
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
	<ul>
		<li><a name="<?php echo $x + 1; ?>"><?php echo $eventName[0]['meta_value']; ?></a></li>
		<li><?php echo $txtCommunityEventLocation[0]['meta_value']; ?></li>
		<li><?php echo $results[$x]['meta_value']; ?></li>
		<li><?php echo $startTime[0]['meta_value']; ?> to <?php echo $endTime[0]['meta_value']; ?></li>
		<li><?php echo $txtCommunityEventDescription[0]['meta_value']; ?></li>
	</ul>
<?php
		}
	}
	/////////////////
	//End Calender //
	/////////////////
?>
</div>
         </div> <!-- .post-full  -->
    </div> <!-- #left  -->
</div> <!-- #entry-full  -->
<?php get_footer(); ?>