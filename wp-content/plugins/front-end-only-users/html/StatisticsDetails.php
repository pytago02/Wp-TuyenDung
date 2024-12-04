<div class="OptionTab ActiveTab" id="Statistics_Details">
	<?php 
		$Event_Target_Title = urldecode( sanitize_text_field( $_GET['Event_Target_Title'] ) );

		$Current_Page = "admin.php?page=EWD-FEUP-options&Action=EWD_FEUP_Statistics_Details&Selected=Event&Event_Target_Title=" . $Event_Target_Title;
		$Users_Page = "admin.php?page=EWD-FEUP-options&Action=EWD_FEUP_User_Details&Selected=User";

		if ( isset( $_GET['OrderBy'] ) and in_array( $_GET['OrderBy'], array( 'Event_Location_Title', 'Event_Date' ) ) ) { $OrderBy = $_GET['OrderBy']; }
		else { $OrderBy = 'Event_Date'; }

		$Order = ( isset( $_GET['Order'] ) and $_GET['Order'] == 'DESC' ) ? 'DESC' : 'ASC';

		$Sql = "SELECT * FROM $ewd_feup_user_events_table_name WHERE Event_Target_Title=%s ";
		if (isset($_GET['Statistic_Type']) and $_GET['Statistic_Type'] == "Page_Loads") {$Sql .= "AND Event_Type='Page Load' ";}
		else {$Sql .= "AND Event_Type!='Page Load' ";}
		if (isset($_GET['OrderBy'])) {$Sql .= "ORDER BY " . $OrderBy . " " . $Order . " ";}
		else {$Sql .= "ORDER BY Event_Date DESC ";}
		$myrows = $wpdb->get_results($wpdb->prepare($Sql, $Event_Target_Title));
		if (isset($_GET['OrderBy'])) {$Current_Page_With_Order_By = $Current_Page . "&OrderBy=" . $OrderBy . "&Order=" . $Order;}
		else { $Current_Page_With_Order_By = $Current_Page; }
	?>
		
	<div class="OptionTab ActiveTab" id="EditProduct">
				<div class="tablenav top">
					<div class="alignleft actions">
						<p><?php echo __("Recent Clicks on", 'front-end-only-users') . " " . $Event_Target_Title; ?></p>
					</div>
				</div>
				
				<table class="wp-list-table striped widefat tags sorttable fields-list ui-sortable" cellspacing="0">
					<thead>
						<tr>
							<th scope='col' class='manage-column column-cb check-column'  style="">
								<span>Username of Clicker</span>
							</th>
							<th scope='col' class='manage-column column-cb check-column'  style="">
								<?php if ($_GET['OrderBy'] == "Event_Location_Title" and $_GET['Order'] == "ASC") {$Order = "DESC";}
									  else {$Order = "ASC";} ?>
								<a href="<?php echo $Current_Page; ?>&OrderBy=Event_Location_Title&Order=<?php echo $Order; ?>">
								<span>Event Location</span>
								<span class="sorting-indicator"></span>
							</th>
							<th scope='col' class='manage-column column-cb check-column'  style="">
								<?php if ($_GET['OrderBy'] == "Event_Date" and $_GET['Order'] == "ASC") {$Order = "DESC";}
									  else {$Order = "ASC";} ?>
								<a href="<?php echo $Current_Page; ?>&OrderBy=Event_Date&Order=<?php echo $Order; ?>">
								<span>Event Date</span>
								<span class="sorting-indicator"></span>
							</th>
						</tr>
					</thead>
				
					<tfoot>
						<tr>
							<th scope='col' class='manage-column column-cb check-column'  style="">
								<span>Username of Clicker</span>
							</th>
							<th scope='col' class='manage-column column-cb check-column'  style="">
								<?php if ($_GET['OrderBy'] == "Event_Location_Title" and $_GET['Order'] == "ASC") {$Order = "DESC";}
									  else {$Order = "ASC";} ?>
								<a href="<?php echo $Current_Page; ?>&OrderBy=Event_Location_Title&Order=<?php echo $Order; ?>">
								<span>Event Location</span>
								<span class="sorting-indicator"></span>
							</th>
							<th scope='col' class='manage-column column-cb check-column'  style="">
								<?php if ($_GET['OrderBy'] == "Event_Date" and $_GET['Order'] == "ASC") {$Order = "DESC";}
									  else {$Order = "ASC";} ?>
								<a href="<?php echo $Current_Page; ?>&OrderBy=Event_Date&Order=<?php echo $Order; ?>">
								<span>Event Date</span>
								<span class="sorting-indicator"></span>
							</th>
						</tr>
					</tfoot>
				
					<tbody id="the-list" class='list:tag'>
						
					<?php
						if ($myrows) { 
					  		foreach ($myrows as $Event) {
								$Username = $wpdb->get_var( $wpdb->prepare( "SELECT Username FROM $ewd_feup_user_table_name WHERE User_ID=%d", $Event->User_ID ) );
								echo "<tr id='Event-" . $Event->User_Event_ID ."'>";
								echo "<td class='name column-username'><a href='" . $Users_Page . "&User_ID=" . $Event->User_ID . "'>" .  $Username . "</a></td>";
								echo "<td class='name column-location'>" .  $Event->Event_Location_Title . "</td>";
								echo "<td class='name column-date'>" .  $Event->Event_Date . "</td>";
								echo "</tr>";
							}
						}
					?>
				
					</tbody>
				</table>
				
				<div class="tablenav bottom">
					<?php /*<div class="alignleft actions">
						<select name='action'>
				  			<option value='-1' selected='selected'><?php _e("Bulk Actions", 'front-end-only-users') ?></option>
							<option value='delete'><?php _e("Delete", 'front-end-only-users') ?></option>
						</select>
						<input type="submit" name="" id="doaction" class="button-secondary action" value="<?php _e('Apply', 'front-end-only-users') ?>"  />
					</div>*/ ?>
					<div class='tablenav-pages <?php if ($Number_of_Pages == 1) {echo "one-page";} ?>'>
						<span class="displaying-num"><?php echo $EventCount; ?> <?php _e("events", 'front-end-only-users') ?></span>
						<span class='pagination-links'>
							<a class='first-page <?php if ($Page == 1) {echo "disabled";} ?>' title='Go to the first page' href='<?php echo esc_attr( $Current_Page_With_Order_By ); ?>&Page=1'>&laquo;</a>
							<a class='prev-page <?php if ($Page <= 1) {echo "disabled";} ?>' title='Go to the previous page' href='<?php echo esc_attr( $Current_Page_With_Order_By ); ?>&Page=<?php echo $Page-1;?>'>&lsaquo;</a>
							<span class="paging-input"><?php echo $Page; ?> <?php _e("of", 'front-end-only-users') ?> <span class='total-pages'><?php echo $Number_of_Pages; ?></span></span>
							<a class='next-page <?php if ($Page >= $Number_of_Pages) {echo "disabled";} ?>' title='Go to the next page' href='<?php echo esc_attr( $Current_Page_With_Order_By ); ?>&Page=<?php echo $Page+1;?>'>&rsaquo;</a>
							<a class='last-page <?php if ($Page == $Number_of_Pages) {echo "disabled";} ?>' title='Go to the last page' href='<?php echo esc_attr( $Current_Page_With_Order_By ) . "&Page=" . $Number_of_Pages; ?>'>&raquo;</a>
						</span>
					</div>
					<br class="clear" />
				</div>

</div>	