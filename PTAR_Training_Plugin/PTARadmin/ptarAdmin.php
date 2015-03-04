<?php

function mainAdmin(){
           echo '<p>Welcome to the Administrative Page.</p>';
}
function upload_files(){
	include 'adminCss/adminCss.css';
	include 'adminJs/adminJs.js';
	$uploadVideoResult = '';
//print_r($_FILES);
	$nonce = $_POST['checkMe'];
	if($_POST['process'] > 0){
		if(wp_verify_nonce( $nonce, 'up-load-file' )){
  			if ($_FILES['uploadVideoFile']["error"] > 0){
   				$uploadVideoResult = '<p>Return Code: ' . $_FILES['uploadVideoFile']['error'] . '</p>';
    			}else if($_POST['process'] == 1){
   				$uploadVideoResult  = '<p>Upload: ' . $_FILES['uploadVideoFile']['name'] . '</p>';
    				$uploadVideoResult  =  $uploadVideoResult . '<p>Type: ' . $_FILES['uploadVideoFile']['type'] . '</p>';
    				$uploadVideoResult  =  $uploadVideoResult . '<p>Size: ' . ($_FILES['uploadVideoFile']['size'] / 1024) . ' kB</p>';
    				$uploadVideoResult  =  $uploadVideoResult . '<p>Temp file: ' . $_FILES['uploadVideoFile']['tmp_name'] . '</p>';

    				if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/PTAR/wp-content/themes/uploads/' . $_POST['directory'] . '/' . $_FILES['uploadVideoFile']["name"])){
      					$uploadVideoResult  =  $uploadVideoResult . '<p>' . $_FILES['uploadVideoFile']['name'] . ' already exists. </p>';
      				}else{
      					move_uploaded_file($_FILES['uploadVideoFile']["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . '/PTAR/wp-content/uploads/' . $_POST['directory'] . '/' . $_FILES['uploadVideoFile']["name"]);
      					$uploadVideoResult  =  $uploadVideoResult . '<p>Stored in: ' . $_SERVER['DOCUMENT_ROOT'] . '/PTAR/wp-content/uploads/' . $_POST['directory'] . '/' . $_FILES['uploadVideoFile']["name"] . '</p>';
      				}
    			}

			$uploadTestsResult = '';
  			if ($_FILES['uploadTestsFile']["error"] > 0){
   				$uploadVideoResult = '<p>Return Code: ' . $_FILES['uploadTestsFile']['error'] . '</p>';
    			}else if($_POST['process'] == 2){
   				$uploadTestsResult  = '<p>Upload: ' . $_FILES['uploadTestsFile']['name'] . '</p>';
    				$uploadTestsResult  =  $uploadTestsResult . '<p>Type: ' . $_FILES['uploadTestsFile']['type'] . '</p>';
    				$uploadTestsResult  =  $uploadTestsResult . '<p>Size: ' . ($_FILES['uploadTestsFile']['size'] / 1024) . ' kB</p>';
    				$uploadTestsResult  =  $uploadTestsResult . '<p>Temp file: ' . $_FILES['uploadTestsFile']['tmp_name'] . '</p>';

    				if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/PTAR/wp-content/uploads/' . $_POST['directory'] . '/' . $_FILES['uploadTestsFile']["name"])){
      					$uploadTestsResult  =  $uploadTestsResult . '<p>' . $_FILES['uploadTestsFile']['name'] . ' already exists. </p>';
      				}else{
      					move_uploaded_file($_FILES['uploadTestsFile']["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . '/PTAR/wp-content/uploads/' . $_POST['directory'] . '/' . $_FILES['uploadTestsFile']["name"]);
      					$uploadTestsResult  =  $uploadTestsResult . '<p>Stored in: ' . $_SERVER['DOCUMENT_ROOT'] . '/PTAR/wp-content/uploads/' . $_POST['directory'] . '/' . $_FILES['uploadTestsFile']["name"] . '</p>';
      				}
?>
	<style>
		.divTab{
			background-color: #DDD;
		}
		#testsTab{
			background-color: #FFFFFF;
		}
		.divTabContent{
			display: none;
		}
		#testsTabContent{
			display: block;
		}
		#videoTab{
			background-color: #DDD;
		}
		#videoTabContent{
			display: none;
		}
	</style>
<?php
    			}

			$uploadDocementResult = '';
  			if ($_FILES['uploadDocumentsFile']["error"] > 0){
   				$uploadDocementResult = '<p>Return Code: ' . $_FILES['uploadDocumentsFile']['error'] . '</p>';
    			}else if($_POST['process'] == 3){
   				$uploadDocementResult  = '<p>Upload: ' . $_FILES['uploadDocumentsFile']['name'] . '</p>';
    				$uploadDocementResult  =  $uploadDocementResult . '<p>Type: ' . $_FILES['uploadDocumentsFile']['type'] . '</p>';
    				$uploadDocementResult  =  $uploadDocementResult . '<p>Size: ' . ($_FILES['uploadDocumentsFile']['size'] / 1024) . ' kB</p>';
    				$uploadDocementResult  =  $uploadDocementResult . '<p>Temp file: ' . $_FILES['uploadDocumentsFile']['tmp_name'] . '</p>';

    				if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/PTAR/wp-content/uploads/' . $_POST['directory'] . '/' . $_FILES['uploadDocumentsFile']["name"])){
      					$uploadDocementResult  =  $uploadDocementResult . '<p>' . $_FILES['uploadDocumentsFile']['name'] . ' already exists. </p>';
      				}else{
      					move_uploaded_file($_FILES['uploadDocumentsFile']["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . '/PTAR/wp-content/uploads/' . $_POST['directory'] . '/' . $_FILES['uploadDocumentsFile']["name"]);
      					$uploadDocementResult  =  $uploadDocementResult . '<p>Stored in: ' . $_SERVER['DOCUMENT_ROOT'] . '/PTAR/wp-content/uploads/' . $_POST['directory'] . '/' . $_FILES['uploadDocumentsFile']["name"] . '</p>';
      				}
?>
	<style>
		.divTab{
			background-color: #DDD;
		}
		#documentsTab{
			background-color: #FFFFFF;
		}
		.divTabContent{
			display: none;
		}
		#testsTabContent{
			display: none;
		}
		#videoTab{
			background-color: #DDD;
		}
		#documentsTabContent{
				display: block;
		}
	</style>
