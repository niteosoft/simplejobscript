{include file="1.5/layout/sjs-header.tpl"}

<style type="text/css">
	#jobpopup h3 {
		color: inherit;
		font-size: 17px;
		text-align: center;
	}
	#jobpopup input {
		width: 100% ;
	}
</style>

<div class="main-content signup-page">
	<div class="adjusted-signup-page">
		<div class="container">
			<h2>GDPR data removal</h2>
			<div>{$translations.alljobs.gdpr_removal_text}</div>
			<br /><br />
				<div class="row mb50">
				
				    <form method="post" action="{$BASE_URL}gdpr-data-removal" role="form">

		              <div class="hf">

		              	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"></div>

		            	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
				                <div class="form-group location job-process">
				                     <select id="gdpr_user_select" name="gdpr_user_select">
				                        {foreach from=$gdpr_users key=id item=value}
				                        <option value="{$id}">{$value}</option>
				                        {/foreach}
				                     </select>   
				                </div>
				                <br /><br />

				                <div class="form-group job-process">
									<label class="process-heading mb15">{$translations.apply.email}</label>
									<input required name="gdpr_email" id="gdpr_email" type="email" class="job-title" />
								</div>


			               		{if $ENABLE_RECAPTCHA}
			               		 <div id="jobpopup" style="background-color: white;">
									{$captcha_html}
									{if $captcha_err}<div class="negative-feedback">{$response_msg}</div>{/if}
								 </div>
								{/if}

			                <button type="submit" class="btn mbtn ">{$translations.detail_sidebar.modal_submit}</button>

			                {if $gdpr_msg_neg == '1'}
			                	<br />
			                	<div class="positive-feedback" style="color: #49A956">{$gdpr_msg}</div>
			                {else if $gdpr_msg_neg == '0'}
			                	<br />
			                	  <div class="negative-feedback" style="color: #CF1E1E; float: none; text-align: center;">{$gdpr_msg}</div>
			                {/if}

		                </div>

		                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"></div>

		              </div>

		            </form>
					<br /><br />
				</div>
		
		</div>
	</div>
</div>

{include file="1.5/layout/sjs-footer.tpl"}