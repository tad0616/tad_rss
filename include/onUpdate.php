<?php

use XoopsModules\Tad_rss\Utility;

function xoops_module_update_tad_rss(&$module, $old_version)
{
    global $xoopsDB;

    //if(!tad_rss_chk_chk1()) tad_rss_go_update1();
    Utility::chk_tad_rss_block();

    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/tad_rss');
    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/tad_rss/thumbs');

    return true;
}



