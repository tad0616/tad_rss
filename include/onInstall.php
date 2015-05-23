<?php
function xoops_module_install_tad_rss(&$module) {
    mk_dir(XOOPS_ROOT_PATH."/uploads/magpierss_cache");
    mk_dir(XOOPS_ROOT_PATH."/uploads/simplepie_cache");
    mk_dir(XOOPS_ROOT_PATH.'/uploads/tad_rss');
    mk_dir(XOOPS_ROOT_PATH.'/uploads/tad_rss/thumbs');
    return true;
}

//建立目錄
function mk_dir($dir=""){
    //若無目錄名稱秀出警告訊息
    if(empty($dir))redirect_header("index.php", 3, "empty director name");
    //若目錄不存在的話建立目錄
    if (!is_dir($dir)) {
        umask(000);
        //若建立失敗秀出警告訊息
        if(!mkdir($dir, 0777)){
            redirect_header("index.php", 3,"create $dir fail!");
        }
    }
    return true;
}
?>
