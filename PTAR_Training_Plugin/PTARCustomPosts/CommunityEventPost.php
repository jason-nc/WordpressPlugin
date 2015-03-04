<?php

add_action( 'init', 'createCommunityEvent' );

function createCommunityEvent() {
	$labels = array(
		'name'               => _x( 'Community Event', 'post type general name' ),
		'singular_name'      => _x( 'Community Event', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'community-event' ),
		'add_new_item'       => __( 'Add New Community Event' ),
		'edit_item'          => __( 'Edit Community Event' ),
		'new_item'           => __( 'New Community Event' ),
		'all_items'          => __( 'All Community Event' ),
		'view_item'          => __( 'View Community Event' ),
		'search_items'       => __( 'Search Community Event' ),
		'not_found'          => __( 'No Community Event found' ),
		'not_found_in_trash' => __( 'No Community Event found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Community Event'
	);

	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our Community Event and Community Event specific data',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title' ),
		'has_archive'   => true,
	);

	register_post_type( 'community-event', $args );
}


add_filter( 'post_updated_messages', 'my_updated_community_event_messages' );

function my_updated_community_event_messages( $messages ) {
	global $post, $post_ID;
	$messages['community-event'] = array(
		0 => '', 
		1 => sprintf( __('Community Event updated. <a href="%s">View Community Event</a>'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Community Event updated.'),
		3 => __('Community Event deleted.'),
		4 => __('Community Event updated.'),
		5 => isset($_GET['revision']) ? sprintf( __('Community Event restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Community Event published. <a href="%s">View Community Event</a>'), esc_url( get_permalink($post_ID) ) ),
		7 => __('Community Event saved.'),
		8 => sprintf( __('Community Event submitted. <a target="_blank" href="%s">Preview Community Event</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Community Event scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Alert Email product</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Community Event draft updated. <a target="_blank" href="%s">Preview Community Event</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);

	return $messages;
}

add_action( 'contextual_help', 'community_event_contextual_help', 10, 3 );

function community_event_contextual_help( $contextual_help, $screen_id, $screen ) { 
	if ( 'community-event' == $screen->id ) {
		$contextual_help = '<h2>A Community Event</h2>
		<p>Alert Email show the details of the items that we sell on the website. You can see a list of them on this page in reverse chronological order - the latest one we added is first.</p> 
		<p>You can view/edit the details of each Community Event by clicking on its name, or you can perform bulk actions using the dropdown menu and selecting multiple items.</p>';
	} elseif ( 'community-event' == $screen->id ) {
		$contextual_help = '<h2>Editing Community Event</h2>
		<p>This page allows you to view/modify Community Event details. Please make sure to fill out the available boxes with the appropriate details (product image, price, brand) and <strong>not</strong> add these details to the Community Event description.</p>';
	}

	return $contextual_help;
}

add_filter( 'manage_edit-community-event_columns', 'community_event_columns' ) ;

function community_event_columns( $columns ) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Name' ),
		'date' => __( 'Date' ),
		'txtCommunityEvent' => __('Community Event'),
		'txtCommunityEventLocation' => __('Community Event Location'),
		'dteDate' => __( 'Community Event Date' ),
		'startTime' => __('Start Time'),
		'endTime' => __('End Time'),
		'txtCommunityEventDescription' => __('Description')
	);
	return $columns;
}

add_action( 'manage_community-event_posts_custom_column', 'manage_community_event_columns', 10, 2 );

function manage_community_event_columns($column, $post_id) {
	global $post;
	switch($column) {
		/* If displaying the 'txtCommunityEventLocation' column. */
			case 'txtCommunityEventLocation' :
			/* Get the post meta. */
			$txtCommunityEventLocation = get_post_meta( $post_id, 'txtCommunityEventLocation', true );
			/* If no duration is found, output a default message. */
			if (empty( $txtCommunityEventLocation))
				echo __('Unknown');
			/* If there is a duration, append 'minutes' to the text string. */
			else
				printf( __('%s'), $txtCommunityEventLocation);
			break;
		/* If displaying the 'dteDate' column. */
			case 'dteDate' :
			/* Get the post meta. */
			$dteDate = get_post_meta( $post_id, 'dteDate', true );
			/* If no duration is found, output a default message. */
			if (empty( $dteDate))
				echo __('Unknown');
			/* If there is a duration, append 'minutes' to the text string. */
			else
				printf( __('%s'), $dteDate);
			break;
		/* If displaying the 'startTime' column. */
			case 'startTime' :
			/* Get the post meta. */
			$startTime = get_post_meta( $post_id, 'startTime', true );
			/* If no duration is found, output a default message. */
			if (empty( $startTime))
				echo __('Unknown');
			/* If there is a duration, append 'minutes' to the text string. */
			else
				printf(__('%s'),$startTime);
			break;
		/* If displaying the 'endTime' column. */
			case 'endTime' :
			/* Get the post meta. */
			$endTime = get_post_meta( $post_id, 'endTime', true );
			/* If no duration is found, output a default message. */
			if(empty($endTime))
				echo __('Unknown');
			/* If there is a duration, append 'minutes' to the text string. */
			else
				printf(__('%s'), $endTime);
			break;
		/* If displaying the 'txtCommunityEvent' column. */
			case 'txtCommunityEvent' :
			/* Get the post meta. */
			$txtCommunityEvent = get_post_meta( $post_id, 'txtCommunityEvent', true );
			/* If no duration is found, output a default message. */
			if(empty($txtCommunityEvent))
				echo __('Unknown');
			/* If there is a duration, append 'minutes' to the text string. */
			else
				printf(__('%s'), $txtCommunityEvent);
			break;
		/* If displaying the 'txtCommunityEventDescription' column. */
			case 'txtCommunityEventDescription' :
			/* Get the post meta. */
			$txtCommunityEventDescription = get_post_meta( $post_id, 'txtCommunityEventDescription', true );
			/* If no duration is found, output a default message. */
			if(empty($txtCommunityEventDescription))
				echo __('Unknown');
			/* If there is a duration, append 'minutes' to the text string. */
			else
				printf(__('%s'), $txtCommunityEventDescription);
			break;
		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}

add_filter('manage_edit-community-event_sortable_columns', 'community_event_sortable_columns');

function community_event_sortable_columns($columns) {
	$columns['dteDate'] = 'dteDate';
	$columns['startTime'] = 'startTime';
	$columns['endTime'] = 'endTime';
	$columns['txtCommunityEvent'] = 'txtCommunityEvent';
	$columns['txtCommunityEventLocation'] = 'txtCommunityEventLocation';
	$columns['txtCommunityEventDescription'] = 'txtCommunityEventDescription';
	return $columns;
}

/* Only run our customization on the 'edit.php' page in the admin. */
add_action( 'load-edit.php', 'training_activity_load' );

function community_event_load() {
	add_filter( 'request', 'sort_community_event' );
}

/* Sorts the training activity. */
function sort_community_event( $vars ) {
	/* Check if we're viewing the 'community-event' post type. */
	if ( isset( $vars['post_type'] ) && 'community-event' == $vars['post_type'] ) {
		if ( isset( $vars['orderby'] ) && 'dteDate' == $vars['orderby'] ) {
			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'dteDate',
					'orderby' => 'meta_value'
				)
			);
		}else if ( isset( $vars['orderby'] ) && 'startTime' == $vars['orderby'] ) {
			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'startTime',
					'orderby' => 'meta_value'
				)
			);
		}else if ( isset( $vars['orderby'] ) && 'endTime' == $vars['orderby'] ) {
			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'endTime',
					'orderby' => 'meta_value'
				)
			);
		}else if ( isset( $vars['orderby'] ) && 'txtCommunityEvent' == $vars['orderby'] ) {
			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'txtCommunityEvent',
					'orderby' => 'meta_value'
				)
			);
		}else if ( isset( $vars['orderby'] ) && 'txtCommunityEventDescription' == $vars['orderby'] ) {
			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'txtCommunityEventDescription',
					'orderby' => 'meta_value'
				)
			);
		}else if ( isset( $vars['orderby'] ) && 'txtCommunityEventLocation' == $vars['orderby'] ) {
			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'txtCommunityEventLocation',
					'orderby' => 'meta_value'
				)
			);
		}
	}
	return $vars;
}

