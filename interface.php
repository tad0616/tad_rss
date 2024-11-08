<?php
//判斷是否對該模組有管理權限
if (!isset($_SESSION['tad_rss_adm'])) {
    $_SESSION['tad_rss_adm'] = isset($xoopsUser) && \is_object($xoopsUser) ? $xoopsUser->isAdmin() : false;
}

$interface_menu[_MD_TADRSS_INDEX] = 'index.php';
$interface_icon[_MD_TADRSS_INDEX] = "fa-rss";
