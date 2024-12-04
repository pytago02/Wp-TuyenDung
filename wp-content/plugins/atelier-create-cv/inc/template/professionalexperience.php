
<div class="input-group-cols">
	<div class="input-col">
		<label for="profession_name"><?php esc_html_e('Vị trí','ateliercv'); ?>:</label>
		<input type="text"  class="pe-prof-name" id="profession_name" name="atl_cv_profession_name" placeholder="<?php esc_html_e('Nhập vị trí...','ateliercv'); ?>">
	</div>

	<div class="input-col">
		<label for="profession_city" class="m-4"><?php esc_html_e('Thành phố','ateliercv'); ?>:</label>
		<input type="text" class="pe-prof-city" id="profession_city" name="atl_cv_profession_city" placeholder="<?php esc_html_e('Nhập thành phố...','ateliercv'); ?>">
	</div>
</div>
<br>

<div class="input-group">
	<label for="employer_name"><?php esc_html_e('Tên công ty','ateliercv'); ?>:</label>
	<input type="text" id="employer_name" name="atl_cv_employer_name" placeholder="<?php esc_html_e('Nhập tên công ty...','ateliercv'); ?>">
</div>
<br>

<div class="input-group-cols">
	<div class="input-col">
		<label for="start_date"><?php esc_html_e('Ngày bắt đầu','ateliercv'); ?>:</label>
		<input type="date" class="pe-start-date" id="start_date" name="atl_cv_pr_start_date" placeholder="<?php esc_html_e('Chọn ngày bắt đầu...','ateliercv'); ?>">
	</div>

	<div class="input-col">
		<label for="end_date" class="m-4"><?php esc_html_e('Ngày kết thúc','ateliercv'); ?>:</label>
		<input type="date" class="pe-end-date" id="end_date" name="atl_cv_pr_end_date" placeholder="<?php esc_html_e('Chọn ngày kết thúc','ateliercv'); ?>">
	</div>
</div>
<div class="check">
    <label for="atl_cv_to_present"></label>
    <input type="checkbox" id="atl_cv_to_present" name="atl_cv_pr_end_date" value="01-01-2040">
    <span class="desc"><?php esc_html_e('Hiện tại','ateliercv'); ?></span>
</div>
<br>

<div class="input-group">
	<label for="pe_desc"><?php esc_html_e('Mô tả','ateliercv'); ?>:</label>
	<textarea id="pe_desc" name="atl_cv_pr_desc" cols="60" rows="8" placeholder="<?php esc_html_e('Nhập mô tả...','ateliercv'); ?>"></textarea>
</div>

<br>
