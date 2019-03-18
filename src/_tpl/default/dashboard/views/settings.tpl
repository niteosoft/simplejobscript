
<div class="row board">
  <h2>{$translations.dashboard_recruiter.settings_headline}</h2>
  <p>{$translations.dashboard_recruiter.change_settings_notification}</p>
</div>
<br /><br />

<div class="col-md-6 col-xs-12 mlpl0">
	<div class="row activity p25">
	  <h3>{$translations.dashboard_recruiter.changepass_headline}</h3>

	  	<form role="form" action="/dashboard-settings" method="post" >
	  		<input name="employer_id" id="employer_id" type="hidden" value="{$ID}">

	  		<div class="dash-form">
				<input placeholder="{$translations.login.new_pass}" name="forget_pass" id="forget_pass" maxlength="50" type="password" class="form-control minput" required /> 

				<input placeholder="{$translations.login.new_pass2}" name="forget_pass2" id="forget_pass2" maxlength="50" type="password" class="form-control minput" required />

				<div id="passrecovery-feedback-err" class="negative-feedback displayNone p5">{$translations.login.err_passes}</div>  

				<button class="btn mbtn fl" name="submit" id="submit"><i class="fa fa-check fa-lg" aria-hidden="true"></i></button>
			</div>

		</form>
	</div>	
</div>

<div class="col-md-6 col-xs-12 mlpl0">
	<div class="row activity">
	  <h3>{$translations.dashboard_recruiter.changename_headline}</h3>
	  	<form role="form" action="/dashboard-settings" method="post" >
	  		<input name="employer_id" id="employer_id" type="hidden" value="{$ID}">

			<div class="dash-form">
			   <input placeholder="{$translations.dashboard_recruiter.new_name}" name="name" id="name" maxlength="50" type="text" class="form-control minput" value="{$name}" required /> 
		
			 	<button type="submit" class="fl btn mbtn" name="submit" id="submit" required><i class="fa fa-check fa-lg" aria-hidden="true"></i></button>
			</div>
			 
		</form>
	</div>	
</div>

<div class="clear"></div>
<br />

{if $PAYMENT_MODE != '3'}
<div class="col-md-12 col-xs-12 mlpl0 mb40">
	<div class="row activity">
	{$translations.dashboard_recruiter.deactivate_msg}
	</div>
</div>
{/if}