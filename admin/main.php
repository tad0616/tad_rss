<?php
use Xmf\Request;
use XoopsModules\Tadtools\SweetAlert;
use XoopsModules\Tadtools\Utility;
/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = 'tad_rss_admin.tpl';
require_once __DIR__ . '/header.php';

/*-----------執行動作判斷區----------*/
$op = Request::getString('op');
$rss_sn = Request::getInt('rss_sn');
$enable = Request::getInt('enable', 1);

switch ($op) {

    //更新資料
    case 'update_tad_rss':
        update_tad_rss($rss_sn);
        header("location: {$_SERVER['PHP_SELF']}");
        exit;

    //新增資料
    case 'insert_tad_rss':
        insert_tad_rss();
        header("location: {$_SERVER['PHP_SELF']}");
        exit;

    //刪除資料
    case 'delete_tad_rss':
        delete_tad_rss($rss_sn);
        header("location: {$_SERVER['PHP_SELF']}");
        exit;

    case 'change_enable':
        change_enable($rss_sn, $enable);
        header("location: {$_SERVER['PHP_SELF']}");
        exit;

    //預設動作
    default:
        tad_rss_form($rss_sn);
        list_tad_rss($rss_sn);
        break;

}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('now_op', $op);
require_once __DIR__ . '/footer.php';

/*-----------function區--------------*/
//tad_rss編輯表單
function tad_rss_form($rss_sn = '')
{
    global $xoopsTpl;

    //抓取預設值
    if (!empty($rss_sn)) {
        $DBV = get_tad_rss($rss_sn);
    } else {
        $DBV = [];
    }

    //預設值設定

    //設定「rss_sn」欄位預設值
    $rss_sn = (!isset($DBV['rss_sn'])) ? '' : $DBV['rss_sn'];

    //設定「title」欄位預設值
    $title = (!isset($DBV['title'])) ? '' : $DBV['title'];

    //設定「url」欄位預設值
    $rss_url = (!isset($DBV['url'])) ? '' : $DBV['url'];

    //設定「enable」欄位預設值
    $enable = (!isset($DBV['enable'])) ? '1' : $DBV['enable'];

    $op = (empty($rss_sn)) ? 'insert_tad_rss' : 'update_tad_rss';

    $xoopsTpl->assign('rss_sn', $rss_sn);
    $xoopsTpl->assign('title', $title);
    $xoopsTpl->assign('enable', $enable);
    $xoopsTpl->assign('rss_url', $rss_url);
    $xoopsTpl->assign('next_op', $op);
}

//新增資料到tad_rss中
function insert_tad_rss()
{
    global $xoopsDB;

    require_once XOOPS_ROOT_PATH . '/modules/tad_rss/class/simplepie/autoloader.php';
    $feed = new SimplePie();
    $feed->set_feed_url($_POST['url']);
    $feed->set_cache_location(XOOPS_ROOT_PATH . '/uploads/simplepie_cache');
    $feed->init();
    $feed->handle_content_type();
    $feed->set_output_encoding(_CHARSET);
    $title = $feed->get_title();

    $sql = 'INSERT INTO `' . $xoopsDB->prefix('tad_rss') . '` (`title`, `url`, `enable`) VALUES (?, ?, ?)';
    Utility::query($sql, 'sss', [$title, $_POST['url'], '1']) or Utility::web_error($sql, __FILE__, __LINE__);

    //取得最後新增資料的流水編號
    $rss_sn = $xoopsDB->getInsertId();

    return $rss_sn;
}

//列出所有tad_rss資料
function list_tad_rss($rss_sn = 1)
{
    global $xoopsDB, $xoopsTpl;

    $SweetAlert = new SweetAlert();
    $SweetAlert->render("delete_tad_rss_func", "main.php?op=delete_tad_rss&rss_sn=", 'rss_sn');

    $sql = 'SELECT * FROM ' . $xoopsDB->prefix('tad_rss') . '';

    //Utility::getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
    $PageBar = Utility::getPageBar($sql, 20, 10);
    $bar = $PageBar['bar'];
    $sql = $PageBar['sql'];

    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    $all_data = [];
    $i = 0;
    while (false !== ($all = $xoopsDB->fetchArray($result))) {
        //以下會產生這些變數： $rss_sn , $title , $url , $enable
        foreach ($all as $k => $v) {
            $$k = $v;
        }

        $all_data[$i]['title'] = $title;
        $all_data[$i]['url'] = $url;
        $all_data[$i]['enable'] = $enable;
        $all_data[$i]['rss_sn'] = $rss_sn;
        $new_enable = 1 == $enable ? 0 : 1;
        $all_data[$i]['new_enable'] = $new_enable;
        $i++;
    }

    $xoopsTpl->assign('all_data', $all_data);
    $xoopsTpl->assign('bar', $bar);
}

//以流水號取得某筆tad_rss資料
function get_tad_rss($rss_sn = '')
{
    global $xoopsDB;
    if (empty($rss_sn)) {
        return;
    }

    $sql = 'SELECT * FROM `' . $xoopsDB->prefix('tad_rss') . '` WHERE `rss_sn`=?';
    $result = Utility::query($sql, 'i', [$rss_sn]) or Utility::web_error($sql, __FILE__, __LINE__);

    $data = $xoopsDB->fetchArray($result);

    return $data;
}

//更新tad_rss某一筆資料
function update_tad_rss($rss_sn = '')
{
    global $xoopsDB;

    $sql = 'UPDATE `' . $xoopsDB->prefix('tad_rss') . '` SET `title` = ?, `url` = ?, `enable` = ? WHERE `rss_sn` = ?';
    Utility::query($sql, 'sssi', [$_POST['title'], $_POST['url'], $_POST['enable'], $rss_sn]) or Utility::web_error($sql, __FILE__, __LINE__);

    return $rss_sn;
}

//更新狀態
function change_enable($rss_sn, $enable = '1')
{
    global $xoopsDB;

    $sql = 'UPDATE `' . $xoopsDB->prefix('tad_rss') . '` SET `enable` = ? WHERE `rss_sn` = ?';
    Utility::query($sql, 'si', [$enable, $rss_sn]) or Utility::web_error($sql, __FILE__, __LINE__);

}

//刪除tad_rss某筆資料資料
function delete_tad_rss($rss_sn = '')
{
    global $xoopsDB;
    $sql = 'DELETE FROM `' . $xoopsDB->prefix('tad_rss') . '` WHERE `rss_sn`=?';
    Utility::query($sql, 'i', [$rss_sn]) or Utility::web_error($sql, __FILE__, __LINE__);

}
