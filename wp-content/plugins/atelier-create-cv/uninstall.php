<?php
if(!defined('WP_UNINSTALL_PLUGIN')) exit;

/**
 * Drop Table
 */
function dropTable() {
	global $wpdb;

	$table_name = $wpdb->prefix . 'prof_ex';
	$table_name2 = $wpdb->prefix . 'school_ex';
	$table_name3 = $wpdb->prefix . 'lang_ex';
	$table_name4 = $wpdb->prefix . 'cert_ex';


	$sql = "DROP TABLE $table_name";
	$sql2 = "DROP TABLE $table_name2";
	$sql3 = "DROP TABLE $table_name3";
	$sql4 = "DROP TABLE $table_name4";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	$wpdb->query($sql);
	$wpdb->query($sql2);
	$wpdb->query($sql3);
	$wpdb->query($sql4);
}

function removeSettings() {

	// Personal Data
	delete_option('atl_cv_first_name');
	delete_option('sidebar_bg_color');
	delete_option('atl_cv_font_color');
	delete_option('atl_cv_square_img');
	delete_option('atl_cv_surname');
	delete_option('atl_cv_email');
	delete_option('atl_cv_telephone');
	delete_option('atl_cv_person_image');
	delete_option('atl_cv_address');
	delete_option('atl_cv_address_code');
	delete_option('atl_cv_city');
	delete_option('atl_cv_date_birth');
	delete_option('atl_cv_place_birth');
	delete_option('atl_cv_driving_license');
	delete_option('atl_cv_gender');
	delete_option('atl_cv_nationality');
	delete_option('atl_cv_condition');
	delete_option('atl_cv_linkedin');
	delete_option('atl_cv_repo');
	delete_option('atl_cv_website');

	// Skill
	delete_option('atl_cv_qf_skills');
	delete_option('atl_cv_qf_hobby');
	delete_option('qf_privacy_policy');
}

dropTable();
removeSettings();




