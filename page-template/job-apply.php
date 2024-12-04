<?php
// Lấy danh sách CV của user hiện tại
$current_user_id = get_current_user_id();
$user_cvs = get_posts(array(
    'post_type' => 'cv',
    'author' => $current_user_id,
    'posts_per_page' => -1,
    'post_status' => 'publish'
));
?>

<form method="post" class="job-apply-form">
    <div class="form-group">
        <label>Chọn CV của bạn</label>
        <?php if (!empty($user_cvs)) : ?>
            <select name="selected_cv" required>
                <option value="">-- Chọn CV --</option>
                <?php foreach ($user_cvs as $cv) : ?>
                    <option value="<?php echo $cv->ID; ?>">
                        <?php echo $cv->post_title; ?>
                        (Cập nhật: <?php echo get_the_modified_date('d/m/Y', $cv->ID); ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            
            <div class="cv-preview">
                <a href="#" class="preview-cv-btn">Xem trước CV</a>
            </div>
        <?php else : ?>
            <p class="no-cv-notice">Bạn chưa có CV nào. 
                <a href="<?php echo home_url('/tao-cv'); ?>">Tạo CV mới</a>
            </p>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Thư giới thiệu</label>
        <textarea name="cover_letter" required></textarea>
    </div>

    <?php wp_nonce_field('submit_job_application', 'job_application_nonce'); ?>
    <input type="hidden" name="job_id" value="<?php echo get_the_ID(); ?>">
    
    <?php if (!empty($user_cvs)) : ?>
        <button type="submit" name="submit_job_application">Ứng tuyển ngay</button>
    <?php endif; ?>
</form> 