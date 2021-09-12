<?php

use WHMCS\Database\Capsule;

require_once dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/init.php';

require_once '../Pagination.php';
$totalUsers = Capsule::table('mod_zeslecp_users')->where("reseller", 0)->orderBy("updated_at", "DESC")->count();

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
$users = Capsule::table('mod_zeslecp_users')->where("reseller", 0)->limit($limit)->offset($page * $limit)->orderBy("updated_at", "DESC")->get();
?>
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
   


