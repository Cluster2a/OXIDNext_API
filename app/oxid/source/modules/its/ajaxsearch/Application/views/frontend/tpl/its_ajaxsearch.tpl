[{assign var="product" value=$oView->getProduct()}]
<table class="table">
	<tbody>
	[{foreach from=$oSearchList item=product}]
		<tr class="searchItemLine">
			<td class="picture text-left">
				<a href="[{$product->getLink()}]" title="[{$product->oxarticles__oxtitle->value}] [{$product->oxarticles__oxvarselect->value}]">
					<img src="[{$oViewConf->getImageUrl('spinner.gif')}]" data-src="[{$product->getPictureUrl()}]" alt="[{$product->oxarticles__oxtitle->value}] [{$product->oxarticles__oxvarselect->value}]" class="ajax_search_img"></a>
			</td>
			<td class="title">
				<a href="[{$product->getLink()}]" title="[{$product->oxarticles__oxtitle->value}] [{$product->oxarticles__oxvarselect->value}]">[{$product->oxarticles__oxtitle->value}] [{$product->oxarticles__oxvarselect->value}]</a>
			</td>
		</tr>
		[{/foreach}]
	</tbody>
</table>

<button type="submit" class="btn btn-primary ajax_search_close" data-placement="bottom">[{oxmultilang ident="ITS_SHOW_CLOSE_SEARCH_RESULTS"}]</button>
[{if $bShowMoreButton}]
	<a class="ajax_search_link float-right" href="[{$bMoreButtonURL}]"><button type="submit" class="btn btn-secondary ajax_search_show_more" data-placement="bottom">[{oxmultilang ident="ITS_SHOW_MORE_SEARCH_RESULTS"}]</button></a>
[{/if}]
