<?php get_header(); ?>

<div class="container mt-4" style="min-height: 500px; padding-top: 20px;">
    <?php
    // Lấy CV ID từ URL
    $cv_id = isset($_GET['cv_id']) ? sanitize_text_field($_GET['cv_id']) : null;

    if (!$cv_id) {
        echo '<p class="text-center">Không tìm thấy thông tin CV.</p>';
        return;
    }

    // Kiểm tra vai trò user
    $current_user = wp_get_current_user();
    if (!in_array('employer', $current_user->roles) && !in_array('administrator', $current_user->roles)) {
        echo '<p class="text-center">Bạn không có quyền truy cập thông tin CV này.</p>';
        return;
    }

    // Lấy thông tin CV từ bảng usermeta
    global $wpdb;
    $user_meta_prefix = $cv_id . '_';
    $user_meta = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT meta_key, meta_value 
             FROM {$wpdb->usermeta} 
             WHERE meta_key LIKE %s",
            $wpdb->esc_like($user_meta_prefix) . '%'
        ),
        ARRAY_A
    );

    // Chuyển đổi dữ liệu để dễ sử dụng
    $cv_data = [];
    foreach ($user_meta as $meta) {
        $cv_data[str_replace($user_meta_prefix, '', $meta['meta_key'])] = $meta['meta_value'];
    }

    // Kiểm tra nếu không có dữ liệu
    if (empty($cv_data['cv_name'])) {
        echo '<p class="text-center">CV không tồn tại hoặc đã bị xóa.</p>';
        return;
    }
    ?>
    <div class="card">
        <div class="card-header">
            <h4>Thông tin CV</h4>
        </div>
        <div class="card-body">
            <p><strong>Tên CV:</strong> <?php echo esc_html($cv_data['cv_name']); ?></p>
            <p><strong>Họ và tên:</strong> <?php echo esc_html($cv_data['full_name']); ?></p>
            <p><strong>Số điện thoại:</strong> <?php echo esc_html($cv_data['phone']); ?></p>
            <p><strong>Địa chỉ:</strong> <?php echo esc_html($cv_data['address']); ?></p>
            <p><strong>Học vấn:</strong><br><?php echo nl2br(esc_html($cv_data['education'])); ?></p>
            <p><strong>Kinh nghiệm làm việc:</strong><br><?php echo nl2br(esc_html($cv_data['experience'])); ?></p>
            <p><strong>Kỹ năng:</strong><br><?php echo nl2br(esc_html($cv_data['skills'])); ?></p>
            <?php if (!empty($cv_data['cv_file'])): ?>
                <p><strong>File CV:</strong> <a href="<?php echo esc_url($cv_data['cv_file']); ?>" target="_blank">Cv tải lên</a></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
