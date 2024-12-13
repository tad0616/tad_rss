<div class="container">
  <div class="row">
    <div class="col-md-12">
      <form action="main.php" method="post" id="myForm" enctype="multipart/form-data" class="form-horizontal" role="form">
        <{if $rss_sn|default:false}>
          <div class="form-group row mb-3">
            <div class="col-md-8">
              <input type="text" name="title" value="<{$title|default:''}>" class="form-control" placeholder="<{$smarty.const._MA_TADRSS_TITLE}>">
            </div>
            <div class="col-md-4">
              <div class="form-check-inline radio-inline">
                  <label class="form-check-label">
                      <input class="form-check-input" type="radio" name="enable" value="1" <{if $enable=='1'}>checked<{/if}>>
                      <{$smarty.const._YES}>
                  </label>
              </div>
              <div class="form-check-inline radio-inline">
                  <label class="form-check-label">
                      <input class="form-check-input" type="radio" name="enable" value="0" <{if $enable=='0'}>checked<{/if}>>
                      <{$smarty.const._NO}>
                  </label>
              </div>
            </div>
          </div>
          <input type="hidden" name="rss_sn" value="<{$rss_sn|default:''}>">
        <{/if}>

        <div class="form-group row mb-3">
          <div class="col-md-1">
            <label for="url" class="col-form-label text-md-right text-md-end control-label"><{$smarty.const._MA_TADRSS_URL}></label>
          </div>
          <div class="col-md-10">
            <input type="text" name="url" value="<{$rss_url|default:''}>" id="url" placeholder="<{$smarty.const._MA_TADRSS_URL}>" class="form-control">
          </div>
          <div class="col-md-1">
            <input type="hidden" name="op" value="<{$next_op|default:''}>">
            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-disk" aria-hidden="true"></i>  <{$smarty.const._TAD_SAVE}></button>
          </div>
        </div>
      </form>

      <{if $all_data|default:false}>
        <table class="table table-striped table-hover">
          <tr>
            <th><{$smarty.const._MA_TADRSS_TITLE}></th>
            <th><{$smarty.const._MA_TADRSS_URL}></th>
            <th><{$smarty.const._MA_TADRSS_ENABLE}></th>
            <th><{$smarty.const._TAD_FUNCTION}></th>
          </tr>
          <tbody>
            <{foreach item=rss from=$all_data}>
              <tr>
                <td><{$rss.title}></td>
                <td><a href="<{$rss.url}>" target="_blank"><{$rss.url}></a></td>
                <td><a href="main.php?op=change_enable&rss_sn=<{$rss.rss_sn}>&enable=<{$rss.new_enable}>"><img src="../images/<{$rss.enable}>.gif"></a></td>
                <td>
                <a href="main.php?rss_sn=<{$rss.rss_sn}>" class="btn btn-sm btn-xs btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i>  <{$smarty.const._TAD_EDIT}></a>
                <a href="javascript:delete_tad_rss_func(<{$rss.rss_sn}>);" class="btn btn-sm btn-xs btn-danger"><i class="fa fa-trash" aria-hidden="true"></i> <{$smarty.const._TAD_DEL}></a>
                </td>
              </tr>
            <{/foreach}>
          </tbody>
        </table>
        <div class="bar"><{$bar|default:''}></div>
      <{/if}>
    </div>
  </div>
</div>