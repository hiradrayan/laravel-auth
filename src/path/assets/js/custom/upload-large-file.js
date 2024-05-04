let browseFile = $('#browseFile');
let resumable = new Resumable({
    target: route,
    query:{_token: csrf_token} ,// CSRF token
    fileType: file_types ?? ['mp4'],
    chunkSize: 1024 * 1024  * 5, // default is 1*1024*1024, this should be less than your maximum limit in php.ini
    headers: {
        'Accept' : 'application/json'
    },
    testChunks: false,
    throttleProgressCallbacks: 1,
});

resumable.assignBrowse(browseFile[0]);

resumable.on('fileAdded', function (file) { // trigger when file picked


    fileSize = parseInt(file.size / (1024*1024));
    if (file.size < max_file_size) {
        showProgress();
        resumable.upload(); // to actually start uploading.
        $("#form_submit_btn").addClass('disabled');
        $("#form_submit_btn").text('در حال آپلود...');
    } else  {
        toastr.error('حجم فایل انتخابی شما '+ fileSize +'mb می‌باشد که بیشتر از سقف '+ max_file_size/(1024*1024) +'mb است.');
    }
});

resumable.on('fileProgress', function (file) { // trigger when file progress update
    updateProgress(Math.floor(file.progress() * 100));
});

resumable.on('fileSuccess', function (file, response) { // trigger when file upload complete
    response = JSON.parse(response)
    $('#videoPreview').attr('src', response.path);
    progress.hide();
    $("#form_submit_btn").removeClass('disabled');
    $("#form_submit_btn").text('ذخیره');
    toastr.success('با موفقیت آپلود شد');

});

resumable.on('fileError', function (file, response) { // trigger when there is any error
    toastr.error('خطایی در آپلود فایل رخ داد');
});


let progress = $('.progress');
function showProgress() {
    progress.find('.progress-bar').css('width', '0%');
    progress.find('.progress-bar').html('0%');
    progress.find('.progress-bar').removeClass('bg-success');
    progress.show();
}

function updateProgress(value) {
    progress.find('.progress-bar').css('width', `${value}%`)
    progress.find('.progress-bar').html(`${value}%`)
}

function hideProgress() {
    progress.hide();
}