<?php
    			}
		}else{
?>
			<p>There was an error while uploading your file. Wordpress was not able to verify you had an approved user account to upload files.</p>
<?php
		}
	}
?>
<p>Upload Files</p>
<div id="uploadFileTabs">
	<div id="divTabs">
		<div id="videoTab" class="divTab">
			Videos
		</div>
		<div id="testsTab" class="divTab">
			Tests
		</div>
		<div id="documentsTab" class="divTab">
			Documents
		</div>
	</div>
	<div id="divTabContents">
		<div id="videoTabContent" class="divTabContent">
			<!--<p><?php /* echo $uploadVideoResult; */ ?></p>-->
			<ul id="listVideofiles">
<?php
		$dirFiles = scandir($_SERVER['DOCUMENT_ROOT'] . '/PTAR/wp-content/uploads/traingVideos/');
		foreach($dirFiles as $dirFile){
			if($dirFile != '.' && $dirFile != '..'){
?>
				<li><?php echo $dirFile; ?> <a href="#" class="deleteVideoFile" alt="<?php echo $dirFile; ?>"><img src="<?php echo site_url(); ?>/wp-content/uploads/2014/12/deleteIcon.jpg" height="25" width="25"/></a></li>
<?php
			}
		}
?>
			</ul>
<?php
		$nonce = wp_create_nonce('up-load-file');
?>
			<form action="<?php echo site_url(); ?>/wp-admin/admin.php?page=upload-files" method="post" enctype="multipart/form-data">
				<input type="file" name="uploadVideoFile" id="uploadVideoFile"/>'
				<input type="submit" id="formUploadVideoFile" value="Submit Video"/>
				<input type="hidden" name="checkMe" id="checkMe" value="<?php echo $nonce; ?>"/>
				<input type="hidden" name="process" value="1"/>
				<input type="hidden" name="directory" value="traingVideos"/>
			</form>
		</div>
		<div id="testsTabContent" class="divTabContent">
			<!--<p><?php /* echo $uploadTestsResult; */ ?></p>-->
			<ul id="listTestfiles">
<?php
		$dirFiles = scandir($_SERVER['DOCUMENT_ROOT'] . '/PTAR/wp-content/uploads/traingTests/');
		foreach($dirFiles as $dirFile){
			if($dirFile != '.' && $dirFile != '..'){
?>
				<li><?php echo $dirFile; ?> <a href="#" class="deleteTestFile" alt="<?php echo $dirFile; ?>"><img src="<?php echo site_url(); ?>/wp-content/uploads/2014/12/deleteIcon.jpg" height="25" width="25"/></a></li>
<?php
			}
		}
