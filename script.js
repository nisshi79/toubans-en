

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

    function GetQueryString()
    {
        var result = {};
        if( 1 < window.location.search.length )
        {
            // 最初の1文字 (?記号) を除いた文字列を取得する
            var query = window.location.search.substring( 1 );

            // クエリの区切り記号 (&) で文字列を配列に分割する
            var parameters = query.split( '&' );

            for( var i = 0; i < parameters.length; i++ )
            {
                // パラメータ名とパラメータ値に分割する
                var element = parameters[ i ].split( '=' );

                var paramName = decodeURIComponent( element[ 0 ] );
                var paramValue = decodeURIComponent( element[ 1 ] );

                // パラメータ名をキーとして連想配列に追加する
                result[ paramName ] = paramValue;
            }
        }
        return result;
    }

    var toubanInfos=GetQueryString();

    $('#group_id').val(toubanInfos['groupId']);

    if('tableId' in toubanInfos){
        fetch('getTouban.php?tableId='+toubanInfos['tableId'])
            .then(response => {
                return response.json(); // ReadableStream -> String への変換
            })
            .then(json => {
                console.log(json);
                fillInputs(json);
                // <form name = "tableInfo" method = "POST" action="input.php">
                // ↑これを、
                // <form name = "tableInfo" method = "POST" action="update.php">
                // ↑こうする
                $('form[name="tableInfo"]').attr('action', 'update.php');
                var titleText = $('#title').text();
                titleText = titleText.replace("初期設定", "設定変更");
                $('#title').text(titleText);

            });
        $("<input>", {
            type: 'hidden',
            id: 'table_id',
            name: 'table_id',
            value: toubanInfos['tableId']
        }).appendTo('#table_id_container');
    }



    function fillInputs(json) {

        if(json.table.top_textarea=='明日の当番のお知らせです' || json.table.top_textarea=='今日の当番のお知らせです'){
            $('#top_textarea_select').val(json.table.top_textarea);

        }else {
            $('#lower_textarea_select').val('挨拶文を自分で入力する）');
            $('#top_textarea').val(json.table.top_textarea);
            $('#top_textarea').show();
        }

        if(json.table.lower_textarea=='確認しておいてください。'　|| json.table.lower_textarea=='よろしくお願いします。'){
            $('#lower_textarea_select').val(json.table.lower_textarea);
        }else {
            $('#lower_textarea_select').val('（締めの文を自分で入力する）');
            $('#lower_textarea').val(json.table.lower_textarea);
            $('#lower_textarea').show();
        }

        /*$('#top_textarea').val(json.table.top_textarea);
        $('#lower_textarea').val(json.table.lower_textarea);*/
        $('#notification_time').val(json.table.notification_time);



        for (let i = 0; i < json.role.length; i++) {
            $('#roles_list_' + i).val(json.role[i].role);
            if (i === json.role.length - 1) break;
            $('#roles_list_add').click();
        }

        for (let i = 0; i < json.member.length; i++) {
            $('#members_list_' + i).val(json.member[i].member);
            if (i === json.member.length - 1) break;
            $('#members_list_add').click();
        }
        switch (json.table.notification_span) {
            case 0: //毎日
                $('#notification_span').val(0);
                $('.notification_dsoW').fadeIn();
                for (let i = 0; i < 7; i++) {
                    var bool = $.inArray(String(i), json.table.notification_date.split(','));
                    if ($.inArray(String(i), json.table.notification_date.split(',')) >= 0) {
                        if(i==0)$('#checkbox_sunday').prop("checked", true);
                        if(i==1)$('#checkbox_monday').prop("checked", true);
                        if(i==2)$('#checkbox_tuesday').prop("checked", true);
                        if(i==3)$('#checkbox_wednesday').prop("checked", true);
                        if(i==4)$('#checkbox_thursday').prop("checked", true);
                        if(i==5)$('#checkbox_friday').prop("checked", true);
                        if(i==6)$('#checkbox_saturday').prop("checked", true);
                    }
                }

                break;

            case 1: //月
                $('#notification_span').val(1);
                $('.notification_doM').fadeIn();
                for (let i = 1; i <= 31; i++) {
                    if (i == json.table.notification_date) $('#notification_doM').val(i);
                }
                break;

            case 2: //週
                $('#notification_span').val(2);
                $('.notification_dsoW').fadeIn();
                for (let i = 0; i < 7; i++) {

                    if (json.table.notification_date == i){
                        if(i==0)$('#radio_sunday').prop("checked", true);
                        if(i==1)$('#radio_monday').prop("checked", true);
                        if(i==2)$('#radio_tuesday').prop("checked", true);
                        if(i==3)$('#radio_wednesday').prop("checked", true);
                        if(i==4)$('#radio_thursday').prop("checked", true);
                        if(i==5)$('#radio_friday').prop("checked", true);
                        if(i==6)$('#radio_saturday').prop("checked", true);
                    }
                }
            default:
                break;
        }
    }

    const isIOS = /iP(hone|(o|a)d)/.test(navigator.userAgent)

    if(isIOS){
        $('.alert-for-ios').fadeIn();
    }

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

    //submit close


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