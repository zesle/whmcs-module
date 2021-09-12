<?php

use WHMCS\Database\Capsule;

require_once dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/init.php';

require_once '../Pagination.php';
$apiKey = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "API_Key")->first()->value;
$apiSecret = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "API_Secret")->first()->value;
$serverURL = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "Server_URL")->first()->value;
$zeslecp = new ZesleCPAPI($apiKey, $apiSecret, $serverURL);

$page = !empty($_POST['page']) ? $_POST['page']+1 : 1;

$response = $zeslecp->getPackagesListPage($page);
$error = 0;
if (preg_match("/Error:/", $response)) {
    $error = 1;
} else {
    $data = json_decode($response, true);
    $packages = $data["data"];
    $totalPkgs = count($packages);
    /*
     * Pagination
     */
    $totalPackages = $data["total"];
    $page = !empty($_POST['page']) ? $_POST['page'] : 0;
    if (!empty($_POST['page'])) {
        $pagConfig = array('baseURL' => '../modules/addons/zeslecp/Admin/Actions/GetPaginationPackages.php', 'totalRows' => $totalPackages, 'currentPage' => $page, 'perPage' => $limit, 'contentDiv' => '#packagesTable');
    } else {
        $pagConfig = array('baseURL' => '../modules/addons/zeslecp/Admin/Actions/GetPaginationPackages.php', 'totalRows' => $totalPackages, 'perPage' => $limit, 'contentDiv' => '#packagesTable');
    }
    $pagination = new Pagination($pagConfig);
}
?>
<table class="datatable" width="100%" cellspacing="2" cellpadding="3" border="0">
    <tbody>
        <tr>
            <th>Package</th>
            <th>Disk Quota</th>
            <th>Max Domains</th>
            <th>Max Sub Domains</th>
            <th>Max Databases</th>
            <th></th>
        </tr>
        <?php foreach ($packages as $package) { ?>
            <tr>
                <td><?php echo $package["name"]; ?></td>
                <td><?php echo $package["disk_quota"]; ?></td>
                <td><?php echo $package["max_addon_domains"]; ?></td>
                <td><?php echo $package["max_subdomains"]; ?></td>
                <td><?php echo $package["max_mysql_databases"]; ?></td>
                <td><a class="zeslecpPkg btn btn-outline-primary" data-pkg-id="<?php echo $package["id"]; ?>" href="javascript:void(0);">
                        <i class="fal fa-edit"></i> Edit
                    </a>
                </td>
            </tr>
            <?php
        }
        if ($error) {
            ?>
            <tr>
                <td colspan="6" style="color:red;"><?php echo $response; ?></td>
            </tr>

            <?php
        } elseif ($totalPkgs == 0) {
            ?>
            <tr>
                <td colspan="6">No Record Found</td>
            </tr>
        <?php }
        ?>
    </tbody>
</table>
<?php echo $pagination->createLinks($limit); ?>
   