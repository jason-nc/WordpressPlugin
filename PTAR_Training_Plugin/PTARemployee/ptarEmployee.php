<?php
function mainEmployee(){
        echo '<p>Welecome to Employee Page</p>';
}
function training_videos(){
	$nonce = wp_create_nonce('video-tracker');
	include 'employeeCss/employeeCss.css';
	include 'employeeJs/employeeJs.js';
	?>
	<h1>Training Videos</h1>
	<input type="hidden" id="checkMe" value="<?php echo $nonce; ?>"/>
<?php
	global $wpdb;
	$query = 'SELECT post_id, meta_value FROM wp_postmeta, wp_posts WHERE post_id = ID AND post_status != "trash" AND meta_key = "txtCoarse" ORDER BY meta_value';
	$resultTrainingVideos = $wpdb->get_results($query,ARRAY_A);
	$stop = count($resultTrainingVideos);
	$trainVideos = array();
	for($index = 0; $index < $stop; $index++){
		$trainVideos[$index]['coarse'] = $resultTrainingVideos[$index]['meta_value'];
		$query = 'SELECT meta_value FROM wp_postmeta, wp_posts WHERE post_id = ' . $resultTrainingVideos[$index]['post_id'] . ' AND meta_key = "txtVideoTitle"';
		$tmp = $wpdb->get_results($query,ARRAY_A);
		$trainVideos[$index]['title'] = $tmp[0]['meta_value'];
		$query = 'SELECT meta_value FROM wp_postmeta, wp_posts WHERE post_id = ' . $resultTrainingVideos[$index]['post_id'] . ' AND meta_key = "txtEmbedCode"';
		$tmp = $wpdb->get_results($query,ARRAY_A);
		$trainVideos[$index]['embedCode'] = $tmp[0]['meta_value'];
	}
?>
	<div class="tabs">    
		<ul class="tab-links">
			<li class="active"><a href="#tab1"><?php echo $trainVideos[0]['coarse']; ?></a></li>
<?php
		$currentTab = 2;
		$currentCoarse = $trainVideos[0]['coarse'];
		for($index = 1; $index < $stop; $index++){
			if(strcmp($currentCoarse, $trainVideos[$index]['coarse']) != 0){
?>
			<li><a href="#tab<?php echo $currentTab; ?>"><?php echo $trainVideos[$index]['coarse']; ?></a></li>
<?php
				$currentCoarse = $trainVideos[$index]['coarse'];
				$currentTab++;
			}
		}
		$currentTab = 1;
		$currentCoarse = '';
?>
		</ul> 
		<div class="tab-content">
<?php
		for($index = 0; $index < $stop; $index++){
			if(strcmp($currentCoarse, $trainVideos[$index]['coarse']) != 0){
				if($index == 0){
					$currentCoarse = $trainVideos[$index]['coarse'];
?>
			<div id="tab<?php echo $currentTab; ?>" class="tab active">
<?php
				}else{
					$currentCoarse = $trainVideos[$index]['coarse'];
					$currentTab++;
?>
			</div>
			<div id="tab<?php echo $currentTab; ?>" class="tab">
<?php
				}
			}
?>
			<p><?php echo $trainVideos[$index]['title']; ?></p>
<?php
			$trainVideos[$index]['embedCode'] = str_replace('&lt;','<',$trainVideos[$index]['embedCode']);
			$trainVideos[$index]['embedCode'] = str_replace('&quot;','"',$trainVideos[$index]['embedCode']);
			$trainVideos[$index]['embedCode'] = str_replace('&gt;','>',$trainVideos[$index]['embedCode']);
?>
			<p><?php echo $trainVideos[$index]['embedCode']; ?></p>
<?php
		}
?>
			</div>
		</div>
	</div>
	<ul>
	<?php
/*
	$dirFiles = scandir($_SERVER['DOCUMENT_ROOT'] . '/PTAR/wp-content/uploads/traingVideos/');
	foreach($dirFiles as $dirFile){
		if($dirFile != '.' && $dirFile != '..'){
	?>
		<li alt="<?php echo $nonce; ?>" class="trackVideoActivity"><a href="<?php echo site_url(); ?>/wp-content/uploads/traingVideos/<?php echo $dirFile; ?>" target="_blank"><?php echo $dirFile; ?></a></li>
	<?php
		}
	}
*/
	?>
	</ul>
	<?php
/*
	$tmpArray = array();
	$index = 0;
	foreach($dirFiles as $dirFile){
		if($dirFile != '.' && $dirFile != '..'){
			$youTubeVid = fopen($_SERVER['DOCUMENT_ROOT'] . '/PTAR/wp-content/uploads/traingVideos/' . $dirFile,'r');
			$curLine = fgets($youTubeVid);
			while($curLine){
				$a = explode('==',$curLine);
				$tmpArray[$index][$a[0]] = $a[1];
				$curLine = fgets($youTubeVid);
			}
			fclose($youTubVid);
		}
		$index++;
	}
	$stop = count($tmpArray);
*/
/*
	for($index = 0; $index < $stop; $index++){
?>
		<h1><?php echo $tmpArray[$index]['title']; ?></h1>
		<p><?php echo $tmpArray[$index]['embeddedVideo']; ?></p>
<?php
	}
*/
}
function training_documents(){
	$nonce = wp_create_nonce('video-tracker');
	include 'employeeCss/employeeCss.css';
	include 'employeeJs/employeeJs.js';
	?>
	<h1>Training Documents</h1>
	<ul>
	<?php
	$dirFiles = scandir($_SERVER['DOCUMENT_ROOT'] . '/PTAR/wp-content/uploads/traingDocuments/');
	foreach($dirFiles as $dirFile){
		if($dirFile != '.' && $dirFile != '..'){
	?>
		<li alt="<?php echo $nonce; ?>" class="trackDocumentActivity"><a href="<?php echo site_url(); ?>/wp-content/uploads/traingDocuments/<?php echo $dirFile; ?>" target="_blank"><?php echo $dirFile; ?></a></li>
	<?php
		}
	}
	?>
	</ul>
	<?php
}
function training_tests(){
	$nonce = wp_create_nonce('video-tracker');
	include 'employeeCss/employeeCss.css';
	include 'employeeJs/employeeJs.js';
	?>
	<h1>Training Tests</h1>
	<input type="hidden" name="checkMe" id="checkMe" value="<?php echo $nonce; ?>"/>
	<ul>
	<?php
	$dirFiles = scandir($_SERVER['DOCUMENT_ROOT'] . '/PTAR/wp-content/uploads/traingTests/');
	foreach($dirFiles as $dirFile){
		if($dirFile != '.' && $dirFile != '..'){
	?>
		<li alt="<?php echo $nonce; ?>" class="trackTestActivity"><a href="<?php echo site_url(); ?>/wp-content/uploads/traingTests/<?php echo $dirFile; ?>" target="_blank"><?php echo $dirFile; ?></a></li>
	<?php
		}
	}
	?>
	</ul>
	<?php
	global $wpdb;
	$query = 'SELECT post_id, meta_value FROM wp_postmeta, wp_posts WHERE post_id = ID AND post_status != "trash" AND meta_key = "intQuestionNumber" ORDER BY cast(meta_value AS UNSIGNED)';
	$resultTestQuestions = $wpdb->get_results($query,ARRAY_A);
	$stop = count($resultTestQuestions);
?>
<div id="divTest">
	<form id="submitTest" action="#" method="get" onsubmit="return false;">
		<input type="hidden" value="<?php echo $nonce; ?>" id="checkMe"/>
<?php
	for($index = 0; $index < $stop; $index++){
		$query = 'SELECT meta_value FROM wp_postmeta WHERE meta_key = "txtQuestion" AND post_id = ' . $resultTestQuestions[$index]['post_id'];
		$result = $wpdb->get_results($query, ARRAY_A);
?>
	<p><?php echo $resultTestQuestions[$index]['meta_value'] . '. ' . $result[0]['meta_value']; ?></p>
	<ul name="<?php echo $resultTestQuestions[$index]['meta_value']; ?>">
<?php
		$query = 'SELECT meta_value FROM wp_postmeta WHERE meta_key = "txtOptionA" AND post_id = ' . $resultTestQuestions[$index]['post_id'];
		$result = $wpdb->get_results($query, ARRAY_A);
		if(count($result) > 0){
?>
		<li><input type="radio" name="<?php echo $resultTestQuestions[$index]['post_id']; ?>" value="A"/><?php echo $result[0]['meta_value']; ?></li>
<?php
		}
		$query = 'SELECT meta_value FROM wp_postmeta WHERE meta_key = "txtOptionB" AND post_id = ' . $resultTestQuestions[$index]['post_id'];
		$result = $wpdb->get_results($query, ARRAY_A);
		if(count($result) > 0){
?>
		<li><input type="radio" name="<?php echo $resultTestQuestions[$index]['post_id']; ?>" value="B"/><?php echo $result[0]['meta_value']; ?></li>
<?php
		}
		$query = 'SELECT meta_value FROM wp_postmeta WHERE meta_key = "txtOptionC" AND post_id = ' . $resultTestQuestions[$index]['post_id'];
		$result = $wpdb->get_results($query, ARRAY_A);
		if(count($result) > 0){
?>
		<li><input type="radio" name="<?php echo $resultTestQuestions[$index]['post_id']; ?>" value="C"/><?php echo $result[0]['meta_value']; ?></li>
<?php
		}
		$query = 'SELECT meta_value FROM wp_postmeta WHERE meta_key = "txtOptionD" AND post_id = ' . $resultTestQuestions[$index]['post_id'];
		$result = $wpdb->get_results($query, ARRAY_A);
		if(count($result) > 0){
?>
		<li><input type="radio" name="<?php echo $resultTestQuestions[$index]['post_id']; ?>" value="D"/><?php echo $result[0]['meta_value']; ?></li>
<?php
		}
		$query = 'SELECT meta_value FROM wp_postmeta WHERE meta_key = "txtOptionE" AND post_id = ' . $resultTestQuestions[$index]['post_id'];
		$result = $wpdb->get_results($query, ARRAY_A);
		if(count($result) > 0){
?>
		<li><input type="radio" name="<?php echo $resultTestQuestions[$index]['post_id']; ?>" value="E"/><?php echo $result[0]['meta_value']; ?></li>
<?php
		}
		$query = 'SELECT meta_value FROM wp_postmeta WHERE meta_key = "txtOptionF" AND post_id = ' . $resultTestQuestions[$index]['post_id'];
		$result = $wpdb->get_results($query, ARRAY_A);
		if(count($result) > 0){
?>
		<li><input type="radio" name="<?php echo $resultTestQuestions[$index]['post_id']; ?>" value="F"/><?php echo $result[0]['meta_value']; ?></li>
<?php
		}
		$query = 'SELECT meta_value FROM wp_postmeta WHERE meta_key = "txtOptionG" AND post_id = ' . $resultTestQuestions[$index]['post_id'];
		$result = $wpdb->get_results($query, ARRAY_A);
		if(count($result) > 0){
?>
		<li><input type="radio" name="<?php echo $resultTestQuestions[$index]['post_id']; ?>" value="G"/><?php echo $result[0]['meta_value']; ?></li>
<?php
		}
?>
	</ul>
<?php
	}
?>
	<p><input type="submit" value="submit"/></p>
	</form>
</div>
<?php
}
add_action( 'admin_menu', 'register_ptar_employee_training_page' );

function register_ptar_employee_training_page(){
    $page = add_menu_page( 'PTAR Employee Training Class', 'PTAR Employee Training Class', '0', 'ptar-employee-training', 'mainEmployee', '', 4 );
    add_submenu_page('ptar-employee-training','Training Videos','Training Videos','0','training-videos','training_videos');
    add_submenu_page('ptar-employee-training','Training Documents','Training Documents','0','training-documents','training_documents');
    add_submenu_page('ptar-employee-training','Training Tests','Training Tests','0','training-tests','training_tests');
}
?>