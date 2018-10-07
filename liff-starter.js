window.onload = function (data) {
    liff.init(function (data) {
        initializeApp(data);
    });
    console.log('su');


};

function initializeApp(data) {
    document.getElementById('languagefield').textContent = data.language;
    document.getElementById('viewtypefield').textContent = data.context.viewType;
    document.getElementById('useridfield').textContent = data.context.userId;
    document.getElementById('utouidfield').textContent = data.context.utouId;
    document.getElementById('roomidfield').textContent = data.context.roomId;
    document.getElementById('groupidfield').textContent = data.context.groupId;

    function isset( data ){
        return ( typeof( data ) != 'undefined' );
    }

    var lineId;
    if(isset(data.context.userId))lineId=data.context.userId;
    if(isset(data.context.roomId))lineId=data.context.roomId;
    if(isset(data.context.groupId))lineId=data.context.groupId;

    console.log(lineId);
    $('#group_id').val(lineId);

    //var requestBuf ='checkId.php?groupId=UU09facbeea4dafecede9e058973ac6b85bcc0202053fcf2caa7886bf9f5b14cc3454a4405db654ca51b8ab0099b20728f6d67245e2adccd77b0c64ed25d7b7413' + lineId;

    fetch('checkId.php?groupId=' + lineId)

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
                $('.notification_dsoW_checkboxes').fadeIn();
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
                $('.notification_dsoW_checkboxes').fadeIn();
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

    $('.notification_dsoW').hide();
    $('.notification_doM').hide();
    $('.notification_doW').hide();





    console.log('continue');

    // openWindow call
    document.getElementById('openwindowbutton').addEventListener('click', function () {
        liff.openWindow({
            url: 'https://line.me'
        });
    });

    // closeWindow call
    document.getElementById('closewindowbutton').addEventListener('click', function () {
        liff.closeWindow();
    });
    // sendMessages call
    document.getElementById('sendmessagebutton').addEventListener('click', function () {
        liff.sendMessages([{
            type: 'text',
            text: "You've successfully sent a message! Hooray!"
        }, {
            type: 'sticker',
            packageId: '2',
            stickerId: '144'
        }]).then(function () {
            window.alert("Message sent");
        }).catch(function (error) {
            window.alert("Error sending message: " + error);
        });
    });

    //get profile call
    document.getElementById('getprofilebutton').addEventListener('click', function () {
        liff.getProfile().then(function (profile) {
            document.getElementById('useridprofilefield').textContent = profile.userId;
            document.getElementById('displaynamefield').textContent = profile.displayName;

            var profilePictureDiv = document.getElementById('profilepicturediv');
            if (profilePictureDiv.firstElementChild) {
                profilePictureDiv.removeChild(profilePictureDiv.firstElementChild);
            }
            var img = document.createElement('img');
            img.src = profile.pictureUrl;
            img.alt = "Profile Picture";
            profilePictureDiv.appendChild(img);

            document.getElementById('statusmessagefield').textContent = profile.statusMessage;
            toggleProfileData();
        }).catch(function (error) {
            window.alert("Error getting profile: " + error);
        });
    });
}

function toggleProfileData() {
    var elem = document.getElementById('profileinfo');
    if (elem.offsetWidth > 0 && elem.offsetHeight > 0) {
        elem.style.display = "none";
    } else {
        elem.style.display = "block";
    }
}