<?php
use ateliercv\AtelierCv;

$AtelierCv = new AtelierCv();
?>

<div id="print-body">

    <div id="preview-body" class="preview-body">

        <!-- Sidebar -->
        <div id="preview-sidebar" class="preview-sidebar">
            <div class="sidebar-window">

                <!-- Image Author -->
                <?php
                $img = \ateliercv\AtelierCv::getOptionValue(get_option('atl_cv_person_image'));
                $imgAnonim = ATL_CV_PLUGIN_URL . '/assets/img/PERSON.svg';
                ?>
                <div class="image-box">
                    <img id="prv-img-author" src="<?php echo esc_url((!empty($img)) ? $img : $imgAnonim); ?>" alt="Ảnh tác giả CV" <?php $prvSq = get_option('atl_cv_square_img'); ?>
                    class="<?php echo esc_attr(($prvSq == 1) ? 'square-img' : 'circle-img'); ?>">
                </div>


                <!-- Title -->
                <h2 class="atl-prv-title"><?php esc_html_e('THÔNG TIN CÁ NHÂN','atelircv'); ?></h2>

                <!-- Name && Surname -->
                <div class="data-group">
                    <h4><?php esc_html_e('Họ và tên','ateliercv'); ?></h4>
                    <div class="flex">
                        <p id="prv_name"><?php echo esc_html(AtelierCv::getOptionValue(get_option('atl_cv_first_name')));?></p>&nbsp;
                        <p id="prv_surname"><?php echo esc_html(AtelierCv::getOptionValue(get_option('atl_cv_surname')));?></p>
                    </div>
                </div>

                <!-- Address -->
                <div class="data-group">
                    <h4><?php esc_html_e('Địa chỉ','ateliercv'); ?></h4>
                    <p id="prv-address"><?php echo esc_html(AtelierCv::getOptionValue(get_option('atl_cv_address')));?></p>
                    <div class="flex">
                        <p id="prv-code"><?php echo esc_html(AtelierCv::getOptionValue(get_option('atl_cv_address_code')));?></p>
                        <span>&nbsp;</span>
                        <p id="prv-city"><?php echo esc_html(AtelierCv::getOptionValue(get_option('atl_cv_city')));?></p>
                    </div>
                </div>

                <!-- Email -->
                <div class="data-group">
                    <h4><?php esc_html_e('Email','ateliercv'); ?></h4>
                    <p id="prv-email"><?php echo esc_html(AtelierCv::getOptionValue(get_option('atl_cv_email')));?></p>
                </div>

                <!-- Telephone -->
                <div class="data-group">
                    <h4><?php esc_html_e('Điện thoại','ateliercv'); ?></h4>
                    <p id="prv-tel"><?php echo esc_html( AtelierCv::getOptionValue(get_option('atl_cv_telephone')));?></p>
                </div>

                <!-- Birth Date -->
                <div class="data-group">
                    <h4><?php esc_html_e('Ngày sinh','ateliercv'); ?></h4>
                    <p id="prv-date-birth"><?php $date_birth =  AtelierCv::getOptionValue(get_option('atl_cv_date_birth'));
	                    echo esc_html(AtelierCv::changeDate($date_birth, '/'));
                    ?></p>
                </div>

                <!-- Birth Place -->
                <div class="data-group">
                    <h4><?php esc_html_e('Nơi sinh','ateliercv'); ?></h4>
                    <p id="prv-place-birth"><?php echo esc_html(AtelierCv::getOptionValue(get_option('atl_cv_place_birth')));?></p>
                </div>

                <!-- Nationality -->
                <div class="data-group">
                    <h4><?php esc_html_e('Quốc tịch','ateliercv'); ?></h4>
                    <p id="prv-nationality"><?php echo esc_html(AtelierCv::getOptionValue(get_option('atl_cv_nationality')));?></p>
                </div>

                <!-- Condition -->
                <div class="data-group">
                    <h4><?php esc_html_e('Tình trạng hôn nhân','ateliercv'); ?></h4>
                    <p id="prv-condition"><?php echo esc_html(AtelierCv::getOptionValue(get_option('atl_cv_condition')));?></p>
                </div>

                <!-- Driving License -->
                <div class="data-group">
                    <h4><?php esc_html_e('Bằng lái xe','ateliercv'); ?></h4>
                    <p id="prv-driving-license"><?php echo esc_html(AtelierCv::getOptionValue(get_option('atl_cv_driving_license')));?></p>
                </div>

                <!-- Linkedin -->
                <?php $linkedin = AtelierCv::getOptionValue(get_option('atl_cv_linkedin'));
                if(!empty($linkedin)) { ?>
                <div class="data-group">
                    <h4><?php esc_html_e('Linkedin','ateliercv'); ?></h4>
                    <p id="prv-linkedin"><?php echo esc_url($AtelierCv->textCut($linkedin)); ?></p>
                </div>
                <?php }  ?>

                <!-- Repository -->
	            <?php $repo = AtelierCv::getOptionValue(get_option('atl_cv_repo'));
	            if(!empty($repo)) { ?>
                    <div class="data-group">
                        <h4><?php esc_html_e('Kho lưu trữ','ateliercv'); ?></h4>
                        <p id="prv-repo"><?php echo esc_url($AtelierCv->textCut($repo)); ?></p>
                    </div>
	            <?php }  ?>

                <!-- Website -->
                <?php $website = AtelierCv::getOptionValue(get_option('atl_cv_website'));
                if(!empty($website)) { ?>
                    <div class="data-group">
                        <h4><?php esc_html_e('Website','ateliercv'); ?></h4>
                        <p id="prv-website"><?php echo esc_url( $AtelierCv->textCut( $website ) ); ?></p>
                    </div>
                <?php }  ?>


            </div><!-- end .sidebar-window -->
        </div><!-- end #preview-sidebar.preview-sidebar -->



        <!-- Main Content -->
        <div id="content-preview" class="content-preview">
            <div class="content-window">

                <!-- Name && Surname -->
                <div class="title-content">
                    <h1><span  id="name_span"><?php echo esc_html(\ateliercv\AtelierCv::getOptionValue(get_option('atl_cv_first_name'))); ?></span> <span id="surname_span"><?php echo esc_html(\ateliercv\AtelierCv::getOptionValue(get_option('atl_cv_surname')));?></span>  </h1>
                </div>
                <br>

                <!-- Title -->
                <div class="title-qf">
                    <i class="icon-briefcase"></i>
                    <h2><?php esc_html_e('KINH NGHIỆM LÀM VIỆC','ateliercv'); ?></h2>
                </div>

                <!-- Professional Experience -->
                <div id="main-profession" class="main-profession">
				<?php
				global $wpdb;
				global $table_name;
				$table_name = $wpdb->prefix . 'prof_ex';
				$sql = "SELECT * FROM $table_name ORDER BY `start_date` ASC";
				$result = $wpdb->get_results($sql);

				?>
				<?php foreach ( $result as $item ) {
					$date = $item->end_date;
                    $start_date =  $AtelierCv->changeDateMonth($item->start_date,'/');
                    $end_date = ($date == '0000-00-00') ? 'Hiện tại' :  $AtelierCv->changeDateMonth($item->end_date,'/');

                    ?>

                    <!-- Profession -->
                    <div class="container-experience">

                        <div class="circle-box"></div>
                        <label for="table-name"></label>
                        <input type="hidden" id="table-name" name="table-name" value="<?php echo esc_attr($table_name); ?>"/>

                        <!-- Date -->
                        <div class="date-col">
                            <div class="date-box">
                                <span><?php echo esc_html($start_date . ' - ' .  $end_date); ?></span>
                            </div>
                        </div>

                        <!-- Profession -->
                        <div class="experience-col">
                            <div class="content-position">
                                <h2 class="position-title"><?php echo esc_html($item->profession); ?></h2>
                                <p><?php echo esc_html($item->employer . ', ' . $item->prof_city); ?></p>
                                <p class="desc"><?php echo esc_html($item->desc); ?></p>
                            </div>
                        </div>

                        <!-- Delete profession -->
                        <div class="pex-delete">
                            <button class="btn-delete pe-delete" value="<?php echo intval($item->id); ?>"><?php esc_html_e('Xóa','ateliercv'); ?></button>
                        </div>

                    </div><!-- end .container-experience -->

				<?php   } ?>
                </div><!-- end #main-profession.main-profession -->


                <!-- Education Title -->
                <div class="title-edu">
                    <i class="icon-book"></i>
                    <h2><?php esc_html_e('HỌC VẤN VÀ BẰNG CẤP','ateliercv'); ?></h2>
                </div>

                <div id="main-edu" class="main-edu">
				<?php
				$tb_name_school = $wpdb->prefix . 'school_ex';
				$sql2 = "SELECT * FROM $tb_name_school ORDER BY `start_date` ASC";
				$result2 = $wpdb->get_results($sql2);
				foreach ($result2 as $school) {
					?>
                    <div class="container-school">
                        <div class="circle-box"></div>
                        <label for="table-school"></label>
                        <input type="hidden" id="table-school" name="table-school" value="<?php echo esc_attr($tb_name_school);  ?>">

                        <div class="date-col">
                            <div class="date-box">
                                <span><?php echo esc_html($AtelierCv->changeDateMonth($school->start_date,'/') . ' - ' . $AtelierCv->changeDateMonth($school->end_date,'/')); ?></span>
                            </div>
                        </div>
                        <div class="education-col">
                            <div class="content-position">
                                <h2 class="position-title"><?php echo esc_html($school->school_name); ?></h2>
                                <p class="desc"><?php echo esc_html((!empty($school->level)) ? $school->level . '.' : '');  ?> <?php echo esc_html($school->desc);  ?></p>
                                <p><?php echo esc_html($school->school_city); ?></p>
                            </div>
                        </div>

                        <!-- Delete school -->
                        <div class="sch-delete">
                            <button class="edu-delete" value="<?php echo intval($school->id); ?>"><?php esc_html_e('Xóa','ateliercv'); ?></button>
                        </div>

                    </div><!-- end .container-school -->

				<?php } ?>
                </div><!-- end .main-edu -->


                <!-- Languages -->
                <div class="title-edu title-lang">
                    <i class="icon-globe"></i>
                    <h2><?php esc_html_e('NGOẠI NGỮ','ateliercv'); ?></h2>
                </div>

                <div class="main-lang container-lang">
                <?php
                $tb_lang = $wpdb->prefix . 'lang_ex';
                $sql3 = "SELECT * FROM $tb_lang";
                $result3 = $wpdb->get_results($sql3);
                foreach ($result3 as $lang) { ?>

                    <div class="lang-container">
                        <div class="circle-box"></div>
                        <label for="table-lang"></label>
                        <input type="hidden" id="table-lang" name="table-lang" value="<?php echo esc_attr($tb_lang); ?>">

                        <div class="languages-box">
                            <p><?php echo esc_html($lang->lang . ' - ' . $lang->level); ?></p>
                        </div>

                        <!-- Delete language -->
                        <div id="lang-delete">
                            <button class="lang-delete" value="<?php echo intval($lang->id); ?>"><?php esc_html_e('Xóa','ateliercv'); ?></button>
                        </div>

                    </div>
                <?php }  ?>
                </div><!-- end .main-lang -->

                <!-- Certificates -->
                <div class="title-edu curse-title">
                    <i class="icon-attach"></i>
                    <h2><?php esc_html_e('CHỨNG CHỈ, KHÓA HỌC','ateliercv'); ?></h2>
                </div>

                <div class="main-curse curse-container">
                    <?php
                    $tb_curse = $wpdb->prefix . 'cert_ex';
                    $sql4 = "SELECT * FROM $tb_curse";
                    $result4 = $wpdb->get_results($sql4);
                    foreach ( $result4 as $curse ) { ?>
                        <div class="curse-row">
                            <div class="circle-box"></div>
                            <label for="table-curse"></label>
                            <input type="hidden" id="table-curse" name="table-curse" value="<?php echo esc_attr($tb_curse);  ?>">

                            <div class="curse-box">
                                <span><?php echo esc_html($curse->certificate); ?></span>
                            </div>

                            <!-- Delete curse -->
                            <div id="curse-delete">
                                <button class="curse-delete" value="<?php echo intval($curse->id); ?>"><?php esc_html_e('Xóa','ateliercv'); ?></button>
                            </div>

                        </div>
                    <?php }
                    ?>

                </div><!-- end .container-experience -->

                <!-- Skills -->
                <?php
                $skills = get_option('atl_cv_qf_skills');
                if(!empty($skills)) {
                ?>
                    <div class="title-skill">
                        <i class="icon-star"></i>
                        <h2><?php esc_html_e('KỸ NĂNG','ateliercv'); ?></h2>
                    </div>
                    <div class="skill-box">
                        <div class="content-skill">
                            <div class="circle-box"></div>
                            <p><?php echo esc_html($skills); ?></p>
                        </div>
                    </div>
                <?php } ?>

                <!-- Interests -->
                <?php
                $hobbys = get_option('atl_cv_qf_hobby');
                if(!empty($hobbys)) {
                ?>

                    <div class="title-skill">
                        <i class="icon-heart"></i>
                        <h2><?php esc_html_e('SỞ THÍCH','ateliercv'); ?></h2>
                    </div>
                    <div class="skill-box">
                    <div class="content-skill">
                        <div class="circle-box"></div>
                        <p><?php echo esc_html($hobbys); ?></p>
                    </div>
                </div>
                <?php } ?>


                <!-- Privacy Policy -->
                <div class="title-skill">
                    <i class="icon-list-alt"></i>
                    <h2><?php esc_html_e('CHÍNH SÁCH BẢO MẬT','ateliercv'); ?></h2>
                </div>


                <div class="pp-container">
                    <div class="pp-box">
                        <div class="circle-box"></div>
                        <span><?php
			                $prpol = 'Tôi đồng ý cho phép xử lý dữ liệu cá nhân của tôi cho các mục đích cần thiết của quá trình tuyển dụng (theo Luật Bảo vệ dữ liệu cá nhân ngày 10 tháng 5 năm 2018 (Công báo 2018, mục 1000) và theo Quy định của Nghị viện và Hội đồng Châu Âu (EU) 2016/679 ngày 27 tháng 4 năm 2016 về bảo vệ cá nhân liên quan đến việc xử lý dữ liệu cá nhân và về việc tự do lưu chuyển dữ liệu đó và bãi bỏ Chỉ thị 95/46/EC (GDPR)).';
			                $privacy = !empty(get_option('qf_privacy_policy')) ? get_option('qf_privacy_policy') : $prpol; echo esc_html($privacy); ?>
                            </span>
                    </div>
                </div>
            </div><!-- end .content-window -->
        </div><!-- end #content-preview.content-preview -->

    </div><!-- end #preview-body.preview-body -->

</div>
