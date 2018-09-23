

$(function () {
    $('[name="notification_span"]').change( function() {

        var selectVal = $('[name="notification_span"]').val();

        if(selectVal == '0'){
            /*$('#avaliable_for_month').css("visibility","hidden");
            $('#avaliable_for_month').slideUp();
            $('#avaliable_for_day').css("visibility","visible");
            $('#avaliable_for_day').slideDown();*/

            $('.notification_dsoW').fadeIn();
            $('.notification_doM').hide();

        } else if(selectVal == '1') {
            /*$('#avaliable_for_day').slideUp();
            $('#avaliable_for_month').slideUp();*/

            $('.notification_dsoW').hide();
            $('.notification_doM').fadeIn();

        }
    });
    $('[name="top_textarea_select"]').change( function() {
        var selectVal = $('[name="top_textarea_select"]').val();
        if(selectVal == "（挨拶文を自分で入力する）"){
            $('#top_textarea').fadeIn();
        }else {
            $('#top_textarea').hide();

        }
    });

    $('[name="lower_textarea_select"]').change( function() {
        var selectVal = $('[name="lower_textarea_select"]').val();
        if(selectVal == "（締めの文を自分で入力する）"){
            $('#lower_textarea').fadeIn();
        }else {
            $('#lower_textarea').hide();

        }
    });

    /*$('[name=notfication_timing_number_sign]').change( function() {
        var selectVal = $('[name=notfication_timing_number_sign]').val();
        if(selectVal == '-1'){
            $('#notfication_timing_avsolute_value').fadeIn();
        } else {
            $('#notfication_timing_avsolute_value').fadeOut();
        }
    });*/
    $('#lower_textarea').hide();

    $('#top_textarea').hide();
    //最初は全てのパネルを非表示に
    $('.notification_doM').hide();

    $('.modal').modaal({
        hide_close: 'true'
    });
    $('#modaal_close').on('click',function () {
        $('.modal').modaal('close');
    })
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