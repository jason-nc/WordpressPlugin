<?php
/*
* Template Name: Activity Report Page
*/
//echo '<p>upload files page</p>';
if ( is_user_logged_in() ){
	$user_ID = get_current_user_id();
	$user_info = get_userdata($user_ID);
	$userRole = $user_info->wp_capabilities;
	$role = key($userRole);
        if($role == 'administrator'){
		$nonce = $_POST['checkMe'];
		if(wp_verify_nonce( $nonce, 'activiy-report' )){
			global $wpdb;
			$query = 'SELECT wp_postmeta.post_id, wp_posts.post_date FROM wp_postmeta, wp_posts WHERE wp_postmeta.meta_key = "userId" AND wp_postmeta.meta_value = ' . $_POST['userId'] . ' AND wp_postmeta.post_id = wp_posts.ID ORDER BY wp_posts.ID, wp_posts.post_date';
			//$query = 'SELECT post_id FROM wp_postmeta WHERE meta_key = "userId" AND meta_value = ' . $_POST['userId'];
			$resultPosts = $wpdb->get_results($query,ARRAY_A);
			$stop = count($resultPosts);
			$index = 0;
			echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>
	<files>
<?php
			while($index < $stop){
?>		
		<file>
			<postId><?php echo $resultPosts[$index]['post_id']; ?></postId>
			<postDate><?php echo $resultPosts[$index]['post_date']; ?></postDate>
<?php
			$query = 'SELECT meta_value FROM wp_postmeta WHERE meta_key = "fileName" AND post_id = ' . $resultPosts[$index]['post_id'];
			$tmpResult = $wpdb->get_results($query,ARRAY_A);
?>
			<fileName><?php echo $tmpResult[0]['meta_value']; ?></fileName>
<?php
			$query = 'SELECT meta_value FROM wp_postmeta WHERE meta_key = "txtEvent" AND post_id = ' . $resultPosts[$index]['post_id'];
			$tmpResult = $wpdb->get_results($query,ARRAY_A);
?>
			<Event><?php echo $tmpResult[0]['meta_value']; ?></Event>
<?php
			$query = 'SELECT meta_value FROM wp_postmeta WHERE meta_key = "txtDescription" AND post_id = ' . $resultPosts[$index]['post_id'];
			$tmpResult = $wpdb->get_results($query,ARRAY_A);
?>
			<Description><?php echo $tmpResult[0]['meta_value']; ?></Description>
		</file>
<?php
				$index++;
			}
?>
	</files>
<?php
                }else{
		?>
		<p>You must have administrative privilege to view this page.</p>
		<?php
        	}
        }else{
?>
<p>You must have administrative privilege to view this page.</p>
<?php
        }
}else{
?>
<p>You must be logged in to this page.</p>
<?php
}
?>