liff.init(function (data) {
    $.ajax({
        type: 'POST',
        url: './update.php',
        dataType:'text',
        data: {
            userId : data.context.userId
        },
        success: function(data) {
            alert("success");
            //location.href = "./test.php";
        }
    });


});