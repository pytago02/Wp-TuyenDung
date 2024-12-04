<?php
/**
 * Show job application when viewing a single job listing.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/job-application.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     wp-job-manager
 * @category    Template
 * @version     1.31.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<?php if ( $apply = get_the_job_application_method() ) :
	wp_enqueue_script( 'wp-job-manager-job-application' );
	
	// Kiểm tra xem người dùng đã đăng nhập và đã ứng tuyển công việc này chưa
	$has_applied = false;
	if (is_user_logged_in()) {
		$user_id = get_current_user_id();
		$applied_jobs = get_user_meta($user_id, 'applied_jobs', true);
		if (!empty($applied_jobs)) {
			foreach ($applied_jobs as $job) {
				if ($job['job_id'] == get_the_ID()) {
					$has_applied = true;
					break;
				}
			}
		}
	}
	?>
	<div class="job_application application">
		<?php do_action( 'job_application_start', $apply ); ?>

		<?php if ($has_applied): ?>
			<div class="alert alert-info">Bạn đã ứng tuyển công việc này</div>
			<input style="background-color: #FF9001;" type="button" class="application_button button" value="<?php esc_attr_e( 'Ứng tuyển lại', 'wp-job-manager' ); ?>" />
		<?php else: ?>
			<input type="button" class="application_button button" value="<?php esc_attr_e( 'Ứng tuyển', 'wp-job-manager' ); ?>" />
		<?php endif; ?>

		

		<div class="application_details">
			<?php
			// Kiểm tra xem người dùng đã đăng nhập chưa
			if (!is_user_logged_in()) {
				echo '<p>' . esc_html__('Vui lòng đăng nhập để ứng tuyển', 'wp-job-manager') . '</p>';
				echo '<a href="' . esc_url(wp_login_url(get_permalink())) . '" class="button">' . esc_html__('Đăng nhập', 'wp-job-manager') . '</a>';
			} else {
				// Lấy danh sách CV của user hiện tại
				$cv_list = get_user_meta(get_current_user_id(), 'cv_list', true);
				
				if (empty($cv_list)) {
					echo '<p>' . esc_html__('Bạn chưa có CV nào. Vui lòng tạo CV trước khi ứng tuyển.', 'wp-job-manager') . '</p>';
					echo '<a href="' . esc_url(home_url('/ho-so-cv')) . '" class="button">' . esc_html__('Tạo CV', 'wp-job-manager') . '</a>';
				} else {
					// Xử lý khi form được submit
					if (isset($_POST['selected_cv']) && isset($_POST['job_id']) && isset($_POST['_wpjm_nonce'])) {
						if (wp_verify_nonce($_POST['_wpjm_nonce'], 'submit_job_application')) {
							$user_id = get_current_user_id();
							$cv_id = sanitize_text_field($_POST['selected_cv']);
							$job_id = sanitize_text_field($_POST['job_id']);
							
							// Lấy thông tin công việc
							$job = get_post($job_id);
							
							// Lấy danh sách công việc đã ứng tuyển
							$applied_jobs = get_user_meta($user_id, 'applied_jobs', true);
							if (!is_array($applied_jobs)) {
								$applied_jobs = array();
							}
							
							// Thêm công việc mới vào danh sách
							$applied_jobs[] = array(
								'job_id' => $job_id,
								'cv_id' => $cv_id,
								'job_title' => $job->post_title,
								'company_name' => get_post_meta($job_id, '_company_name', true),
								'apply_date' => current_time('mysql')
							);
							
							// Cập nhật meta data
							update_user_meta($user_id, 'applied_jobs', $applied_jobs);

							// Gửi email cho nhà tuyển dụng 
							$employer_email = get_post_meta($job_id, '_application', true); 
							$candidate_name = wp_get_current_user()->display_name; 
							$application_id = $job_id; // Bạn có thể điều chỉnh để lấy ID chính xác nếu cần 
							$message = sprintf( 'Xin chào!<br><br> 
								Ứng viên <strong>%s</strong> đã ứng tuyển vào công việc <strong>%s</strong> của bạn.<br><br> 
								Để xem chi tiết hồ sơ ứng tuyển, vui lòng truy cập vào link sau:<br> 
								%s<br><br> 
								Trân trọng,<br> 
								%s', $candidate_name, $job->post_title, admin_url('tat-ca-cong-viec'), get_bloginfo('name') ); 
							$subject = 'Ứng tuyển mới: ' . $job->post_title; 
							$headers = array('Content-Type: text/html; charset=UTF-8'); 
							wp_mail($employer_email, $subject, $message, $headers);
						}
					}
					?>
					<form class="job-application-form" method="post">
						<div class="form-group">
							<label><?php esc_html_e('Chọn CV của bạn', 'wp-job-manager'); ?></label>
							<select name="selected_cv" required>
								<?php foreach ($cv_list as $cv_id => $cv_name) : ?>
									<option value="<?php echo esc_attr($cv_id); ?>"><?php echo esc_html($cv_name); ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<input type="hidden" name="job_id" value="<?php echo esc_attr(get_the_ID()); ?>">
						<?php wp_nonce_field('submit_job_application', '_wpjm_nonce'); ?>
						<input type="submit" value="<?php esc_attr_e('Gửi hồ sơ', 'wp-job-manager'); ?>" class="button">
					</form>
					<?php
				}
			}
			?>
		</div>
		<?php do_action( 'job_application_end', $apply ); ?>
	</div>
<?php endif; ?>
