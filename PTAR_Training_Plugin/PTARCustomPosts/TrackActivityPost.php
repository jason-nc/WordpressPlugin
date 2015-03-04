<?php

add_action( 'init', 'createActivityPost' );

function createActivityPost() {
	$labels = array(
		'name'               => _x( 'Training Activity', 'post type general name' ),
		'singular_name'      => _x( 'Training Activity', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'training-activity' ),
		'add_new_item'       => __( 'Add New Training Activity' ),
		'edit_item'          => __( 'Edit Training Activity' ),
		'new_item'           => __( 'New Training Activity' ),
		'all_items'          => __( 'All Training Activity' ),
		'view_item'          => __( 'View Training Activity' ),
		'search_items'       => __( 'Search Training Activity' ),
		'not_found'          => __( 'No Training Activity found' ),
		'not_found_in_trash' => __( 'No Training Activity found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Training Activity'
	);

	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our Training Activity and Training Activity specific data',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title' ),
		'has_archive'   => true,
	);

	register_post_type( 'training-activity', $args );
}


add_filter( 'post_updated_messages', 'my_updated_messages' );

function my_updated_messages( $messages ) {
	global $post, $post_ID;
	$messages['training-activity'] = array(
		0 => '', 
		1 => sprintf( __('Training Activity updated. <a href="%s">View Training Activity</a>'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Training Activity updated.'),
		3 => __('Training Activity deleted.'),
		4 => __('Training Activity updated.'),
		5 => isset($_GET['revision']) ? sprintf( __('Training Activity restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Training Activity published. <a href="%s">View Training Activity</a>'), esc_url( get_permalink($post_ID) ) ),
		7 => __('Training Activity saved.'),
		8 => sprintf( __('Training Activity submitted. <a target="_blank" href="%s">Preview Training Activity</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Training Activity scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Alert Email product</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Training Activity draft updated. <a target="_blank" href="%s">Preview Training Activity</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);

	return $messages;
}

add_action( 'contextual_help', 'training_activity_contextual_help', 10, 3 );

function training_activity_contextual_help( $contextual_help, $screen_id, $screen ) { 
	if ( 'training-activity' == $screen->id ) {
		$contextual_help = '<h2>ATraining Activity</h2>
		<p>Alert Email show the details of the items that we sell on the website. You can see a list of them on this page in reverse chronological order - the latest one we added is first.</p> 
		<p>You can view/edit the details of each Training Activity by clicking on its name, or you can perform bulk actions using the dropdown menu and selecting multiple items.</p>';
	} elseif ( 'training-activity' == $screen->id ) {
		$contextual_help = '<h2>Editing Training Activity</h2>
		<p>This page allows you to view/modify Training Activity details. Please make sure to fill out the available boxes with the appropriate details (product image, price, brand) and <strong>not</strong> add these details to the Training Activity description.</p>';
	}

	return $contextual_help;
}

add_filter( 'manage_edit-training-activity_columns', 'training_activity_columns' ) ;

function training_activity_columns( $columns ) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Name' ),
		'date' => __( 'Date' ),
		'userName' => __( 'User Name' ),
		'userId' => __('User Id'),
		'fileName' => __('File Name'),
		'filePath' => __('File Path'),
		'txtEvent' => __('Event'),
		'txtDescription' => __('Description')
	);
	return $columns;
}

add_action( 'manage_training-activity_posts_custom_column', 'manage_training_activity_columns', 10, 2 );

function manage_training_activity_columns($column, $post_id) {
	global $post;
	switch($column) {
		/* If displaying the 'userName' column. */
			case 'userName' :
			/* Get the post meta. */
			$userName = get_post_meta( $post_id, 'userName', true );
			/* If no duration is found, output a default message. */
			if (empty( $userName))
				echo __('Unknown');
			/* If there is a duration, append 'minutes' to the text string. */
			else
				printf( __('%s'), $userName);
			break;
		/* If displaying the 'userId' column. */
			case 'userId' :
			/* Get the post meta. */
			$userId = get_post_meta( $post_id, 'userId', true );
			/* If no duration is found, output a default message. */
			if (empty( $userId))
				echo __('Unknown');
			/* If there is a duration, append 'minutes' to the text string. */
			else
				printf(__('%s'),$userId);
			break;
		/* If displaying the 'fileName' column. */
			case 'fileName' :
			/* Get the post meta. */
			$fileName = get_post_meta( $post_id, 'fileName', true );
			/* If no duration is found, output a default message. */
			if(empty( $fileName))
				echo __('Unknown');
			/* If there is a duration, append 'minutes' to the text string. */
			else
				printf(__('%s'), $fileName);
			break;
		/* If displaying the 'filePath' column. */
			case 'filePath' :
			/* Get the post meta. */
			$filePath = get_post_meta( $post_id, 'filePath', true );
			/* If no duration is found, output a default message. */
			if(empty($filePath))
				echo __('Unknown');
			/* If there is a duration, append 'minutes' to the text string. */
			else
				printf(__('%s'), $filePath);
			break;
		/* If displaying the 'txtEvent' column. */
			case 'txtEvent' :
			/* Get the post meta. */
			$txtEvent = get_post_meta( $post_id, 'txtEvent', true );
			/* If no duration is found, output a default message. */
			if(empty($txtEvent))
				echo __('Unknown');
			/* If there is a duration, append 'minutes' to the text string. */
			else
				printf(__('%s'), $txtEvent);
			break;
		/* If displaying the 'txtDescription' column. */
			case 'txtDescription' :
			/* Get the post meta. */
			$txtDescription = get_post_meta( $post_id, 'txtDescription', true );
			/* If no duration is found, output a default message. */
			if(empty($txtDescription))
				echo __('Unknown');
			/* If there is a duration, append 'minutes' to the text string. */
			else
				printf(__('%s'), $txtDescription);
			break;
		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}

add_filter('manage_edit-training-activity_sortable_columns', 'training_activity_sortable_columns');

function training_activity_sortable_columns($columns) {
	$columns['userName'] = 'userName';
	$columns['userId'] = 'userId';
	$columns['fileName'] = 'fileName';
	$columns['filePath'] = 'filePath';
	$columns['txtEvent'] = 'txtEvent';
	$columns['txtDescription'] = 'txtDescription';
	return $columns;
}

/* Only run our customization on the 'edit.php' page in the admin. */
add_action( 'load-edit.php', 'training_activity_load' );

function training_activity_load() {
	add_filter( 'request', 'sort_training_activity' );
}

/* Sorts the training activity. */
function sort_training_activity( $vars ) {
	/* Check if we're viewing the 'training-activity' post type. */
	if ( isset( $vars['post_type'] ) && 'training-activity' == $vars['post_type'] ) {
		if ( isset( $vars['orderby'] ) && 'userName' == $vars['orderby'] ) {
			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'userName',
					'orderby' => 'meta_value'
				)
			);
		}else if ( isset( $vars['orderby'] ) && 'userId' == $vars['orderby'] ) {
			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'userId',
					'orderby' => 'meta_value'
				)
			);
		}else if ( isset( $vars['orderby'] ) && 'fileName' == $vars['orderby'] ) {
			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'fileName',
					'orderby' => 'meta_value'
				)
			);
		}else if ( isset( $vars['orderby'] ) && 'filePath' == $vars['orderby'] ) {
			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'filePath',
					'orderby' => 'meta_value'
				)
			);
		}else if ( isset( $vars['orderby'] ) && 'txtEvent' == $vars['orderby'] ) {
			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'txtEvent',
					'orderby' => 'meta_value'
				)
			);
		}else if ( isset( $vars['orderby'] ) && 'txtDescription' == $vars['orderby'] ) {
			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'txtDescription',
					'orderby' => 'meta_value'
				)
			);
		}
	}
	return $vars;
}

