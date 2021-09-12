<?php

use WHMCS\Database\Capsule;

if (!defined("WHMCS"))
    die("This file cannot be accessed directly");
global $CONFIG;
require_once dirname(__DIR__) . '/inc/header.php';
require_once dirname(__DIR__) . '/inc/nav.php';
require_once dirname(__DIR__) . '/API/ZesleCPAPI.php';
require_once 'Pagination.php';
$totalUsers = Capsule::table('mod_zeslecp_users')->where("reseller", 0)->count();
$zeslecp = new ZesleCPAPI($vars["API_Key"], $vars["API_Secret"], $vars["Server_URL"]);

/*
 * Pagination
 */
$page = !empty($_POST['page']) ? $_POST['page'] : 0;
if (!empty($_POST['limit'])) {
    $limit = $_POST['limit'];
} else {
    $limit = 10;
}
if (!empty($_POST['page'])) {
    $pagConfig = array('baseURL' => '../modules/addons/zeslecp/Admin/Actions/GetPaginationUsers.php', 'totalRows' => $totalUsers, 'currentPage' => $page, 'perPage' => $limit, 'contentDiv' => '#usersTable');
} else {
    $pagConfig = array('baseURL' => '../modules/addons/zeslecp/Admin/Actions/GetPaginationUsers.php', 'totalRows' => $totalUsers, 'perPage' => $limit, 'contentDiv' => '#usersTable');
}
$pagination = new Pagination($pagConfig);
$response = $zeslecp->getPackagesList();
$data = json_decode($response, true);
$packages = $data["data"];
$pkgOptions = "";
foreach ($packages as $package) {
    $pkgOptions .= '<option value="' . $package["id"] . '">' . $package["name"] . '</option>';
}
$users = Capsule::table('mod_zeslecp_users')->where("reseller", 0)->limit($limit)->offset($page * $limit)->orderBy("updated_at", "DESC")->get();
?>

