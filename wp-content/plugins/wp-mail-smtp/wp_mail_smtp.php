<?php
/**
 * Plugin Name: WP Mail SMTP
 * Version: 4.2.0
 * Requires at least: 5.5
 * Requires PHP: 7.2
 * Plugin URI: https://wpmailsmtp.com/
 * Description: Cấu hình lại hàm <code>wp_mail()</code> để sử dụng Gmail/Mailgun/SendGrid/SMTP thay vì <code>mail()</code> mặc định và tạo trang tùy chọn để quản lý cài đặt.
 * Author: WP Mail SMTP
 * Author URI: https://wpmailsmtp.com/
 * Network: false
 * Text Domain: wp-mail-smtp
 * Domain Path: /assets/languages
 */

/**
 * @author    WPForms
 * @copyright WPForms, 2007-23, All Rights Reserved
 * Mã này được phát hành theo giấy phép GPL phiên bản 3 trở lên, có sẵn tại đây
 * https://www.gnu.org/licenses/gpl.txt
 */

/**
 * Thiết lập tùy chọn trong wp-config.php
 *
 * Đặc biệt hướng đến người dùng WP Multisite, bạn có thể đặt các tùy chọn cho plugin này dưới dạng
 * hằng số trong wp-config.php. Sao chép mã bên dưới vào wp-config.php và điều chỉnh cài đặt.
 * Giá trị từ các hằng số KHÔNG bị stripslash().
 *
 * Khi được bật, hãy đảm bảo comment (ở đầu dòng bằng //) những hằng số bạn không cần,
 * hoặc xóa chúng hoàn toàn để chúng không can thiệp vào cài đặt plugin.
 */

/*
define( 'WPMS_ON', true ); // True bật hỗ trợ và sử dụng hằng số, false tắt nó.

define( 'WPMS_DO_NOT_SEND', true ); // Hoặc false, trong trường hợp đó hằng số bị bỏ qua.

define( 'WPMS_MAIL_FROM', 'mail@example.com' );
define( 'WPMS_MAIL_FROM_FORCE', true ); // True bật, false tắt.
define( 'WPMS_MAIL_FROM_NAME', 'From Name' );
define( 'WPMS_MAIL_FROM_NAME_FORCE', true ); // True bật, false tắt.
define( 'WPMS_MAILER', 'sendinblue' ); // Giá trị có thể: 'mail', 'smtpcom', 'sendinblue', 'mailgun', 'sendgrid', 'gmail', 'smtp'.
define( 'WPMS_SET_RETURN_PATH', true ); // Đặt $phpmailer->Sender nếu true, chỉ liên quan đến Other SMTP mailer.

// Các mailer được đề xuất.
define( 'WPMS_SMTPCOM_API_KEY', '' );
define( 'WPMS_SMTPCOM_CHANNEL', '' );
define( 'WPMS_SENDINBLUE_API_KEY', '' );
define( 'WPMS_SENDINBLUE_DOMAIN', '' );

define( 'WPMS_ZOHO_DOMAIN', '' );
define( 'WPMS_ZOHO_CLIENT_ID', '' );
define( 'WPMS_ZOHO_CLIENT_SECRET', '' );

define( 'WPMS_PEPIPOST_API_KEY', '' );

define( 'WPMS_SENDINBLUE_API_KEY', '' );

define( 'WPMS_MAILGUN_API_KEY', '' );
define( 'WPMS_MAILGUN_DOMAIN', '' );
define( 'WPMS_MAILGUN_REGION', 'US' ); // hoặc 'EU' cho Châu Âu.

define( 'WPMS_SENDGRID_API_KEY', '' );

define( 'WPMS_GMAIL_CLIENT_ID', '' );
define( 'WPMS_GMAIL_CLIENT_SECRET', '' );

define( 'WPMS_SMTP_HOST', 'localhost' ); // Máy chủ SMTP.
define( 'WPMS_SMTP_PORT', 25 ); // Số cổng máy chủ SMTP.
define( 'WPMS_SSL', '' ); // Giá trị có thể '', 'ssl', 'tls' - lưu ý TLS không phải là STARTTLS.
define( 'WPMS_SMTP_AUTH', true ); // True bật, false tắt.
define( 'WPMS_SMTP_USER', 'username' ); // Tên người dùng xác thực SMTP, chỉ được sử dụng nếu WPMS_SMTP_AUTH là true.
define( 'WPMS_SMTP_PASS', 'password' ); // Mật khẩu xác thực SMTP, chỉ được sử dụng nếu WPMS_SMTP_AUTH là true.
define( 'WPMS_SMTP_AUTOTLS', true ); // True bật, false tắt.
*/

/**
 * Không cho phép nhiều phiên bản 1.5.x (Lite và Pro) trở lên hoạt động.
 *
 * @since 1.5.0
 */
