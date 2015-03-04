<?php

/**

 * Plugin Name: PATR Training Plugin

 * Description: Custom code for PATR

 * Version: 1.0

 * Author: Jason Copping

 */
defined('ABSPATH') or die("No script kiddies please!");
date_default_timezone_set('America/New_York');
include 'PTARCustomPosts/TrackActivityPost.php';
include 'PTARCustomPosts/CommunityEventPost.php';
include 'PTARCustomPosts/trainingVideoPost.php';
include 'PTARCustomPosts/TestPost.php';
include 'PTARadmin/ptarAdmin.php';
include 'PTARemployee/ptarEmployee.php';
 ?>