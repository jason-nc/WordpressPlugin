<?php

add_action( 'init', 'createTrainingVideo' );

function createTrainingVideo() {
	$labels = array(
		'name'               => _x( 'Training Video', 'post type general name' ),
		'singular_name'      => _x( 'Training Video', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'training-video' ),
		'add_new_item'       => __( 'Add New Training Video' ),
		'edit_item'          => __( 'Edit Training Video' ),
		'new_item'           => __( 'New Training Video' ),
		'all_items'          => __( 'All Training Video' ),
		'view_item'          => __( 'View Training Video' ),
		'search_items'       => __( 'Search Training Video' ),
		'not_found'          => __( 'No Training Video found' ),
		'not_found_in_trash' => __( 'No Training Video found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Training Video'
	);

	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our Training Video and Training Video specific data',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title' ),
		'has_archive'   => true,
	);

	register_post_type( 'training-video', $args );
}


add_filter( 'post_updated_messages', 'my_updated_training_video_messages' );

function my_updated_training_video_messages( $messages ) {
	global $post, $post_ID;
	$messages['training-video'] = array(
		0 => '', 
		1 => sprintf( __('Training Video updated. <a href="%s">View Training Video</a>'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Training Video updated.'),
		3 => __('Training Video deleted.'),
		4 => __('Training Video updated.'),
		5 => isset($_GET['revision']) ? sprintf( __('Training Video restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Training Video published. <a href="%s">View Training Video</a>'), esc_url( get_permalink($post_ID) ) ),
		7 => __('Training Video saved.'),
		8 => sprintf( __('Training Video submitted. <a target="_blank" href="%s">Preview Training Video</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Training Video scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Alert Email product</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Training Video draft updated. <a target="_blank" href="%s">Preview Training Video</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);

	return $messages;
}

add_action( 'contextual_help', 'training_video_contextual_help', 10, 3 );

function training_video_contextual_help( $contextual_help, $screen_id, $screen ) { 
	if ( 'training-video' == $screen->id ) {
		$contextual_help = '<h2>A Training Video</h2>
		<p>Alert Email show the details of the items that we sell on the website. You can see a list of them on this page in reverse chronological order - the latest one we added is first.</p> 
		<p>You can view/edit the details of each Training Video by clicking on its name, or you can perform bulk actions using the dropdown menu and selecting multiple items.</p>';
	} elseif ( 'training-video' == $screen->id ) {
		$contextual_help = '<h2>Editing Training Video</h2>
		<p>This page allows you to view/modify Training Video details. Please make sure to fill out the available boxes with the appropriate details (product image, price, brand) and <strong>not</strong> add these details to the Training Video description.</p>';
	}

	return $contextual_help;
}

add_filter( 'manage_edit-training-video_columns', 'training_video_columns' ) ;

function training_video_columns( $columns ) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Name' ),
		'date' => __( 'Date' ),
		'txtVideoTitle' => __('Video Title'),
		'txtCoarse' => __('Training Coarse'),
		'txtEmbedCode' => __( 'You Tube Embed Code' )
	);
	return $columns;
}

add_action( 'manage_training-video_posts_custom_column', 'manage_training_video_columns', 10, 2 );

function manage_training_video_columns($column, $post_id) {
	global $post;
	switch($column) {
		/* If displaying the 'txtVideoTitle' column. */
			case 'txtVideoTitle' :
			/* Get the post meta. */
			$txtVideoTitle = get_post_meta( $post_id, 'txtVideoTitle', true );
			/* If no duration is found, output a default message. */
			if (empty( $txtVideoTitle))
				echo __('Unknown');
			/* If there is a duration, append 'minutes' to the text string. */
			else
				printf( __('%s'), $txtVideoTitle);
			break;
		/* If displaying the 'txtCoarse' column. */
			case 'txtCoarse' :
			/* Get the post meta. */
			$txtCoarse = get_post_meta( $post_id, 'txtCoarse', true );
			/* If no duration is found, output a default message. */
			if (empty( $txtCoarse))
				echo __('Unknown');
			/* If there is a duration, append 'minutes' to the text string. */
			else
				printf( __('%s'), $txtCoarse);
			break;
		/* If displaying the 'txtEmbedCode' column. */
			case 'txtEmbedCode' :
			/* Get the post meta. */
			$txtEmbedCode = get_post_meta( $post_id, 'txtEmbedCode', true );
			/* If no duration is found, output a default message. */
			if (empty( $txtEmbedCode))
				echo __('Unknown');
			/* If there is a duration, append 'minutes' to the text string. */
			else
				printf(__('%s'),$txtEmbedCode);
			break;
		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}

add_filter('manage_edit-training-video_sortable_columns', 'training_video_sortable_columns');

function training_video_sortable_columns($columns) {
	$columns['txtVideoTitle'] = 'txtVideoTitle';
	$columns['txtCoarse'] = 'txtCoarse';
	$columns['txtEmbedCode'] = 'txtEmbedCode';
	return $columns;
}

/* Only run our customization on the 'edit.php' page in the admin. */
add_action( 'load-edit.php', 'training_video_load' );

function training_video_load() {
	add_filter( 'request', 'sort_training_video' );
}

/* Sorts the training activity. */
function sort_training_video( $vars ) {
	/* Check if we're viewing the 'training-video' post type. */
	if ( isset( $vars['post_type'] ) && 'training-video' == $vars['post_type'] ) {
		if ( isset( $vars['orderby'] ) && 'txtVideoTitle' == $vars['orderby'] ) {
			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'txtVideoTitle',
					'orderby' => 'meta_value'
				)
			);
		}else if ( isset( $vars['orderby'] ) && 'txtCoarse' == $vars['orderby'] ) {
			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'txtCoarse',
					'orderby' => 'meta_value'
				)
			);
		}else if ( isset( $vars['orderby'] ) && 'txtEmbedCode' == $vars['orderby'] ) {
			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'txtEmbedCode',
					'orderby' => 'meta_value'
				)
			);
		}
	}
	return $vars;
}