<div class="tab-content admin-tabs zeslecp">
    <div class="tab-pane active" id="tab1">
        <div class="row" style="margin-bottom: 10px;">
            <div class="col-md-4 showEntries"  style="margin-top: 10px;">
                Show
                <select class="form-control select-inline" id="limit" name="limit">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                entries
            </div>
            <div class="col-md-8" style="text-align:right">
                <button id="addNewUser" class="btn btn-primary">
                    <i class="fas fa-plus"></i> &nbsp;Add a New User
                </button>&nbsp;&nbsp;
                <button id="isUsers" class="btn btn-warning">
                    <i class="fas fa-sync"></i> &nbsp;Import & Synchronize Users
                </button>
            </div>
        </div>
        <div id="usersTable">
            <table class="datatable" width="100%" cellspacing="2" cellpadding="3" border="0">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) { ?>
                        <tr>
                            <td><?php echo $user->username; ?></td>
                            <td><?php echo $user->name; ?></td>
                            <td><?php echo $user->email ?></td>
                            <td>
                                <?php
                                if ($user->status == 1) {
                                    echo "Active";
                                } elseif ($user->status == 0) {
                                    echo "Inactive";
                                } elseif ($user->status == 2) {
                                    echo "Suspended";
                                }
                                ?>
                            </td>
                            <td>
                                <?php if ($user->status == 0 || $user->status == 1) { ?>
                                    <a class="zeslecpUserEdit btn btn-outline-primary" data-user-id="<?php echo $user->user_id; ?>" href="javascript:void(0);">
                                        <i class="fal fa-edit"></i> Edit
                                    </a>
                                <?php } if ($user->status == 1) { ?>
                                    <a class="zeslecpUserSuspend btn btn-warning" data-user-username="<?php echo $user->username; ?>" data-user-id="<?php echo $user->user_id; ?>" href="javascript:void(0);">
                                        <i class="fal fa-lock-alt"></i> Suspend
                                    </a>
                                <?php } if ($user->status == 1) { ?>
                                    <a class="zeslecpUserTrash btn btn-danger" data-user-username="<?php echo $user->username; ?>" data-user-id="<?php echo $user->user_id; ?>" href="javascript:void(0);">
                                        <i class="fal fa-trash-alt"></i> Terminate
                                    </a>
                                <?php } if ($user->status == 2) { ?>
                                    <a class="zeslecpUserUnsuspend btn btn-warning" data-user-username="<?php echo $user->username; ?>" data-user-id="<?php echo $user->user_id; ?>" href="javascript:void(0);">
                                        <i class="far fa-lock-open-alt"></i> Unsuspend
                                    </a>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php
                    }
                    if ($totalUsers == 0) {
                        ?>
                        <tr>
                            <td colspan="5">No Record Found</td>
                        </tr>
                    <?php }
                    ?>
                </tbody>
            </table>
            <?php echo $pagination->createLinks($limit); ?>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" aria-hidden="true" id="addNewUserModal">
    <div class="modal-dialog" style="width:45%;">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Add a New User</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -23px;">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="upperPart">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Name</label> 
                            <div class="form-group">
                                <input type="text" id="userName" autocomplete="off" class="form-control input-400"/>
                                <span class="error1"></span>
                                <span>Name of a user (allowed: letters, numbers, space, dashes and underscore, min: 3 chars, max: 255 chars).</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Username</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="text" id="userUsername" autocomplete="off" class="form-control input-400"/>
                                <span class="error2"></span>
                                <span>Unique username of a user (allowed: alpha numeric only, min: 3 chars, max: 30 chars).</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Primary Domain</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="text" id="primaryDomain" autocomplete="off" class="form-control input-400"/>
                                <span class="error3"></span>
                                <span>Unique primary domain of a user (allowed: valid domain without http/https protocol, min: 3 chars, max: 63 chars).</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Password</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <div class="row">
                                    <div class="col-md-9">
                                        <input type="password" id="password" autocomplete="off" class="form-control input-400"/>
                                    </div>
                                    <div class="col-md-3">
                                        <input id="addPwdGenerator" class="btn btn-primary" type="button" value="Generate" style="padding: 4px 12px;"/>
                                    </div>
                                </div>
                                <span class="error4"></span>
                                <span>Password for a user (min: 8 chars, max: 50 chars). Password must contain 2 chars of each (lower alpha, upper alpha, numeric and special characters)</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Re-type Password</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="text" id="rpassword" autocomplete="off" class="form-control input-400"/>
                                <span class="error5"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Email</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="text" id="userEmail" autocomplete="off" class="form-control input-400"/>
                                <span class="error6"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Choose a Package</label> 
                            <div class="form-group">
                                <select id="pkgId" class="form-control input-400">
                                    <option value="">Select...</option>
                                    <?php echo $pkgOptions; ?>
                                </select>
                                <span class="error7"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="text-align: center;margin-top: 10px;">
                        <input id="createNewUserBtn" class="btn btn-primary" type="button" value="Create User"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="text-align: center;margin-top: 4px;">
                        <p id="invalidAPIError" style="color:#f46a6a; display: none;"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" aria-hidden="true" id="editUserModal">
    <div class="modal-dialog" style="width:45%;">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Edit a User</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -23px;">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="upperPart">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Name</label> 
                            <div class="form-group">
                                <input type="hidden" id="useId" value=""/>
                                <input type="text" id="euserName" autocomplete="off" class="form-control input-400"/>
                                <span class="eerror1"></span>
                                <span>Name of a user (allowed: letters, numbers, space, dashes and underscore, min: 3 chars, max: 255 chars).</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Username</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="text" id="euserUsername" autocomplete="off" class="form-control input-400"/>
                                <span class="eerror2"></span>
                                <span>Unique username of a user (allowed: alpha numeric only, min: 3 chars, max: 30 chars).</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Primary Domain</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="text" id="eprimaryDomain" autocomplete="off" class="form-control input-400"/>
                                <span class="eerror3"></span>
                                <span>Unique primary domain of a user (allowed: valid domain without http/https protocol, min: 3 chars, max: 63 chars).</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Password</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <div class="row">
                                    <div class="col-md-9">
                                        <input type="password" id="epassword" autocomplete="off" class="form-control input-400" value=""/>
                                    </div>
                                    <div class="col-md-3">
                                        <input id="editPwdGenerator" class="btn btn-primary" type="button" value="Generate" style="padding: 4px 12px;"/>
                                    </div>
                                </div>
                                <span class="eerror4"></span>
                                <span>Password for a user (min: 8 chars, max: 50 chars). Password must contain 2 chars of each (lower alpha, upper alpha, numeric and special characters)</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Re-type Password</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="text" id="erpassword" autocomplete="off" class="form-control input-400" value=""/>
                                <span class="eerror5"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Email</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="text" id="euserEmail" autocomplete="off" class="form-control input-400"/>
                                <span class="eerror6"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Choose a Package</label> 
                            <div class="form-group">
                                <select id="epkgId" class="form-control input-400">
                                    <option value="">Select...</option>
                                    <?php echo $pkgOptions; ?>
                                </select>
                                <span class="eerror7"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="text-align: center;margin-top: 10px;">
                        <input id="editUserBtn" class="btn btn-primary" type="button" value="Edit User"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="text-align: center;margin-top: 4px;">
                        <p id="einvalidAPIError" style="color:#f46a6a; display: none;"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
