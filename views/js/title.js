var userName;

$(window).ready(() => {
    $.ajax({
        type: "GET",
        url: "/MessageBoard/member/getSessionUserName"
    }).then(function (e) {

        userName = e;
        if (e) {
            $("#showUserName").html(getTitleUserNameView(e));
            $("#showLogin").text("登出");
            $("#showRegistered").remove();
        } else {
            $("#showUserName").remove();
        }

    });
});