add_action( 'load-post.php', 'training_activity_meta_boxes_setup' );
add_action( 'load-post-new.php', 'training_activity_meta_boxes_setup' );

function training_activity_meta_boxes_setup() {
	/* Add meta boxes on the 'add_meta_boxes' hook. */
	add_action( 'add_meta_boxes', 'training_activity_add_post_meta_boxes' );
	add_action( 'save_post', 'training_activity_save_all_post_class_meta', 10, 2 );
}

function training_activity_add_post_meta_boxes() {
	add_meta_box(
		'edit-training_activity',			// Unique ID
		esc_html__( 'training_activity', 'example' ),		// Title
		'training_activity_post_class_meta_box',			// Callback function
		'training-activity',				// Admin page (or post type)
		'normal',					// Context
		'default'					// Priority
	);
}

function training_activity_post_class_meta_box( $object, $box ) { 
	if($box['id'] == 'edit-training_activity'){
		wp_nonce_field( basename( __FILE__ ), 'userName_nonce' ); 
		wp_nonce_field( basename( __FILE__ ), 'userId_nonce' ); 
		wp_nonce_field( basename( __FILE__ ), 'fileName_nonce' ); 
		wp_nonce_field( basename( __FILE__ ), 'filePath_nonce' ); 
		wp_nonce_field( basename( __FILE__ ), 'txtEvent_nonce' ); 
		wp_nonce_field( basename( __FILE__ ), 'txtDescription_nonce' ); 
?>

<div style="width: 30;">

	<p>User Name:</br> <input type="text" name="userName" value="<?php echo esc_attr( get_post_meta( $object->ID, 'userName', true ) ); ?>"></p>
	<p>User Id:</br> <input type="text" name="userId" value="<?php echo esc_attr( get_post_meta( $object->ID, 'userId', true ) ); ?>"></p>
	<p>File Name:</br> <input type="text" name="fileName" value="<?php echo esc_attr( get_post_meta( $object->ID, 'fileName', true ) ); ?>"></p>
	<p>File Path:</br> <input type="text" name="filePath" value="<?php echo esc_attr( get_post_meta( $object->ID, 'filePath', true ) ); ?>"></p>
	<p>Event:</br> <input type="text" name="txtEvent" value="<?php echo esc_attr( get_post_meta( $object->ID, 'txtEvent', true ) ); ?>"></p>
	<p>Description:</br> <input type="text" name="txtDescription" value="<?php echo esc_attr( get_post_meta( $object->ID, 'txtDescription', true ) ); ?>"></p>
</div>
<?php

	}
}

