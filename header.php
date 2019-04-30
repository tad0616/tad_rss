<?php
use XoopsModules\Tadtools\Utility;
include_once '../../mainfile.php';
include_once 'function.php';
if ('1' == $xoopsModuleConfig['use_pda'] and false === mb_strpos($_SESSION['theme_kind'], 'bootstrap')) {
    Utility::mobile_device_detect(true, false, true, true, true, true, true, 'pda.php', false);

}

//判斷是否對該模組有管理權限
$isAdmin = false;
if ($xoopsUser) {
    $module_id = $xoopsModule->getVar('mid');
    $isAdmin = $xoopsUser->isAdmin($module_id);
}

$interface_menu[_TAD_TO_MOD] = 'index.php';
if ($isAdmin) {
    $interface_menu[_TAD_TO_ADMIN] = 'admin/main.php';
}
