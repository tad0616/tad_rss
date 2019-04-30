<?php

use XoopsModules\Tadtools\Utility;
use XoopsModules\Tad_rss\Update;

function xoops_module_update_tad_rss(&$module, $old_version)
{
    global $xoopsDB;

    Update::chk_tad_rss_block();

    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/tad_rss');
    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/tad_rss/thumbs');

    return true;
}
