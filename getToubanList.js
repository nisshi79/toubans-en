window.onload = function (data) {
    $('.add_touban').attr('href', 'mainForm.php');
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
                        .append(`<li><a href="mainForm.php?groupId=test&tableId=${touban.table.id}">`+touban.role[0].role+'</a></li>');
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

    fetch('getToubanList.php?groupId=' + lineId)
        .then(response => {
            return response.json(); // ReadableStream -> String への変換
        })
        .then(json => {
            json.forEach(function (touban) {
                $('.toubanList')
                    .append(`<li><a href="mainForm.php?groupId=${lineId}&tableId=${touban.table.id}">`+touban.role[0].role+'</a></li>');
            });
        })

}