add_action( 'load-post.php', 'community_event_meta_boxes_setup' );
add_action( 'load-post-new.php', 'community_event_meta_boxes_setup' );

function community_event_meta_boxes_setup() {
	/* Add meta boxes on the 'add_meta_boxes' hook. */
	add_action( 'add_meta_boxes', 'community_event_add_post_meta_boxes' );
	add_action( 'save_post', 'community_event_save_all_post_class_meta', 10, 2 );
}

function community_event_add_post_meta_boxes() {
	add_meta_box(
		'edit-community_event',			// Unique ID
		esc_html__( 'community_event', 'example' ),		// Title
		'community_event_post_class_meta_box',			// Callback function
		'community-event',				// Admin page (or post type)
		'normal',					// Context
		'default'					// Priority
	);
}

function community_event_post_class_meta_box( $object, $box ) { 
	if($box['id'] == 'edit-community_event'){
		wp_nonce_field( basename( __FILE__ ), 'dteDate_nonce' ); 
		wp_nonce_field( basename( __FILE__ ), 'startTime_nonce' ); 
		wp_nonce_field( basename( __FILE__ ), 'endTime_nonce' ); 
		wp_nonce_field( basename( __FILE__ ), 'txtCommunityEvent_nonce' ); 
		wp_nonce_field( basename( __FILE__ ), 'txtCommunityEventLocation_nonce' ); 
		wp_nonce_field( basename( __FILE__ ), 'txtCommunityEventDescription_nonce' ); 
?>

<div style="width: 30;">

	<p>Event Date (YYYY-MM-DD):</br> <input type="text" name="dteDate" value="<?php echo esc_attr( get_post_meta( $object->ID, 'dteDate', true ) ); ?>"></p>
	<p>Start Time:</br> <input type="text" name="startTime" value="<?php echo esc_attr( get_post_meta( $object->ID, 'startTime', true ) ); ?>"></p>
	<p>End Time:</br> <input type="text" name="endTime" value="<?php echo esc_attr( get_post_meta( $object->ID, 'endTime', true ) ); ?>"></p>
	<p>Event:</br> <input type="text" name="txtCommunityEvent" value="<?php echo esc_attr( get_post_meta( $object->ID, 'txtCommunityEvent', true ) ); ?>"></p>
	<p>Location:</br> <input type="text" name="txtCommunityEventLocation" value="<?php echo esc_attr( get_post_meta( $object->ID, 'txtCommunityEventLocation', true ) ); ?>"></p>
	<p>Description:</br> <textarea name="txtCommunityEventDescription"><?php echo esc_attr( get_post_meta( $object->ID, 'txtCommunityEventDescription', true ) ); ?></textarea></p>
</div>
<?php

	}
}

