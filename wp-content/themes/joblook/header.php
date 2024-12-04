<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Joblook
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<style>
		.user-profile .dropdown-content {
			display: none;
			position: absolute;
			background-color: #f9f9f9;
			min-width: 160px;
			box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
			z-index: 1;
			padding: 12px 16px;
			border-radius: 4px;
		}

		.user-profile .dropdown:hover .dropdown-content {
			display: block;
		}

		.user-profile .dropdown-content a {
			color: black;
			text-decoration: none;
			display: block;
		}

		.user-profile .dropdown-content a:hover {
			background-color: #f1f1f1;
		}

		/* Style cho avatar trong dropdown */
		.user-profile .rounded-circle {
			width: 40px;
			height: 40px;
			border-radius: 50%;
			object-fit: cover;
			border: 2px solid #ffffff;
			box-shadow: 0 0 5px rgba(0,0,0,0.1);
			transition: transform 0.3s ease;
		}

		.user-profile .rounded-circle:hover {
			transform: scale(1.1);
			box-shadow: 0 0 8px rgba(0,0,0,0.2);
		}

		.user-profile .user-name {
			display: inline-block;
			margin-left: 10px;
			color: #333;
			font-size: 14px;
			vertical-align: middle;
		}

		.user-profile .dropdown {
			display: flex;
			align-items: center;
		}
	</style>
	<?php wp_head(); ?>
</head>

