



<h2><?php esc_html_e('Kỹ năng','ateliercv'); ?></h2>
<div class="input-group">
    <label for="qf_skills"></label>
    <input type="text" id="qf_skills" name="atl_cv_qf_skills" value="<?php \ateliercv\AtelierCv::getValue('atl_cv_qf_skills'); ?>">
</div>

<h2><?php esc_html_e('Sở thích','ateliercv'); ?></h2>
<div class="input-group">
    <label for="qf_hobby"></label>
    <input type="text" id="qf_hobby" name="atl_cv_qf_hobby" value="<?php \ateliercv\AtelierCv::getValue('atl_cv_qf_hobby'); ?>">
</div>

<h2><?php esc_html_e('Chính sách bảo mật','ateliercv'); ?></h2>
<div class="input-group">
    <label for="qf_privacy_policy"></label>
    <textarea id="qf_privacy_policy" name="qf_privacy_policy" cols="60" rows="8"> <?php $privpol =  \ateliercv\AtelierCv::getValue('atl_cv_qf_languages');echo empty($privpol) ? 'Tôi đồng ý cho phép xử lý dữ liệu cá nhân của tôi cho các mục đích cần thiết trong quá trình tuyển dụng (theo Luật Bảo vệ Dữ liệu Cá nhân ngày 29.08.1997; (văn bản hợp nhất: Công báo 2016 mục 922).': $privpol; ?></textarea>
</div>
