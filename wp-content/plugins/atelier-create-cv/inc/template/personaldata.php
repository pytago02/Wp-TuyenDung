
<div id="pd-section" class="pd-section">

	<!-- Image -->
	<div class="input-group">
		<label for="person_image"><?php esc_html_e('Ảnh','ateliercv'); ?></label><br>
        <div class="input-img-group">
            <p id="tooltip-img" class="tooltip-img">
                <?php esc_html_e('Ảnh phải là hình vuông, ví dụ: <br>
                150x150 / 600x600 / 1200x1200','ateliercv'); ?>
            </p>
            <input type="button" class="btn-img" id="person_image" value="<?php esc_attr_e('Tải lên','ateliercv'); ?>"><br>
            <input type="button" class="btn-img" id="person_image_delete" value="<?php esc_attr_e('Xóa','ateliercv'); ?>"><br>
            <input type="hidden"  name="atl_cv_person_image" id="person_image_hidden" value="<?php echo esc_attr(get_option('atl_cv_person_image')); ?>">
        </div>
	</div>
    <br>

    <div class="input-group-cols">

        <!-- Background color -->
        <div id="color-picker-pd" class="input-col">
            <label class="color-m" for="sidebar_bg_color"><?php esc_html_e('Màu nền','ateliercv'); ?></label><br>
            <input type="text" class="color-field" name="sidebar_bg_color" id="sidebar_bg_color" value="<?php echo esc_attr(get_option('sidebar_bg_color'));?>">
        </div>

        <!-- Font color -->
        <div id="color-picker-font" class="input-col">
            <label class="color-m" for="atl_cv_font_color"><?php esc_html_e('Màu chữ','ateliercv'); ?></label><br>
            <input type="text" class="color-field" name="atl_cv_font_color" id="atl_cv_font_color" value="<?php echo esc_attr(get_option('atl_cv_font_color'));?>">
        </div>

    </div>

    <div class="input-group padding-10">
        <p class="switch-p"><?php esc_html_e('Bật ảnh vuông','ateliercv'); ?></p>
        <label class="switch">
            <input type="checkbox" name="atl_cv_square_img" id="atl_cv_square_img" value="1"  <?php checked(1,get_option('atl_cv_square_img'),1); ?>>
            <span class="slider round"></span>
        </label>
    </div>

    <!-- Name -->
	<div class="input-group">
		<label for="first_name"><?php esc_html_e('Tên','ateliercv'); ?>*</label><br>
		<input type="text" id="first_name" name="atl_cv_first_name" placeholder="<?php esc_html_e('Nhập tên của bạn...','ateliercv'); ?>"  value="<?php echo esc_attr(get_option('atl_cv_first_name')); ?>" required><br>
	</div>
    <br>

	<!-- Surname -->
	<div class="input-group">
		<label for="surname"><?php esc_html_e('Họ','ateliercv'); ?>*</label><br>
		<input type="text" id="surname" name="atl_cv_surname" placeholder="<?php esc_html_e('Nhập họ của bạn','ateliercv'); ?>" value="<?php echo esc_attr(get_option('atl_cv_surname'));?>" required><br>
	</div>
    <br>

	<!-- Email && Telephone -->
	<div class="input-group-cols">
		<!-- Email -->
		<div class="input-col">
			<label for="email"><?php esc_html_e('Email','ateliercv'); ?>*</label>
            <input type="email" class="pd-email" id="email" name="atl_cv_email" placeholder="<?php esc_html_e('Email...','ateliercv'); ?>" value="<?php echo esc_attr(get_option('atl_cv_email'));?>" required>
		</div>

		<!-- Telephone -->
		<div class="input-col">
			<label for="telephone" class="m-4"><?php esc_html_e('Điện thoại','ateliercv'); ?></label>
            <input type="tel" class="pd-tel" id="telephone" name="atl_cv_telephone" placeholder="<?php esc_html_e('Số điện thoại...','ateliercv'); ?>" value="<?php echo esc_attr(get_option('atl_cv_telephone'));?>">
		</div>
	</div>
    <br>

	<!-- Address -->
	<div class="input-group">
		<label for="pd-address"><?php esc_html_e('Địa chỉ','ateliercv'); ?></label><br>
		<input type="text" id="pd-address" name="atl_cv_address" placeholder="<?php esc_html_e('Địa chỉ...','ateliercv'); ?>" value="<?php echo esc_attr(get_option('atl_cv_address'));?>"><br>
	</div>
    <br>

    <!-- Code && City -->
    <div class="input-group-cols">
        <!-- Code -->
        <div class="input-col">
            <label for="address_code"><?php esc_html_e('Mã bưu điện','ateliercv'); ?></label>
            <input type="text" class="pd-code" id="address_code" name="atl_cv_address_code" placeholder="<?php esc_html_e('Mã bưu điện...','ateliercv'); ?>" value="<?php echo esc_attr(get_option('atl_cv_address_code'));?>">
        </div>

        <!-- City -->
        <div class="input-col">
            <label for="city" class="m-4"><?php esc_html_e('Thành phố','ateliercv'); ?></label>
            <input type="text" class="pd-city" id="city" name="atl_cv_city" placeholder="<?php esc_html_e('Thành phố...','ateliercv'); ?>" value="<?php echo esc_attr(get_option('atl_cv_city'));?>">
        </div>
    </div>
    <br>

    <br>
    <div class="input-group">
        <div class="dp-button">
            <button class="dp-button-info" id="pd-all-info"><?php esc_html_e('Thông tin bổ sung','ateliercv'); ?> <strong>+</strong></button>
        </div>
    </div>
    <br>

    <div id="dp-hidden-submit" class="dp-hidden-submit">
        <!-- Date Birth && Place Birth -->
        <div class="input-group-cols">
            <!-- Date Birth -->
            <div class="input-col">
                <label for="date_birth"><?php esc_html_e('Ngày sinh','ateliercv'); ?>:</label>
                <input type="date" class="pd-date-birth" id="date_birth" name="atl_cv_date_birth" placeholder="<?php esc_html_e('Ngày sinh...','ateliercv'); ?>" value="<?php echo esc_attr(get_option('atl_cv_date_birth'));?>">
            </div>

            <!-- Place Birth -->
            <div class="input-col">
                <label for="place_birth" class="m-4"><?php esc_html_e('Nơi sinh','ateliercv'); ?>:</label>
                <input type="text" class="pd-place-birth" id="place_birth" name="atl_cv_place_birth" placeholder="<?php esc_html_e('Nơi sinh...','ateliercv'); ?>" value="<?php echo esc_attr(get_option('atl_cv_place_birth'));?>">
            </div>
        </div>
        <br>

        <!-- Driving License && Gender -->
        <div class="input-group-cols">
            <!-- Driving License -->
            <div class="input-col">
                <label for="driving_license"><?php esc_html_e('Bằng lái xe','ateliercv'); ?>:</label>
                <input type="text" class="pd-dr-lic" id="driving_license" name="atl_cv_driving_license" placeholder="<?php esc_html_e('Bằng lái xe...','ateliercv'); ?>" value="<?php echo esc_attr(get_option('atl_cv_driving_license'));?>">
            </div>

        </div>
        <br>

        <!-- Nationality && Condition -->
        <div class="input-group-cols">
            <!-- Nationality -->
            <div class="input-col">
                <label for="nationality"><?php esc_html_e('Quốc tịch','ateliercv'); ?>:</label>
                <input type="text" class="pd-nationality" id="nationality" name="atl_cv_nationality" placeholder="<?php esc_html_e('Quốc tịch...','ateliercv'); ?>" value="<?php echo esc_attr(get_option('atl_cv_nationality')); ?>">
            </div>

            <!-- Condition -->
            <div class="input-col">
                <label for="condition" class="m-4"><?php esc_html_e('Tình trạng hôn nhân','ateliercv'); ?>:</label>
                <input type="text" class="pd-condition" id="condition" name="atl_cv_condition" placeholder="<?php esc_html_e('Tình trạng hôn nhân...','ateliercv'); ?>" value="<?php echo esc_attr(get_option('atl_cv_condition'));?>">
            </div>
        </div>
        <br>

        <!-- Website's -->
        <div class="input-group-cols">
            <!-- Linkedin -->
            <div class="input-col">
                <label for="linkedin"><?php esc_html_e('LinkedIn','ateliercv'); ?></label>
                <input type="text" class="pd-linkedin" id="linkedin" name="atl_cv_linkedin" placeholder="LinkedIn..." value="<?php echo esc_attr(get_option('atl_cv_linkedin'));?>">
            </div>

            <!-- Repository Page -->
            <div class="input-col">
                <label for="repo"><?php esc_html_e('Kho lưu trữ','ateliercv'); ?></label>
                <input type="text" class="pd-repo" id="repo" name="atl_cv_repo" placeholder="Repository..." value="<?php echo esc_attr(get_option('atl_cv_repo'));?>">
            </div>

            <!-- Website -->
            <div class="input-col">
                <label for="website" class="m-4"><?php esc_html_e('Trang web','ateliercv'); ?>:</label>
                <input type="text" class="pd-website" id="website" name="atl_cv_website" placeholder="<?php esc_html_e('Trang web...','ateliercv'); ?>" value="<?php echo esc_attr(get_option('atl_cv_website'));?>">
            </div>
        </div>
        <br>
    </div>
</div>