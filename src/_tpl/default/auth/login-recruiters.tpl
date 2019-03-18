{include file="1.5/layout/login-header.tpl"}

<div class="main-content login-page">
	<div class="adjusted-login-page">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-xs-12">
					<img src="{$BASE_URL}{$SITE_LOGO_PATH}">
					<h2>{$translations.login.headline_login} {$translations.login.submessage}</h2>

					{if $login_failed}
					 <div id="incorrect-login-err" class="negative-feedback-form centered">{$translations.login.incorrect}</div>
					 <div class="clear-both"></div>
					 <br />
					{/if}

					<form id="login-form" name="login-form" method="post" action="{$BASE_URL}login/" role="form">

						<div id="login-email-fg">
							<h4>{$translations.login.email}</h4>
							<input required type="email" {if $relogin_email}value="{$relogin_email}"{/if} name="signin_email" id="signin_email" maxlength="500">
							<div id="err-login-email" class="negative-feedback-form displayNone">{$translations.login.err_email}</div>
						</div>
						<div class="clear-both"></div>

						<div id="login-pass-fg">
							<h4>{$translations.login.password}</h4>
							<input required name="signin_pass" id="signin_pass" maxlength="300" type="password">
							<div id="err-login-pass" class="negative-feedback-form displayNone">{$translations.login.err_pass_short}</div>
						</div>

					</form> 
					
					<div id="forgotpassblockid">
						<a href="#" class="forgot-pass" onclick="SimpleJobScript.hideLoginFields();" >{$translations.login.forgot_password}</a>
					</div>

					<div id="submit-block" >
						<div class="back-to-home"><button type="submit" class="btn b2h" onclick="return SimpleJobScript.loginFormValidation();" name="submit" id="submit">{$translations.registration.sign_in}</button></div>
					</div>

					<a id="sign-up-link" href="{$BASE_URL}{$URL_REGISTER_RECRUITERS}" class="make-account">{$translations.login.noacc_text}</a>


					<div id="forgotten-zone" class="displayNone">
						<br /><br /><br /><br />
						<form role="form" action="" method="post" >
							
								<h4>{$translations.login.forgotten_enter_email}</h4>
								<input required name="forget_email" id="forget_email" maxlength="300" type="email">

								<div id="passrecovery-feedback-err" class="negative-feedback-form displayNone centered">{$translations.login.recovery_err}</div>
								<div id="passrecovery-feedback-err2" class="negative-feedback-form displayNone centered">{$translations.login.recovery_err2}</div>
								<div id="passrecovery-feedback-ok" class="pos-feedback-form centered displayNone centered">{$translations.login.newpass_email_sent}</div>
				
						 		<div class="clear-both"></div>
								<br />

								<button type="button" class="btn mbtn" onclick="return SimpleJobScript.passwordRecovery();">{$translations.login.forgotten_submit}</button>

						 		<div class="clear-both"></div>
								<br />

								<i id="fspinner" class=" fa fa-refresh fa-spin fa-lg fa-fw refresh-spinner displayNone"></i>
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

{include file="1.5/layout/login-footer.tpl"}
