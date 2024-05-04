e2p = s => (s+'').replace(/\d/g, d => '۰۱۲۳۴۵۶۷۸۹'[d]);

function fallbackCopyTextToClipboard(text) {
    var textArea = document.createElement("textarea");
    textArea.value = text;

    // Avoid scrolling to bottom
    textArea.style.top = "0";
    textArea.style.left = "0";
    textArea.style.position = "fixed";

    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();

    try {
        var successful = document.execCommand('copy');
        if (successful) {
            toastr.options.positionClass = 'toast-bottom-left';
            toastr.success('کپی شد');
        }
        // console.log('Fallback: Copying text command was ' + msg);
    } catch (err) {
        console.error('Oops, unable to copy', err);
    }

    document.body.removeChild(textArea);
}

function copyTextToClipboard(text) {
    if (!navigator.clipboard) {
        fallbackCopyTextToClipboard(text);
        return;
    }
    navigator.clipboard.writeText(text).then(function() {
        toastr.options.positionClass = 'toast-bottom-left';
        toastr.success('کپی شد');
        // console.log('Async: Copying to clipboard was successful!');
    }, function(err) {
        console.error('Could not copy text: ', err);
    });
}
