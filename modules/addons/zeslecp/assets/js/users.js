$(document).ready(function () {
    $("#limit").change(function () {
        var limit = $(this).val();
        var dataString = 'limit=' + limit;
        $.ajax({
            type: "POST",
            cache: false,
            data: dataString,
            url: "../modules/addons/zeslecp/Admin/Actions/GetPaginationUsers.php",
            success: function (data) {
                $("#usersTable").html(data);
            }
        });
    });
    $("#limit1").change(function () {
        var limit = $(this).val();
        var dataString = 'limit=' + limit;
        $.ajax({
            type: "POST",
            cache: false,
            data: dataString,
            url: "../modules/addons/zeslecp/Admin/Actions/GetPaginationResellers.php",
            success: function (data) {
                $("#usersTable").html(data);
            }
        });
    });
    $(document).on("click", ".zeslecpUserEdit", function () {
        var useId = $(this).attr("data-user-id");
        $("#useId").val(useId);
        var dataString = 'action=editUser&useId=' + useId;
        $.ajax({
            type: "POST",
            cache: false,
            data: dataString,
            url: "../modules/addons/zeslecp/Admin/Actions/getUser.php",
            success: function (data) {
                var res = data.match(/Error:/g);
                if (res !== null) {
                    alert(data);
                } else {
                    $("#epassword").attr("type", "text");
                    const obj = JSON.parse(data);
                    $("#euserName").val(obj.name);
                    $("#euserUsername").val(obj.username);
                    $("#epassword").val(obj.password);
                    $("#erpassword").val(obj.password);
                    $("#eprimaryDomain").val(obj.primary_domain);
                    $("#euserEmail").val(obj.email);
                    $("#epkgId").val(obj.package_id);
                    $("#editUserModal").modal();
                }
            }
        });
        return false;
    });
    $("#editUserBtn").click(function () {
        $("#invalidAPIError").hide();
        var userName = $("#euserName").val();
        if (userName == "") {
            $("#euserName").css("border", "1px solid #f46a6a");
            $(".eerror1").html("This name is required<br/>");
            $('#editUserModal').animate({scrollTop: 0}, 'slow');
            return false;
        }
        var userUsername = $("#euserUsername").val();
        if (userUsername == "") {
            $("#euserUsername").css("border", "1px solid #f46a6a");
            $(".eerror2").html("This username is required<br/>");
            $('#editUserModal').animate({scrollTop: 0}, 'slow');
            return false;
        }
        var primaryDomain = $("#eprimaryDomain").val();
        if (primaryDomain == "") {
            $("#eprimaryDomain").css("border", "1px solid #f46a6a");
            $(".eerror3").html("This primary domain is required<br/>");
            return false;
        }
        var password = $("#epassword").val();
        var rpassword = $("#erpassword").val();
        if (password != rpassword) {
            $("#erpassword").css("border", "1px solid #f46a6a");
            $(".eerror5").text("Password do not match");
            return false;
        }
        var userEmail = $("#euserEmail").val();
        var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        if (userEmail == "") {
            $("#euserEmail").css("border", "1px solid #f46a6a");
            $(".eerror6").text("This email is required");
            return false;
        }
        if (!userEmail.match(validRegex)) {
            $("#euserEmail").css("border", "1px solid #f46a6a");
            $(".eerror6").text("Email id is invalid");
            return false;
        }
        var pkgId = $("#epkgId").val();
        if (pkgId == "") {
            $("#epkgId").css("border", "1px solid #f46a6a");
            $(".eerror7").text("This package is required");
            return false;
        }
        //$(this).attr("disabled", "disabled");
        var userId = $("#useId").val();
        var obj = new Object();
        obj.name = userName;
        obj.username = userUsername;
        obj.primary_domain = primaryDomain;
        obj.email = userEmail;
        if (password != "") {
            obj.password = password;
            obj.password2 = password;
        }
        obj.package_id = pkgId;
        obj.reseller = false;
        var jsonString = JSON.stringify(obj);
        var dataString = 'data=' + jsonString + "&userId=" + userId;
        $.ajax({
            type: "POST",
            cache: false,
            data: dataString,
            url: "../modules/addons/zeslecp/Admin/Actions/EditUser.php",
            success: function (data) {
                if (data == "ok") {
                    location.reload();
                } else {
                    var dataArray = data.split(":");
                    if (dataArray[0] == "name") {
                        $("#euserName").css("border", "1px solid #f46a6a");
                        $(".eerror1").html(dataArray[1] + "<br/>");
                        $('#editUserModal').animate({scrollTop: 0}, 'slow');
                    } else if (dataArray[0] == "username") {
                        $("#euserUsername").css("border", "1px solid #f46a6a");
                        $(".eerror2").html(dataArray[1] + "<br/>");
                        $('#editUserModal').animate({scrollTop: 0}, 'slow');
                    } else if (dataArray[0] == "primary_domain") {
                        $("#eprimaryDomain").css("border", "1px solid #f46a6a");
                        $(".eerror3").html(dataArray[1] + "<br/>");
                    } else if (dataArray[0] == "password") {
                        $("#epassword").css("border", "1px solid #f46a6a");
                        $(".eerror4").html(dataArray[1] + "<br/>");
                    } else if (dataArray[0] == "password2") {
                        $("#epassword").css("border", "1px solid #f46a6a");
                        $(".eerror4").html(dataArray[1] + "<br/>");
                    } else if (dataArray[0] == "email") {
                        $("#euserEmail").css("border", "1px solid #f46a6a");
                        $(".eerror6").text(dataArray[1]);
                    } else {
                        $("#einvalidAPIError").show();
                        $("#einvalidAPIError").text(data);
                    }
                }
            }
        });
    });
    $("#euserName").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".eerror1").html("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror1").html("This name is required<br/>");
        }
    });
    $("#euserName").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror1").html("This name is required<br/>");
        }
    });
    $("#euserUsername").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".eerror2").html("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror2").html("This username is required<br/>");
        }
    });
    $("#euserUsername").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror2").html("This username is required<br/>");
        }
    });
    $("#eprimaryDomain").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".eerror3").html("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror3").html("This primary domain is required<br/>");
        }
    });
    $("#eprimaryDomain").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror3").html("This primary domain is required<br/>");
        }
    });
    $("#epassword").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".eerror4").html("");
        }
    });
    $("#erpassword").keyup(function () {
        if ($(this).val() != "") {
            var rpassword = $(this).val();
            var password = $("#epassword").val();
            if (rpassword != password) {
                $(this).css("border", "1px solid #f46a6a");
                $(".eerror5").text("Password do not match");
            } else {
                $(this).css("border", "1px solid #ccc");
                $(".eerror5").text("");
            }
        }
    });
    $("#euserEmail").keyup(function () {
        if ($(this).val() != "") {
            var userEmail = $(this).val();
            var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
            if (!userEmail.match(validRegex)) {
                $(this).css("border", "1px solid #f46a6a");
                $(".eerror6").text("Email id is invalid");
                return false;
            } else {
                $(this).css("border", "1px solid #ccc");
                $(".eerror6").text("");
            }
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror6").text("This email is required");
        }
    });
    $("#euserEmail").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror6").text("This email is required");
        }
    });
    $("#epkgId").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".eerror7").text("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror7").text("This package is required");
        }
    });
    $("#epkgId").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror7").text("This package is required");
        }
    });
    $(document).on("click", ".zeslecpUserSuspend", function () {
        var useId = $(this).attr("data-user-id");
        var username = $(this).attr("data-user-username");
        var dataString = 'action=suspendUser&useId=' + useId;
        if (!confirm(" Are you Sure? You are about to suspend user \"" + username + "\"")) {
            return false;
        }
        $.ajax({
            type: "POST",
            cache: false,
            data: dataString,
            url: "../modules/addons/zeslecp/Admin/Actions/SuspendUser.php",
            success: function (data) {
                var res = data.match(/Error:/g);
                if (res !== null) {
                    alert(data);
                } else {
                    alert(data);
                    location.reload();
                }
            }
        });
    });
    $(document).on("click", ".zeslecpUserUnsuspend", function () {
        var useId = $(this).attr("data-user-id");
        var username = $(this).attr("data-user-username");
        var dataString = 'action=unsuspendUser&useId=' + useId;
        if (!confirm(" Are you Sure? You are about to unsuspend user \"" + username + "\"")) {
            return false;
        }
        $.ajax({
            type: "POST",
            cache: false,
            data: dataString,
            url: "../modules/addons/zeslecp/Admin/Actions/UnsuspendUser.php",
            success: function (data) {
                var res = data.match(/Error:/g);
                if (res !== null) {
                    alert(data);
                } else {
                    alert(data);
                    location.reload();
                }
            }
        });
    });
    $(document).on("click", ".zeslecpUserTrash", function () {
        var useId = $(this).attr("data-user-id");
        var username = $(this).attr("data-user-username");
        var dataString = 'action=terminateUser&useId=' + useId;
        if (!confirm(" Are you Sure? You are about to remove the account \"" + username + "\"")) {
            return false;
        }
        $.ajax({
            type: "POST",
            cache: false,
            data: dataString,
            url: "../modules/addons/zeslecp/Admin/Actions/TerminateUser.php",
            success: function (data) {
                var res = data.match(/Error:/g);
                if (res !== null) {
                    alert(data);
                } else {
                    alert(data);
                    location.reload();
                }
            }
        });
    });
    $("#createNewResellerBtn").click(function () {
        $("#invalidAPIError").hide();
        var userName = $("#userName").val();
        if (userName == "") {
            $("#userName").css("border", "1px solid #f46a6a");
            $(".error1").html("This name is required<br/>");
            return false;
        }
        var userUsername = $("#userUsername").val();
        if (userUsername == "") {
            $("#userUsername").css("border", "1px solid #f46a6a");
            $(".error2").html("This username is required<br/>");
            return false;
        }
        var primaryDomain = $("#primaryDomain").val();
        if (primaryDomain == "") {
            $("#primaryDomain").css("border", "1px solid #f46a6a");
            $(".error3").html("This primary domain is required<br/>");
            return false;
        }
        var password = $("#password").val();
        if (password == "") {
            $("#password").css("border", "1px solid #f46a6a");
            $(".error4").html("This password is required<br/>");
            return false;
        }
        var rpassword = $("#rpassword").val();
        if (rpassword == "") {
            $("#rpassword").css("border", "1px solid #f46a6a");
            $(".error5").text("This password2 is required");
            return false;
        }
        if (password != rpassword) {
            $("#rpassword").css("border", "1px solid #f46a6a");
            $(".error5").text("Password do not match");
            return false;
        }
        var userEmail = $("#userEmail").val();
        var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        if (userEmail == "") {
            $("#userEmail").css("border", "1px solid #f46a6a");
            $(".error6").text("This email is required");
            return false;
        }
        if (!userEmail.match(validRegex)) {
            $("#userEmail").css("border", "1px solid #f46a6a");
            $(".error6").text("Email id is invalid");
            return false;
        }
        var pkgId = $("#pkgId").val();
        if (pkgId == "") {
            $("#pkgId").css("border", "1px solid #f46a6a");
            $(".error7").text("This package is required");
            return false;
        }
        //$(this).attr("disabled", "disabled");
        var obj = new Object();
        obj.name = userName;
        obj.username = userUsername;
        obj.primary_domain = primaryDomain;
        obj.email = userEmail;
        obj.password = password;
        obj.password2 = password;
        obj.package_id = pkgId;
        obj.reseller = true;
        var jsonString = JSON.stringify(obj);
        var dataString = 'data=' + jsonString;
        $.ajax({
            type: "POST",
            cache: false,
            data: dataString,
            url: "../modules/addons/zeslecp/Admin/Actions/AddUser.php",
            success: function (data) {
                if (data == "ok") {
                    location.reload();
                } else {
                    $(this).removeAttr("disabled");
                    var dataArray = data.split(":");
                    if (dataArray[0] == "name") {
                        $("#userName").css("border", "1px solid #f46a6a");
                        $(".error1").html(dataArray[1] + "<br/>");
                        $('#addNewUserModal').animate({scrollTop: 0}, 'slow');
                    } else if (dataArray[0] == "username") {
                        $("#userUsername").css("border", "1px solid #f46a6a");
                        $(".error2").html(dataArray[1] + "<br/>");
                        $('#addNewUserModal').animate({scrollTop: 0}, 'slow');
                    } else if (dataArray[0] == "primary_domain") {
                        $("#primaryDomain").css("border", "1px solid #f46a6a");
                        $(".error3").html(dataArray[1] + "<br/>");
                    } else if (dataArray[0] == "password") {
                        $("#password").css("border", "1px solid #f46a6a");
                        $(".error4").html(dataArray[1] + "<br/>");
                    } else if (dataArray[0] == "password2") {
                        $("#password").css("border", "1px solid #f46a6a");
                        $(".error4").html(dataArray[1] + "<br/>");
                    } else if (dataArray[0] == "email") {
                        $("#userEmail").css("border", "1px solid #f46a6a");
                        $(".error6").text(dataArray[1]);
                    } else {
                        $("#invalidAPIError").show();
                        $("#invalidAPIError").text(data);
                    }

                }
            }
        });
    });
    $("#editResellerBtn").click(function () {
        $("#invalidAPIError").hide();
        var userName = $("#euserName").val();
        if (userName == "") {
            $("#euserName").css("border", "1px solid #f46a6a");
            $(".eerror1").html("This name is required<br/>");
            $('#editUserModal').animate({scrollTop: 0}, 'slow');
            return false;
        }
        var userUsername = $("#euserUsername").val();
        if (userUsername == "") {
            $("#euserUsername").css("border", "1px solid #f46a6a");
            $(".eerror2").html("This username is required<br/>");
            $('#editUserModal').animate({scrollTop: 0}, 'slow');
            return false;
        }
        var primaryDomain = $("#eprimaryDomain").val();
        if (primaryDomain == "") {
            $("#eprimaryDomain").css("border", "1px solid #f46a6a");
            $(".eerror3").html("This primary domain is required<br/>");
            return false;
        }
        var password = $("#epassword").val();
        var rpassword = $("#erpassword").val();
        if (password != rpassword) {
            $("#erpassword").css("border", "1px solid #f46a6a");
            $(".eerror5").text("Password do not match");
            return false;
        }
        var userEmail = $("#euserEmail").val();
        var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        if (userEmail == "") {
            $("#euserEmail").css("border", "1px solid #f46a6a");
            $(".eerror6").text("This email is required");
            return false;
        }
        if (!userEmail.match(validRegex)) {
            $("#euserEmail").css("border", "1px solid #f46a6a");
            $(".eerror6").text("Email id is invalid");
            return false;
        }
        var pkgId = $("#epkgId").val();
        if (pkgId == "") {
            $("#epkgId").css("border", "1px solid #f46a6a");
            $(".eerror7").text("This package is required");
            return false;
        }
        //$(this).attr("disabled", "disabled");
        var userId = $("#useId").val();
        var obj = new Object();
        obj.name = userName;
        obj.username = userUsername;
        obj.primary_domain = primaryDomain;
        obj.email = userEmail;
        if (password != "") {
            obj.password = password;
            obj.password2 = password;
        }
        obj.package_id = pkgId;
        obj.reseller = true;
        var jsonString = JSON.stringify(obj);
        var dataString = 'data=' + jsonString + "&userId=" + userId;
        $.ajax({
            type: "POST",
            cache: false,
            data: dataString,
            url: "../modules/addons/zeslecp/Admin/Actions/EditUser.php",
            success: function (data) {
                if (data == "ok") {
                    location.reload();
                } else {
                    var dataArray = data.split(":");
                    if (dataArray[0] == "name") {
                        $("#euserName").css("border", "1px solid #f46a6a");
                        $(".eerror1").html(dataArray[1] + "<br/>");
                        $('#editUserModal').animate({scrollTop: 0}, 'slow');
                    } else if (dataArray[0] == "username") {
                        $("#euserUsername").css("border", "1px solid #f46a6a");
                        $(".eerror2").html(dataArray[1] + "<br/>");
                        $('#editUserModal').animate({scrollTop: 0}, 'slow');
                    } else if (dataArray[0] == "primary_domain") {
                        $("#eprimaryDomain").css("border", "1px solid #f46a6a");
                        $(".eerror3").html(dataArray[1] + "<br/>");
                    } else if (dataArray[0] == "password") {
                        $("#epassword").css("border", "1px solid #f46a6a");
                        $(".eerror4").html(dataArray[1] + "<br/>");
                    } else if (dataArray[0] == "password2") {
                        $("#epassword").css("border", "1px solid #f46a6a");
                        $(".eerror4").html(dataArray[1] + "<br/>");
                    } else if (dataArray[0] == "email") {
                        $("#euserEmail").css("border", "1px solid #f46a6a");
                        $(".eerror6").text(dataArray[1]);
                    } else {
                        $("#einvalidAPIError").show();
                        $("#einvalidAPIError").text(data);
                    }
                }
            }
        });
    });
    $("#isUsers").click(function () {
        if (!confirm(" Are you Sure? You are about to import & synchronize users?")) {
            return false;
        }
        var dataString = 'action=fghrtuibvht76ut';
        if (!confirm(" Are you Sure? You are about to import & synchronize users?")) {
            return false;
        }
        $.ajax({
            type: "POST",
            cache: false,
            data: dataString,
            url: "../modules/addons/zeslecp/Admin/Actions/syncUsers.php",
            success: function (data) {
                var res = data.match(/Error:/g);
                if (res !== null) {
                    alert(data);
                } else {
                    alert(data);
                    location.reload();
                }
            }
        });
    });
    $("#isResellers").click(function () {
        if (!confirm(" Are you Sure? You are about to import & synchronize resellers?")) {
            return false;
        }
        var dataString = 'action=fhdkfh89uyidfholaqpk';
        if (!confirm(" Are you Sure? You are about to import & synchronize resellers?")) {
            return false;
        }
        $.ajax({
            type: "POST",
            cache: false,
            data: dataString,
            url: "../modules/addons/zeslecp/Admin/Actions/syncResellers.php",
            success: function (data) {
                var res = data.match(/Error:/g);
                if (res !== null) {
                    alert(data);
                } else {
                    alert(data);
                    location.reload();
                }
            }
        });
    });
    $("#addPwdGenerator").click(function () {
        var dataString = 'action=generatePwd';
        $.ajax({
            type: "POST",
            cache: false,
            data: dataString,
            url: "../modules/addons/zeslecp/Admin/Actions/PasswordGenerator.php",
            success: function (data) {
                $("#password").val(data);
                $("#password").attr("type", "text");
            }
        });
    });
    $("#editPwdGenerator").click(function () {
        var dataString = 'action=generatePwd';
        $.ajax({
            type: "POST",
            cache: false,
            data: dataString,
            url: "../modules/addons/zeslecp/Admin/Actions/PasswordGenerator.php",
            success: function (data) {
                $("#epassword").val(data);
                $("#epassword").attr("type", "text");
            }
        });
    });
});


