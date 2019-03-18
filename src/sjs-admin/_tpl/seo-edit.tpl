{include file="header.tpl"} 

<div class="admin-content">
  <div class="admin-wrap-content" >
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<form id="publish_seo" method="post" action="{$BASE_URL_ADMIN}seo/{$CURRENT_ID}/update">
	<div class="list settings">
		{foreach from=$fields item=setting}

				{assign var=name value=$setting[0]}
				{assign var=value value=$setting[1]}
				{assign var=desc value=$setting[2]}
				{assign var=title value=$setting[3]}

				<div class="row settings-row fs13" >
					<div class="row-fluid mt15" >

						<div class="col-lg-2 col-md-2 col-sm-2">
							<strong>{$title}:</strong>
						</div>

						<div class="col-lg-3 col-md-3  col-sm-8 ml20Desk">
							<input class="form-control minput" type="text" name="{$name}" value="{$value|escape}" size="120" />&nbsp;
						</div>

						<div class="col-lg-3 col-md-3 col-sm-8">
							{$desc}
						</div>
					</div>
				</div>

		{/foreach}
			<div class="button-holder-admin" style="margin-top: 30px;">
				<button type="submit" onclick="jobberBase.messages.add('Settings saved');" class="btn btn-default btn-primary mbtn" name="submit" id="save" >Save</button>

				<a href="{$BASE_URL_ADMIN}seo/" style="text-decoration: none;">
					<button type="button" class="btn btn-default btn-warning mbtn" name="button" id="button" >Go back</button>
				</a>
			</div>
		</div>
		</form>

	</div>
</div>
</div>

{include file="footer.tpl"}