<?php
$joblook_options = joblook_theme_options();
$fb_url = $joblook_options['fb_url'];
$insta_url = $joblook_options['insta_url']; 
$twitter_url = $joblook_options['twitter_url'];
$header_layout = $joblook_options['header_layout'];
$dark_header = $joblook_options['dark_header'];
$header_full_width = $joblook_options['header_full_width'];
?>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'joblook' ); ?></a>

	<?php if($header_layout=="header1"){ ?>

			<?php if($dark_header==1){ ?>
			<header id="masthead" class="site-header header1 dark-header">
			<?php } else { ?>
			<header id="masthead" class="site-header header1">
			<?php } ?>	

			<?php if($header_full_width){ ?>
			<div class="container-fluid">
			<?php } else{ ?>
			<div class="container"> 
			<?php } ?>
				<div class="row">
					<div class="col-md-12">
						<div class="site-logo">
							<?php
							the_custom_logo(); ?>

							<div class="site-title-wrap">

							<?php
							if ( is_front_page() && is_home() ) :
								?>
								<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
								<?php
							else :
								?>
								<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
								<?php
							endif;
							$joblook_description = get_bloginfo( 'description', 'display' );
							if ( $joblook_description || is_customize_preview() ) :
								?>
								<p class="site-description"><?php echo $joblook_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
							<?php endif; ?>

							</div>

						</div><!-- .site-logo -->


						<div id="hamburger-menu">
							<button class="open-menu">
							<span></span>
							<span></span>
							<span></span>
							</button>
						</div>

			
						<nav id="site-navigation" class="header-navigation">

							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'primary',
									'menu_id'        => 'primary-menu',
								)
							);
							?>

							<?php if(is_user_logged_in()): ?>
								<?php 
								$current_user = wp_get_current_user();
								$avatar = get_avatar($current_user->ID, 30, '', '', array('class' => 'rounded-circle'));
								?>
								<div class="user-profile">
									<div class="dropdown">
										<?php echo $avatar; ?>
										<span class="user-name"><?php echo esc_html($current_user->display_name); ?></span>
										<div class="dropdown-content">
											<a href="<?php echo wp_logout_url(home_url()); ?>">Đăng xuất</a>
										</div>
									</div>
								</div>
							<?php endif; ?>

							<?php
							    if ($fb_url || $twitter_url || $insta_url ): ?>
							    <div class="social-icons">
							        <?php if ($fb_url): ?>
							        <span><a target="_blank" href='<?php echo esc_url($fb_url) ?>'><i class="fa-brands fa-facebook"></i></a></span>
							        <?php endif;  ?>

							        <?php if ($insta_url): ?>
							        <span><a target="_blank" href='<?php echo esc_url($insta_url) ?>'><i class="fa-brands fa-instagram"></i></a></span>
							        <?php endif;  ?>


							         <?php if ($twitter_url): ?>
							        <span><a target="_blank" href='<?php echo esc_url($twitter_url) ?>'><i class="fa-brands fa-x-twitter"></i></a></span>
							        <?php endif;  ?>
							    </div>

							<?php endif;  ?>

							<button class="close-menu"><span class="sr-text"><?php echo esc_html__('Close Menu','joblook'); ?></span></button>


						</nav><!-- #site-navigation -->

						<?php
					    if ($fb_url || $twitter_url || $insta_url ): ?>
					    <div class="social-icons outside">
							        <?php if ($fb_url): ?>
							        <span><a target="_blank" href='<?php echo esc_url($fb_url) ?>'><i class="fa-brands fa-facebook"></i></a></span>
							        <?php endif;  ?>

							        <?php if ($insta_url): ?>
							        <span><a target="_blank" href='<?php echo esc_url($insta_url) ?>'><i class="fa-brands fa-instagram"></i></a></span>
							        <?php endif;  ?>


							         <?php if ($twitter_url): ?>
							        <span><a target="_blank" href='<?php echo esc_url($twitter_url) ?>'><i class="fa-brands fa-x-twitter"></i></a></span>
							        <?php endif;  ?>
					    </div>

						<?php endif;  ?>
					</div>
				</div>
			</div>
		</header><!-- #masthead -->

	<?php } elseif($header_layout=="header2"){ ?>

			<?php if($dark_header==1){ ?>
			<header id="masthead" class="site-header header2 dark-header">
			<?php } else { ?>
			<header id="masthead" class="site-header header2">
			<?php } ?>	

			<?php if($header_full_width){ ?>
			<div class="container-fluid">
			<?php } else{ ?>
			<div class="container">
			<?php } ?>
				<div class="row">
					<div class="col-md-12">
						<div class="site-logo">
							<?php
							the_custom_logo(); ?>

							<div class="site-title-wrap">

							<?php
							if ( is_front_page() && is_home() ) :
								?>
								<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
								<?php
							else :
								?>
								<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
								<?php
							endif;
							$joblook_description = get_bloginfo( 'description', 'display' );
							if ( $joblook_description || is_customize_preview() ) :
								?>
								<p class="site-description"><?php echo $joblook_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
							<?php endif; ?>

							</div>

						</div><!-- .site-logo -->


						<div id="hamburger-menu">
							<button class="open-menu">
							<span></span>
							<span></span>
							<span></span>
							</button>
						</div>

			
						<nav id="site-navigation" class="header-navigation">

							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'primary',
									'menu_id'        => 'primary-menu',
								)
							);
							?>

							<?php if(is_user_logged_in()): ?>
								<?php 
								$current_user = wp_get_current_user();
								$avatar = get_avatar($current_user->ID, 30, '', '', array('class' => 'rounded-circle'));
								?>
								<div class="user-profile">
									<div class="dropdown">
										<?php echo $avatar; ?>
										<span class="user-name"><?php echo esc_html($current_user->display_name); ?></span>
										<div class="dropdown-content">
											<a href="<?php echo wp_logout_url(home_url()); ?>">Đăng xuất</a>
										</div>
									</div>
								</div>
							<?php endif; ?>

							<?php
							    if ($fb_url || $twitter_url || $insta_url ): ?>
							    <div class="social-icons">
							        <?php if ($fb_url): ?>
							        <span><a target="_blank" href='<?php echo esc_url($fb_url) ?>'><i class="fa-brands fa-facebook"></i></a></span>
							        <?php endif;  ?>

							        <?php if ($insta_url): ?>
							        <span><a target="_blank" href='<?php echo esc_url($insta_url) ?>'><i class="fa-brands fa-instagram"></i></a></span>
							        <?php endif;  ?>


							         <?php if ($twitter_url): ?>
							        <span><a target="_blank" href='<?php echo esc_url($twitter_url) ?>'><i class="fa-brands fa-x-twitter"></i></a></span>
							        <?php endif;  ?>
							    </div>

							<?php endif;  ?>

							<button class="close-menu"><span class="sr-text"><?php echo esc_html__('Close Menu','joblook'); ?></span></button>


						</nav><!-- #site-navigation -->

						<?php
					    if ($fb_url || $twitter_url || $insta_url ): ?>
					    <div class="social-icons outside">
							        <?php if ($fb_url): ?>
							        <span><a target="_blank" href='<?php echo esc_url($fb_url) ?>'><i class="fa-brands fa-facebook"></i></a></span>
							        <?php endif;  ?>

							        <?php if ($insta_url): ?>
							        <span><a target="_blank" href='<?php echo esc_url($insta_url) ?>'><i class="fa-brands fa-instagram"></i></a></span>
							        <?php endif;  ?>


							         <?php if ($twitter_url): ?>
							        <span><a target="_blank" href='<?php echo esc_url($twitter_url) ?>'><i class="fa-brands fa-x-twitter"></i></a></span>
							        <?php endif;  ?>
					    </div>

						<?php endif;  ?>
					</div>
				</div>
			</div>
		</header><!-- #masthead -->


	<?php } elseif($header_layout=="header3"){ ?>

			<?php if($dark_header==1){ ?>
			<header id="masthead" class="site-header header3 dark-header">
			<?php } else { ?>
			<header id="masthead" class="site-header header3">
			<?php } ?>	

			<?php if($header_full_width){ ?>
			<div class="container-fluid">
			<?php } else{ ?>
			<div class="container">
			<?php } ?>
				<div class="row">
					<div class="col-md-12">
						<div class="top-header-wrap">
							<?php
						    if ($fb_url || $twitter_url || $insta_url ): ?>
						    <div class="social-icons">
							        <?php if ($fb_url): ?>
							        <span><a target="_blank" href='<?php echo esc_url($fb_url) ?>'><i class="fa-brands fa-facebook"></i></a></span>
							        <?php endif;  ?>

							        <?php if ($insta_url): ?>
							        <span><a target="_blank" href='<?php echo esc_url($insta_url) ?>'><i class="fa-brands fa-instagram"></i></a></span>
							        <?php endif;  ?>


							         <?php if ($twitter_url): ?>
							        <span><a target="_blank" href='<?php echo esc_url($twitter_url) ?>'><i class="fa-brands fa-x-twitter"></i></a></span>
							        <?php endif;  ?>
						    </div>

							<?php endif;  ?>

							<div class="site-logo">
								<?php
								the_custom_logo(); ?>

								<div class="site-title-wrap">

								<?php
								if ( is_front_page() && is_home() ) :
									?>
									<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
									<?php
								else :
									?>
									<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
									<?php
								endif;
								$joblook_description = get_bloginfo( 'description', 'display' );
								if ( $joblook_description || is_customize_preview() ) :
									?>
									<p class="site-description"><?php echo $joblook_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
								<?php endif; ?>

								</div>
							</div><!-- .site-logo -->

							<div class="header-search">
								<?php get_search_form(); ?>
							</div>

							<div id="hamburger-menu">
								<button class="open-menu">
								<span></span>
								<span></span>
								<span></span>
								</button>
							</div>
						</div>

						<div class="bottom-header-wrap">
							<nav id="site-navigation" class="header-navigation">

								<?php
								wp_nav_menu(
									array(
										'theme_location' => 'primary',
										'menu_id'        => 'primary-menu',
									)
								);
								?>

								<?php if(is_user_logged_in()): ?>
									<?php 
									$current_user = wp_get_current_user();
									$avatar = get_avatar($current_user->ID, 30, '', '', array('class' => 'rounded-circle'));
									?>
									<div class="user-profile">
										<div class="dropdown">
											<?php echo $avatar; ?>
											<span class="user-name"><?php echo esc_html($current_user->display_name); ?></span>
											<div class="dropdown-content">
												<a href="<?php echo wp_logout_url(home_url()); ?>">Đăng xuất</a>
											</div>
										</div>
									</div>
								<?php endif; ?>

								<?php
								    if ($fb_url || $twitter_url || $insta_url ): ?>
								    <div class="social-icons">
							        <?php if ($fb_url): ?>
							        <span><a target="_blank" href='<?php echo esc_url($fb_url) ?>'><i class="fa-brands fa-facebook"></i></a></span>
							        <?php endif;  ?>

							        <?php if ($insta_url): ?>
							        <span><a target="_blank" href='<?php echo esc_url($insta_url) ?>'><i class="fa-brands fa-instagram"></i></a></span>
							        <?php endif;  ?>


							         <?php if ($twitter_url): ?>
							        <span><a target="_blank" href='<?php echo esc_url($twitter_url) ?>'><i class="fa-brands fa-x-twitter"></i></a></span>
							        <?php endif;  ?>
								    </div>

								<?php endif;  ?>

								<button class="close-menu"><span class="sr-text"><?php echo esc_html__('Close Menu','joblook'); ?></span></button>


							</nav><!-- #site-navigation -->
						</div>


					</div>
				</div>
			</div>
		</header><!-- #masthead -->


	<?php } ?>
