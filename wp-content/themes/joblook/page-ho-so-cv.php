<?php get_header(); ?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="text-center mb-4">Tạo CV</h2>
      
      <?php
      // Kiểm tra user đã đăng nhập chưa
      if (!is_user_logged_in()) {
        echo '<p class="text-center">Vui lòng đăng nhập để tạo CV</p>';
        return;
      }

      $current_user = wp_get_current_user();
      $user_id = $current_user->ID;

      // Thêm xử lý xóa CV
      if(isset($_POST['delete_cv'])) {
        $cv_id = $_POST['cv_id'];
        $cv_list = get_user_meta($user_id, 'cv_list', true);
        
        if(($key = array_search($cv_id, $cv_list)) !== false) {
          unset($cv_list[$key]);
          update_user_meta($user_id, 'cv_list', array_values($cv_list));
          
          // Xóa tất cả meta data của CV
          delete_user_meta($user_id, $cv_id . '_cv_name');
          delete_user_meta($user_id, $cv_id . '_full_name');
          delete_user_meta($user_id, $cv_id . '_phone');
          delete_user_meta($user_id, $cv_id . '_address');
          delete_user_meta($user_id, $cv_id . '_education');
          delete_user_meta($user_id, $cv_id . '_experience');
          delete_user_meta($user_id, $cv_id . '_skills');
          delete_user_meta($user_id, $cv_id . '_cv_file');
          
          echo '<div class="alert alert-success">Đã xóa CV thành công!</div>';
        }
      }

      // Thêm phần hiển thị danh sách CV trước form
      $cv_list = get_user_meta($user_id, 'cv_list', true);
      if(!empty($cv_list)): ?>
        <div class="card mb-4">
          <div class="card-header">
            <h4>Danh sách CV của bạn</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>Tên CV</th>
                    <th>Họ và tên</th>
                    <th>File CV</th>
                    <th>Thao tác</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($cv_list as $cv): 
                    $cv_name = get_user_meta($user_id, $cv . '_cv_name', true);
                    $full_name = get_user_meta($user_id, $cv . '_full_name', true);
                    $cv_file = get_user_meta($user_id, $cv . '_cv_file', true);
                  ?>
                    <tr>
                      <td><?php echo esc_html($cv_name); ?></td>
                      <td><?php echo esc_html($full_name); ?></td>
                      <td>
                        <?php if(!empty($cv_file)): ?>
                          <a href="<?php echo esc_url($cv_file); ?>" target="_blank">Xem file</a>
                        <?php else: ?>
                          Chưa có file
                        <?php endif; ?>
                      </td>
                      <td>
                        <form method="post" style="display: inline;">
                          <input type="hidden" name="cv_id" value="<?php echo esc_attr($cv); ?>">
                          <button type="submit" name="load_cv" class="btn btn-sm btn-info">Chỉnh sửa</button>
                          <button type="submit" name="delete_cv" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa CV này?')">Xóa</button>
                        </form>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <?php
      // Xử lý form submit
      if (isset($_POST['submit_cv'])) {
        
        // Kiểm tra tên CV có bị trùng không
        $cv_list = get_user_meta($user_id, 'cv_list', true);
        $cv_name_exists = false;
        
        if(!empty($cv_list)) {
          foreach($cv_list as $existing_cv_id) {
            $existing_cv_name = get_user_meta($user_id, $existing_cv_id . '_cv_name', true);
            if($existing_cv_name == $_POST['cv_name']) {
              $cv_name_exists = true;
              break;
            }
          }
        }

        if($cv_name_exists) {
          echo '<div class="alert alert-danger">Tên CV đã tồn tại. Vui lòng chọn tên khác!</div>';
        } else {
          // Tạo ID CV ngẫu nhiên
          $cv_id = uniqid('cv_');
          
          // Xử lý upload file
          if(!empty($_FILES['cv_file']['name'])) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            $upload = wp_handle_upload($_FILES['cv_file'], array('test_form' => false));
            if(!isset($upload['error'])) {
              update_user_meta($user_id, $cv_id . '_cv_file', $upload['url']);
            }
          }

          // Lưu thông tin cá nhân
          update_user_meta($user_id, $cv_id . '_cv_name', sanitize_text_field($_POST['cv_name']));
          update_user_meta($user_id, $cv_id . '_full_name', sanitize_text_field($_POST['full_name']));
          update_user_meta($user_id, $cv_id . '_phone', sanitize_text_field($_POST['phone']));
          update_user_meta($user_id, $cv_id . '_address', sanitize_text_field($_POST['address']));
          update_user_meta($user_id, $cv_id . '_education', sanitize_textarea_field($_POST['education']));
          update_user_meta($user_id, $cv_id . '_experience', sanitize_textarea_field($_POST['experience']));
          update_user_meta($user_id, $cv_id . '_skills', sanitize_textarea_field($_POST['skills']));

          // Lưu danh sách ID CV của user
          if(empty($cv_list)) {
            $cv_list = array();
          }
          $cv_list[] = $cv_id;
          update_user_meta($user_id, 'cv_list', $cv_list);

          echo '<div class="alert alert-success">Đã lưu thông tin CV thành công!</div>';
        }
      }

      // Xử lý chỉnh sửa CV
      if(isset($_POST['edit_cv'])) {
        $cv_id = $_POST['cv_id'];
        
        // Kiểm tra tên CV có tồn tại không
        $cv_list = get_user_meta($user_id, 'cv_list', true);
        $cv_name_exists = false;
        
        if(!empty($cv_list)) {
          foreach($cv_list as $existing_cv_id) {
            $existing_cv_name = get_user_meta($user_id, $existing_cv_id . '_cv_name', true);
            if($existing_cv_name == $_POST['cv_name']) {
              $cv_name_exists = true;
              break;
            }
          }
        }

        if(!$cv_name_exists) {
          echo '<div class="alert alert-danger">Tên CV không tồn tại. Vui lòng kiểm tra lại!</div>';
        } else {
          // Cập nhật thông tin CV
          update_user_meta($user_id, $cv_id . '_cv_name', sanitize_text_field($_POST['cv_name']));
          update_user_meta($user_id, $cv_id . '_full_name', sanitize_text_field($_POST['full_name']));
          update_user_meta($user_id, $cv_id . '_phone', sanitize_text_field($_POST['phone']));
          update_user_meta($user_id, $cv_id . '_address', sanitize_text_field($_POST['address']));
          update_user_meta($user_id, $cv_id . '_education', sanitize_textarea_field($_POST['education']));
          update_user_meta($user_id, $cv_id . '_experience', sanitize_textarea_field($_POST['experience']));
          update_user_meta($user_id, $cv_id . '_skills', sanitize_textarea_field($_POST['skills']));

          // Xử lý upload file mới nếu có
          if(!empty($_FILES['cv_file']['name'])) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            $upload = wp_handle_upload($_FILES['cv_file'], array('test_form' => false));
            if(!isset($upload['error'])) {
              update_user_meta($user_id, $cv_id . '_cv_file', $upload['url']);
            }
          }

          echo '<div class="alert alert-success">Đã cập nhật thông tin CV thành công!</div>';
        }
      }

      // Lấy thông tin CV đã lưu
      $cv_list = get_user_meta($user_id, 'cv_list', true);
      $cv_id = !empty($cv_list) ? end($cv_list) : '';
      
      $cv_name = get_user_meta($user_id, $cv_id . '_cv_name', true);
      $full_name = get_user_meta($user_id, $cv_id . '_full_name', true);
      $phone = get_user_meta($user_id, $cv_id . '_phone', true);
      $address = get_user_meta($user_id, $cv_id . '_address', true);
      $education = get_user_meta($user_id, $cv_id . '_education', true);
      $experience = get_user_meta($user_id, $cv_id . '_experience', true); 
      $skills = get_user_meta($user_id, $cv_id . '_skills', true);
      $cv_file = get_user_meta($user_id, $cv_id . '_cv_file', true);
      ?>

      <form method="post" class="cv-form" enctype="multipart/form-data">
        <div class="form-group mb-3">
          <label>Tên CV</label>
          <input type="text" name="cv_name" class="form-control" value="<?php echo esc_attr($cv_name); ?>" required>
        </div>

        <div class="form-group mb-3">
          <label>Họ và tên</label>
          <input type="text" name="full_name" class="form-control" value="<?php echo esc_attr($full_name); ?>" required>
        </div>

        <div class="form-group mb-3">
          <label>Số điện thoại</label>
          <input type="tel" name="phone" class="form-control" value="<?php echo esc_attr($phone); ?>" required>
        </div>

        <div class="form-group mb-3">
          <label>Địa chỉ</label>
          <input type="text" name="address" class="form-control" value="<?php echo esc_attr($address); ?>" required>
        </div>

        <div class="form-group mb-3">
          <label>Học vấn</label>
          <textarea name="education" class="form-control" rows="4" required><?php echo esc_textarea($education); ?></textarea>
        </div>

        <div class="form-group mb-3">
          <label>Kinh nghiệm làm việc</label>
          <textarea name="experience" class="form-control" rows="4" required><?php echo esc_textarea($experience); ?></textarea>
        </div>

        <div class="form-group mb-3">
          <label>Kỹ năng</label>
          <textarea name="skills" class="form-control" rows="4" required><?php echo esc_textarea($skills); ?></textarea>
        </div>

        <div class="form-group mb-3 uploadfilecv">
          <label>Tải lên CV (PDF, DOC, DOCX)</label>
          <input type="file" name="cv_file" class="form-control" accept=".pdf,.doc,.docx">
          <?php if(!empty($cv_file)): ?>
            <p class="mt-2">CV hiện tại: <a href="<?php echo esc_url($cv_file); ?>" target="_blank">Xem file</a></p>
          <?php endif; ?>
        </div>

        <?php if(!empty($cv_id)): ?>
          <input type="hidden" name="cv_id" value="<?php echo esc_attr($cv_id); ?>">
          <button type="submit" name="edit_cv" class="btn btn-warning me-2">Cập nhật CV</button>
        <?php endif; ?>
        <button type="submit" name="submit_cv" class="btn btn-primary">Lưu CV mới</button>
      </form>

    </div>
  </div>
</div>

<?php get_footer(); ?>
