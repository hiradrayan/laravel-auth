e2p = s => (s+'').replace(/\d/g, d => '۰۱۲۳۴۵۶۷۸۹'[d]);

function timerCountDown() {
    // Set the date we're counting down to
    var nowDate = new Date (), countDownDate = new Date ( nowDate );
    countDownDate.setMinutes ( nowDate.getMinutes() + 2 );
    // countDownDate.setSeconds ( nowDate.getSeconds() + 10 );

    $("#resend_sms_timer").html('۱:۵۹');
    // Update the count down every 1 second
    var x = setInterval(function() {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        $("#resend_sms_timer").html(e2p(minutes) + ":" + e2p((seconds >= 10 ? seconds : "0"+seconds)));

        // If the count down is over, write some text
        if (distance <= 1000) {
            clearInterval(x);
            $("#resend_sms_timer_block").slideUp();
            $("#resend_sms_link").slideDown();
        }
    }, 1000);
}

function resendOtp () {

    $.ajax({
        type: "POST",
        url: resendOtpUrl,
        data: {
            mobile: mobile,
            "_token": csrf_token,
        },
        cache: false,
        timeout: (30 * 1000),
        async: true,
        success: function (data) {
            toastr.success(data.message);

            $("#resend_sms_timer_block").slideDown();
            $("#resend_sms_link").slideUp();
            timerCountDown();

        },
        error: function (xhr, ajaxOptions, thrownError) {
            var response = xhr.responseJSON;
            toastr.error(response.message);

            $("#resend_sms_timer_block").slideDown();
            $("#resend_sms_link").slideUp();

            timerCountDown();

        }
    });

}
