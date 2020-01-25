{if $email_send_package eq 1}
	<div class="action-req">
		<div class="container">
			<div class="row caution">
				<div class="col-md-12 col-xs-12">
					<div class="row">
						<div class="col-md-1 col-xs-12">
							<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
						</div>
						<div class="col-md-11 col-xs-12">
							<p><span>{$translations.registration.msg}</span>
								<div>{$translations.registration.account_not_confirmed_text}</div>	
							</p>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
{/if}

{if $HIDE_PCG_PLAN == '0'}
<form id="af" name="af" method="post" action="{$BASE_URL}account-payment/" class="dash-form" role="form" >
	<div class="row activity">
		<div class="col-md-6 col-xs-12 mlReset">			
		  <h3>{$translations.dashboard_recruiter.choose_plan} {$translations.dashboard_recruiter.acc_plan}</h3>
		  <br /><br />

				<select id="package_select_id" onchange="SimpleJobScript.accountPlanSelectChanged(this.value);" name="package_select_id" class="form-control minput" required>
							
				{foreach from=$packages key=id item=value}
					<option {if $id == $active_mode_id}selected{/if} value="{$id}">{$value}</option>
				}
				{/foreach}
				</select>
		</div>
	</div>
	<div class="row activity">
		<div class="col-md-6 col-xs-12 mlReset mb50">
		
		  <h3>{$translations.dashboard_recruiter.plan_features}</h3>
		  <br /><br />

		    <p class="mb20">{$translations.post_step1.account_plan} <span class="ttu light-font" id="ajax-plan-name">{$pd.name}</span></p>
		    <p class="mb20">{$translations.dashboard_recruiter.plan_features_job_expiry} <span class="light-font" id="ajax-plan-jp">{$pd.job_period}</span> <span class="light-font">{$translations.date.days}</span></p>
		    <p class="mb20">{$translations.dashboard_recruiter.plan_features_job_ads} <span class="light-font" id="ajax-plan-jl">{$pd.jobs_left}</span></p>
		    <p class="mb20">{$translations.dashboard_recruiter.plan_features_resumes} <span class="light-font" id="ajax-plan-cvdl">{$pd.cv_downloads}</span></p>

		</div>


		<div class="col-md-6 col-xs-12 mobPl">
				<h3>{$translations.dashboard_recruiter.pricing_headline}</h3>
			    <br /><br />

			    <p class="mb20">{$translations.dashboard_recruiter.price} <span class="light-font" id="ajax-price">{$PRICE}</span></p>

			    {if $VAT}
			    	<p class="mb20">{$translations.post_step2.vat} <span class="light-font" id="ajax-vat">{$PRICE_VAT}</span></p>
			    	<p class="mb20">{$translations.post_step2.final_price} <span class="light-font" id="ajax-price-vat">{$PRICE_VAT_TOTAL}</span></p>
			    {/if}
		</div>

	</div>

	<div class="row activity mb50">
		<div class="col-md-6 col-xs-12 mlReset">
			<button type="submit" class="btn mbtn fl" id="topup-submit" name="topup-submit" style="
			padding: 10px 24px!important;width: 100% !important;">
		{$translations.dashboard_recruiter.purchase}</button>
		</div>
	</div>
	
</form>
{/if}