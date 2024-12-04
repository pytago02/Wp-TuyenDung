<?php
get_header();

// Kiểm tra user đã đăng nhập chưa
if (!is_user_logged_in()) {
    echo '<div class="container" style="min-height: 500px;"><p class="text-center">Vui lòng đăng nhập để xem danh sách ứng viên</p></div>';
    get_footer();
    return;
}

// Kiểm tra xem có phải là nhà tuyển dụng không
if (!current_user_can('employer') && !current_user_can('administrator')) {
    echo '<div class="container" style="min-height: 500px;"><p class="text-center">Bạn không có quyền xem trang này</p></div>';
    get_footer();
    return;
}

// Lấy job_id từ URL
$job_id = isset($_GET['job_id']) ? intval($_GET['job_id']) : 0;

if (!$job_id) {
    echo '<div class="container" style="min-height: 500px;"><p class="text-center">Không tìm thấy công việc</p></div>';
    get_footer();
    return;
}

// Lấy thông tin công việc
$job = get_post($job_id);

// Kiểm tra xem công việc có tồn tại và người dùng có phải là người đăng không
if (!$job || $job->post_author != get_current_user_id()) {
    echo '<div class="container" style="min-height: 500px;"><p class="text-center">Bạn không có quyền xem danh sách ứng viên của công việc này</p></div>';
    get_footer();
    return;
}

// Xử lý cập nhật trạng thái
if(isset($_POST['update_status'])) {
    $applicant_id = intval($_POST['applicant_id']);
    $new_status = sanitize_text_field($_POST['new_status']);
    
    // Cập nhật trạng thái mới
    update_post_meta($job_id, '_application_status_' . $applicant_id, $new_status);
    
    // Thông báo thành công
    echo '<div class="alert alert-success">Đã cập nhật trạng thái thành công!</div>';
}

// Lấy danh sách ứng viên đã ứng tuyển
$applicants = array();
$all_users = get_users();

foreach ($all_users as $user) {
    $applied_jobs = get_user_meta($user->ID, 'applied_jobs', true);
    if (!empty($applied_jobs) && is_array($applied_jobs)) {
        // Debug để xem cấu trúc của $applied_jobs
        error_log('Applied Jobs for user ' . $user->ID . ': ' . print_r($applied_jobs, true));
        
        foreach ($applied_jobs as $applied_job) {
            if ($applied_job['job_id'] == $job_id) {
                // Debug để xem thông tin chi tiết của ứng tuyển
                error_log('Found application for job ' . $job_id . ': ' . print_r($applied_job, true));
                
                $applicants[] = array(
                    'user_id' => $user->ID,
                    'cv_id' => $applied_job['cv_id'], // Kiểm tra key này có đúng không
                    'apply_date' => $applied_job['apply_date'],
                    'status' => get_post_meta($job_id, '_application_status_' . $user->ID, true) ?: 'pending'
                );
                break;
            }
        }
    }
}

?>

<div class="container" style="min-height: 500px;">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center mb-4">Danh sách ứng viên - <?php echo esc_html($job->post_title); ?></h2>

            <?php if (empty($applicants)) : ?>
                <div class="alert alert-info">
                    Chưa có ứng viên nào ứng tuyển vào vị trí này
                </div>
            <?php else : ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Họ và tên</th>
                                <th>Email</th>
                                <th>Ngày ứng tuyển</th>
                                <th>CV</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($applicants as $applicant) : 
                                $user_info = get_userdata($applicant['user_id']);
                                $cv_list = get_user_meta($applicant['user_id'], 'cv_list', true);
                                $cv_name = isset($cv_list[$applicant['cv_id']]) ? $cv_list[$applicant['cv_id']] : '';
                                $cv_url = get_post_meta($applicant['cv_id'], 'cv_pdf_file', true);
                            ?>
                                <tr>
                                    <td><?php echo esc_html($user_info->display_name); ?></td>
                                    <td><?php echo esc_html($user_info->user_email); ?></td>
                                    <td><?php echo date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($applicant['apply_date'])); ?></td>
                                    <td>
                                    <a href="<?php echo home_url('/cv-ung-vien?cv_id=' . $cv_name . '&view_only=true'); ?>" class="btn btn-sm btn-info me-2">Xem CV</a>
                                        
                                        <?php if(!empty($cv_file)) : ?>
                                            <a href="<?php echo esc_url($cv_file); ?>" target="_blank" class="btn btn-sm btn-success me-2">Tệp CV</a>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php 
                                        $status_labels = array(
                                            'pending' => __('Đang chờ xử lý', 'joblook'),
                                            'reviewed' => __('Đã xem', 'joblook'),
                                            'accepted' => __('Đã chấp nhận', 'joblook'),
                                            'rejected' => __('Từ chối', 'joblook')
                                        );
                                        echo '<span class="status-' . esc_attr($applicant['status']) . '">' . 
                                             esc_html($status_labels[$applicant['status']]) . '</span>';
                                        ?>
                                    </td>
                                    <td>

                                        <form method="post" class="d-inline">
                                            <select name="new_status" class="form-control application-status">
                                                <?php foreach ($status_labels as $value => $label) : ?>
                                                    <option value="<?php echo esc_attr($value); ?>" 
                                                            <?php selected($applicant['status'], $value); ?>>
                                                        <?php echo esc_html($label); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <input type="hidden" name="applicant_id" value="<?php echo esc_attr($applicant['user_id']); ?>">
                                            <input type="hidden" name="update_status" value="1">
                                            <td>
                                                <button type="submit" class="btn btn-sm btn-success mt-2">
                                                    Cập nhật
                                                </button>
                                            </td>
                                          
                                        </form>
                                    </td>
                                    
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.status-pending { color: #856404; background: #fff3cd; padding: 5px 10px; border-radius: 3px; }
.status-reviewed { color: #004085; background: #cce5ff; padding: 5px 10px; border-radius: 3px; }
.status-accepted { color: #155724; background: #d4edda; padding: 5px 10px; border-radius: 3px; }
.status-rejected { color: #721c24; background: #f8d7da; padding: 5px 10px; border-radius: 3px; }
.btn { margin-right: 5px; }
</style>

<?php get_footer(); ?>
