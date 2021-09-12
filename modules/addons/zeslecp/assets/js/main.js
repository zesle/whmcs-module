$(document).ready(function () {
    $("#addNewPkg").click(function () {
        $("#addNewPackageModal").modal();
    });
    $("#createNewPackageBtn").click(function () {
        $("#invalidAPIError").hide();
        var pkgName = $("#pkgName").val();
        if (pkgName == "") {
            $("#pkgName").css("border", "1px solid #f46a6a");
            $(".error1").html("This name is required<br/>");
            $('#addNewPackageModal').animate({scrollTop: 0}, 'slow');
            return false;
        }
        var mbl = $("#mBW").val();
        if (mbl == "") {
            $("#mBW").css("border", "1px solid #f46a6a");
            $(".error2").text("This monthly bandwidth limit is required");
            $('#addNewPackageModal').animate({scrollTop: 0}, 'slow');
            return false;
        }
        var diskQ = $("#diskQ").val();
        if (diskQ == "") {
            $("#diskQ").css("border", "1px solid #f46a6a");
            $(".error3").text("This disk quota is required");
            $('#addNewPackageModal').animate({scrollTop: 0}, 'slow');
            return false;
        }
        var mpDomains = $("#mpDomains").val();
        if (mpDomains == "") {
            $("#mpDomains").css("border", "1px solid #f46a6a");
            $(".error4").text("This max parked domains is required");
            $('#addNewPackageModal').animate({scrollTop: 90}, 'slow');
            return false;
        }
        var maDomains = $("#maDomains").val();
        if (maDomains == "") {
            $("#maDomains").css("border", "1px solid #f46a6a");
            $(".error5").text("This max addon domains is required");
            $('#addNewPackageModal').animate({scrollTop: 90}, 'slow');
            return false;
        }
        var msDomains = $("#msDomains").val();
        if (msDomains == "") {
            $("#msDomains").css("border", "1px solid #f46a6a");
            $(".error6").text("This max subdomains is required");
            $('#addNewPackageModal').animate({scrollTop: 400}, 'slow');
            return false;
        }
        var meAccount = $("#meAccount").val();
        if (meAccount == "") {
            $("#meAccount").css("border", "1px solid #f46a6a");
            $(".error7").text("This max email accounts is required");
            $('#addNewPackageModal').animate({scrollTop: 440}, 'slow');
            return false;
        }
        var mqpeAccount = $("#mqpeAccount").val();
        if (mqpeAccount == "") {
            $("#mqpeAccount").css("border", "1px solid #f46a6a");
            $(".error8").text("This max quota per email account is required");
            $('#addNewPackageModal').animate({scrollTop: 480}, 'slow');
            return false;
        }
        var meForwarders = $("#meForwarders").val();
        if (meForwarders == "") {
            $("#meForwarders").css("border", "1px solid #f46a6a");
            $(".error9").text("This max email forwarders is required");
            $('#addNewPackageModal').animate({scrollTop: 680}, 'slow');
            return false;
        }
        var mmLists = $("#mmLists").val();
        if (mmLists == "") {
            $("#mmLists").css("border", "1px solid #f46a6a");
            $(".error10").text("This max mailing lists is required");
            $('#addNewPackageModal').animate({scrollTop: 720}, 'slow');
            return false;
        }
        var mAutoresponders = $("#mAutoresponders").val();
        if (mAutoresponders == "") {
            $("#mAutoresponders").css("border", "1px solid #f46a6a");
            $(".error11").text("This max autoresponders is required");
            $('#addNewPackageModal').animate({scrollTop: 760}, 'slow');
            return false;
        }
        var mmDatabases = $("#mmDatabases").val();
        if (mmDatabases == "") {
            $("#mmDatabases").css("border", "1px solid #f46a6a");
            $(".error12").text("This max mysql databases is required");
            $('#addNewPackageModal').animate({scrollTop: 800}, 'slow');
            return false;
        }
        var mfAccounts = $("#mfAccounts").val();
        if (mfAccounts == "") {
            $("#mfAccounts").css("border", "1px solid #f46a6a");
            $(".error13").text("This max ftp accounts is required");
            $('#addNewPackageModal').animate({scrollTop: 1080}, 'slow');
            return false;
        }
        var muAccounts = $("#muAccounts").val();
        if (muAccounts == "") {
            $("#muAccounts").css("border", "1px solid #f46a6a");
            $(".error14").text("This max user accounts is required");
            $('#addNewPackageModal').animate({scrollTop: 1180}, 'slow');
            return false;
        }
        var mhebdRelayed = $("#mhebdRelayed").val();
        if (mhebdRelayed == "") {
            $("#mhebdRelayed").css("border", "1px solid #f46a6a");
            $(".error15").text("This max email per hour is required");
            $('#addNewPackageModal').animate({scrollTop: 1450}, 'slow');
            return false;
        }
        var mpofodmadmspHour = $("#mpofodmadmspHour").val();
        if (mpofodmadmspHour == "") {
            $("#mpofodmadmspHour").css("border", "1px solid #f46a6a");
            $(".error16").text("This max defer fail percentage is required");
            return false;
        }
        var themeId = $("#themeId").val();
        if (themeId == "") {
            $("#themeId").css("border", "1px solid #f46a6a");
            $(".error17").text("This ZesleCP theme is required");
            return false;
        }
        var locale = $("#locale").val();
        if (locale == "") {
            $("#locale").css("border", "1px solid #f46a6a");
            $(".error18").text("This language is required");
            return false;
        }
        $("#invalidError").hide();
        var dedicatedIP = 0;
        if ($("#dedicatedIP").is(":checked")) {
            dedicatedIP = 1;
        }
        var shellAccess = 0;
        if ($("#shellAccess").is(":checked")) {
            shellAccess = 1;
        }
        var cgiAccess = 0;
        if ($("#cgiAccess").is(":checked")) {
            cgiAccess = 1;
        }
        var obj = new Object();
        obj.pkgName = pkgName;
        obj.mbl = mbl;
        obj.diskQ = diskQ;
        obj.mpDomains = mpDomains;
        obj.maDomains = maDomains;
        obj.msDomains = msDomains;
        obj.meAccount = meAccount;
        obj.mqpeAccount = mqpeAccount;
        obj.meForwarders = meForwarders;
        obj.mmLists = mmLists;
        obj.mAutoresponders = mAutoresponders;
        obj.mmDatabases = mmDatabases;
        obj.mfAccounts = mfAccounts;
        obj.muAccounts = muAccounts;
        obj.mhebdRelayed = mhebdRelayed;
        obj.mpofodmadmspHour = mpofodmadmspHour;
        obj.themeId = themeId;
        obj.locale = locale;
        obj.dedicatedIP = dedicatedIP;
        obj.shellAccess = shellAccess;
        obj.cgiAccess = cgiAccess;
        var jsonString = JSON.stringify(obj);
        var dataString = 'data=' + jsonString;
        $.ajax({
            type: "POST",
            cache: false,
            data: dataString,
            url: "../modules/addons/zeslecp/Admin/Actions/AddPackage.php",
            success: function (data) {
                if (data == "ok") {
                    location.reload();
                } else {
                    $(this).removeAttr("disabled");
                    var dataArray = data.split(":");
                    if (dataArray[0] == "name") {
                        $("#pkgName").css("border", "1px solid #f46a6a");
                        $(".error1").html(dataArray[1] + "<br/>");
                        $('#addNewPackageModal').animate({scrollTop: 0}, 'slow');
                    } else {
                        $("#invalidAPIError").show();
                        $("#invalidAPIError").text(data);
                    }
                }
            }
        });
    });

    // End of create package button

    $("#mpofodmadmspHour").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".error16").text("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".error16").text("This max defer fail percentage is required");
        }
    });
    $("#mpofodmadmspHour").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".error16").text("This max defer fail percentage is required");
        }
    });
    $("#mhebdRelayed").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".error15").text("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".error15").text("This max email per hour is required");
        }
    });
    $("#mhebdRelayed").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".error15").text("This max email per hour is required");
        }
    });
    $("#muAccounts").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".error14").text("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".error14").text("This max user accounts is required");
        }
    });
    $("#muAccounts").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".error14").text("This max user accounts is required");
        }
    });
    $("#mfAccounts").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".error13").text("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".error13").text("This max ftp accounts is required");
        }
    });
    $("#mfAccounts").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".error13").text("This max ftp accounts is required");
        }
    });
    $("#mmDatabases").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".error12").text("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".error12").text("This max mysql databases is required");
        }
    });
    $("#mmDatabases").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".error12").text("This max mysql databases is required");
        }
    });
    $("#mAutoresponders").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".error11").text("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".error11").text("This max autoresponders is required");
        }
    });
    $("#mAutoresponders").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".error11").text("This max autoresponders is required");
        }
    });
    $("#mmLists").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".error10").text("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".error10").text("This max mailing lists is required");
        }
    });
    $("#mmLists").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".error10").text("This max mailing lists is required");
        }
    });
    $("#meForwarders").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".error9").text("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".error9").text("This max email forwarders is required");
        }
    });
    $("#meForwarders").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".error9").text("This max email forwarders is required");
        }
    });
    $("#mqpeAccount").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".error8").text("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".error8").text("This max quota per email account is required");
        }
    });
    $("#mqpeAccount").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".error8").text("This max quota per email account is required");
        }
    });
    $("#meAccount").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".error7").text("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".error7").text("This max email accounts is required");
        }
    });
    $("#meAccount").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".error7").text("This max email accounts is required");
        }
    });
    $("#msDomains").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".error6").text("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".error6").text("This max subdomains is required");
        }
    });
    $("#msDomains").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".error6").text("This max subdomains is required");
        }
    });
    $("#maDomains").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".error5").text("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".error5").text("This max addon domains is required");
        }
    });
    $("#maDomains").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".error5").text("This max addon domains is required");
        }
    });
    $("#mpDomains").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".error4").text("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".error4").text("This max parked domains is required");
        }
    });
    $("#mpDomains").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".error4").text("This max parked domains is required");
        }
    });
    $("#diskQ").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".error3").text("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".error3").text("This disk quota is required");
        }
    });
    $("#diskQ").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".error3").text("This disk quota is required");
        }
    });
    $("#mBW").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".error2").text("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".error2").text("This monthly bandwidth limit is required");
        }
    });
    $("#mBW").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".error2").text("This monthly bandwidth limit is required");
        }
    });
    $("#pkgName").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".error1").html("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".error1").html("This name is required<br/>");
        }
    });
    $("#pkgName").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".error1").html("This name is required<br/>");
        }
    });
    $("#umBW").click(function () {
        if ($(this).is(":checked")) {
            $("#mBW").val("-1");
            $("#mBW").attr("readonly", "readonly");
            $("#mBW").css("border", "1px solid #ccc");
            $(".error2").text("");
        } else {
            $("#mBW").val("");
            $("#mBW").removeAttr("readonly");
        }
    });
    $("#uDiskQ").click(function () {
        if ($(this).is(":checked")) {
            $("#diskQ").val("-1");
            $("#diskQ").attr("readonly", "readonly");
            $("#diskQ").css("border", "1px solid #ccc");
            $(".error3").text("");
        } else {
            $("#diskQ").val("");
            $("#diskQ").removeAttr("readonly");
        }
    });
    $("#umpDomains").click(function () {
        if ($(this).is(":checked")) {
            $("#mpDomains").val("-1");
            $("#mpDomains").attr("readonly", "readonly");
            $("#mpDomains").css("border", "1px solid #ccc");
            $(".error4").text("");
        } else {
            $("#mpDomains").val("");
            $("#mpDomains").removeAttr("readonly");
        }
    });
    $("#umaDomains").click(function () {
        if ($(this).is(":checked")) {
            $("#maDomains").val("-1");
            $("#maDomains").attr("readonly", "readonly");
            $("#maDomains").css("border", "1px solid #ccc");
            $(".error5").text("");
        } else {
            $("#maDomains").val("");
            $("#maDomains").removeAttr("readonly");
        }
    });
    $("#umsDomains").click(function () {
        if ($(this).is(":checked")) {
            $("#msDomains").val("-1");
            $("#msDomains").attr("readonly", "readonly");
            $("#msDomains").css("border", "1px solid #ccc");
            $(".error6").text("");
        } else {
            $("#msDomains").val("");
            $("#msDomains").removeAttr("readonly");
        }
    });
    $("#umeAccount").click(function () {
        if ($(this).is(":checked")) {
            $("#meAccount").val("-1");
            $("#meAccount").attr("readonly", "readonly");
            $("#meAccount").css("border", "1px solid #ccc");
            $(".error7").text("");
        } else {
            $("#meAccount").val("");
            $("#meAccount").removeAttr("readonly");
        }
    });
    $("#umqpeAccount").click(function () {
        if ($(this).is(":checked")) {
            $("#mqpeAccount").val("-1");
            $("#mqpeAccount").attr("readonly", "readonly");
            $("#mqpeAccount").css("border", "1px solid #ccc");
            $(".error8").text("");
        } else {
            $("#mqpeAccount").val("");
            $("#mqpeAccount").removeAttr("readonly");
        }
    });
    $("#umeForwarders").click(function () {
        if ($(this).is(":checked")) {
            $("#meForwarders").val("-1");
            $("#meForwarders").attr("readonly", "readonly");
            $("#meForwarders").css("border", "1px solid #ccc");
            $(".error9").text("");
        } else {
            $("#meForwarders").val("");
            $("#meForwarders").removeAttr("readonly");
        }
    });
    $("#ummLists").click(function () {
        if ($(this).is(":checked")) {
            $("#mmLists").val("-1");
            $("#mmLists").attr("readonly", "readonly");
            $("#mmLists").css("border", "1px solid #ccc");
            $(".error10").text("");
        } else {
            $("#mmLists").val("");
            $("#mmLists").removeAttr("readonly");
        }
    });
    $("#umAutoresponders").click(function () {
        if ($(this).is(":checked")) {
            $("#mAutoresponders").val("-1");
            $("#mAutoresponders").attr("readonly", "readonly");
            $("#mAutoresponders").css("border", "1px solid #ccc");
            $(".error11").text("");
        } else {
            $("#mAutoresponders").val("");
            $("#mAutoresponders").removeAttr("readonly");
        }
    });
    $("#ummDatabases").click(function () {
        if ($(this).is(":checked")) {
            $("#mmDatabases").val("-1");
            $("#mmDatabases").attr("readonly", "readonly");
            $("#mmDatabases").css("border", "1px solid #ccc");
            $(".error12").text("");
        } else {
            $("#mmDatabases").val("");
            $("#mmDatabases").removeAttr("readonly");
        }
    });
    $("#umfAccounts").click(function () {
        if ($(this).is(":checked")) {
            $("#mfAccounts").val("-1");
            $("#mfAccounts").attr("readonly", "readonly");
            $("#mfAccounts").css("border", "1px solid #ccc");
            $(".error13").text("");
        } else {
            $("#mfAccounts").val("");
            $("#mfAccounts").removeAttr("readonly");
        }
    });
    $("#umuAccounts").click(function () {
        if ($(this).is(":checked")) {
            $("#muAccounts").val("-1");
            $("#muAccounts").attr("readonly", "readonly");
            $("#muAccounts").css("border", "1px solid #ccc");
            $(".error14").text("");
        } else {
            $("#muAccounts").val("");
            $("#muAccounts").removeAttr("readonly");
        }
    });
    $("#umhebdRelayed").click(function () {
        if ($(this).is(":checked")) {
            $("#mhebdRelayed").val("-1");
            $("#mhebdRelayed").attr("readonly", "readonly");
            $("#mhebdRelayed").css("border", "1px solid #ccc");
            $(".error15").text("");
        } else {
            $("#mhebdRelayed").val("");
            $("#mhebdRelayed").removeAttr("readonly");
        }
    });
    $("#umpofodmadmspHour").click(function () {
        if ($(this).is(":checked")) {
            $("#mpofodmadmspHour").val("-1");
            $("#mpofodmadmspHour").attr("readonly", "readonly");
            $("#mpofodmadmspHour").css("border", "1px solid #ccc");
            $(".error16").text("");
        } else {
            $("#mpofodmadmspHour").val("");
            $("#mpofodmadmspHour").removeAttr("readonly");
        }
    });
    $(document).on("click", ".zeslecpPkg", function () {
        var pkg = $(this).attr("data-pkg-id");
        $("#pkgId").val(pkg);
        var dataString = 'action=editPackage&pkg=' + pkg;
        $.ajax({
            type: "POST",
            cache: false,
            data: dataString,
            url: "../modules/addons/zeslecp/Admin/Actions/getPackage.php",
            success: function (data) {
                var res = data.match(/Error:/g);
                if (res !== null) {
                    alert(data);
                } else {
                    const obj = JSON.parse(data);
                    $("#epkgName").val(obj.name);
                    $("#emBW").val(obj.monthly_bw_limit);
                    if (obj.monthly_bw_limit == -1) {
                        $("#emBW").attr("readonly", "readonly");
                        $("#eumBW").prop('checked', true);
                    }
                    $("#ediskQ").val(obj.disk_quota);
                    if (obj.disk_quota == -1) {
                        $("#ediskQ").attr("readonly", "readonly");
                        $("#euDiskQ").prop('checked', true);
                    }
                    $("#empDomains").val(obj.max_parked_domains);
                    if (obj.max_parked_domains == -1) {
                        $("#empDomains").attr("readonly", "readonly");
                        $("#eumpDomains").prop('checked', true);
                    }
                    $("#emaDomains").val(obj.max_addon_domains);
                    if (obj.max_addon_domains == -1) {
                        $("#emaDomains").attr("readonly", "readonly");
                        $("#eumaDomains").prop('checked', true);
                    }
                    $("#emsDomains").val(obj.max_subdomains);
                    if (obj.max_subdomains == -1) {
                        $("#emsDomains").attr("readonly", "readonly");
                        $("#eumsDomains").prop('checked', true);
                    }
                    $("#emeAccount").val(obj.max_email_accounts);
                    if (obj.max_email_accounts == -1) {
                        $("#emeAccount").attr("readonly", "readonly");
                        $("#eumeAccount").prop('checked', true);
                    }
                    $("#emqpeAccount").val(obj.max_quota_per_email_account);
                    if (obj.max_quota_per_email_account == -1) {
                        $("#emqpeAccount").attr("readonly", "readonly");
                        $("#eumqpeAccount").prop('checked', true);
                    }
                    $("#emeForwarders").val(obj.max_email_forwarders);
                    if (obj.max_email_forwarders == -1) {
                        $("#emeForwarders").attr("readonly", "readonly");
                        $("#eumeForwarders").prop('checked', true);
                    }
                    $("#emmLists").val(obj.max_mailing_lists);
                    if (obj.max_mailing_lists == -1) {
                        $("#emmLists").attr("readonly", "readonly");
                        $("#eummLists").prop('checked', true);
                    }
                    $("#emAutoresponders").val(obj.max_autoresponders);
                    if (obj.max_autoresponders == -1) {
                        $("#emAutoresponders").attr("readonly", "readonly");
                        $("#eumAutoresponders").prop('checked', true);
                    }
                    $("#emmDatabases").val(obj.max_mysql_databases);
                    if (obj.max_mysql_databases == -1) {
                        $("#emmDatabases").attr("readonly", "readonly");
                        $("#eummDatabases").prop('checked', true);
                    }
                    $("#emfAccounts").val(obj.max_ftp_accounts);
                    if (obj.max_ftp_accounts == -1) {
                        $("#emfAccounts").attr("readonly", "readonly");
                        $("#eumfAccounts").prop('checked', true);
                    }
                    $("#emuAccounts").val(obj.max_user_accounts);
                    if (obj.max_user_accounts == -1) {
                        $("#emuAccounts").attr("readonly", "readonly");
                        $("#eumuAccounts").prop('checked', true);
                    }
                    $("#emhebdRelayed").val(obj.max_email_per_hour);
                    if (obj.max_email_per_hour == -1) {
                        $("#emhebdRelayed").attr("readonly", "readonly");
                        $("#eumhebdRelayed").prop('checked', true);
                    }
                    $("#empofodmadmspHour").val(obj.max_defer_fail_percentage);
                    if (obj.max_defer_fail_percentage == -1) {
                        $("#empofodmadmspHour").attr("readonly", "readonly");
                        $("#eumpofodmadmspHour").prop('checked', true);
                    }
                    if (obj.dedicated_ip == 1) {
                        $("#ededicatedIP").prop('checked', true);
                    }
                    if (obj.shell_access == 1) {
                        $("#eshellAccess").prop('checked', true);
                    }
                    if (obj.cgi_access == 1) {
                        $("#ecgiAccess").prop('checked', true);
                    }
                    $("#ethemeId").val(obj.theme_id);
                    $("#elocale").val(obj.locale_id);
                    $("#editPackageModal").modal();
                }
            }
        });
    });
    $("#editPackageBtn").click(function () {
        $("#einvalidAPIError").hide();
        var pkgName = $("#epkgName").val();
        if (pkgName == "") {
            $("#epkgName").css("border", "1px solid #f46a6a");
            $(".eerror1").html("This name is required<br/>");
            $('#editPackageModal').animate({scrollTop: 0}, 'slow');
            return false;
        }
        var mbl = $("#emBW").val();
        if (mbl == "") {
            $("#emBW").css("border", "1px solid #f46a6a");
            $(".eerror2").text("This monthly bandwidth limit is required");
            $('#editPackageModal').animate({scrollTop: 0}, 'slow');
            return false;
        }
        var diskQ = $("#ediskQ").val();
        if (diskQ == "") {
            $("#ediskQ").css("border", "1px solid #f46a6a");
            $(".eerror3").text("This disk quota is required");
            $('#editPackageModal').animate({scrollTop: 0}, 'slow');
            return false;
        }
        var mpDomains = $("#empDomains").val();
        if (mpDomains == "") {
            $("#empDomains").css("border", "1px solid #f46a6a");
            $(".eerror4").text("This max parked domains is required");
            $('#editPackageModal').animate({scrollTop: 90}, 'slow');
            return false;
        }
        var maDomains = $("#emaDomains").val();
        if (maDomains == "") {
            $("#emaDomains").css("border", "1px solid #f46a6a");
            $(".eerror5").text("This max addon domains is required");
            $('#editPackageModal').animate({scrollTop: 90}, 'slow');
            return false;
        }
        var msDomains = $("#emsDomains").val();
        if (msDomains == "") {
            $("#emsDomains").css("border", "1px solid #f46a6a");
            $(".eerror6").text("This max subdomains is required");
            $('#editPackageModal').animate({scrollTop: 400}, 'slow');
            return false;
        }
        var meAccount = $("#emeAccount").val();
        if (meAccount == "") {
            $("#emeAccount").css("border", "1px solid #f46a6a");
            $(".eerror7").text("This max email accounts is required");
            $('#editPackageModal').animate({scrollTop: 440}, 'slow');
            return false;
        }
        var mqpeAccount = $("#emqpeAccount").val();
        if (mqpeAccount == "") {
            $("#emqpeAccount").css("border", "1px solid #f46a6a");
            $(".eerror8").text("This max quota per email account is required");
            $('#editPackageModal').animate({scrollTop: 480}, 'slow');
            return false;
        }
        var meForwarders = $("#emeForwarders").val();
        if (meForwarders == "") {
            $("#emeForwarders").css("border", "1px solid #f46a6a");
            $(".eerror9").text("This max email forwarders is required");
            $('#editPackageModal').animate({scrollTop: 680}, 'slow');
            return false;
        }
        var mmLists = $("#emmLists").val();
        if (mmLists == "") {
            $("#emmLists").css("border", "1px solid #f46a6a");
            $(".eerror10").text("This max mailing lists is required");
            $('#editPackageModal').animate({scrollTop: 720}, 'slow');
            return false;
        }
        var mAutoresponders = $("#emAutoresponders").val();
        if (mAutoresponders == "") {
            $("#emAutoresponders").css("border", "1px solid #f46a6a");
            $(".eerror11").text("This max autoresponders is required");
            $('#editPackageModal').animate({scrollTop: 760}, 'slow');
            return false;
        }
        var mmDatabases = $("#emmDatabases").val();
        if (mmDatabases == "") {
            $("#emmDatabases").css("border", "1px solid #f46a6a");
            $(".eerror12").text("This max mysql databases is required");
            $('#editPackageModal').animate({scrollTop: 800}, 'slow');
            return false;
        }
        var mfAccounts = $("#emfAccounts").val();
        if (mfAccounts == "") {
            $("#emfAccounts").css("border", "1px solid #f46a6a");
            $(".eerror13").text("This max ftp accounts is required");
            $('#editPackageModal').animate({scrollTop: 1080}, 'slow');
            return false;
        }
        var muAccounts = $("#emuAccounts").val();
        if (muAccounts == "") {
            $("#emuAccounts").css("border", "1px solid #f46a6a");
            $(".eerror14").text("This max user accounts is required");
            $('#editPackageModal').animate({scrollTop: 1180}, 'slow');
            return false;
        }
        var mhebdRelayed = $("#emhebdRelayed").val();
        if (mhebdRelayed == "") {
            $("#emhebdRelayed").css("border", "1px solid #f46a6a");
            $(".eerror15").text("This max email per hour is required");
            $('#editPackageModal').animate({scrollTop: 1450}, 'slow');
            return false;
        }
        var mpofodmadmspHour = $("#empofodmadmspHour").val();
        if (mpofodmadmspHour == "") {
            $("#empofodmadmspHour").css("border", "1px solid #f46a6a");
            $(".eerror16").text("This max defer fail percentage is required");
            $('#editPackageModal').animate({scrollTop: 1450}, 'slow');
            return false;
        }
        var themeId = $("#ethemeId").val();
        if (themeId == "") {
            $("#ethemeId").css("border", "1px solid #f46a6a");
            $(".eerror17").text("This ZesleCP theme is required");
            return false;
        }
        var locale = $("#elocale").val();
        if (locale == "") {
            $("#elocale").css("border", "1px solid #f46a6a");
            $(".eerror18").text("This language is required");
            return false;
        }
        $("#einvalidError").hide();
        var dedicatedIP = 0;
        if ($("#ededicatedIP").is(":checked")) {
            dedicatedIP = 1;
        }
        var shellAccess = 0;
        if ($("#eshellAccess").is(":checked")) {
            shellAccess = 1;
        }
        var cgiAccess = 0;
        if ($("#ecgiAccess").is(":checked")) {
            cgiAccess = 1;
        }
        var obj = new Object();
        obj.pkgName = pkgName;
        obj.mbl = mbl;
        obj.diskQ = diskQ;
        obj.mpDomains = mpDomains;
        obj.maDomains = maDomains;
        obj.msDomains = msDomains;
        obj.meAccount = meAccount;
        obj.mqpeAccount = mqpeAccount;
        obj.meForwarders = meForwarders;
        obj.mmLists = mmLists;
        obj.mAutoresponders = mAutoresponders;
        obj.mmDatabases = mmDatabases;
        obj.mfAccounts = mfAccounts;
        obj.muAccounts = muAccounts;
        obj.mhebdRelayed = mhebdRelayed;
        obj.mpofodmadmspHour = mpofodmadmspHour;
        obj.themeId = themeId;
        obj.locale = locale;
        obj.dedicatedIP = dedicatedIP;
        obj.shellAccess = shellAccess;
        obj.cgiAccess = cgiAccess;
        var jsonString = JSON.stringify(obj);
        var pkg = $("#pkgId").val();
        var dataString = 'data=' + jsonString + "&pkg=" + pkg;
        $.ajax({
            type: "POST",
            cache: false,
            data: dataString,
            url: "../modules/addons/zeslecp/Admin/Actions/EditPackage.php",
            success: function (data) {
                if (data == "ok") {
                    location.reload();
                } else {
                    $(this).prop('disabled', false);
                    var dataArray = data.split(":");
                    if (dataArray[0] == "name") {
                        $("#epkgName").css("border", "1px solid #f46a6a");
                        $(".eerror1").html(dataArray[1] + "<br/>");
                        $('#editPackageModal').animate({scrollTop: 0}, 'slow');
                    } else {
                        $("#einvalidAPIError").show();
                        $("#einvalidAPIError").text(data);
                    }
                }
            }
        });
    }); // End of edit button

    $("#empofodmadmspHour").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".eerror16").text("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror16").text("This max defer fail percentage is required");
        }
    });
    $("#empofodmadmspHour").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror16").text("This max defer fail percentage is required");
        }
    });
    $("#emhebdRelayed").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".eerror15").text("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror15").text("This max email per hour is required");
        }
    });
    $("#emhebdRelayed").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror15").text("This max email per hour is required");
        }
    });
    $("#emuAccounts").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".eerror14").text("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror14").text("This max user accounts is required");
        }
    });
    $("#emuAccounts").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror14").text("This max user accounts is required");
        }
    });
    $("#emfAccounts").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".eerror13").text("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror13").text("This max ftp accounts is required");
        }
    });
    $("#emfAccounts").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror13").text("This max ftp accounts is required");
        }
    });
    $("#emmDatabases").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".eerror12").text("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror12").text("This max mysql databases is required");
        }
    });
    $("#emmDatabases").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror12").text("This max mysql databases is required");
        }
    });
    $("#emAutoresponders").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".eerror11").text("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror11").text("This max autoresponders is required");
        }
    });
    $("#emAutoresponders").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror11").text("This max autoresponders is required");
        }
    });
    $("#emmLists").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".eerror10").text("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror10").text("This max mailing lists is required");
        }
    });
    $("#emmLists").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror10").text("This max mailing lists is required");
        }
    });
    $("#emeForwarders").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".eerror9").text("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror9").text("This max email forwarders is required");
        }
    });
    $("#emeForwarders").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror9").text("This max email forwarders is required");
        }
    });
    $("#emqpeAccount").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".eerror8").text("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror8").text("This max quota per email account is required");
        }
    });
    $("#emqpeAccount").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror8").text("This max quota per email account is required");
        }
    });
    $("#emeAccount").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".eerror7").text("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror7").text("This max email accounts is required");
        }
    });
    $("#emeAccount").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror7").text("This max email accounts is required");
        }
    });
    $("#emsDomains").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".eerror6").text("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror6").text("This max subdomains is required");
        }
    });
    $("#emsDomains").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror6").text("This max subdomains is required");
        }
    });
    $("#emaDomains").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".eerror5").text("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror5").text("This max addon domains is required");
        }
    });
    $("#emaDomains").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror5").text("This max addon domains is required");
        }
    });
    $("#empDomains").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".eerror4").text("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror4").text("This max parked domains is required");
        }
    });
    $("#empDomains").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror4").text("This max parked domains is required");
        }
    });
    $("#ediskQ").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".eerror3").text("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror3").text("This disk quota is required");
        }
    });
    $("#ediskQ").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror3").text("This disk quota is required");
        }
    });
    $("#emBW").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".eerror2").text("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror2").text("This monthly bandwidth limit is required");
        }
    });
    $("#emBW").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror2").text("This monthly bandwidth limit is required");
        }
    });
    $("#epkgName").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".eerror1").html("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror1").html("This name is required<br/>");
        }
    });
    $("#epkgName").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".eerror1").html("This name is required<br/>");
        }
    });
    $("#eumBW").click(function () {
        if ($(this).is(":checked")) {
            $("#emBW").val("-1");
            $("#emBW").attr("readonly", "readonly");
            $("#emBW").css("border", "1px solid #ccc");
            $(".eerror2").text("");
        } else {
            $("#emBW").val("");
            $("#emBW").removeAttr("readonly");
        }
    });
    $("#euDiskQ").click(function () {
        if ($(this).is(":checked")) {
            $("#ediskQ").val("-1");
            $("#ediskQ").attr("readonly", "readonly");
            $("#ediskQ").css("border", "1px solid #ccc");
            $(".eerror3").text("");
        } else {
            $("#ediskQ").val("");
            $("#ediskQ").removeAttr("readonly");
        }
    });
    $("#eumpDomains").click(function () {
        if ($(this).is(":checked")) {
            $("#empDomains").val("-1");
            $("#empDomains").attr("readonly", "readonly");
            $("#empDomains").css("border", "1px solid #ccc");
            $(".eerror4").text("");
        } else {
            $("#empDomains").val("");
            $("#empDomains").removeAttr("readonly");
        }
    });
    $("#eumaDomains").click(function () {
        if ($(this).is(":checked")) {
            $("#emaDomains").val("-1");
            $("#emaDomains").attr("readonly", "readonly");
            $("#emaDomains").css("border", "1px solid #ccc");
            $(".eerror5").text("");
        } else {
            $("#emaDomains").val("");
            $("#emaDomains").removeAttr("readonly");
        }
    });
    $("#eumsDomains").click(function () {
        if ($(this).is(":checked")) {
            $("#emsDomains").val("-1");
            $("#emsDomains").attr("readonly", "readonly");
            $("#emsDomains").css("border", "1px solid #ccc");
            $(".eerror6").text("");
        } else {
            $("#emsDomains").val("");
            $("#emsDomains").removeAttr("readonly");
        }
    });
    $("#eumeAccount").click(function () {
        if ($(this).is(":checked")) {
            $("#emeAccount").val("-1");
            $("#emeAccount").attr("readonly", "readonly");
            $("#emeAccount").css("border", "1px solid #ccc");
            $(".eerror7").text("");
        } else {
            $("#emeAccount").val("");
            $("#emeAccount").removeAttr("readonly");
        }
    });
    $("#eumqpeAccount").click(function () {
        if ($(this).is(":checked")) {
            $("#emqpeAccount").val("-1");
            $("#emqpeAccount").attr("readonly", "readonly");
            $("#emqpeAccount").css("border", "1px solid #ccc");
            $(".eerror8").text("");
        } else {
            $("#emqpeAccount").val("");
            $("#emqpeAccount").removeAttr("readonly");
        }
    });
    $("#eumeForwarders").click(function () {
        if ($(this).is(":checked")) {
            $("#emeForwarders").val("-1");
            $("#emeForwarders").attr("readonly", "readonly");
            $("#emeForwarders").css("border", "1px solid #ccc");
            $(".eerror9").text("");
        } else {
            $("#emeForwarders").val("");
            $("#emeForwarders").removeAttr("readonly");
        }
    });
    $("#eummLists").click(function () {
        if ($(this).is(":checked")) {
            $("#emmLists").val("-1");
            $("#emmLists").attr("readonly", "readonly");
            $("#emmLists").css("border", "1px solid #ccc");
            $(".eerror10").text("");
        } else {
            $("#emmLists").val("");
            $("#emmLists").removeAttr("readonly");
        }
    });
    $("#eumAutoresponders").click(function () {
        if ($(this).is(":checked")) {
            $("#emAutoresponders").val("-1");
            $("#emAutoresponders").attr("readonly", "readonly");
            $("#emAutoresponders").css("border", "1px solid #ccc");
            $(".eerror11").text("");
        } else {
            $("#emAutoresponders").val("");
            $("#emAutoresponders").removeAttr("readonly");
        }
    });
    $("#eummDatabases").click(function () {
        if ($(this).is(":checked")) {
            $("#emmDatabases").val("-1");
            $("#emmDatabases").attr("readonly", "readonly");
            $("#emmDatabases").css("border", "1px solid #ccc");
            $(".eerror12").text("");
        } else {
            $("#emmDatabases").val("");
            $("#emmDatabases").removeAttr("readonly");
        }
    });
    $("#eumfAccounts").click(function () {
        if ($(this).is(":checked")) {
            $("#emfAccounts").val("-1");
            $("#emfAccounts").attr("readonly", "readonly");
            $("#emfAccounts").css("border", "1px solid #ccc");
            $(".eerror13").text("");
        } else {
            $("#emfAccounts").val("");
            $("#emfAccounts").removeAttr("readonly");
        }
    });
    $("#eumuAccounts").click(function () {
        if ($(this).is(":checked")) {
            $("#emuAccounts").val("-1");
            $("#emuAccounts").attr("readonly", "readonly");
            $("#emuAccounts").css("border", "1px solid #ccc");
            $(".eerror14").text("");
        } else {
            $("#emuAccounts").val("");
            $("#emuAccounts").removeAttr("readonly");
        }
    });
    $("#eumhebdRelayed").click(function () {
        if ($(this).is(":checked")) {
            $("#emhebdRelayed").val("-1");
            $("#emhebdRelayed").attr("readonly", "readonly");
            $("#emhebdRelayed").css("border", "1px solid #ccc");
            $(".eerror15").text("");
        } else {
            $("#emhebdRelayed").val("");
            $("#emhebdRelayed").removeAttr("readonly");
        }
    });
    $("#eumpofodmadmspHour").click(function () {
        if ($(this).is(":checked")) {
            $("#empofodmadmspHour").val("-1");
            $("#empofodmadmspHour").attr("readonly", "readonly");
            $("#empofodmadmspHour").css("border", "1px solid #ccc");
            $(".eerror16").text("");
        } else {
            $("#empofodmadmspHour").val("");
            $("#empofodmadmspHour").removeAttr("readonly");
        }
    });
    $("#addNewUser").click(function () {
        $("#addNewUserModal").modal();
    });
    $("#createNewUserBtn").click(function () {
        $("#invalidAPIError").hide();
        var userName = $("#userName").val();
        if (userName == "") {
            $("#userName").css("border", "1px solid #f46a6a");
            $(".error1").html("This name is required<br/>");
            $('#addNewUserModal').animate({scrollTop: 0}, 'slow');
            return false;
        }
        var userUsername = $("#userUsername").val();
        if (userUsername == "") {
            $("#userUsername").css("border", "1px solid #f46a6a");
            $(".error2").html("This username is required<br/>");
            $('#addNewUserModal').animate({scrollTop: 0}, 'slow');
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
        obj.reseller = false;
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
    $("#userName").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".error1").html("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".error1").html("This name is required<br/>");
        }
    });
    $("#userName").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".error1").html("This name is required<br/>");
        }
    });
    $("#userUsername").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".error2").html("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".error2").html("This username is required<br/>");
        }
    });
    $("#userUsername").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".error2").html("This username is required<br/>");
        }
    });
    $("#primaryDomain").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".error3").html("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".error3").html("This primary domain is required<br/>");
        }
    });
    $("#primaryDomain").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".error3").html("This primary domain is required<br/>");
        }
    });
    $("#password").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".error4").html("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".error4").html("This password is required<br/>");
        }
    });
    $("#password").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".error4").html("This password is required<br/>");
        }
    });
    $("#rpassword").keyup(function () {
        if ($(this).val() != "") {
            var rpassword = $(this).val();
            var password = $("#password").val();
            if (rpassword != password) {
                $(this).css("border", "1px solid #f46a6a");
                $(".error5").text("Password do not match");
            } else {
                $(this).css("border", "1px solid #ccc");
                $(".error5").text("");
            }
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".error5").text("This password2 is required");
        }
    });
    $("#rpassword").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".error5").text("This password2 is required");
        }
    });
    $("#userEmail").keyup(function () {
        if ($(this).val() != "") {
            var userEmail = $(this).val();
            var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
            if (!userEmail.match(validRegex)) {
                $(this).css("border", "1px solid #f46a6a");
                $(".error6").text("Email id is invalid");
                return false;
            } else {
                $(this).css("border", "1px solid #ccc");
                $(".error6").text("");
            }
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".error6").text("This email is required");
        }
    });
    $("#userEmail").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".error6").text("This email is required");
        }
    });
    $("#pkgId").keyup(function () {
        if ($(this).val() != "") {
            $(this).css("border", "1px solid #ccc");
            $(".error7").text("");
        } else {
            $(this).css("border", "1px solid #f46a6a");
            $(".error7").text("This package is required");
        }
    });
    $("#pkgId").blur(function () {
        if ($(this).val() == "") {
            $(this).css("border", "1px solid #f46a6a");
            $(".error7").text("This package is required");
        }
    });
});