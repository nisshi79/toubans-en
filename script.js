$(function () {
    $('[name="block_size_radio"]:radio').change( function() {
        if($('#block_size_day').prop('checked')){
            $('#avaliable_for_month').css("visibility","hidden");
            $('#avaliable_for_month').slideUp();
            $('#avaliable_for_day').css("visibility","visible");
            $('#avaliable_for_day').slideDown();

            $('.notification_for_day').fadeIn();
            $('.notification_for_week').hide();
            $('.notification_for_month').hide();

        } else if ($('#block_size_week').prop('checked')) {
            $('#avaliable_for_day').slideUp();
            $('#avaliable_for_month').slideUp();

            $('.notification_for_day').hide();
            $('.notification_for_week').fadeIn();
            $('.notification_for_month').hide();

        } else if ($('#block_size_month').prop('checked')) {
            $('#avaliable_for_day').css("visibility","hidden");
            $('#avaliable_for_day').slideUp();
            $('#avaliable_for_month').css("visibility","visible");
            $('#avaliable_for_month').slideDown();


            $('.notification_for_day').hide();
            $('.notification_for_week').hide();
            $('.notification_for_month').fadeIn();
        }
    });

    $('[name=notfication_timing_number_sign]').change( function() {
        var selectVal = $('[name=notfication_timing_number_sign]').val();
        if(selectVal == '-1'){
            $('#notfication_timing_avsolute_value').fadeIn();
        } else {
            $('#notfication_timing_avsolute_value').fadeOut();
        }
    });

    //最初は全てのパネルを非表示に
    $('.notification_for_month').hide();
    $('.notification_for_week').hide();

    /*$('[name="block_size_radio"]:radio').change( function(){
                //選択したパネルを開く
                $('.notification_date_container').show();
    })*/

   /* $(".text_area").height(30);//init
    $(".text_area").css("lineHeight","20px");//init

    $(".text_area").on("input",function(evt){
        if(evt.target.scrollHeight > evt.target.offsetHeight){
            $(evt.target).height(evt.target.scrollHeight);
        }else{
            var lineHeight = Number($(evt.target).css("lineHeight").split("px")[0]);
            while (true){
                $(evt.target).height($(evt.target).height() - lineHeight);
                if(evt.target.scrollHeight > evt.target.offsetHeight){
                    $(evt.target).height(evt.target.scrollHeight);
                    break;
                }
            }
        }
    });
*/
});