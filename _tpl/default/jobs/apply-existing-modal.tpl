
<a data-toggle="modal" data-target="#applyModal" href="#" onclick="return false;"><button id="apply_online_now" type="button" data-toggle="modal" data-target="#jobpopup" class="btn btn-apply">{$translations.apply.apply_btn}</button></a>
<br /><br />

<div class="modal fade trans-bg" id="jobpopup" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal">&times;</button>	
				<div class="apply-popup">
					<div class="container">
						<div class="row ">
							<div class="col-md-12 col-xs-12 application-head">
								<h2>{$translations.job_detail_section.application_title} - {$translations.apply.tab2}</h2>
								<p class="h-summary">{$translations.apply.amend_text}<a href="/{$URL_PROFILE}/edit" target="_blank" class="green-link">{$translations.apply.amend_text2}</a> {$translations.apply.amend_text3} </p>
							</div>
							<br><br>

							<div class="col-md-12 col-xs-12" style="padding-left: 40px;">
							<div id="new-user">
							  <form role="form" method="post" action="{$BASE_URL}{$URL_APPLY}" enctype="multipart/form-data" >
							  		<input type="hidden" name="job_id" id="job_id" value="{$job.id}" />
									<input type="hidden" name="new_user" id="new_user" value="0" />

									<div class="row mlpl0">
										<div class="col-md-6 col-xs-12 pushTop40 mb50 tal ls25">

											  {if $SESSION_APPLICANT_NAME}
											  <div>{$SESSION_APPLICANT_NAME}</div>
											  {/if}

											  {if $SESSION_APPLICANT_OCCUPATION}
											  <div>{$SESSION_APPLICANT_OCCUPATION}</div>
											  {/if}

											  {if $SESSION_APPLICANT_EMAIL}
											  <div>{$SESSION_APPLICANT_EMAIL}</div>
											  {/if}

											  {if $SESSION_APPLICANT_PHONE}
											  <div>{$SESSION_APPLICANT_PHONE}</div>
											  {/if}

											  {if $SESSION_APPLICANT_LOCATION}
											  <div>{$SESSION_APPLICANT_LOCATION}</div>
											  {/if}

											  {if $SESSION_APPLICANT_SKILLS}
											  <div>{$SESSION_APPLICANT_SKILLS}</div>
											  {/if}

											  <hr />
											  {if $SESSION_APPLICANT_PORTFOLIO}
											 <div><a href="{$SESSION_APPLICANT_PORTFOLIO_LINK}" target="_blank">{$SESSION_APPLICANT_PORTFOLIO}</a></div>
											  {/if}

											  <div>
											 {foreach $SESSION_APPLICANT_SM_LINKS as $SM_OBJ}
											 	 <a class="mr12" href="{if $SM_OBJ->whatsapp == 'true'}tel:{$SM_OBJ->whatsapp_numb}{else}{$SM_OBJ->linkToShow}{/if}" target="_blank"><i class="fa fa-{$SM_OBJ->icon} fa-lg" aria-hidden="true"></i></a>
											 {/foreach}
											 </div>

										</div>


										<div class="col-md-6 col-xs-12 pushTop40 mb50 tal ls25">
											 <div>{$SESSION_APPLICANT_MESSAGE}</div>
											 <hr />

											 <div>{$SESSION_APPLICANT_CVTEXT}</div> 
										</div>
								</div>

								<div class="row mlpl0">

									<div class="col-md-6 col-xs-12 mlpl0">
										<button type="submit" class="btn btn-modal-a" onclick="return SimpleJobScript.Apply({$MAX_CV_SIZE}, 'existing');">{$translations.apply.submit}</button>

										<button type="button" data-dismiss="modal" class="btn btn-modal-c">{$translations.job_detail_section.close}</button>
									</div>

									<div class="col-md-3 col-xs-12">
										<div class="modal-ajax" >
											<i id="fspinner_apply" class="displayNone fa fa-refresh fa-spin fa-lg fa-fw refresh-spinner"></i>
										</div>

									</div>

								</div>

							  </form>
				
							</div>
							</div>

						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>