function training_activity_save_all_post_class_meta( $post_id, $post ) {
	training_activity_save_post_class_meta( $post_id, $post, 'userName' );
	training_activity_save_post_class_meta( $post_id, $post, 'userId' );
	training_activity_save_post_class_meta( $post_id, $post, 'fileName' );
	training_activity_save_post_class_meta( $post_id, $post, 'filePath' );
	training_activity_save_post_class_meta( $post_id, $post, 'txtEvent' );
	training_activity_save_post_class_meta( $post_id, $post, 'txtDescription' );
}

function training_activity_save_post_class_meta( $post_id, $post, $column ) {
	/* Verify the nonce before proceeding. */
	if ( !isset( $_POST[$column . '_nonce'] ) || !wp_verify_nonce( $_POST[$column . '_nonce'], basename( __FILE__ ) ) )
		return $post_id;

	/* Get the post type object. */
	$post_type = get_post_type_object( $post->post_type );

	/* Check if the current user has permission to edit the post. */
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;

	/* Get the posted data and sanitize it for use as an HTML class. */
	//$new_meta_value = ( isset( $_POST[$column] ) ? sanitize_html_class( $_POST[$column] ) : '' );
	$new_meta_value = ( isset( $_POST[$column] ) ? esc_attr( $_POST[$column] ) : '' );

	/* Get the meta key. */
	$meta_key = $column;

	/* Get the meta value of the custom field key. */
	$meta_value = get_post_meta( $post_id, $meta_key, true );

	/* If a new meta value was added and there was no previous value, add it. */
	if ( $new_meta_value && '' == $meta_value )
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );

	/* If the new meta value does not match the old value, update it. */
	elseif ( $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );

	/* If there is no new meta value but an old value exists, delete it. */
	elseif ( '' == $new_meta_value && $meta_value )
		delete_post_meta( $post_id, $meta_key, $meta_value );
}

