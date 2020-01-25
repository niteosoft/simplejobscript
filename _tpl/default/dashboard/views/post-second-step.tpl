<div class="row " id="step-2">

	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 mlpl0">

		<div class="row mb20 mt25">
			<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
				<h3 class="process-heading">{$translations.post_step2.title}</h3>
			</div>
			<div class="col-lg-5 col-md-5 col-sm-8 col-xs-12 pt10 tar light-black">								
				{$job_data.title}
			</div>
		</div>

		<div class="row mb20">
			<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
				<h3 class="process-heading">{$translations.post_step2.expires}</h3>
			</div>
			<div class="col-lg-5 col-md-5 col-sm-8 col-xs-12 pt10 tar light-black">								
				{$job_period} {$translations.post_step2.days} &nbsp;-&nbsp;&nbsp;{$job_data.expires_date}
			</div>
		</div>

		{if $PAY == 'true'}

				<div class="row mb20">
					<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
						<h3 class="process-heading">{$translations.post_step2.adtype}</h3>
					</div>
					<div class="col-lg-5 col-md-5 col-sm-8 col-xs-12 pt10 tar light-black">		
					{if $SPOTLIGHT == 'true' && $PREMIUM_LISTING_PRICE > 0}						
						{$translations.post_step2.premium} &nbsp;-&nbsp;&nbsp; {$translations.post_step2.premium_desc}
					{else}
						{$translations.post_step2.standard}
					{/if}
					</div>
				</div>

				{if $SPOTLIGHT == 'true' && $PREMIUM_LISTING_PRICE > 0}
					<div class="row mb20">
						<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
							<h3 class="process-heading">{$translations.post_step2.premium_ad_fee}</h3>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-8 col-xs-12 pt10 tar light-black">								
							{$FORMATED_CURRENCY}
						</div>
					</div>
				{/if}
				
					<div class="row mb20">
						<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
							<h3 class="process-heading">{$translations.post_step2.job_post_fee}</h3>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-8 col-xs-12 pt10 tar light-black">	
						{if $JOB_POSTED_PRICE > 0}							
							{$FORMATED_CURRENCY_JOBPOSTED}
						{elseif $JOB_POSTED_PRICE == 0}
							{$translations.post_step2.free}
						{/if}
						</div>
					</div>

				<br />
				<hr />

					<div class="row mb12">
						<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
							<h3 class="process-heading">{$translations.post_step2.fees}</h3>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-8 col-xs-12 pt10 tar light-black">								
							{$PRICE}
						</div>
					</div>

                {if $VAT}

					<div class="row mb12">
						<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
							<h3 class="process-heading">{$translations.post_step2.vat}</h3>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-8 col-xs-12 pt10 tar light-black">								
							{$PRICE_VAT}
						</div>
					</div>

					<div class="row">
						<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
							<h3 class="process-heading">{$translations.post_step2.final_price}</h3>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-8 col-xs-12 pt10 tar light-black">								
							{$PRICE_VAT_TOTAL}
						</div>
					</div>

                {/if}

		{else}

					<div class="row">
						<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
							<h3 class="process-heading">{$translations.post_step2.adtype}</h3>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-8 col-xs-12 pt10 tar light-black">								
							{$translations.post_step2.standard}
						</div>
					</div>

				<br />
				<hr />

				{if $PAYMENT_MODE == '3'}
					<div class="row">
						<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
							<h3 class="process-heading">{$translations.post_step1.account_plan}</h3>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-8 col-xs-12 pt10 tar light-black">								
							{$jobs_left_msg}
						</div>
					</div>
				{else}
					<div class="row">
						<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
							<h3 class="process-heading">{$translations.post_step2.fees}</h3>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-8 col-xs-12 pt10 tar light-black">								
							{$translations.post_step2.free}
						</div>
					</div>
				{/if}

		{/if}

	</div>

	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mlpl0">
		<button type="button" data-toggle="modal" data-target="#previewModal" id="preview-btn-mobile" class="btn mbtn fl" >{$translations.post_step2.preview_btn_label}</button>				
	</div>

</div>

<br />
<hr />

<form method="post" action="{$BASE_URL}{$URL_JOB_POSTED}/" role="form">
	<input type="hidden" id="step" name="step" value="2" />
	<input type="hidden" id="employer_id" name="employer_id" value="{$job_data.employer_id}" />
	<input type="hidden" id="job_id" name="job_id" value="{$job_data.id}" />

	<div class="button-holder">
		{if $PAY == 'true'}
			<input type="hidden" id="price" name="price" />
			{if $SPOTLIGHT == 'true' && $PREMIUM_LISTING_PRICE > 0}
				<input type="hidden" id="price_premium" name="price_premium" />
			{/if}
			{if $JOB_POSTED_PRICE > 0}
				<input type="hidden" id="price_ad" name="price_ad" />
			{/if}

			<input type="hidden" name="item_name" value="{$translations.paypal.checkout_item_name}" /> 
			<input type="hidden" name="item_number" value="{$translations.paypal.checkout_item_number}" /> 
		    <input type="hidden" name="item_desc" value="{$translations.paypal.checkout_item_desc}" /> 
			<input type="hidden" name="item_price" />
			<input type="hidden" name="item_qty" value="1" />

	    	<button type="submit" class="btn btn-green" id="paypal_submit" name="paypal_submit" >{$translations.post_step2.paypal_btn_label}</button>

		{else}

			<button type="submit" class="btn btn-green" id="pblish" name="pblish" >{$translations.post_step2.label_publish}</button>

		{/if}

			<button type="submit" class="btn btn-gray sec-btn" id="goback" name="goback" >{$translations.dashboard_recruiter.go_back_edit_text}</button>

	</div>

</form>