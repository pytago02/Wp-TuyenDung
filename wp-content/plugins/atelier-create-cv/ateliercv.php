<?php
/*
Plugin Name: Atelier Create CV
Plugin URI: https://atelierweb.pl/create_cv/plugins/atelier-cv/
Description: Atelier Create Cv is plugin to independent create cv.
Version: 1.1.2
Requires PHP: 7.0
Author: Mariusz Borkowski
Author URI: https://atelierweb.pl
License: GPLv2 or later
Text Domain: ateliercv
Domain Path: /lang/
*/

defined('ABSPATH') or die('No script kiddies please!');

/* Define */
define('ATL_CV_PLUGIN_URL', plugin_dir_url(__FILE__));
define('ATL_CV_PLUGIN_NAME', plugin_basename(__FILE__));

/* Composer autoload */
if(file(dirname(__FILE__) . '/vendor/autoload.php')):
	require_once dirname(__FILE__) . '/vendor/autoload.php';
endif;

/* Instance Init Class */
$init = new \ateliercv\Init();

function plugin_activation() {
	global $wpdb;

	$table_name = sanitize_text_field($wpdb->prefix . 'prof_ex');
	$table_name2 = sanitize_text_field($wpdb->prefix . 'school_ex');
	$table_name3 = sanitize_text_field($wpdb->prefix . 'lang_ex');
	$table_name4 = sanitize_text_field($wpdb->prefix . 'cert_ex');

	$sql = "CREATE TABLE $table_name (
	  `id` MEDIUMINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	  `user_id` int(9) NOT NULL,
	  `profession` varchar(255) NOT NULL,
	  `prof_city` varchar(255) NOT NULL,
	  `employer` varchar(255) NOT NULL,
	  `start_date` date NOT NULL,
	  `end_date` date NOT NULL,
	  `desc` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta( $sql );

	$sql2 = "CREATE TABLE $table_name2 (
	  `id` MEDIUMINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	  `user_id` int(9) NOT NULL,
	  `level` varchar(255) NOT NULL,
	  `school_city` varchar(255) NOT NULL,
	  `school_name` varchar(255) NOT NULL,
	  `start_date` date NOT NULL,
	  `end_date` date NOT NULL,
	  `desc` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";


	dbDelta( $sql2 );


	$sql3 = "CREATE TABLE $table_name3 (
	  `id` MEDIUMINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	  `user_id` int(9) NOT NULL,
	  `lang` varchar(255) NOT NULL,
	  `level` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";


	dbDelta( $sql3 );

	$sql4 = "CREATE TABLE $table_name4 (
	  `id` MEDIUMINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	  `user_id` int(9) NOT NULL,
	  `certificate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";


	dbDelta( $sql4 );

}

function plugin_deactivation() {

}



function plugin_activation_table() {

	addProfession();
	addSchool();
	addLang();
	addCurse();

}
register_activation_hook( __FILE__, 'plugin_activation' );
register_deactivation_hook( __FILE__, 'plugin_deactivation' );

add_action('init','plugin_activation_table');



/**
 * Delete expereience in Ajax
 */
function my_action() {
	global $wpdb;
	$id = intval( $_POST['id'] );
	$table_name = sanitize_text_field($_POST['table-name']);

	$sql = "DELETE FROM $table_name WHERE `id`=$id";

	$wpdb->query($sql);

	wp_die();
}
add_action( 'wp_ajax_my_action', 'my_action' );

function my_edu_action() {
	global $wpdb;
	$id = intval( $_POST['id'] );
	$table_name = sanitize_text_field($_POST['table-school']);

	$sql = "DELETE FROM $table_name WHERE `id`=$id";

	$wpdb->query($sql);

	wp_die();
}
add_action( 'wp_ajax_my_edu_action', 'my_edu_action' );

function my_lang_action() {
	global $wpdb;
	$id = intval( $_POST['id'] );
	$table_name = sanitize_text_field($_POST['table-lang']);

	$sql = "DELETE FROM $table_name WHERE `id`=$id";

	$wpdb->query($sql);

	wp_die();
}
add_action( 'wp_ajax_my_lang_action', 'my_lang_action' );

function my_curse_action() {
	global $wpdb;
	$id = intval( $_POST['id'] );
	$table_name = sanitize_text_field($_POST['table-curse']);

	$sql = "DELETE FROM $table_name WHERE `id`=$id";

	$wpdb->query($sql);

	wp_die();
}
add_action( 'wp_ajax_my_curse_action', 'my_curse_action' );


/**
 * Add Profession
 */
function addProfession() {
	global $wpdb;
	$user = wp_get_current_user();
	$id_user = $user->ID;

	if(isset($_POST['atl_cv_profession_name']) && isset($_POST['atl_cv_profession_city']) && isset($_POST['atl_cv_employer_name']) && isset($_POST['atl_cv_pr_start_date']) && isset($_POST['atl_cv_pr_end_date']) && isset($_POST['atl_cv_pr_desc'])) {

		// Add profession
		$profession = sanitize_text_field($_POST['atl_cv_profession_name']);
		$prof_city = sanitize_text_field($_POST['atl_cv_profession_city']);
		$employer = sanitize_text_field($_POST['atl_cv_employer_name']);
		$start_date = sanitize_text_field($_POST['atl_cv_pr_start_date']);
		$end_date = sanitize_text_field($_POST['atl_cv_pr_end_date']);
		$desc = sanitize_text_field($_POST['atl_cv_pr_desc']);

		$table_name = sanitize_text_field($wpdb->prefix . 'prof_ex');

		$wpdb->insert(
			$table_name,
			[
				'id'         => null,
				'user_id'    => $id_user,
				'profession' => $profession,
				'prof_city'  => $prof_city,
				'employer'   => $employer,
				'start_date' => $start_date,
				'end_date'   => $end_date,
				'desc'       => $desc
			]
		);
	}
}

/**
 * Add School
 */
function addSchool() {

	global $wpdb;
	$user = wp_get_current_user();
	$id_user = $user->ID;


	if ( !empty($_POST['atl_degree_level']) ||  !empty($_POST['atl_cv_qf_city']) || !empty($_POST['atl_cv_qf_school']) || !empty($_POST['qf_start_date']) || !empty($_POST['qf_end_date'])) {

		$level        = sanitize_text_field($_POST['atl_degree_level']);
		$school_city  = sanitize_text_field($_POST['atl_cv_qf_city']);
		$school_name  = sanitize_text_field($_POST['atl_cv_qf_school']);
		$school_start = sanitize_text_field($_POST['qf_start_date']);
		$school_end   = sanitize_text_field($_POST['qf_end_date']);
		$school_desc  = isset($_POST['qf_desc']) ? sanitize_text_field($_POST['qf_desc']) : '';

		$table_name2 = sanitize_text_field($wpdb->prefix . 'school_ex');

		$wpdb->insert(
			$table_name2,
			[
				'id'          => null,
				'user_id'     => $id_user,
				'level'       => $level,
				'school_city' => $school_city,
				'school_name' => $school_name,
				'start_date'  => $school_start,
				'end_date'    => $school_end,
				'desc'        => $school_desc
			]
		);

	}

}

/**
 * Add Lang
 */
function addLang() {

	global $wpdb;
	$user = wp_get_current_user();
	$id_user = $user->ID;

	if(!empty($_POST['atl_cv_qf_languages']) && !empty($_POST['atl_cv_qf_languages_lvl']))  {

		$lang = sanitize_text_field($_POST['atl_cv_qf_languages']);
		$lvl = sanitize_text_field($_POST['atl_cv_qf_languages_lvl']);

		$table_name3 = sanitize_text_field($wpdb->prefix . 'lang_ex');

		$wpdb->insert(
			$table_name3,
			[
				'id'         => null,
				'user_id'    => $id_user,
				'lang' => $lang,
				'level'  => $lvl

			]
		);
	}
}

/*
 * Add certificate
 */
function addCurse() {

	global $wpdb;
	$user = wp_get_current_user();
	$id_user = $user->ID;

	if(!empty($_POST['atl_cv_qf_curses'])) {

		$curse = sanitize_text_field($_POST['atl_cv_qf_curses']);
		$table_name4 = sanitize_text_field($wpdb->prefix . 'cert_ex');

		$wpdb->insert(
			$table_name4,
			[
				'id' => null,
				'user_id' => $id_user,
				'certificate' => $curse
			]
		);

	}


}


