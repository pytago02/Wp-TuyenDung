jQuery(document).ready(function($) {
    // Xem trước CV
    $('.preview-cv-btn').on('click', function(e) {
        e.preventDefault();
        
        var cvId = $('select[name="selected_cv"]').val();
        if (!cvId) {
            alert('Vui lòng chọn CV trước khi xem!');
            return;
        }

        // Mở modal xem trước CV
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'preview_cv',
                cv_id: cvId,
                nonce: cv_preview.nonce
            },
            success: function(response) {
                if (response.success) {
                    // Hiển thị CV trong modal
                    showPreviewModal(response.data.html);
                }
            }
        });
    });
});

function showPreviewModal(cvHtml) {
    // Tạo và hiển thị modal
    var modal = $('<div class="cv-preview-modal">' +
        '<div class="modal-content">' +
            '<span class="close">&times;</span>' +
            '<div class="cv-content">' + cvHtml + '</div>' +
        '</div>' +
    '</div>');
    
    $('body').append(modal);
    
    // Đóng modal
    modal.find('.close').on('click', function() {
        modal.remove();
    });
} 