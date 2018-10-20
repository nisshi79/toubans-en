

$(function () {
   /* $('#spans_list_add').on("click", function () {
        $('.date_range_input').daterangepicker({
            opens: 'left'
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
    });*/

    //jquery使うバージョン

   /* $(".text_area").height(21);//init
    $(".text_area").css("lineHeight","20px");//init*/





    $('.notification_dsoW').hide();
    $('.notification_doM').hide();
    $('.notification_doW').hide();

    $('[name="notification_span"]').change( function() {

        var selectVal = $('[name="notification_span"]').val();

        if(selectVal == '0'){
            /*$('#avaliable_for_month').css("visibility","hidden");
            $('#avaliable_for_month').slideUp();
            $('#avaliable_for_day').css("visibility","visible");
            $('#avaliable_for_day').slideDown();*/
            $('.notification_doW').hide();
            $('.notification_doM').hide();
            $('.notification_dsoW').fadeIn();

        } else if(selectVal == '1') {
            /*$('#avaliable_for_day').slideUp();
            $('#avaliable_for_month').slideUp();*/
            $('.notification_doW').hide();
            $('.notification_dsoW').hide();
            $('.notification_doM').fadeIn();

        }else if(selectVal == '2'){
            $('.notification_dsoW').hide();
            $('.notification_doM').hide();
            $('.notification_doW').fadeIn();

        }else if(selectVal == '3'){
            $('.notification_dsoW').slideUp();
            $('.notification_doM').slideUp();
            $('.notification_doW').slideUp();
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


    //$('.checkbox').attr('required',true);

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


   ///////////////////
    // varidation
    /////////////////
   /* rules: {
        mytext: { required: true }
    }
    $('form').validate();*/

   //////////////////////
    // date-picker Initiarization
    ////////////////////

    /*$('input[name="daterange"]').daterangepicker({
            startDate: '<%= @current_date_range.first.strftime("%Y-%m-%d") %>',
            endDate: '<%= @current_date_range.last.strftime("%Y-%m-%d") %>',
            format:'YYYY/MM/DD',
            showDropdowns: false,
            ranges: {
                '直近30日': [moment().subtract('days', 29), moment()],
                '今月': [moment().startOf('month'), moment().endOf('month')],
                '先月': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
            },
            opens: 'left',
            locale: {
                applyLabel: '反映',
                cancelLabel: '取消',
                fromLabel: '開始日',
                toLabel: '終了日',
                weekLabel: 'W',
                customRangeLabel: '自分で指定',
                daysOfWeek: moment.weekdaysMin(),
                monthNames: moment.monthsShort(),
                firstDay: moment.localeData()._week.dow
            },
        },
        function(s, e){
            console.log(s)
            console.log(e)
        });*/
    /*$(".text_area").on("input",function(evt){
        if(evt.target.scrollHeight > evt.target.offsetHeight){
            $(evt.target).height(evt.target.scrollHeight);
        }else{
            var lineHeight = Number($(evt.target).css("lineHeight").split("px")[0]);
            while (true){
                $(evt.target).height($(evt.target).height() - lineHeight);
                if(evt.target.scrollHeight > evt.target.offsetHeight){
                    $(evt.target).height(evt.target.scrollHeight);
                }
                break;
            }
        }
    });*/

    /*var ta = document.querySelector('.text_area');
   /!* ta.addEventListener('focus', function(){
        autosize(ta);
    });*!/
    ta.style.display = 'none';
    autosize(ta);
    ta.style.display = '';
    autosize.update(ta);*/
});