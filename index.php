<?php
use Xmf\Request;
use XoopsModules\Tadtools\Utility;
/*-----------引入檔案區--------------*/
require __DIR__ . '/header.php';
$xoopsOption['template_main'] = 'tad_rss_index.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';

/*-----------執行動作判斷區----------*/
$op = Request::getString('op');

switch ($op) {
    default:
        list_tad_rss($xoopsModuleConfig['show_num']);
        $op = 'list_tad_rss';
        break;
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('toolbar', Utility::toolbar_bootstrap($interface_menu, false, $interface_icon));
$xoopsTpl->assign('jquery', Utility::get_jquery(true));
$xoopsTpl->assign('now_op', $op);
require_once XOOPS_ROOT_PATH . '/footer.php';

/*-----------function區--------------*/

//列出所有tad_rss資料
function list_tad_rss($maxitems = 5)
{
    global $xoopsDB, $xoopsTpl, $xoTheme;
    $xoTheme->addScript('modules/tadtools/jqueryCookie/jquery.cookie.js');

    $sql = 'SELECT * FROM `' . $xoopsDB->prefix('tad_rss') . '` WHERE `enable`=?';
    $result = Utility::query($sql, 's', ['1']) or Utility::web_error($sql, __FILE__, __LINE__);

    $data = [];
    $i = 0;
    while (false !== ($all = $xoopsDB->fetchArray($result))) {
        //以下會產生這些變數： $rss_sn , $title , $url , $enable
        foreach ($all as $k => $v) {
            $$k = $v;
        }

        $rss = get_rss_by_simplepie($url, $maxitems);

        $data[$i]['title'] = $title;
        $data[$i]['rss_sn'] = $rss_sn;
        $data[$i]['url'] = $url;
        $data[$i]['link'] = $rss['web']['link'];
        $data[$i]['content'] = $rss['content'];

        //die($rss['content']);
        $i++;
    }
    $xoopsTpl->assign('data', $data);
}

//以 simplepie 來取得RSS
function get_rss_by_simplepie($url = '', $maxitems = 5)
{
    require_once XOOPS_ROOT_PATH . '/modules/tad_rss/class/simplepie/autoloader.php';
    $feed = new SimplePie();
    $feed->set_feed_url($url);

    $feed->init();
    $feed->handle_content_type();

    $feed->set_output_encoding(_CHARSET);
    $feed->set_cache_location(XOOPS_ROOT_PATH . '/uploads/simplepie_cache');

    $arr['web']['title'] = $feed->get_title();
    $arr['web']['link'] = $feed->get_permalink();
    $arr['web']['description'] = $feed->get_description();

    $content = [];
    $i = 0;
    foreach ($feed->get_items(0, $maxitems) as $item) {
        $href = $item->get_permalink();
        $title = $item->get_title();
        $date = $item->get_date('Y-m-d');
        $description = $item->get_description();

        $content[$i]['date'] = $date;
        $content[$i]['href'] = $href;
        $content[$i]['title'] = $title;
        $content[$i]['description'] = nl2br(strip_tags($description));
        $i++;
    }

    $arr['webinfo'] = "<a href='{$arr['web']['link']}' target='_blank'>{$arr['web']['title']}</a>";
    $arr['content'] = $content;

    return $arr;
}