if ( function_exists( 'wp_mail_smtp' ) ) {

	if ( ! function_exists( 'wp_mail_smtp_deactivate' ) ) {
		/**
		 * Hủy kích hoạt nếu plugin đã được kích hoạt.
		 * Cần thiết khi chuyển từ 1.5+ Lite sang Pro.
		 *
		 * @since 1.5.0
		 */
		function wp_mail_smtp_deactivate() {
			/*
			 * Ngăn chặn các vấn đề về các hàm WP không có sẵn cho các plugin khác kết nối vào
			 * việc hủy kích hoạt sớm này. Vấn đề GH #861.
			 */
			require_once ABSPATH . WPINC . '/pluggable.php';

			deactivate_plugins( plugin_basename( __FILE__ ) );
		}
	}
	add_action( 'admin_init', 'wp_mail_smtp_deactivate' );

	// Không xử lý mã plugin tiếp.
	return;
}

if ( ! function_exists( 'wp_mail_smtp_check_pro_loading_allowed' ) ) {
	/**
	 * Không cho phép 1.4.x trở xuống bị lỗi khi 1.5+ Pro được kích hoạt.
	 * Điều này sẽ dừng plugin hiện tại và hiển thị thông báo trong khu vực admin.
	 *
	 * @since 1.5.0
	 */
	function wp_mail_smtp_check_pro_loading_allowed() {

		// Kiểm tra pro mà không sử dụng wp_mail_smtp()->is_pro(), vì tại thời điểm này quá sớm.
		if ( ! is_readable( rtrim( plugin_dir_path( __FILE__ ), '/\\' ) . '/src/Pro/Pro.php' ) ) {
			// Hiện tại, không có phiên bản pro của plugin được tải.
			return false;
		}

		if ( ! function_exists( 'is_plugin_active' ) ) {
			require_once ABSPATH . '/wp-admin/includes/plugin.php';
		}

		$lite_plugin_slug = 'wp-mail-smtp/wp_mail_smtp.php';

		// Tìm kiếm tên plugin cũ.
		if ( is_plugin_active( $lite_plugin_slug ) ) {
			/*
			 * Ngăn chặn các vấn đề về các hàm WP không có sẵn cho các plugin khác kết nối vào
			 * việc hủy kích hoạt sớm này. Vấn đề GH #861.
			 */
			require_once ABSPATH . WPINC . '/pluggable.php';

			if (
				is_multisite() &&
				is_plugin_active_for_network( plugin_basename( __FILE__ ) ) &&
				! is_plugin_active_for_network( $lite_plugin_slug )
			) {
				// Hủy kích hoạt plugin Lite nếu Pro được kích hoạt ở cấp Network.
				deactivate_plugins( $lite_plugin_slug );
			} else {
				// Vì Pro được tải và Lite cũng vậy - hủy kích hoạt *im lặng* chính nó để không làm hỏng plugin SMTP cũ hơn.
				deactivate_plugins( plugin_basename( __FILE__ ) );

				if ( is_network_admin() ) {
					add_action( 'network_admin_notices', 'wp_mail_smtp_lite_deactivation_notice' );
				} else {
					add_action( 'admin_notices', 'wp_mail_smtp_lite_deactivation_notice' );
				}

				return true;
			}
		}

		return false;
	}

	if ( ! function_exists( 'wp_mail_smtp_lite_deactivation_notice' ) ) {
		/**
		 * Hiển thị thông báo sau khi hủy kích hoạt.
		 *
		 * @since 1.5.0
		 */
		function wp_mail_smtp_lite_deactivation_notice() {

			echo '<div class="notice notice-warning"><p>' . esc_html__( 'Vui lòng hủy kích hoạt phiên bản miễn phí của plugin WP Mail SMTP trước khi kích hoạt WP Mail SMTP Pro.', 'wp-mail-smtp' ) . '</p></div>';

			if ( isset( $_GET['activate'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				unset( $_GET['activate'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			}
		}
	}

	// Dừng tải plugin.
	if ( wp_mail_smtp_check_pro_loading_allowed() === true ) {
		return;
	}
}

if ( ! function_exists( 'wp_mail_smtp_insecure_php_version_notice' ) ) {
	/**
	 * Hiển thị thông báo admin, nếu máy chủ đang sử dụng phiên bản PHP cũ/không an toàn.
	 *
	 * @since 2.0.0
	 */
	function wp_mail_smtp_insecure_php_version_notice() {

		?>
		<div class="notice notice-error">
			<p>
				<?php
				printf(
					wp_kses( /* translators: %1$s - WPBeginner URL for recommended WordPress hosting. */
						__( 'Trang web của bạn đang chạy <strong>phiên bản không an toàn</strong> của PHP không còn được hỗ trợ. Vui lòng liên hệ với nhà cung cấp hosting web để cập nhật phiên bản PHP hoặc chuyển sang <a href="%1$s" target="_blank" rel="noopener noreferrer">công ty hosting WordPress được đề xuất</a>.', 'wp-mail-smtp' ),
						array(
							'a'      => array(
								'href'   => array(),
								'target' => array(),
								'rel'    => array(),
							),
							'strong' => array(),
						)
					),
					'https://www.wpbeginner.com/wordpress-hosting/'
				);
				?>
				<br><br>
				<?php

				$doc_link = add_query_arg(
					[
						'utm_source'   => 'WordPress',
						'utm_medium'   => 'Admin Notice',
						'utm_campaign' => is_readable( rtrim( plugin_dir_path( __FILE__ ), '/\\' ) . '/src/Pro/Pro.php' ) ? 'plugin' : 'liteplugin',
						'utm_content'  => 'Minimal Required PHP Version',
					],
					'https://wpmailsmtp.com/docs/supported-php-versions-for-wp-mail-smtp/'
				);

				printf(
					wp_kses( /* translators: %s - WPMailSMTP.com docs URL with more details. */
						__( '<strong>Plugin WP Mail SMTP đã bị vô hiệu hóa</strong> trên trang web của bạn cho đến khi bạn khắc phục vấn đề. <a href="%s" target="_blank" rel="noopener noreferrer">Đọc thêm để biết thông tin bổ sung.</a>', 'wp-mail-smtp' ),
						array(
							'a'      => array(
								'href'   => array(),
								'target' => array(),
								'rel'    => array(),
							),
							'strong' => array(),
						)
					),
					esc_url( $doc_link )
				);
				?>
			</p>
		</div>

		<?php

		// Trong trường hợp đây là khi kích hoạt plugin.
		if ( isset( $_GET['activate'] ) ) { //phpcs:ignore
			unset( $_GET['activate'] ); //phpcs:ignore
		}
	}
}

if ( ! defined( 'WPMS_PLUGIN_VER' ) ) {
	/**
	 * Phiên bản plugin.
	 *
	 * @since 0.11.1
	 */
	define( 'WPMS_PLUGIN_VER', '4.2.0' );
}
if ( ! defined( 'WPMS_PHP_VER' ) ) {
	/**
	 * Phiên bản PHP tối thiểu được hỗ trợ.
	 *
	 * @since 1.0.0
	 */
	define( 'WPMS_PHP_VER', '7.2' );
}
if ( ! defined( 'WPMS_WP_VER' ) ) {
	/**
	 * Phiên bản WordPress tối thiểu được hỗ trợ.
	 *
	 * @since 3.3.0
	 */
	define( 'WPMS_WP_VER', '5.5' );
}
if ( ! defined( 'WPMS_PLUGIN_FILE' ) ) {
	/**
	 * Đường dẫn file chính của plugin.
	 *
	 * @since 2.1.2
	 */
	define( 'WPMS_PLUGIN_FILE', __FILE__ );
}

if ( ! function_exists( 'wp_mail_smtp_unsupported_wp_version_notice' ) ) {
	/**
	 * Hiển thị thông báo admin, nếu trang web đang sử dụng phiên bản WP không được hỗ trợ.
	 *
	 * @since 3.3.0
	 */
	function wp_mail_smtp_unsupported_wp_version_notice() {

		?>
		<div class="notice notice-error">
			<p>
				<?php
				printf(
					wp_kses( /* translators: %s The minimal WP version supported by WP Mail SMTP. */
						__( 'Trang web của bạn đang chạy <strong>phiên bản cũ</strong> của WordPress không còn được WP Mail SMTP hỗ trợ. Vui lòng cập nhật trang WordPress của bạn lên ít nhất phiên bản <strong>%s</strong>.', 'wp-mail-smtp' ),
						[
							'strong' => [],
						]
					),
					esc_html( WPMS_WP_VER )
				);
				?>
				<br><br>
				<?php
				echo wp_kses(
					__( '<strong>Plugin WP Mail SMTP đã bị vô hiệu hóa</strong> trên trang web của bạn cho đến khi WordPress được cập nhật lên phiên bản yêu cầu.', 'wp-mail-smtp' ),
					[
						'strong' => [],
					]
				);
				?>
			</p>
		</div>

		<?php

		// Trong trường hợp đây là khi kích hoạt plugin.
		if ( isset( $_GET['activate'] ) ) { //phpcs:ignore
			unset( $_GET['activate'] ); //phpcs:ignore
		}
	}
}

/**
 * Hiển thị thông báo admin và ngăn thực thi mã plugin, nếu máy chủ đang
 * sử dụng phiên bản PHP cũ/không an toàn.
 *
 * @since 2.0.0
 */
if ( version_compare( phpversion(), WPMS_PHP_VER, '<' ) ) {
	add_action( 'admin_notices', 'wp_mail_smtp_insecure_php_version_notice' );

	return;
}

/**
 * Hiển thị thông báo admin và ngăn thực thi mã plugin, nếu phiên bản WP thấp hơn WPMS_WP_VER.
 *
 * @since 3.3.0
 */
if ( version_compare( get_bloginfo( 'version' ), WPMS_WP_VER, '<' ) ) {
	add_action( 'admin_notices', 'wp_mail_smtp_unsupported_wp_version_notice' );

	return;
}

require_once dirname( __FILE__ ) . '/wp-mail-smtp.php';
