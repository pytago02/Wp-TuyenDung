jQuery(document).ready(function(){


    /* Button hide and show all data personal */
    jQuery('#dp-hidden-submit').hide();

    jQuery('#pd-all-info').on('click',function (e){

        e.preventDefault();
        jQuery('#dp-hidden-submit').slideToggle(1000);
    });

    function liveInput($element,$preview) {

        jQuery($element).on('input',function () {
            let $val = jQuery(this).val();
            jQuery($preview).html($val);
        });

    }

    /* Upload Media */
    function uploadMediaFIleHtml(val1,val2,val3) {
        var uploadMedia;

        jQuery(val1).on('click', function (e) {
            e.preventDefault();
            if(uploadMedia) {
                uploadMedia.open();
                return;
            }

            uploadMedia = wp.media.frames.file_frame = wp.media({
                title: 'Upload Media',
                button: {
                    text: 'Use this media'
                },
                multiple: false
            });

            uploadMedia.on('select',function() {
                attachment = uploadMedia.state().get('selection').first().toJSON();
                jQuery(val2).val(attachment.url);
                //jQuery(val3).css('background-image','url('+attachment.url+')');
                jQuery(val3).attr("src",  attachment.url)
            });

            uploadMedia.open();

        });
    }

    jQuery('#person_image_delete').on('click',function() {
        jQuery('#prv-img-author').attr('src','');
        jQuery('#person_image_hidden').attr('value','');
    });

    // Image
    uploadMediaFIleHtml('#person_image','#person_image_hidden','#prv-img-author');

    /* Name && Surname */
    liveInput('#first_name','#prv_name, #name_span');
    liveInput('#surname','#prv_surname, #surname_span');

    /* Email && Tel */
    liveInput('#email','#prv-email');
    liveInput('#telephone','#prv-tel');

    /* Address */
    liveInput('#pd-address','#prv-address');
    liveInput('#address_code','#prv-code');
    liveInput('#city','#prv-city');

    /* Date Birth && Place Birth */
    liveInput('#date_birth','#prv-date-birth');
    liveInput('#place_birth','#prv-place-birth');

    /* Driving License && Gender */
    liveInput('#driving_license','#prv-driving-license');
    liveInput('#gender','#prv-gender');

    /* Nationality && Condition */
    liveInput('#nationality','#prv-nationality');
    liveInput('#condition','#prv-condition');

    /* Linkedin && Website */
    liveInput('#linkedin','#prv-linkedin');
    liveInput('#website','#prv-website');


    /!* Remove Profession *!/
    jQuery( ".pe-delete" ).each(function() {
        jQuery(this).on('click',function() {
            var $id = jQuery( this ).val();
            var $table_name = jQuery('#table-name').val();
            var data = {
                'action': 'my_action',
                'id': $id,
                'table-name': $table_name
            }
            jQuery.post(ajaxurl, data, function (response) {

                location.reload();

            });
        });
    });

    /!* Remove Education *!/
    jQuery( ".edu-delete" ).each(function() {
        jQuery(this).on('click',function() {
            var $id = jQuery( this ).val();
            var $table_name = jQuery('#table-school').val();
            var data = {
                'action': 'my_edu_action',
                'id': $id,
                'table-school': $table_name
            }
            jQuery.post(ajaxurl, data, function (response) {

                location.reload();

            });

        });
    });

    /!* Remove Languages *!/
    jQuery( ".lang-delete" ).each(function() {
        jQuery(this).on('click',function() {
            var $id = jQuery( this ).val();
            var $table_name = jQuery('#table-lang').val();
            var data = {
                'action': 'my_lang_action',
                'id': $id,
                'table-lang': $table_name
            }
            jQuery.post(ajaxurl, data, function (response) {

                location.reload();

            });

        });
    });

    /!* Remove Curses *!/
    jQuery( ".curse-delete" ).each(function() {
        jQuery(this).on('click',function() {
            var $id = jQuery( this ).val();
            var $table_name = jQuery('#table-curse').val();
            var data = {
                'action': 'my_curse_action',
                'id': $id,
                'table-curse': $table_name
            }
            jQuery.post(ajaxurl, data, function (response) {

                location.reload();

            });

        });
    });


    /* Check if div is empty  */
    function notEmpty($empty,$hide) {
        let $lengthCont = jQuery($empty).length;
        if($lengthCont == 0 ) {
            jQuery($hide).hide();
        }
    }

    jQuery('#atl_cv_to_present').on('change',function() {
        if(this.checked) {
            jQuery('input.pe-end-date').prop( "disabled", true );
        } else {
            jQuery('input.pe-end-date').prop( "disabled", false );
        }

    });

    jQuery('#atl_cv_square_img').on('change',function() {
        if(this.checked) {
            jQuery('#prv-img-author').css({'border-radius':'0','transition': '700ms'});
        } else {
            jQuery('#prv-img-author').css({'border-radius':'50%','transition': '700ms'});
        }

    });



    // Languages
    notEmpty('.lang-container','.container-lang,.title-lang');

    // Certificate
    notEmpty('.curse-row','.curse-container,.curse-title');

    jQuery('.color-field').wpColorPicker();


    /**
     * Preview Live Color
     * @param id
     * @param idPrv
     * @param styles
     */
    function colorLiveBgPrv(id, idPrv,styles) {
        jQuery('#sidebar_bg_color').wpColorPicker(
            'option',
            'change',
            function(e) {
                jQuery('#preview-sidebar').css('background-color' , e.target.value)
            }
        );
    }

    function colorLiveFontPrv() {
        jQuery('#atl_cv_font_color').wpColorPicker(
            'option',
            'change',
            function(e) {
                jQuery('.preview-sidebar, h2.atl-prv-title').css('color',  e.target.value);
                jQuery('.image-box img').css('border', '3px solid ' + e.target.value);
                jQuery('#prv-img-author').css('transition', '0');
            }
        );
    }

    colorLiveFontPrv();

    // Background color Sidebar
    colorLiveBgPrv();

}) ;


function pdf() {
    const element = document.getElementById('preview-body');
    html2pdf(element);
}