add_action( 'load-post.php', 'training_video_meta_boxes_setup' );
add_action( 'load-post-new.php', 'training_video_meta_boxes_setup' );

function training_video_meta_boxes_setup() {
	/* Add meta boxes on the 'add_meta_boxes' hook. */
	add_action( 'add_meta_boxes', 'training_video_add_post_meta_boxes' );
	add_action( 'save_post', 'training_video_save_all_post_class_meta', 10, 2 );
}

function training_video_add_post_meta_boxes() {
	add_meta_box(
		'edit-training_video',			// Unique ID
		esc_html__( 'training_video', 'example' ),		// Title
		'training_video_post_class_meta_box',			// Callback function
		'training-video',				// Admin page (or post type)
		'normal',					// Context
		'default'					// Priority
	);
}

function training_video_post_class_meta_box( $object, $box ) { 
	if($box['id'] == 'edit-training_video'){
		wp_nonce_field( basename( __FILE__ ), 'txtVideoTitle_nonce' ); 
		wp_nonce_field( basename( __FILE__ ), 'txtCoarse_nonce' ); 
		wp_nonce_field( basename( __FILE__ ), 'txtEmbedCode_nonce' ); 
?>

<div style="width: 30;">

	<p>Video Title:</br> <input type="text" name="txtVideoTitle" value="<?php echo esc_attr( get_post_meta( $object->ID, 'txtVideoTitle', true ) ); ?>"></p>
	<p>Coarse:</br> <input type="text" name="txtCoarse" value="<?php echo esc_attr( get_post_meta( $object->ID, 'txtCoarse', true ) ); ?>"></p>
	<p>YouTube Embed Code:</br> <textarea name="txtEmbedCode"><?php echo esc_attr( get_post_meta( $object->ID, 'txtEmbedCode', true ) ); ?></textarea></p>
</div>
<?php

	}
}

function training_video_save_all_post_class_meta( $post_id, $post ) {
	training_video_save_post_class_meta( $post_id, $post, 'txtVideoTitle' );
	training_video_save_post_class_meta( $post_id, $post, 'txtCoarse' );
	training_video_save_post_class_meta( $post_id, $post, 'txtEmbedCode' );
}

function training_video_save_post_class_meta( $post_id, $post, $column ) {
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

add_filter( 'post_class', 'training_video_post_class' );

function training_video_post_class( $classes ) {
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
add_action( 'restrict_manage_posts', 'training_video_file_filtering' );
function training_video_file_filtering(){
  	global $wpdb;
  	if ( $_GET['post_type'] == 'training-video' ) {
    		$fileNames = $wpdb->get_results( 'SELECT meta_value FROM wp_postmeta WHERE meta_key = "txtCoarse" GROUP BY meta_value', ARRAY_A ) ;
		$stop = count($fileNames);
?>
      		<label for="sortCoarse" class="screen-reader-text"><?php echo __( 'Show all Coarses', 'textdomain' ); ?></label>
    		<select id="sortCoarse" name="sortCoarse">
      			<option value=""><?php echo __( 'All Coarses', 'textdomain' ); ?></option>
<?php
    		foreach( $fileNames as $f ) {
      			$selected = ( !empty( $_GET['sortCoarse'] ) AND $_GET['sortCoarse'] == $f['meta_value'] ) ? 'selected="select"' : '';
?>
      			<option value="<?php echo $f['meta_value']; ?>" <?php echo $selected; ?>><?php echo $f['meta_value']; ?></option>
<?php
               }
?>	
		</select>
<?php
	}
}
add_filter( 'parse_query','training_video_file_filter' );
function training_video_file_filter($query){	
	if(!empty($_GET['sortCoarse'])){
		set_query_var( 'meta_query', array( array( 'key' => 'txtCoarse', 'value' => $_GET['sortCoarse']) ) );
		set_query_var( 'orderby','meta_value' );
	}
}
?>