<?php
/**
 * Lưu CV vào user meta khi CV được tạo/cập nhật
 * 
 * @param int $cv_id ID của CV (có thể là post ID nếu CV được lưu dưới dạng custom post type)
 * @param string $cv_name Tên của CV
 */
function save_cv_to_user_meta($cv_id, $cv_name) {
    $user_id = get_current_user_id();
    
    // Lấy danh sách CV hiện tại
    $user_cvs = get_user_meta($user_id, 'user_cvs', true);
    
    // Nếu chưa có danh sách CV, tạo mảng mới
    if (!is_array($user_cvs)) {
        $user_cvs = array();
    }
    
    // Thêm CV mới vào danh sách
    $user_cvs[$cv_id] = $cv_name;
    
    // Cập nhật metadata
    update_user_meta($user_id, 'user_cvs', $user_cvs);
}

/**
 * Xóa CV khỏi user meta
 * 
 * @param int $cv_id ID của CV cần xóa
 */
function remove_cv_from_user_meta($cv_id) {
    $user_id = get_current_user_id();
    $user_cvs = get_user_meta($user_id, 'user_cvs', true);
    
    if (is_array($user_cvs) && isset($user_cvs[$cv_id])) {
        unset($user_cvs[$cv_id]);
        update_user_meta($user_id, 'user_cvs', $user_cvs);
    }
}