<?php get_header(); ?>

<div class="container" style="min-height: 500px;">
  <div class="row">
    <div class="col-md-12">
      <h2 class="text-center mb-4">Quản lý CV</h2>
      
      <?php
      // Kiểm tra user đã đăng nhập chưa
      if (!is_user_logged_in()) {
        echo '<p class="text-center">Vui lòng đăng nhập để quản lý CV</p>';
        return;
      }

      $current_user = wp_get_current_user();
      $user_id = $current_user->ID;

      // Xử lý xóa CV
      if(isset($_POST['delete_cv'])) {
        $cv_id = $_POST['cv_id'];
        
        // Xóa tất cả thông tin CV
        delete_user_meta($user_id, $cv_id . '_cv_name');
        delete_user_meta($user_id, $cv_id . '_full_name');
        delete_user_meta($user_id, $cv_id . '_phone');
        delete_user_meta($user_id, $cv_id . '_address');
        delete_user_meta($user_id, $cv_id . '_education');
        delete_user_meta($user_id, $cv_id . '_experience');
        delete_user_meta($user_id, $cv_id . '_skills');
        delete_user_meta($user_id, $cv_id . '_cv_file');

        // Xóa CV khỏi danh sách
        $cv_list = get_user_meta($user_id, 'cv_list', true);
        if(!empty($cv_list)) {
          $cv_list = array_diff($cv_list, array($cv_id));
          update_user_meta($user_id, 'cv_list', $cv_list);
        }

        echo '<div class="alert alert-success">Đã xóa CV thành công!</div>';
      }

      // Lấy danh sách CV
      $cv_list = get_user_meta($user_id, 'cv_list', true);
      
      if(empty($cv_list)) {
        echo '<p class="text-center">Bạn chưa có CV nào. <a href="' . home_url('/ho-so-cv') . '">Tạo CV mới</a></p>';
      } else {
        echo '<div class="table-responsive">';
        echo '<table class="table table-striped">';
        echo '<thead><tr>
                <th>Tên CV</th>
                <th>Họ và tên</th>
                <th>Số điện thoại</th>
                <th>Thao tác</th>
              </tr></thead>';
        echo '<tbody>';
        
        foreach($cv_list as $cv_id) {
          $cv_name = get_user_meta($user_id, $cv_id . '_cv_name', true);
          $full_name = get_user_meta($user_id, $cv_id . '_full_name', true);
          $phone = get_user_meta($user_id, $cv_id . '_phone', true);
          $cv_file = get_user_meta($user_id, $cv_id . '_cv_file', true);
          
          echo '<tr>';
          echo '<td>' . esc_html($cv_name) . '</td>';
          echo '<td>' . esc_html($full_name) . '</td>';
          echo '<td>' . esc_html($phone) . '</td>';
          echo '<td>';
          echo '<a href="' . home_url('/ho-so-cv?cv_id=' . $cv_id) . '" class="btn btn-sm btn-info me-2">Xem/Sửa</a>';
          
          if(!empty($cv_file)) {
            echo '<a href="' . esc_url($cv_file) . '" target="_blank" class="btn btn-sm btn-success me-2">Tệp CV</a>';
          }
          
          echo '<form method="post" class="d-inline">';
          echo '<input type="hidden" name="cv_id" value="' . esc_attr($cv_id) . '">';
          echo '<button type="submit" name="delete_cv" class="btn btn-sm btn-danger" onclick="return confirm(\'Bạn có chắc chắn muốn xóa CV này?\')">Xóa</button>';
          echo '</form>';
          echo '</td>';
          echo '</tr>';
        }
        
        echo '</tbody></table>';
        echo '</div>';
      }
        
      ?>

    </div>
  </div>
</div>



<?php get_footer(); ?>
