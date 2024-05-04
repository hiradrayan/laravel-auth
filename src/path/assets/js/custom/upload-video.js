$('#video').change(function (e) {
    $('.progress').show();


    let file = e.target.files[0];
    var startUpload = true;

    if (file.type != 'video/mp4' && file.type != 'video/quicktime') {
        toastr.options.positionClass = 'toast-top-right';
        toastr.error('فرمت فایل نامعتبر است. فرمت‌های مجاز: 	' +
            'mov ،avi ،wmv ،mp4');
        $("#video").val(null);
        $('.progress').hide();
        return null;
    }

    let options = {
        "url": `https://napi.arvancloud.ir/vod/2.0/channels/${channelId}/files`,
        "authorization": `${authorization}`,
        "acceptLanguage": "en",
        "uuid": file.name + file.size + file.lastModified
    };

    let upload = new tus.Upload(file, {
        // resume: true,
        chunkSize: 1048576, // 1MB
        endpoint: options.url,
        retryDelays: [0, 500, 1000, 1500, 2000, 2500],
        headers: {
            'Authorization': options.authorization,
            'Accept-Language': options.acceptLanguage
        },
        metadata: {
            filename: file.name,
            filetype: file.type,
        },
        onError: function (error) {
            toastr.error('خطایی رخ داده. لطفا دوباره تلاش فرمایید. (کد۲)');
            console.log("Failed because: " + error)
        },
        onProgress: function (bytesUploaded, bytesTotal) {
            if (startUpload) {
                $(".progress").empty();
                $('#form_submit').addClass('disabled');
                $('.progress').append('<div class="progress-bar" role="progressbar" style="width: percentage%;" aria-valuenow="$(percentage)" aria-valuemin="0" aria-valuemax="100"></div>');
                startUpload = false;
            }
            var percentage = (bytesUploaded / bytesTotal * 100).toFixed(0);
            // console.log(bytesUploaded, bytesTotal, percentage + "%");
            $('.progress-bar').attr("aria-valuenow", percentage);
            $('.progress-bar').width(percentage + '%');
            $('.progress-bar').html(percentage + '%');
        },
        onSuccess: function () {
            // console.log("Download %s from %s", upload.file.name, upload.url);
            toastr.success('آپلود شد.');
            saveVideo(upload);
        },
    });
    upload.start();
});

function saveVideo(upload) {
    param = {
        video_url: upload.url,
        video_title: upload.file.name,
        type: 'file_upload',
        "_token": csrf_token,
    };
    $.ajax({
        type: "POST",
        url: save_video_url,
        data: param,
        cache: false,
        timeout: (site_timeout * 1000),
        async: true,
        success: function (data) {
            $('#form_submit').removeClass('disabled');
            $('#vod_id').val(data.id);
            $('#video').val(null);
            toastr.success('ویدئو درحال پردازش است.');
            getVideo();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            toastr.error('خطا در ارسال ویدئو ، لطفا پارامتر های ارسالی خود را چک نمایید.');
        }
    });
}

function getVideo() {
    vId = $('#vod_id').val();
    $.ajax({
        type: "POST",
        url: get_video_url,
        data: {
            vod_id: vId,
            "_token": csrf_token,
        },
        cache: false,
        timeout: (site_timeout * 1000),
        async: true,
        success: function (data) {
            let error = 0;
            $(".video_preview").empty();
            if(! data.id){
                $(".video_preview").append('<p style="color: red;">تبدیل ناموفق ویدیو<br>' +
                    'لطفا دوباره تلاش کنید و/یا فایل ویدیو را بررسی نمایید (ممکن است فایل ویدیوی شما دچار اشکال فنی باشد)</p>');
                error = 1;
            }
            available = data.available;
            // console.log(available);
            if(available){
                $(".video_preview").append('<div class="preview_container">\n' +
                    '  <img src="'+ data.thumbnail_url+'" class="preview_image">\n' +
                    '  <div class="preview_overlay">\n' +
                    '  <a target="_blank" href="'+ data.player_url+'" class="preview_icon" title="پخش">\n' +
                    '    <i class="fa fa-play fa-2x"></i>\n' +
                    '  </a>\n' +
                    '  </div>'+
                    '<p style="font-size: 0.8em;">حجم فایل اصلی (آپلود شده): '+Math.round(((data.file_info.general.size)/(1024*1024)*100))/100+'MB' +
                    '<br> مجموع حجم (شامل فایل اصلی و نسخه‌های تبدیل‌شده): '+ data.directory_size +' </p> '

                );
                $(".video_preview").append( '<p style="font-size: 0.8em;">  لینک در آروان:  <a href="https://npanel.arvancloud.ir/vod/videos/'+ data.id + '" target="_blank">' + data.title + '</a><br>' +
                    'لینک فایل اصلی آپلود شده:  <a href="'+data.video_url+'" target="_blank"> مشاهده <span class="fa fa-play-circle"></span> </a></p>');

                (data.convert_info).forEach(function (item,index) {
                    $(".video_preview").append('<p style="font-size: 0.8em;">' + 'بیت‌ریت: <br> تصویر: '+ item.video_bitrate + 'kbps<br> صدا: '+ item.audio_bitrate + '<br> رزولوشن: ' + item.resolution + '<br> <a target="_blank" href="'+data.mp4_videos[index]+'">لینک ویدیو <span class="fa fa-play-circle"></span></a> </p>');
                });
                $(".video_preview").append('</p>');
            }else if(!error){
                $(".video_preview").append('<i class="fa fa-spinner fa-spin fa-3x"></i><br> <h5 style="color: red;">   ویديو آپلود شده در حال پردازش است.  <br> درصورت تمایل میتوانید درس را ذخیره کرده و بعدا برای مشاهده پیش‌نمایش ویديو مراجعه فرمایید. </h5>')
                setTimeout(function () {
                    getVideo();
                },20000);
            }
        }
    });

}

