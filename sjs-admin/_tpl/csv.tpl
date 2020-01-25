{include file="header.tpl"}
		
<div class="admin-content">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
	<label class="admin-label">Subscribers</label>
	<div class="subheading">List of email addresses exported in transferable format</div>
	</div>

	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt25">
	 		{if $err}
	 		<div class="red mb15">{$err}</div>
	 		{else}
	 		<div class="green mb15">{$success}</div>
	 		{/if}

			<a href="{$file_path}"><img width="50" height="50" src="{$BASE_URL}_tpl/{$THEME}/img/csv.png" /></a>
    </div>
</div>

{include file="footer.tpl"}