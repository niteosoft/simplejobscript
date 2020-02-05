
{if $ENABLE_RECAPTCHA}
	<div class="tos">
{else}
	<div class="tos mb50">
{/if}

	<label><input name="public_profile" id="public_profile" type="checkbox" class="checkbox-custom" onclick="SimpleJobScript.toggleUserForm();">
	<h4>{$translations.apply.save_profile}</h4>
	</label>
	<br />

	<div id="userForm" class="displayNone col-md-6 col-xs-12 ml0 pl0">
		<div class="form-group">
			<h3>{$translations.apply.user_new_passs}</h3>
			<input type="password" id="xuser_password" name="xuser_password"  maxlength="50" />
 			<div id="err-new-pass" class="negative-feedback displayNone">{$translations.login.err_pass_short}</div>
			<div class="textarea-feedback mt5" >{$translations.apply.new_profile_desc}</div> 
		</div>
	</div>

</div>