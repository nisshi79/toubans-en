window.onload = function (data) {
    if (navigator.userAgent.indexOf("Line") !== -1) {
        liff.init(function (data) {
            initializeApp(data);
        });
    }
    else {
        fetch('getToubanList.php?groupId=test')
            .then(response => {
                return response.json(); // ReadableStream -> String への変換
            })
            .then(json => {
                json.forEach(function (touban) {
                    $('.toubanList')
                        .append(`<li><a class="black_font large_font">${touban.role[0].role}: </a><a class="btn" href="mainForm.php?groupId=test&tableId=${touban.table.id}">設定変更</a> <a id="${touban.table.id}" class="btn touban_del" href="javascript:void(0)">削除</a></li>`);
                    $('.toubanList').off('click');
                    $('.toubanList').on('click','li .touban_del', function () {
                        if(window.confirm('本当によろしいですか？')){
                            fetch('delTouban.php?toubanId='+$(this).attr('id')+'&groupId=test')
                                .then(response => {
                                    return response.json(); // ReadableStream -> String への変換
                                })
                                .then(json => {
                                    $('.toubanList').empty();
                                    json.forEach(function (touban) {
                                        $('.toubanList')
                                            .append(`<li><a class="black_font large_font">${touban.role[0].role}: </a><a class="btn" href="mainForm.php?groupId=test&tableId=${touban.table.id}">設定変更</a> <a id="${touban.table.id}" class="btn touban_del" href="javascript:void(0)">削除</a></li>`);
                                    });
                                });;
                        }
                    });
                });
            });
        $('.add_touban').attr('href', 'mainForm.php?groupId=test');



    }
};

function initializeApp(data) {
    function isset( data ){
        return ( typeof( data ) != 'undefined' );
    }

    var lineId;
    if(isset(data.context.userId))lineId=data.context.userId;
    if(isset(data.context.roomId))lineId=data.context.roomId;
    if(isset(data.context.groupId))lineId=data.context.groupId;

    console.log(lineId);

    $('.add_touban').attr('href', 'mainForm.php?groupId='+lineId);

    fetch('getToubanList.php?groupId='+lineId)
        .then(response => {
            return response.json(); // ReadableStream -> String への変換
        })
        .then(json => {
            json.forEach(function (touban) {
                $('.toubanList')
                    .append(`<li><a class="black_font large_font">${touban.role[0].role}: </a><a class="btn" href="mainForm.php?groupId=${lineId}&tableId=${touban.table.id}">設定変更</a> <a id="${touban.table.id}" class="btn touban_del" href="javascript:void(0)">削除</a></li>`);
                $('.toubanList').off('click');
                $('.toubanList').on('click','li .touban_del', function () {
                    if(window.confirm('本当によろしいですか？')){
                        fetch('delTouban.php?toubanId='+$(this).attr('id')+'&groupId='+lineId)
                            .then(response => {
                                return response.json(); // ReadableStream -> String への変換
                            })
                            .then(json => {
                                $('.toubanList').empty();
                                json.forEach(function (touban) {
                                    $('.toubanList')
                                        .append(`<li><a class="black_font large_font">${touban.role[0].role}: </a><a class="btn" href="mainForm.php?groupId=${lineId}&tableId=${touban.table.id}">設定変更</a> <a id="${touban.table.id}" class="btn touban_del" href="javascript:void(0)">削除</a></li>`);
                                });
                            });;
                    }
                });
            });
        });

    $('.add_touban').attr('href', 'mainForm.php?groupId='+lineId);
}