add_filter( 'post_class', 'training_activity_post_class' );

function training_activity_post_class( $classes ) {
	/* Get the current post ID. */
	$post_id = get_the_ID();

	/* If we have a post ID, proceed. */
	if ( !empty( $post_id ) ) {
		/* Get the custom post class. */
		$post_class = get_post_meta( $post_id, 'patr_post_class', true );

		/* If a post class was input, sanitize it and add it to the post class array. */
		if ( !empty( $post_class ) )
			$classes[] = sanitize_html_class( $post_class );
	}

	return $classes;
}
add_action( 'restrict_manage_posts', 'training_activity_file_filtering' );
function training_activity_file_filtering(){
  	global $wpdb;
  	if ( $_GET['post_type'] == 'training-activity' ) {
    		$fileNames = $wpdb->get_results( 'SELECT meta_value FROM wp_postmeta WHERE meta_key = "fileName" GROUP BY meta_value', ARRAY_A ) ;
		$stop = count($fileNames);
?>
      		<label for="sortFiles" class="screen-reader-text"><?php echo __( 'Show all files', 'textdomain' ); ?></label>
    		<select id="sortFiles" name="sortFiles">
      			<option value=""><?php echo __( 'All files', 'textdomain' ); ?></option>
<?php
    		foreach( $fileNames as $f ) {
      			$selected = ( !empty( $_GET['sortFiles'] ) AND $_GET['sortFiles'] == $f['meta_value'] ) ? 'selected="select"' : '';
?>
      			<option value="<?php echo $f['meta_value']; ?>" <?php echo $selected; ?>><?php echo $f['meta_value']; ?></option>
<?php
               }
?>	
		</select>
<?php
    		$fileUsers = $wpdb->get_results( 'SELECT meta_value FROM wp_postmeta WHERE meta_key = "userName" GROUP BY meta_value', ARRAY_A ) ;
		$stop = count($fileUsers);
?>
      		<label for="sortUsers" class="screen-reader-text"><?php echo __( 'Show all users', 'textdomain' ); ?></label>
    		<select id="sortUsers" name="sortUsers">
      			<option value=""><?php echo __( 'All users', 'textdomain' ); ?></option>
<?php
    		foreach( $fileUsers as $user ) {
      			$selected = ( !empty( $_GET['sortUsers'] ) AND $_GET['sortUsers'] == $user['meta_value'] ) ? 'selected="select"' : '';
?>
      			<option value="<?php echo $user['meta_value']; ?>" <?php echo $selected; ?>><?php echo $user['meta_value']; ?></option>
<?php
               }
?>	
		</select>
<?php
	}
}
add_filter( 'parse_query','training_activity_file_filter' );
function training_activity_file_filter($query){	
	if(!empty($_GET['sortUsers']) && !empty($_GET['sortFiles'])){
		set_query_var( 'meta_query', array( 
							array( 'key' => 'userName', 'value' => $_GET['sortUsers'] ),
							array( 'key' => 'fileName', 'value' => $_GET['sortFiles'] )
						) );
		set_query_var( 'orderby','meta_value' );
	}else if(!empty($_GET['sortFiles'])){
		set_query_var( 'meta_query', array( array( 'key' => 'fileName', 'value' => $_GET['sortFiles']) ) );
		set_query_var( 'orderby','meta_value' );
	}else if(!empty($_GET['sortUsers'])){
		set_query_var( 'meta_query', array( array( 'key' => 'userName', 'value' => $_GET['sortUsers'] ) ) );
		set_query_var( 'orderby','meta_value' );
	}
}
?>