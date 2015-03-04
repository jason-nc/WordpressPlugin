<?php

add_action( 'init', 'createTestQuestion' );

function createTestQuestion() {
	$labels = array(
		'name'               => _x( 'Test Question', 'post type general name' ),
		'singular_name'      => _x( 'Test Question', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'test-question' ),
		'add_new_item'       => __( 'Add New Test Question' ),
		'edit_item'          => __( 'Edit Test Question' ),
		'new_item'           => __( 'New Test Question' ),
		'all_items'          => __( 'All Test Question' ),
		'view_item'          => __( 'View Test Question' ),
		'search_items'       => __( 'Search Test Question' ),
		'not_found'          => __( 'No Test Question found' ),
		'not_found_in_trash' => __( 'No Test Question found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Test Question'
	);

	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our Test Question and Test Question specific data',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title' ),
		'has_archive'   => true,
	);

	register_post_type( 'test-question', $args );
}


add_filter( 'post_updated_messages', 'my_updated_test_question_messages' );

function my_updated_test_question_messages( $messages ) {
	global $post, $post_ID;
	$messages['test-question'] = array(
		0 => '', 
		1 => sprintf( __('Test Question updated. <a href="%s">View Test Question</a>'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Test Question updated.'),
		3 => __('Test Question deleted.'),
		4 => __('Test Question updated.'),
		5 => isset($_GET['revision']) ? sprintf( __('Test Question restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Test Question published. <a href="%s">View Test Question</a>'), esc_url( get_permalink($post_ID) ) ),
		7 => __('Test Question saved.'),
		8 => sprintf( __('Test Question submitted. <a target="_blank" href="%s">Preview Test Question</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Test Question scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Alert Email product</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Test Question draft updated. <a target="_blank" href="%s">Preview Test Question</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);

	return $messages;
}

add_action( 'contextual_help', 'test_question_contextual_help', 10, 3 );

function test_question_contextual_help( $contextual_help, $screen_id, $screen ) { 
	if ( 'test-question' == $screen->id ) {
		$contextual_help = '<h2>A Test Question</h2>
		<p>Alert Email show the details of the items that we sell on the website. You can see a list of them on this page in reverse chronological order - the latest one we added is first.</p> 
		<p>You can view/edit the details of each Test Question by clicking on its name, or you can perform bulk actions using the dropdown menu and selecting multiple items.</p>';
	} elseif ( 'test-question' == $screen->id ) {
		$contextual_help = '<h2>Editing Test Question</h2>
		<p>This page allows you to view/modify Test Question details. Please make sure to fill out the available boxes with the appropriate details (product image, price, brand) and <strong>not</strong> add these details to the Test Question description.</p>';
	}

	return $contextual_help;
}

add_filter( 'manage_edit-test-question_columns', 'test_question_columns' ) ;

function test_question_columns( $columns ) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Name' ),
		'date' => __( 'Date' ),
		'intQuestionNumber' => __('Question Number'),
		'txtQuestion' => __('Question'),
		'txtOptionA' => __( 'Optoin A' ),
		'txtOptionB' => __( 'Optoin B' ),
		'txtOptionC' => __( 'Optoin C' ),
		'txtOptionD' => __( 'Optoin D' ),
		'txtOptionE' => __( 'Optoin E' ),
		'txtOptionF' => __( 'Optoin F' ),
		'txtOptionG' => __( 'Optoin G' ),
		'txtAnswer' => __('Answer')
	);
	return $columns;
}

add_action( 'manage_test-question_posts_custom_column', 'manage_test_question_columns', 10, 2 );

function manage_test_question_columns($column, $post_id) {
	global $post;
	switch($column) {
		/* If displaying the 'intQuestionNumber' column. */
			case 'intQuestionNumber' :
			/* Get the post meta. */
			$intQuestionNumber = get_post_meta( $post_id, 'intQuestionNumber', true );
			/* If no duration is found, output a default message. */
			if (empty( $intQuestionNumber))
				echo __('Unknown');
			/* If there is a duration, append 'minutes' to the text string. */
			else
				printf( __('%s'), $intQuestionNumber);
			break;
		/* If displaying the 'txtQuestion' column. */
			case 'txtQuestion' :
			/* Get the post meta. */
			$txtQuestion = get_post_meta( $post_id, 'txtQuestion', true );
			/* If no duration is found, output a default message. */
			if (empty( $txtQuestion))
				echo __('Unknown');
			/* If there is a duration, append 'minutes' to the text string. */
			else
				printf( __('%s'), $txtQuestion);
			break;
		/* If displaying the 'txtOptionA' column. */
			case 'txtOptionA' :
			/* Get the post meta. */
			$txtOptionA = get_post_meta( $post_id, 'txtOptionA', true );
			/* If no duration is found, output a default message. */
			if (empty( $txtOptionA))
				echo __('Unknown');
			/* If there is a duration, append 'minutes' to the text string. */
			else
				printf(__('%s'),$txtOptionA);
			break;
		/* If displaying the 'txtOptionB' column. */
			case 'txtOptionB' :
			/* Get the post meta. */
			$txtOptionB = get_post_meta( $post_id, 'txtOptionB', true );
			/* If no duration is found, output a default message. */
			if(empty($txtOptionB))
				echo __('Unknown');
			/* If there is a duration, append 'minutes' to the text string. */
			else
				printf(__('%s'), $txtOptionB);
			break;
		/* If displaying the 'txtOptionC' column. */
			case 'txtOptionC' :
			/* Get the post meta. */
			$txtOptionC = get_post_meta( $post_id, 'txtOptionC', true );
			/* If no duration is found, output a default message. */
			if(empty($txtOptionC))
				echo __('Unknown');
			/* If there is a duration, append 'minutes' to the text string. */
			else
				printf(__('%s'), $txtOptionC);
			break;
		/* If displaying the 'txtOptionD' column. */
			case 'txtOptionD' :
			/* Get the post meta. */
			$txtOptionD = get_post_meta( $post_id, 'txtOptionD', true );
			/* If no duration is found, output a default message. */
			if(empty($txtOptionD))
				echo __('Unknown');
			/* If there is a duration, append 'minutes' to the text string. */
			else
				printf(__('%s'), $txtOptionD);
			break;
		/* If displaying the 'txtOptionE' column. */
			case 'txtOptionE' :
			/* Get the post meta. */
			$txtOptionD = get_post_meta( $post_id, 'txtOptionE', true );
			/* If no duration is found, output a default message. */
			if(empty($txtOptionE))
				echo __('Unknown');
			/* If there is a duration, append 'minutes' to the text string. */
			else
				printf(__('%s'), $txtOptionE);
			break;
		/* If displaying the 'txtOptionF' column. */
			case 'txtOptionF' :
			/* Get the post meta. */
			$txtOptionD = get_post_meta( $post_id, 'txtOptionF', true );
			/* If no duration is found, output a default message. */
			if(empty($txtOptionF))
				echo __('Unknown');
			/* If there is a duration, append 'minutes' to the text string. */
			else
				printf(__('%s'), $txtOptionF);
			break;
		/* If displaying the 'txtAnswer' column. */
			case 'txtAnswer' :
			/* Get the post meta. */
			$txtAnswer = get_post_meta( $post_id, 'txtAnswer', true );
			/* If no duration is found, output a default message. */
			if(empty($txtAnswer))
				echo __('Unknown');
			/* If there is a duration, append 'minutes' to the text string. */
			else
				printf(__('%s'), $txtAnswer);
			break;
		/* If displaying the 'txtOptionG' column. */
			case 'txtOptionG' :
			/* Get the post meta. */
			$txtOptionD = get_post_meta( $post_id, 'txtOptionG', true );
			/* If no duration is found, output a default message. */
			if(empty($txtOptionG))
				echo __('Unknown');
			/* If there is a duration, append 'minutes' to the text string. */
			else
				printf(__('%s'), $txtOptionG);
			break;
		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}

add_filter('manage_edit-test-question_sortable_columns', 'test_question_sortable_columns');

function test_question_sortable_columns($columns) {
	$columns['intQuestionNumber'] = 'intQuestionNumber';
	$columns['txtQuestion'] = 'txtQuestion';
	$columns['txtOptionA'] = 'txtOptionA';
	$columns['txtOptionB'] = 'txtOptionB';
	$columns['txtOptionC'] = 'txtOptionC';
	$columns['txtOptionD'] = 'txtOptionD';
	$columns['txtOptionE'] = 'txtOptionE';
	$columns['txtOptionF'] = 'txtOptionF';
	$columns['txtOptionG'] = 'txtOptionG';
	$columns['txtAnswer'] = 'txtAnswer';
	return $columns;
}

/* Only run our customization on the 'edit.php' page in the admin. */
add_action( 'load-edit.php', 'test_question_load' );

function test_question_load() {
	add_filter( 'request', 'sort_test_question' );
}

/* Sorts the test question. */
function sort_test_question( $vars ) {
	/* Check if we're viewing the 'test-question' post type. */
	if ( isset( $vars['post_type'] ) && 'test-question' == $vars['post_type'] ) {
		if ( isset( $vars['orderby'] ) && 'intQuestionNumber' == $vars['orderby'] ) {
			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'intQuestionNumber',
					'orderby' => 'meta_value'
				)
			);
		}else if ( isset( $vars['orderby'] ) && 'txtQuestion' == $vars['orderby'] ) {
			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'txtQuestion',
					'orderby' => 'meta_value'
				)
			);
		}else if ( isset( $vars['orderby'] ) && 'txtOptionA' == $vars['orderby'] ) {
			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'txtOptionA',
					'orderby' => 'meta_value'
				)
			);
		}else if ( isset( $vars['orderby'] ) && 'txtOptionB' == $vars['orderby'] ) {
			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'txtOptionB',
					'orderby' => 'meta_value'
				)
			);
		}else if ( isset( $vars['orderby'] ) && 'txtOptionC' == $vars['orderby'] ) {
			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'txtOptionC',
					'orderby' => 'meta_value'
				)
			);
		}else if ( isset( $vars['orderby'] ) && 'txtOptionD' == $vars['orderby'] ) {
			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'txtOptionD',
					'orderby' => 'meta_value'
				)
			);
		}else if ( isset( $vars['orderby'] ) && 'txtOptionE' == $vars['orderby'] ) {
			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'txtOptionE',
					'orderby' => 'meta_value'
				)
			);
		}else if ( isset( $vars['orderby'] ) && 'txtOptionF' == $vars['orderby'] ) {
			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'txtOptionF',
					'orderby' => 'meta_value'
				)
			);
		}else if ( isset( $vars['orderby'] ) && 'txtOptionG' == $vars['orderby'] ) {
			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'txtOptionG',
					'orderby' => 'meta_value'
				)
			);
		}else if ( isset( $vars['orderby'] ) && 'txtAnswer' == $vars['orderby'] ) {
			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'txtAnswer',
					'orderby' => 'meta_value'
				)
			);
		}
	}
	return $vars;
}

