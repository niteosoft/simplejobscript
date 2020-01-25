<div class="row board">
  <h2>{$translations.dashboard_recruiter.account_headline}</h2>
  <p>{$translations.dashboard_recruiter.account_note}</p>
  {if $no_resources_msg}<p class="red">{$no_resources_msg}</p>{/if}
</div>

<div class="row activity">
  <h3 class="ttcap">{$acc_data.name} {$translations.dashboard_recruiter.acc_plan}</h3>

  <div class="col-md-4 col-xs-12 boxes">
   <h4>{$acc_data.jobs_left}</h4>
   <h5 class="custom-h5">{$jobs_left_msg}</h5>
 </div>

 <div class="col-md-4 col-xs-12 boxes">
   <h4>{$acc_data.cv_downloads_left}</h4>
   <h5>{$cvs_left_msg}</h5>
 </div>

 <div class="col-md-4 col-xs-12 boxes">
   <h4>{$acc_data.job_period} {$translations.date.days}</h4>
   <h5>{$translations.dashboard_recruiter.job_expiry_period}</h5>
 </div>
</div>

<div class="row activity">
  <h3>{$translations.dashboard_recruiter.renew_text}</h3>
  <br /><br />

  	<div class="col-md-6 col-xs-12 mlReset">
		<a href="{$BASE_URL}{$URL_DASHBOARD}/{$URL_DASHBOARD_ACCOUNT_ORDER}"><button type="button" class="btn mbtn" name="topup-btn" id="topup-btn" ><i class="fa fa-arrow-circle-right fa-lg" aria-hidden="true"></i></button></a> 
  	</div>

</div>

<div class="row activity mb50">
  <h3>{$translations.dashboard_recruiter.deactivate_headline}</h3>
  <br /><br />

  <p>{$translations.dashboard_recruiter.deactivate_msg}</p>

</div>
