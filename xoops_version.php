<?php
$modversion = [];
global $xoopsConfig;

//---模組基本資訊---//
$modversion['name'] = _MI_TADRSS_NAME;
// $modversion['version'] = 2.6;
$modversion['version'] = $_SESSION['xoops_version'] >= 20511 ? '3.0.0-Stable' : '3.0';
$modversion['description'] = _MI_TADRSS_DESC;
$modversion['author'] = _MI_TADRSS_AUTHOR;
$modversion['credits'] = _MI_TADRSS_CREDITS;
$modversion['help'] = 'page=help';
$modversion['license'] = 'GNU GPL 2.0';
$modversion['license_url'] = 'www.gnu.org/licenses/gpl-2.0.html/';
$modversion['image'] = "images/logo_{$xoopsConfig['language']}.png";
$modversion['dirname'] = basename(__DIR__);

//---模組狀態資訊---//
$modversion['release_date'] = '2024-12-12';
$modversion['module_website_url'] = 'https://tad0616.net/';
$modversion['module_website_name'] = _MI_TAD_WEB;
$modversion['module_status'] = 'release';
$modversion['author_website_url'] = 'https://tad0616.net/';
$modversion['author_website_name'] = _MI_TAD_WEB;
$modversion['min_php'] = 5.6;
$modversion['min_xoops'] = '2.5.10';

//---paypal資訊---//
$modversion['paypal'] = [
    'business' => 'tad0616@gmail.com',
    'item_name' => 'Donation : ' . _MI_TAD_WEB,
    'amount' => 0,
    'currency_code' => 'USD',
];

//---資料表架構---//
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][1] = 'tad_rss';

//---啟動後台管理界面選單---//
$modversion['system_menu'] = 1;

//---管理介面設定---//
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = 'admin/menu.php';

//---使用者主選單設定---//
$modversion['hasMain'] = 1;

$modversion['onInstall'] = 'include/onInstall.php';
$modversion['onUpdate'] = 'include/onUpdate.php';
//---樣板設定---//
$modversion['templates'] = [
    ['file' => 'tad_rss_index.tpl', 'description' => 'tad_rss_index.tpl'],
    ['file' => 'tad_rss_admin.tpl', 'description' => 'tad_rss_admin.tpl'],
];

//---區塊設定---//
$modversion['blocks'] = [
    1 => [
        'file' => 'tad_rss_show.php',
        'name' => _MI_TADRSS_BNAME1,
        'description' => _MI_TADRSS_BDESC1,
        'show_func' => 'tad_rss_show',
        'template' => 'tad_rss_show.tpl',
        'edit_func' => 'tad_rss_show_edit',
        'options' => '|10',
    ],
];

//---偏好設定---//
$modversion['config'] = [
    [
        'name' => 'show_num',
        'title' => '_MI_TADRSS_SHOW_NUM',
        'description' => '_MI_TADRSS_SHOW_NUM_DESC',
        'formtype' => 'textbox',
        'valuetype' => 'int',
        'default' => '10',
    ],
];
