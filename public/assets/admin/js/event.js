$('#change-password').change (function() {
   let status  = !$(this).is(":checked");
   showChangePassword(status)
});

$("#btn-reset-edit-user").click(function(){
    showChangePassword(true);
});

function showChangePassword(status){
    $("#password").attr('readonly', status);
    $("#password-confirm").attr('readonly', status);

    $("#password").val("");
    $("#password-confirm").val("");
}



$(".btn-del-confirm").click(function(){
    let url = $(this).data('url');
    if(!confirm("Dữ liệu sẽ không thể khôi phục khi bị xóa, bạn chắc chắn muốn xóa không?")){
        return;
    }

    window.location.href = url;
});

$(".submit_contact").click(function(){
    let url = $(this).data('url');
    if(!confirm("Mail đã được gửi thành công! ComputerShop cảm ơn bạn đã phản hồi")){
        return;
    }

    window.location.href = url;
});

/* date */
function updateDate() {
    var now = new Date();
    var options = { year: 'numeric', month: 'long', day: 'numeric' };
    var formattedDate = now.toLocaleDateString('en-US', options);

    document.getElementById('realtime-date').innerHTML = formattedDate;
}


/* date */
function updateTime() {
    var now = new Date();
    var time = now.toLocaleTimeString();

    document.getElementById('realtime-time').innerHTML = time;
}





