$(function () {
    /*k
    $('#spans_list_0').daterangepicker({
        opens: 'right',
        autoUpdateInput: false,
        locale:{
            format: "YYYY-MM-DD"
        }
    }, function(start, end, label) {
        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });*/

    /*$('#spans_list').on('DOMSubtreeModified propertychange', function() {
        var countA = $('#spans_list li').length;
        var countBuf = countA-1;
        console.log(countBuf);
        $('#spans_list_'+countBuf).daterangepicker({
            autoUpdateInput : false,
            autoApply: true,
            opens: 'right',
            locale:{
                format: "YYYY-MM-DD"
            }
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
    });*/




        $('[id^=spans_list_]').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
        });

        $('[id^=spans_list_]').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });


});
