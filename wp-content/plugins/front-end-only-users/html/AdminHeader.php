		<div class="wrap">
		<div class="Header"><h2><?php _e("Front End Only Users Settings", 'front-end-only-users') ?></h2></div>

		<?php if ($EWD_FEUP_Full_Version != "Yes" or get_option("EWD_FEUP_Trial_Happening") == "Yes") { ?>
			<?php $display_trial_banner = ( time() < 1575331200 and ( time() > 1574917200 or ( time() > 1574467200 and get_option('EWD_URP_Install_Time') < time() - 7*24*3600) ) ); ?>
			<div class="ewd-feup-dashboard-new-upgrade-banner">
				<div class="ewd-feup-dashboard-banner-icon"></div>
				<div class="ewd-feup-dashboard-banner-buttons">
					<a class="ewd-feup-dashboard-new-upgrade-button" href="http://www.etoilewebdesign.com/plugins/front-end-only-users/#plugin-sales-plans" target="_blank">UPGRADE NOW</a>
				</div>
				<div class="ewd-feup-dashboard-banner-text <?php echo ( $display_trial_banner ? 'ewd-feup-bf-banner' : '' ); ?>">
					<!-- Start Black Friday -->
					<?php if ( $display_trial_banner ) { ?>
					<div class="ewd-feup-dashboard-banner-black-friday-text">
						<div class="ewd-feup-dashboard-banner-black-friday-title">
							30% OFF PREMIUM FOR BLACK FRIDAY!
						</div>
						<div class="ewd-feup-dashboard-banner-black-friday-brief">
							Upgrade now to receive this great discount. No coupon code necessary. November 28th to December 2nd EST.
						</div>
						<div class="ewd-feup-dashboard-banner-black-friday-brief-mobile">
							November 28th to December 2nd EST.
						</div>
					</div>
					<?php } ?>
					<!-- End Black Friday -->
					<div class="ewd-feup-dashboard-banner-title">
						GET FULL ACCESS WITH OUR PREMIUM VERSION
					</div>
					<div class="ewd-feup-dashboard-banner-brief">
						Experience the user management and membership plugin that allows for front-end user registration and login
					</div>
				</div>
			</div>
		<?php } ?>