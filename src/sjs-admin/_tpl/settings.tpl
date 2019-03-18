{include file="header.tpl"}

	<div class="admin-content">
 <div class="admin-wrap-content">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	{if $settings_categories && $settings_form == ''}
		  <label class="admin-label">Settings</label>
		<br />
			{section name=tmp loop=$settings_categories}
				<div class="settings-row">
					<div class="settings-wrapper">
					<a class="right" href="{$BASE_URL_ADMIN}settings/{$settings_categories[tmp].var_name}/" title="Edit {$settings_categories[tmp].name}"><span class="fui-gear blueColor" ></span>&nbsp;</a>
					<label class="settings"><a class="blue-font" href="{$BASE_URL_ADMIN}settings/{$settings_categories[tmp].var_name}/">{$settings_categories[tmp].name}</a></label>
					</div>

					<div class="light">{if $settings_categories[tmp].description != ''}{$settings_categories[tmp].description}{/if}</div>
				</div>
			{/section}
			<div class="settings-row">
				<a class="right blue" href="{$BASE_URL_ADMIN}password/" title="Change password"><i class="fa fa-gear blueColor mr5" aria-hidden="true"></i></a>
				<label class="settings"><a class="blue-font" href="{$BASE_URL_ADMIN}password/">ADMIN</a></label>
			</div>
	{/if}

	{if $settings_form != ''}
		{if $category_name !=  ''} <label class="settings">{$category_name}</label> <a href="/sjs-admin/settings"><div class="subheading">&larr;go back</div></a>{/if}
		{if $category_name|lower == 'invoicing'}<span style="font-size: 14px; opacity: 0.75;">To edit rest of the texts, change translations - "invoice" section</span>{/if}
		{if $category_name == 'URLS'}<span style="font-size: 14px; opacity: 0.75;">Here you can translate URL routes. Useful when English is not used.</span>{/if}

		{if $errors != ''}
			<div class="fail">
				{foreach from=$errors item=error}
				{section name=tmp2 loop=$error}								
					<div>{$error[tmp2]}</div>
				{/section}						
				{/foreach}
			</div>
		{/if}
		
		<form id="publish_form" method="post" enctype="multipart/form-data" action="{$BASE_URL_ADMIN}settings/{$CURRENT_ID}/">
			<div class="list settings">
			{foreach from=$settings_form item=setting}
				{assign var=name value=$setting.name}
				{assign var=title value=$setting.title}
				{assign var=description value=$setting.description}
				{assign var=value value=$setting.value}
				{assign var=data_type value=$setting.data_type}
				{assign var=input_type value=$setting.input_type}
				{assign var=input_options value=$setting.input_options}
				{assign var=extradata value=$setting.extradata}
				{assign var=settingsLogo value=$setting.name|strip}
				
				{if $PROFILE_PLUGIN == '0' and ($name == 'url_profile' or $name == 'url_profile_edit' or $name == 'url_profile_applications'
				 or $name == 'url_profile_changepassword' or $name == 'url_profile_delete')}
				  {continue}
				{/if}

				<div class="row settings-row {if $errors.$name != ''} error{/if} fs13" >
				<div class="row-fluid mt15" >
					<div class="col-lg-2 col-md-2 col-sm-2">
						<strong>{$title}:</strong>
					</div>

					<div class="col-lg-3 col-md-3  col-sm-8 ml20Desk">
{if $input_type == 'text_area'}
						<textarea class="form-control minput{if $errors.$name != ''} error{/if}" name="{$name}" cols="40" rows="2">{$value|escape}</textarea>
					{elseif $input_type == 'radiobutton'}
						{if $data_type == 'boolean'}
							<input  style="margin-right: 5px;" type="radio" name="{$name}" value="0" {if $value == 0}checked="checked"{/if} />{if $input_options[0]}{$input_options[0]}{else}0{/if}&nbsp;
							<input  style="margin-right: 5px;" type="radio" name="{$name}" value="1" {if $value == 1}checked="checked"{/if} />{if $input_options[1]}{$input_options[1]}{else}1{/if}
							&nbsp;
						{else}
							{section name=tmp2 loop=$input_options}
								<input type="radio" name="{$name}" value="{$input_options[tmp2]}" {if $input_options[tmp2] == $value}checked="checked"{/if} />{$input_options[tmp2]}
							{/section}
						{/if}
					{elseif $input_type == 'select'}
						<select class="form-control minput" {if $errors.$name != ''}class="error"{/if} name="{$name}">
						{section name=tmp2 loop=$input_options}
							<option value="{$input_options[tmp2]}" {if $input_options[tmp2] == $value}selected="selected"{/if}>{$input_options[tmp2]}</option>
						{/section}
						</select>&nbsp;
					{elseif $input_type == 'checkbox'}
						<input class="form-control" {if $errors.$name != ''}class="error"{/if} type="checkbox" name="{$name}[]" value="_hidden" style="display:none;" checked="checked" />
						{section name=tmp2 loop=$input_options}
							<input class="form-control minput" type="checkbox" name="{$name}[]" value="{$input_options[tmp2]}" {if in_array($input_options[tmp2], $value)}checked="checked"{/if} />{$input_options[tmp2]}<br />
						{/section}
					{elseif $input_type == 'file'}
						Current logo:<br />
						<img src="{$BASE_URL}img.php?q={$name}" alt="" /><br /><br />
						<input class="form-control" type="file" name="{$name}[]" />
					{else}

						{if $title|lower == 'website logo' or $title|lower == 'company default logo' or $title|lower == 'logo'}
						 	<label id="{$settingsLogo}Label" for="{$settingsLogo}File">Upload new</label>
							<input accept=".jpg,.jpeg,.png, .gif, .bmp" type="file" name="{$settingsLogo}File" id="{$settingsLogo}File" class="form-control inputfile minput" />
							 <input class="form-control minput {if $errors.$name != ''} error{/if}" type="hidden" name="{$name}" value="{$value|escape}" size="42" />&nbsp;

							<script type="text/javascript">
								 $('#{$settingsLogo}File').change(function() {
									 var fname = $('#{$settingsLogo}File').val().split('\\').pop();
									 if( fname )
										$('#{$settingsLogo}Label').html(fname);
									 else
										$('#{$settingsLogo}Label').html($('#{$settingsLogo}Label').html());
									 });
							</script>

						{else}

						    <input class="form-control minput {if $errors.$name != ''} error{/if}" type="text" name="{$name}" value="{$value|escape}" size="42" />&nbsp;
					

						{/if}

					{/if}

					</div>

					<div class="col-lg-3 col-md-3 col-sm-8">
						{$description}
					</div>


					{if $title|lower == 'website logo' or $title|lower == 'company default logo' or $title|lower == 'invoice logo path'}
					<div class="col-lg-3 col-md-3 col-sm-8">
						<img width="150" src="{$BASE_URL}{$value}" />
					</div>
					{/if}
						
				</div>

				</div>

			{/foreach}
			</div>
			<div class="button-holder-admin" style="margin-top: 25px;">
				<input type="hidden" name="action" value="update_settings" />

				<button onclick="jobberBase.messages.add('Settings saved');" type="submit" class="btn btn-default btn-primary mbtn" name="submit" id="save" >Save</button>

				<a href="{$BASE_URL_ADMIN}settings/" style="text-decoration: none;">
					<button type="button" class="btn btn-default btn-warning mbtn" name="button" id="button" >Cancel</button>
				</a>

			</div>
		</form>
		{/if}
		</div>
	</div>
 </div>
		
{include file="footer.tpl"}