function community_event_save_all_post_class_meta( $post_id, $post ) {
	community_event_save_post_class_meta( $post_id, $post, 'dteDate' );
	community_event_save_post_class_meta( $post_id, $post, 'startTime' );
	community_event_save_post_class_meta( $post_id, $post, 'endTime' );
	community_event_save_post_class_meta( $post_id, $post, 'txtCommunityEvent' );
	community_event_save_post_class_meta( $post_id, $post, 'txtCommunityEventLocation' );
	community_event_save_post_class_meta( $post_id, $post, 'txtCommunityEventDescription' );
}

function community_event_save_post_class_meta( $post_id, $post, $column ) {
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

add_filter( 'post_class', 'community_event_post_class' );

function community_event_post_class( $classes ) {
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
add_action( 'restrict_manage_posts', 'community_event_file_filtering' );
function community_event_file_filtering(){
  	global $wpdb;
  	if ( $_GET['post_type'] == 'community-event' ) {
    		$fileNames = $wpdb->get_results( 'SELECT meta_value FROM wp_postmeta WHERE meta_key = "dteDate" GROUP BY meta_value', ARRAY_A ) ;
		$stop = count($fileNames);
?>
      		<label for="sortDates" class="screen-reader-text"><?php echo __( 'Show all Dates', 'textdomain' ); ?></label>
    		<select id="sortDates" name="sortDates">
      			<option value=""><?php echo __( 'All events', 'textdomain' ); ?></option>
<?php
    		foreach( $fileNames as $f ) {
      			$selected = ( !empty( $_GET['sortDates'] ) AND $_GET['sortDates'] == $f['meta_value'] ) ? 'selected="select"' : '';
?>
      			<option value="<?php echo $f['meta_value']; ?>" <?php echo $selected; ?>><?php echo $f['meta_value']; ?></option>
<?php
               }
?>	
		</select>
<?php
    		$fileNames = $wpdb->get_results( 'SELECT meta_value FROM wp_postmeta WHERE meta_key = "txtCommunityEventLocation" GROUP BY meta_value', ARRAY_A ) ;
		$stop = count($fileNames);
?>
      		<label for="sortLocations" class="screen-reader-text"><?php echo __( 'Show all Locations', 'textdomain' ); ?></label>
    		<select id="sortLocations" name="sortLocations">
      			<option value=""><?php echo __( 'All events', 'textdomain' ); ?></option>
<?php
    		foreach( $fileNames as $f ) {
      			$selected = ( !empty( $_GET['sortLocations'] ) AND $_GET['sortLocations'] == $f['meta_value'] ) ? 'selected="select"' : '';
?>
      			<option value="<?php echo $f['meta_value']; ?>" <?php echo $selected; ?>><?php echo $f['meta_value']; ?></option>
<?php
               }
?>	
		</select>
<?php
	}
}
add_filter( 'parse_query','community_event_file_filter' );
function community_event_file_filter($query){	
	
	if(!empty($_GET['sortLocations']) && !empty($_GET['sortDates'])){
		set_query_var( 'meta_query', array( 
							array( 'key' => 'dteDate', 'value' => $_GET['sortDates'] )
						) );
		set_query_var( 'orderby','meta_value' );
	}else if(!empty($_GET['sortDates'])){
		set_query_var( 'meta_query', array( array( 'key' => 'dteDate', 'value' => $_GET['sortDates']) ) );
		set_query_var( 'orderby','meta_value' );
	}else if(!empty($_GET['sortLocations'])){
		set_query_var( 'meta_query', array( array( 'key' => 'txtCommunityEventLocation', 'value' => $_GET['sortLocation'] ) ) );
		set_query_var( 'orderby','meta_value' );
	}
}
?>