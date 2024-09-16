<{foreach from=$block.rss_data item=rss_data}>
    <div>
        <a href="<{$rss_data.link}>" rel="external" style="font-weight:bold;"><{$rss_data.title}></a>
        <ul class="vertical_menu">
            <{foreach from=$rss_data.content item=rss}>
                <li>
                <a href="<{$rss.link}>" rel="external">
                <{if $rss.date|default:false}>[<{$rss.date}>] <{/if}>
                <i class="fa fa-rss-square" aria-hidden="true"></i>
                <{$rss.title}>
                </a>
                </li>
            <{/foreach}>
        </ul>
    </div>
<{/foreach}>
<div class="text-right text-end">
    <a href="<{$xoops_url}>/modules/tad_rss" class="badge badge-info">more...</a>
</div>
