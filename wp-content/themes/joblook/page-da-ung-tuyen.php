<?php
/**
 * Template Name: Trang Đã Ứng Tuyển
 */

get_header();

// Kiểm tra đăng nhập
if (!is_user_logged_in()) {
    ?>
    <div class="container">
        <div class="alert alert-warning">
            <p><?php esc_html_e('Vui lòng đăng nhập để xem danh sách công việc đã ứng tuyển', 'joblook'); ?></p>
            <a href="<?php echo esc_url(wp_login_url(get_permalink())); ?>" class="button">
                <?php esc_html_e('Đăng nhập', 'joblook'); ?>
            </a>
        </div>
    </div>
    <?php
} else {
    // Lấy danh sách công việc đã ứng tuyển từ user meta
    $user_id = get_current_user_id();
    $applied_jobs = get_user_meta($user_id, 'applied_jobs', true);

    if (!is_array($applied_jobs)) {
        $applied_jobs = array();
    }
    ?>
    <div class="container" style="min-height: 500px;">
        <h1 class="page-title"><?php esc_html_e('Công việc đã ứng tuyển', 'joblook'); ?></h1>
        
        <?php if (!empty($applied_jobs)) : ?>
            <div class="applied-jobs-list">
                <table class="table">
                    <thead>
                        <tr>
                            <th><?php esc_html_e('Tên công việc', 'joblook'); ?></th>
                            <th><?php esc_html_e('Công ty', 'joblook'); ?></th>
                            <th><?php esc_html_e('Ngày ứng tuyển', 'joblook'); ?></th>
                            <th style="width: 150px"><?php esc_html_e('Trạng thái', 'joblook'); ?></th>
                            <th><?php esc_html_e('CV đã nộp', 'joblook'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($applied_jobs as $job) : 
                            // Kiểm tra xem công việc còn tồn tại không
                            $job_post = get_post($job['job_id']);
                            if ($job_post) :
                            ?>
                            <tr>
                                <td>
                                    <a href="<?php echo esc_url(get_permalink($job['job_id'])); ?>">
                                        <?php echo esc_html($job['job_title']); ?>
                                    </a>
                                </td>
                                <td><?php echo esc_html($job['company_name']); ?></td>
                                <td><?php echo date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($job['apply_date'])); ?></td>
                                <td>
                                    <?php 
                                    $status = get_post_meta($job['job_id'], '_application_status_' . $user_id, true);
                                    $status = empty($status) ? 'pending' : $status;
                                    
                                    $status_labels = array(
                                        'pending' => __('Đang chờ xử lý', 'joblook'),
                                        'reviewed' => __('Đã xem', 'joblook'),
                                        'accepted' => __('Đã chấp nhận', 'joblook'),
                                        'rejected' => __('Từ chối', 'joblook')
                                    );
                                    
                                    echo '<span class="status-' . esc_attr($status) . '">' . esc_html($status_labels[$status]) . '</span>';
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                    $cv = get_post($job['cv_id']);
                                    if ($cv) {
                                        $cv_name = get_post_meta($job['cv_id'], 'cv_name', true);
                                        echo esc_html($cv_name);
                                        
                                        // Hiển thị link xem CV
                                        $cv_url = get_post_meta($job['cv_id'], 'cv_pdf_file', true);
                                        if ($cv_url) {
                                            echo ' <a href="' . esc_url($cv_url) . '" target="_blank">' . esc_html__('(Xem CV)', 'joblook') . '</a>';
                                        }
                                    } else {
                                        echo esc_html__('CV không còn tồn tại', 'joblook');
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <div class="alert alert-info">
                <p><?php esc_html_e('Bạn chưa ứng tuyển công việc nào.', 'joblook'); ?></p>
                <a href="<?php echo esc_url(home_url()); ?>" class="button">
                    <?php esc_html_e('Xem danh sách việc làm', 'joblook'); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
    
    <style>
    .status-pending { color: #856404; background: #fff3cd; padding: 5px 10px; border-radius: 3px; }
    .status-reviewed { color: #004085; background: #cce5ff; padding: 5px 10px; border-radius: 3px; }
    .status-accepted { color: #155724; background: #d4edda; padding: 5px 10px; border-radius: 3px; }
    .status-rejected { color: #721c24; background: #f8d7da; padding: 5px 10px; border-radius: 3px; }
    </style>
<?php
}

get_footer();
?>
