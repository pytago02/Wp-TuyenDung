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