{include file="1.5/layout/sjs-header.tpl"}

<div class="jobs-alert">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-xs-12">
				<h2>{$translations.subscriptions.subscribe_message}</h2>
				<p class="subscribe-p">{$translations.subscriptions.subscribe_desc}</p>

				<div class="tab-contentx">
					<div id="subsc" class="city active">
					
						{if $success}
							<div class="row">
								<div class="pos-feedback">{$translations.subscriptions.positive_feedback_maillist}</div>
							</div>
							<br />
						{/if}

						<form id="subscribe-form" role="form" method="post" action="{$BASE_URL}{$URL_SUBSCRIBE}">

								{foreach from=$cats item=obj}
									<label><input name="cat{$obj.id}" id="cat{$obj.id}" type="checkbox" class="checkbox-custom"></input> <h4>{$obj.name}</h4></label><br />
							  	{/foreach}

								<div class="tab-submit">
									<h3>{$translations.apply.email}</h3>
						 			<input id="subscribe-email" name="subscribe-email" maxlength="300" type="email" required />
						 			<br /><br />

						 			{if $GDPR_ENABLED == '1'}
						 			<div class="subscribe-tos">
										<label style="text-align: left;"><input required type="checkbox" class="checkbox-custom"></input> 
										<h4>{$translations.registration.accept_part1} <a target="_blank" href="{$BASEURL}gdpr"> {$translations.registration.accept_gdpr}</a></h4></label>
									</div>
									{/if}

						 			<div class="subscribe-tos">
										<label><input required type="checkbox" class="checkbox-custom"></input> 
										<h4>{$translations.registration.accept_part1} <a target="_blank" href="{$BASEURL}{TERMS_CONDITIONS_URL}"> {$translations.registration.accept_part2}</a></h4></label>
									</div>

									{if $ENABLE_RECAPTCHA}
									<br />
				               		 <div id="jobpopup" style="background-color: white;">
										{$captcha_html}
										{if $captcha_err}<div class="negative-feedback">{$response_msg}</div>{/if}
									 </div>
									{/if}

									<button type="submit" class="btn">{$translations.subscriptions.subscribe_submit}</button>
								</div>

						</form>

					</div>

				</div>
			</div>
		</div>
	</div>
</div>

{include file="1.5/layout/sjs-footer.tpl"}