add_action( 'load-post.php', 'test_question_meta_boxes_setup' );
add_action( 'load-post-new.php', 'test_question_meta_boxes_setup' );

function test_question_meta_boxes_setup() {
	/* Add meta boxes on the 'add_meta_boxes' hook. */
	add_action( 'add_meta_boxes', 'test_question_add_post_meta_boxes' );
	add_action( 'save_post', 'test_question_save_all_post_class_meta', 10, 2 );
}

function test_question_add_post_meta_boxes() {
	add_meta_box(
		'edit-test_question',			// Unique ID
		esc_html__( 'test_question', 'example' ),		// Title
		'test_question_post_class_meta_box',			// Callback function
		'test-question',				// Admin page (or post type)
		'normal',					// Context
		'default'					// Priority
	);
}

function test_question_post_class_meta_box( $object, $box ) { 
	if($box['id'] == 'edit-test_question'){
		wp_nonce_field( basename( __FILE__ ), 'intQuestionNumber_nonce' ); 
		wp_nonce_field( basename( __FILE__ ), 'txtQuestion_nonce' ); 
		wp_nonce_field( basename( __FILE__ ), 'txtOptionA_nonce' ); 
		wp_nonce_field( basename( __FILE__ ), 'txtOptionB_nonce' ); 
		wp_nonce_field( basename( __FILE__ ), 'txtOptionC_nonce' ); 
		wp_nonce_field( basename( __FILE__ ), 'txtOptionD_nonce' ); 
		wp_nonce_field( basename( __FILE__ ), 'txtOptionE_nonce' ); 
		wp_nonce_field( basename( __FILE__ ), 'txtOptionF_nonce' ); 
		wp_nonce_field( basename( __FILE__ ), 'txtOptionG_nonce' ); 
		wp_nonce_field( basename( __FILE__ ), 'txtAnswer_nonce' ); 
?>

<div style="width: 30;">
	<p>Question Number:</br> <input type="text" name="intQuestionNumber" value="<?php echo esc_attr( get_post_meta( $object->ID, 'intQuestionNumber', true ) ); ?>"></p>
	<p>Question:</br> <textarea name="txtQuestion"><?php echo esc_attr( get_post_meta( $object->ID, 'txtQuestion', true ) ); ?></textarea></p>
	<p>Option A:</br> <textarea name="txtOptionA"><?php echo esc_attr( get_post_meta( $object->ID, 'txtOptionA', true ) ); ?></textarea></p>
	<p>Option B:</br> <textarea name="txtOptionB"><?php echo esc_attr( get_post_meta( $object->ID, 'txtOptionB', true ) ); ?></textarea></p>
	<p>Option C:</br> <textarea name="txtOptionC"><?php echo esc_attr( get_post_meta( $object->ID, 'txtOptionC', true ) ); ?></textarea></p>
	<p>Option D:</br> <textarea name="txtOptionD"><?php echo esc_attr( get_post_meta( $object->ID, 'txtOptionD', true ) ); ?></textarea></p>
	<p>Option E:</br> <textarea name="txtOptionE"><?php echo esc_attr( get_post_meta( $object->ID, 'txtOptionE', true ) ); ?></textarea></p>
	<p>Option F:</br> <textarea name="txtOptionF"><?php echo esc_attr( get_post_meta( $object->ID, 'txtOptionF', true ) ); ?></textarea></p>
	<p>Option G:</br> <textarea name="txtOptionG"><?php echo esc_attr( get_post_meta( $object->ID, 'txtOptionG', true ) ); ?></textarea></p>
	<p>Answer (use option letter):</br> <input type="text" name="txtAnswer" value="<?php echo esc_attr( get_post_meta( $object->ID, 'txtAnswer', true ) ); ?>"></p>
</div>
<?php

	}
}

function test_question_save_all_post_class_meta( $post_id, $post ) {
	test_question_save_post_class_meta( $post_id, $post, 'intQuestionNumber' );
	test_question_save_post_class_meta( $post_id, $post, 'txtQuestion' );
	test_question_save_post_class_meta( $post_id, $post, 'txtOptionA' );
	test_question_save_post_class_meta( $post_id, $post, 'txtOptionB' );
	test_question_save_post_class_meta( $post_id, $post, 'txtOptionC' );
	test_question_save_post_class_meta( $post_id, $post, 'txtOptionD' );
	test_question_save_post_class_meta( $post_id, $post, 'txtOptionE' );
	test_question_save_post_class_meta( $post_id, $post, 'txtOptionF' );
	test_question_save_post_class_meta( $post_id, $post, 'txtOptionG' );
	test_question_save_post_class_meta( $post_id, $post, 'txtAnswer' );
}

function test_question_save_post_class_meta( $post_id, $post, $column ) {
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

add_filter( 'post_class', 'test_question_post_class' );

function test_question_post_class( $classes ) {
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
?>