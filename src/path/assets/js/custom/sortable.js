$(document).ready(function () {
    $('table tbody').sortable({
        handle:'.handle-order',
        group: "sortable-table",
        update: function (event,ui) {
            $(this).children().each(function (index) {
                if($(this).attr('data-order') != (index+1)){
                    $(this).attr('data-order',(index+1)).addClass('updated-order')
                }
            })
            ajaxUpdateOrder();
        },
        start: function(event,ui){
            ui.placeholder.height(ui.item.height());
        },
        axis: 'y',
        animation: 150,

    });

    $('.sortable').sortable({
        handle:'.handle-order',
        group: "sortable-card",
        update: function (event,ui) {
            $(this).children().each(function (index) {
                if($(this).attr('data-order') != (index+1)){
                    $(this).attr('data-order',(index+1)).addClass('updated-order')
                }
            })
            ajaxUpdateOrder();
        },
        start: function(event,ui){
            ui.placeholder.height(ui.item.height());
        },
        axis: 'y',
        animation: 150,

    });

    function ajaxUpdateOrder() {
        var orders = [];
        $('.updated-order').each(function () {
            let temp = {};
            temp['id']= $(this).attr('data-index');
            temp['order'] = parseInt($(this).attr('data-order'));
            temp['type'] = $(this).attr('data-type');
            orders.push(temp);
        });
        $.ajax({
            url: sortUrl,
            method: 'POST',
            dataType: 'json',
            data:{
                data: sortData,
                orderList: JSON.stringify(orders),
                type: sortType,
                "_token": sortToken,
            },success: function (response) {
                toastr.options.positionClass = 'toast-bottom-left';
                toastr.success('با موفقیت ذخیره شد');
            },error: function () {
                toastr.options.positionClass = 'toast-bottom-left';
                toastr.error('خطایی در بروزرسانی رخ داد');
            }
        })
    }

});
