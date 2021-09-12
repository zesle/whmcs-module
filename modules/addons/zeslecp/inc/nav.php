<?php
if (!defined("WHMCS"))
    die("This file cannot be accessed directly");
$action = $_GET["action"];
global $CONFIG;
if ($action == "users") {
    $userActive = 'class="active"';
} elseif ($action == "resellers") {
    $resellerActive = 'class="active"';
} else {
    $dashActive = 'class="active"';
}
?>
<ul class="nav nav-tabs admin-tabs" role="tablist">
    <li class="dropdown pull-right tabdrop hide">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="icon-align-justify"></i> <b class="caret"></b></a>
        <ul class="dropdown-menu"></ul>
    </li>
    <li <?php echo $dashActive; ?>>
        <a style="text-decoration: none;" class="tab-top" href="addonmodules.php?module=zeslecp" role="tab"  data-tab-id="1">ZesleCP Dashboard</a>
    </li>
    <li <?php echo $userActive; ?>>
        <a style="text-decoration: none;" class="tab-top" href="addonmodules.php?module=zeslecp&action=users" role="tab" data-tab-id="1">User Accounts List</a>
    </li>
    <li <?php echo $resellerActive; ?>>
        <a style="text-decoration: none;" class="tab-top" href="addonmodules.php?module=zeslecp&action=resellers" role="tab" data-tab-id="1">Reseller Accounts List</a>
    </li>
</ul>
