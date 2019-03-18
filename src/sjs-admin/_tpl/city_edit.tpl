{include file="header.tpl"}

	<div class="admin-content">
	 <div class="admin-wrap-content">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label class="admin-label">Locations - {if $action eq 'add'}New location{else}"Edit {$city.name}"{/if}</label>
			<div class="subheading" >Write permalink (location URL) in lowercase as a single word (eg. "uk", or "united-kingdom"). ( <a style="opacity: 0.8;" href="{$BASE_URL_ADMIN}cities/">&larr;go back</a> )</div>
			<br />
		</div>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<form id="city_form" action="{$BASE_URL_ADMIN}cities/{if $action eq 'add'}add/{else}edit/{/if}" method="post">
				<div class="row-fluid">
					<div class="left window">
						<div class="block_inner">
							<div class="group{if $errors.name} error{/if} mb15">
								<label>Name</label>
								<input type="text" class="form-control minput" name="name" value="{$city.name}" />
								{if $errors.name}<span class="suggestion">Location name can not be empty</span>
								{/if}
							</div>
							<div class="group{if $errors.asciiName} error{/if}">
								<label>Permalink</label>
								<input type="text" class="form-control minput" name="ascii_name" value="{$city.ascii_name}"/>
								{if $errors.asciiName}<span class="suggestion">{$errors.asciiName}</span>
								{/if}
							</div>
							<div class="button-holder-admin mt30" style="margin-left: 0px;">
								<button type="submit" class="btn btn-default btn-primary mbtn" name="submit" id="save">{if $action eq 'add'}Save entry{else}Save changes{/if}</button>
								{if $action eq 'edit'}<input type="hidden" name="id" value="{$city.id}" />{/if}
								
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	</div>

{include file="footer.tpl"}