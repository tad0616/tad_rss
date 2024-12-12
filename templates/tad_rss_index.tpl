<{$toolbar|default:''}>

<script type="text/javascript">
  $(document).ready(function() {
    var $tabs = $("#rss-tabs").tabs({ cookie: { expires: 30 } , collapsible: true});
  });
</script>

<h1 class="sr-only visually-hidden">All RSS</h1>

<div id="rss-tabs">
  <ul>
    <{foreach item=web from=$data}>
      <li><a href="#rss-tabs-<{$web.rss_sn}>"><{$web.title}></a></li>
    <{/foreach}>
  </ul>
  <{foreach item=rss from=$data}>
    <div id="rss-tabs-<{$rss.rss_sn}>">
      <div class="alert alert-info">
        <h2>
          <a href="<{$rss.link}>"><{$rss.title}></a>
          <{if $smarty.session.tad_rss_adm|default:false}>
            <a href="admin/main.php?op=tad_rss_form&rss_sn=<{$rss.rss_sn}>" class="btn btn-sm btn-xs btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i>  <{$smarty.const._TAD_EDIT}></a>
          <{/if}>
        </h2>
      </div>

      <{foreach item=item from=$rss.content}>
        <h3><{$item.date}> <a href="<{$item.href}>" target="_blank"><{$item.title}></a></h3>
        <div class="well card card-body bg-light m-1" style="line-height: 1.8em;">
          <{$item.description}>
        </div>
      <{/foreach}>

    </div>
  <{/foreach}>
</div>
<div class="clearfix"></div>