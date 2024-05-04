$(".unpublish-comment-btn, .publish-comment-btn, .delete-comment-btn").on('click',function(){
    var status = $(this).attr('data-status');
    var comment_row = $(this).closest('.comment-table-row');
    var comment_id = comment_row.attr('data-comment-id');

    if (status == 'delete') {
        if (!confirm('آیا از حذف کامل این نظر اطمینان دارید؟ با حذف این نظر دیگر امکان برگشت آن وجود ندارد')) {
            return false;
        }
    }

    $.ajax({
        type: "POST",
        url: change_comment_status_url,
        data: {
            comment_id: comment_id,
            publish_status: status,
            "_token": csrf_token,
        },
        cache: false,
        timeout: (30 * 1000),
        async: true,
        success: function (data) {
            toastr.success(data.message);

            if (status == 'delete') {
                comment_row.slideUp();
            }

            if (status == 'publish') {
                comment_row.find('.publish-comment-btn').hide();
                comment_row.find('.unpublish-comment-btn').show();
                comment_row.addClass('bg-light-success');
                comment_row.removeClass('bg-light-dark');
            }

            if (status == 'unpublish') {
                comment_row.find('.unpublish-comment-btn').hide();
                comment_row.find('.publish-comment-btn').show();
                comment_row.addClass('bg-light-dark');
                comment_row.removeClass('bg-light-success');


            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            var response = xhr.responseJSON;
            toastr.error(response.message);
        }
    });


});
