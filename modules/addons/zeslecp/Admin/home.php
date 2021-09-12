<?php
if (!defined("WHMCS"))
    die("This file cannot be accessed directly");
global $CONFIG;
require_once dirname(__DIR__) . '/inc/header.php';
require_once dirname(__DIR__) . '/inc/nav.php';
require_once dirname(__DIR__) . '/API/ZesleCPAPI.php';
require_once 'Pagination.php';
$zeslecp = new ZesleCPAPI($vars["API_Key"], $vars["API_Secret"], $vars["Server_URL"]);
$response = $zeslecp->getPackagesList();
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
    $page = 0;
    $limit = $data["per_page"];
    $totalPackages = $data["total"];
    $pagConfig = array('baseURL' => '../modules/addons/zeslecp/Admin/Actions/GetPaginationPackages.php', 'totalRows' => $totalPackages, 'perPage' => $limit, 'contentDiv' => '#packagesTable');
    $pagination = new Pagination($pagConfig);
}
?>

<div class="tab-content admin-tabs zeslecp">
    <div class="tab-pane active" id="tab1">
        <div class="row" style="margin-bottom: 10px;">
            <div class="col-md-12" style="text-align:right">
                <button id="addNewPkg" class="btn btn-primary">
                    <i class="fas fa-plus"></i> &nbsp;Add a New Package
                </button>&nbsp;&nbsp;
            </div>
        </div>
        <div id="packagesTable">
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
            <?php echo $pagination ? $pagination->createLinks($limit) : ''; ?>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" aria-hidden="true" id="addNewPackageModal">
    <div class="modal-dialog" style="width:50%;">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Add a New Package</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -23px;">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="upperPart">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Package Name</label> 
                            <div class="form-group">
                                <input type="input" id="pkgName" autocomplete="off" class="form-control input-400"/>
                                <span class="error1"></span>
                                <span>A unique name of the package (allowed: letters, numbers, space, dashes and underscore, min: 3 chars, max: 64 chars).</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Monthly Bandwidth (GB)</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="number" id="mBW" autocomplete="off" class="form-control input-400"/>
                                <span class="error2"></span>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="umBW" value="-1"/> &nbsp; Unlimited
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Disk Quota (GB)</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="number" id="diskQ" autocomplete="off" class="form-control input-400"/>
                                <span class="error3"></span>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="uDiskQ" value="-1"/> &nbsp; Unlimited
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Max Parked Domains</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="number" id="mpDomains" autocomplete="off" class="form-control input-400"/>
                                <span class="error4"></span>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="umpDomains" value="-1"/> &nbsp; Unlimited
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Max Addon Domains</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="number" id="maDomains" autocomplete="off" class="form-control input-400"/>
                                <span class="error5"></span>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="umaDomains" value="-1"/> &nbsp; Unlimited
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Max Sub Domains</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="number" id="msDomains" autocomplete="off" class="form-control input-400"/>
                                <span class="error6"></span>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="umsDomains" value="-1"/> &nbsp; Unlimited
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Max Email Accounts</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="number" id="meAccount" autocomplete="off" class="form-control input-400"/>
                                <span class="error7"></span>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="umeAccount" value="-1"/> &nbsp; Unlimited
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Max Quote Per Email Account</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="number" id="mqpeAccount" autocomplete="off" class="form-control input-400"/>
                                <span class="error8"></span>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="umqpeAccount" value="-1"/> &nbsp; Unlimited
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Max Email Forwarders</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="number" id="meForwarders" autocomplete="off" class="form-control input-400"/>
                                <span class="error9"></span>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="umeForwarders" value="-1"/> &nbsp; Unlimited
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Max Mailing Lists</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="number" id="mmLists" autocomplete="off" class="form-control input-400"/>
                                <span class="error10"></span>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="ummLists" value="-1"/> &nbsp; Unlimited
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Max Autoresponders</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="number" id="mAutoresponders" autocomplete="off" class="form-control input-400"/>
                                <span class="error11"></span>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="umAutoresponders" value="-1"/> &nbsp; Unlimited
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Max MySQL Databases</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="number" id="mmDatabases" autocomplete="off" class="form-control input-400"/>
                                <span class="error12"></span>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="ummDatabases" value="-1"/> &nbsp; Unlimited
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Max FTP Accounts</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="number" id="mfAccounts" autocomplete="off" class="form-control input-400"/>
                                <span class="error13"></span>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="umfAccounts" value="-1"/> &nbsp; Unlimited
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Max User Accounts</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="number" id="muAccounts" autocomplete="off" class="form-control input-400"/>
                                <span class="error14"></span>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="umuAccounts" value="-1"/> &nbsp; Unlimited
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Maximum Hourly Email by Domain Relayed</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="number" id="mhebdRelayed" autocomplete="off" class="form-control input-400"/>
                                <span class="error15"></span>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="umhebdRelayed" value="-1"/> &nbsp; Unlimited
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Maximum percentage of failed or deferred messages a domain may send per hour</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="number" id="mpofodmadmspHour" autocomplete="off" class="form-control input-400"/>
                                <span class="error16"></span>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="umpofodmadmspHour" value="-1"/> &nbsp; Unlimited
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="lowerPart">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="checkbox" id="dedicatedIP" value="y"/> &nbsp; Dedicated IP
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="checkbox" id="shellAccess" value="y"/> &nbsp; Shell Access
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="checkbox" id="cgiAccess" value="y"/> &nbsp; CGI Access
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>ZesleCP Theme</label> 
                            <div class="form-group">
                                <select id="themeId" class="form-control input-400">
                                    <option value="">Select...</option>
                                    <option value="1">default</option>
                                </select>
                                <span class="error17"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Locale</label> 
                            <div class="form-group">
                                <select id="locale" class="form-control input-400">
                                    <option value="">Select...</option>
                                    <option value="1">English</option>
                                </select>
                                <span class="error18"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="text-align: center;margin-top: 10px;">
                        <input id="createNewPackageBtn" class="btn btn-primary" type="button" value="Create Package"/>
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
<div class="modal" tabindex="-1" role="dialog" aria-hidden="true" id="editPackageModal">
    <div class="modal-dialog" style="width:50%;">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Edit Package</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -23px;">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="upperPart">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Package Name</label> 
                            <div class="form-group">
                                <input type="hidden" id="pkgId" value=""/>
                                <input type="input" id="epkgName" autocomplete="off" class="form-control input-400"/>
                                <span class="eerror1"></span>
                                <span>A unique name of the package (allowed: letters, numbers, space, dashes and underscore, min: 3 chars, max: 64 chars).</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Monthly Bandwidth (GB)</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="number" id="emBW" autocomplete="off" class="form-control input-400"/>
                                <span class="eerror2"></span>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="eumBW" value="-1"/> &nbsp; Unlimited
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Disk Quota (GB)</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="number" id="ediskQ" autocomplete="off" class="form-control input-400"/>
                                <span class="eerror3"></span>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="euDiskQ" value="-1"/> &nbsp; Unlimited
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Max Parked Domains</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="number" id="empDomains" autocomplete="off" class="form-control input-400"/>
                                <span class="eerror4"></span>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="eumpDomains" value="-1"/> &nbsp; Unlimited
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Max Addon Domains</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="number" id="emaDomains" autocomplete="off" class="form-control input-400"/>
                                <span class="eerror5"></span>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="eumaDomains" value="-1"/> &nbsp; Unlimited
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Max Sub Domains</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="number" id="emsDomains" autocomplete="off" class="form-control input-400"/>
                                <span class="eerror6"></span>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="eumsDomains" value="-1"/> &nbsp; Unlimited
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Max Email Accounts</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="number" id="emeAccount" autocomplete="off" class="form-control input-400"/>
                                <span class="eerror7"></span>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="eumeAccount" value="-1"/> &nbsp; Unlimited
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Max Quote Per Email Account</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="number" id="emqpeAccount" autocomplete="off" class="form-control input-400"/>
                                <span class="eerror8"></span>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="eumqpeAccount" value="-1"/> &nbsp; Unlimited
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Max Email Forwarders</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="number" id="emeForwarders" autocomplete="off" class="form-control input-400"/>
                                <span class="eerror9"></span>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="eumeForwarders" value="-1"/> &nbsp; Unlimited
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Max Mailing Lists</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="number" id="emmLists" autocomplete="off" class="form-control input-400"/>
                                <span class="eerror10"></span>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="eummLists" value="-1"/> &nbsp; Unlimited
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Max Autoresponders</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="number" id="emAutoresponders" autocomplete="off" class="form-control input-400"/>
                                <span class="eerror11"></span>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="eumAutoresponders" value="-1"/> &nbsp; Unlimited
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Max MySQL Databases</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="number" id="emmDatabases" autocomplete="off" class="form-control input-400"/>
                                <span class="eerror12"></span>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="eummDatabases" value="-1"/> &nbsp; Unlimited
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Max FTP Accounts</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="number" id="emfAccounts" autocomplete="off" class="form-control input-400"/>
                                <span class="eerror13"></span>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="eumfAccounts" value="-1"/> &nbsp; Unlimited
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Max User Accounts</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="number" id="emuAccounts" autocomplete="off" class="form-control input-400"/>
                                <span class="eerror14"></span>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="eumuAccounts" value="-1"/> &nbsp; Unlimited
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Maximum Hourly Email by Domain Relayed</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="number" id="emhebdRelayed" autocomplete="off" class="form-control input-400"/>
                                <span class="eerror15"></span>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="eumhebdRelayed" value="-1"/> &nbsp; Unlimited
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Maximum percentage of failed or deferred messages a domain may send per hour</label> 
                            <div class="form-group" style="margin-bottom: 6px;">
                                <input type="number" id="empofodmadmspHour" autocomplete="off" class="form-control input-400"/>
                                <span class="eerror16"></span>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="eumpofodmadmspHour" value="-1"/> &nbsp; Unlimited
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="lowerPart">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="checkbox" id="ededicatedIP" value="y"/> &nbsp; Dedicated IP
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="checkbox" id="eshellAccess" value="y"/> &nbsp; Shell Access
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="checkbox" id="ecgiAccess" value="y"/> &nbsp; CGI Access
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>ZesleCP Theme</label> 
                            <div class="form-group">
                                <select id="ethemeId" class="form-control input-400">
                                    <option value="">Select...</option>
                                    <option value="1">default</option>
                                </select>
                                <span class="eerror17"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Locale</label> 
                            <div class="form-group">
                                <select id="elocale" class="form-control input-400">
                                    <option value="">Select...</option>
                                    <option value="1">English</option>
                                </select>
                                <span class="eerror18"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="text-align: center;margin-top: 10px;">
                        <input id="editPackageBtn" class="btn btn-primary" type="button" value="Edit Package"/>
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
