{include file="1.5/layout/sjs-header.tpl"}

{if $WYSIWYG_PAGE}
<div class="static-page">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-xs-12">
{/if}
				{include file=$tpl}
				
{if $WYSIWYG_PAGE}
			</div>
		</div>
	</div>
</div>			
{/if}

{include file="1.5/layout/sjs-footer.tpl"}