?>
			</ul>
			<form action="<?php echo site_url(); ?>/wp-admin/admin.php?page=upload-files" method="post" enctype="multipart/form-data">
				<input type="file" name="uploadTestsFile" id="uploadTestslFile"/>
				<input type="submit" value="Submit"/>
				<input type="hidden" name="checkMe" value="<?php echo $nonce; ?>"/>
				<input type="hidden" name="process" value="2"/>
				<input type="hidden" name="directory" value="traingTests"/>
			</form>
		</div>
		<div id="documentsTabContent" class="divTabContent">
			<!--<p><?php /* echo $uploadDocementResult; */ ?></p>-->
			<ul id="listDocumentfiles">
<?php
		$dirFiles = scandir($_SERVER['DOCUMENT_ROOT'] . '/PTAR/wp-content/uploads/traingDocuments/');
		foreach($dirFiles as $dirFile){
			if($dirFile != '.' && $dirFile != '..'){
?>
				<li><?php echo $dirFile; ?> <a href="#" class="deleteDocumentFile" alt="<?php echo $dirFile; ?>"><img src="<?php echo site_url(); ?>/wp-content/uploads/2014/12/deleteIcon.jpg" height="25" width="25"/></a></li>
<?php
			}
		}
?>
			</ul>
			<form action="<?php echo site_url(); ?>/wp-admin/admin.php?page=upload-files" method="post" enctype="multipart/form-data">
				<input type="file" name="uploadDocumentsFile" id="uploadDocumentsFile"/>
				<input type="submit" value="Submit"/>
				<input type="hidden" name="checkMe" value="<?php echo $nonce; ?>"/>
				<input type="hidden" name="process" value="3"/>
				<input type="hidden" name="directory" value="traingDocuments"/>
			</form>
		</div>
	</div>
</div>
<?php
}

function check_activity(){
	include 'adminCss/adminCss.css';
	include 'adminJs/adminJs.js';
	$nonce = wp_create_nonce('activiy-report');
?>
	<h1>Check Activity</h1>
<?php
	global $wpdb;
	$query = 'SELECT user_login, ID FROM wp_users';
	$userResult = $wpdb->get_results($query,ARRAY_A);
	$stop = count($userResult);
	$index = 0;
?>
	<select id="users" alt="<?php echo $nonce; ?>">
		<option selected></option>
<?php
		while($index < $stop){
?>
		<option value="<?php echo $userResult[$index]['ID']; ?>"><?php echo $userResult[$index]['user_login']; ?></option>
<?php
			$index++;
		}
?>
	</select>
	<div id="seeUserActivity">
		<table id="displayActivity">
		</table>
	</div>
<?php
}

function application_for_employemnt(){
	include 'adminCss/adminCss.css';
	include 'adminJs/adminJs.js';
//print_r($_FILES);
?>
<p>Application Files</p>
<div id="uploadFileTabs">
	<div id="divTabContents">
<?php
		$nonce = wp_create_nonce('up-load-file');
?>
		<input type="hidden" name="checkMe" id="checkMe" value="<?php echo $nonce; ?>"/>
		<div>
			<ul id="listApplicationfiles">
<?php
		$dirFiles = scandir($_SERVER['DOCUMENT_ROOT'] . '/PTAR/wp-content/uploads/employmentApplication/');
		foreach($dirFiles as $dirFile){
			if($dirFile != '.' && $dirFile != '..'){
?>
				<li><a href="<?php echo site_url(); ?>/wp-content/uploads/employmentApplication/<?php echo $dirFile; ?>" target="_blank"><?php echo $dirFile; ?></a> <a href="#" class="deleteApplicationFile" alt="<?php echo $dirFile; ?>"><img src="<?php echo site_url(); ?>/wp-content/uploads/2014/12/deleteIcon.jpg" height="25" width="25"/></a></li>
<?php
			}
		}
?>
			</ul>
		</div>
<?php
}

add_action( 'admin_menu', 'register_ptar_admin_training_page' );

function register_ptar_admin_training_page(){
    $page = add_menu_page( 'PTAR Training: Admin', 'PTAR Training: Admin', '7', 'ptar-admin-training', 'mainAdmin', '', 3 );
    add_submenu_page('ptar-admin-training','Upload Files','Upload Files','7','upload-files','upload_files');
    add_submenu_page('ptar-admin-training','Check Activity','Check Activity','7','check-activity','check_activity');
    add_submenu_page('ptar-admin-training','Application for Employemnt','Application for Employemnt','7','application-for-employemnt','application_for_employemnt');
    add_submenu_page('','','','7','up-load-videos','up_load_videos');
}

?>