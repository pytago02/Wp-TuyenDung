<?php 

function ewd_feup_add_custom_meta_box()
{
	add_meta_box("ewd-feup-meta-box", __("Front-End Users",'front-end-only-users'), "ewd_feup_meta_box_markup", array("page", "post"), "side", "high", null);
}
if ($EWD_FEUP_Full_Version == "Yes") {add_action("add_meta_boxes", "ewd_feup_add_custom_meta_box");}

//As of Nov/2015, there doesn't seem to be a way to implement this
function ewd_feup_add_attachments_meta_box()
{
	add_meta_box("ewd-feup-meta-box", __("Front-End Users",'front-end-only-users'), "ewd_feup_meta_box_markup", "attachment", "side", "high", null);
}
//if ($EWD_FEUP_Full_Version == "Yes") {add_action("add_meta_boxes", "ewd_feup_add_attachments_meta_box");}

function ewd_feup_meta_box_markup($object)
{
	global $wpdb, $ewd_feup_levels_table_name;

	$FEUP_Levels = $wpdb->get_results("SELECT * FROM $ewd_feup_levels_table_name");

	wp_nonce_field(basename(__FILE__), "meta-box-nonce");

	$option_values = array("minimum_level" => "At Least", "level" => "Equals", "maximum_level" => "At Most");

	echo  "<div class='ewd-feup-mb'>";
		echo "<p class='ewd-feup-mb-row'>";
		echo "<label for='ewd-feup-level-type-dropdown' class='ewd-feup-mb-label'>FEUP Level</label> ";
		echo "<select name='ewd-feup-level-type-dropdown' class='ewd-feup-mb-select'>";

			foreach($option_values as $key => $value) {
				if ($key == get_post_meta($object->ID, "ewd-feup-level-type-dropdown", true)) {
					echo "<option value='" . $key . "' selected>" . $value . "</option>";
				}
				else {
					echo "<option value='" . $key . "'>" . $value . "</option>";
			    }
			}
		echo "</select>";
		echo "</p>";
		echo "<p class='ewd-feup-mb-row'>";
		echo "<label for='ewd-feup-level-dropdown' class='ewd-feup-mb-label'></label> ";
		echo "<select name='ewd-feup-level-dropdown'>";
			echo "<option value='0'>Not Registered</option>";
			foreach($FEUP_Levels as $Level) {
				if ($Level->Level_Privilege == get_post_meta($object->ID, "ewd-feup-level-dropdown", true)) {
					echo "<option value='" . $Level->Level_Privilege . "' selected>" . $Level->Level_Name . "</option>";
				}
				else {
					echo "<option value='" . $Level->Level_Privilege . "'>" . $Level->Level_Name . "</option>";
			    }
			}
		echo "</select>";
		echo "</p>";
	echo "</div>";
}


function ewd_feup_save_custom_meta_box($post_id, $post="", $update="")
{
	if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__))) {return $post_id;}
 
	if(!current_user_can("edit_post", $post_id)) {return $post_id;}
 
	if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE) {return $post_id;}
 
	$ewd_feup_level_type_dropdown_value = "";
	$ewd_feup_level_dropdown_value = "";
 
 
	if ( isset( $_POST["ewd-feup-level-type-dropdown"] ) ) {
		$ewd_feup_level_type_dropdown_value = sanitize_text_field( $_POST["ewd-feup-level-type-dropdown"] );
	}
	update_post_meta($post_id, "ewd-feup-level-type-dropdown", $ewd_feup_level_type_dropdown_value);

	if(isset($_POST["ewd-feup-level-dropdown"])) {
		$ewd_feup_level_dropdown_value = sanitize_text_field( $_POST["ewd-feup-level-dropdown"] );
	}
	update_post_meta($post_id, "ewd-feup-level-dropdown", $ewd_feup_level_dropdown_value);
}
add_action("save_post", "ewd_feup_save_custom_meta_box", 10, 3);
add_action("edit_attachment", "ewd_feup_save_custom_meta_box", 10, 1);

function EWD_FEUP_Filter_Page_Content($content) {
	$ID = get_the_ID();

	$feup_Label_Restrict_Access_Message =  get_option("EWD_FEUP_Label_Restrict_Access_Message");
	if ($feup_Label_Restrict_Access_Message == "") {$feup_Label_Restrict_Access_Message =  __('Please log in to access this content.', 'front-end-only-users');}

	$Delete_Content = EWD_FEUP_Test_Full_Page_Restriction($ID);

	if ($Delete_Content == "Yes") {$content = $feup_Label_Restrict_Access_Message;}

	return $content;
}

function EWD_FEUP_Test_Full_Page_Restriction($ID) {
	global $wpdb, $ewd_feup_user_table_name, $ewd_feup_levels_table_name;

	$FEUP_Level_Type = get_post_meta($ID, "ewd-feup-level-type-dropdown", true);
	$FEUP_Level = get_post_meta($ID, "ewd-feup-level-dropdown", true);
	
	$Delete_Content = "No";
	if ($FEUP_Level > 0) {
		$Delete_Content = "Yes";

		$User = new FEUP_User;
		if ($User->Is_Logged_In()) {
			$Level_ID = $wpdb->get_var( $wpdb->prepare( "SELECT Level_ID FROM $ewd_feup_user_table_name WHERE User_ID=%d", $User->Get_User_ID() ) );
			$Level = $wpdb->get_var( $wpdb->prepare( "SELECT Level_Privilege FROM $ewd_feup_levels_table_name WHERE Level_ID=%d", $Level_ID ) );

			if ($FEUP_Level_Type == "minimum_level") {
				if ($Level >= $FEUP_Level) {;$Delete_Content = "No";}
			}
			elseif ($FEUP_Level_Type == "level") {
				if ($Level == $FEUP_Level) {$Delete_Content = "No";}
			}
			elseif ($FEUP_Level_Type == "maximum_level") {
				if ($Level <= $FEUP_Level) {$Delete_Content = "No";}
			}
		}
	}

	return $Delete_Content;
}
add_filter('the_content', 'EWD_FEUP_Filter_Page_Content');

?>