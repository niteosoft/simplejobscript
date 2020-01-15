
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
						<div class="row">
							<div class="col-md-12 col-xs-12 application-head">
								<h2>{$translations.job_detail_section.application_title}</h2>
								<p class="h-summary">{$translations.job_detail_section.application_desc} </p>

									<div class="tab-buttons">
										<a href="#" class="btn-ns active" id="new-user-link">
											{$translations.apply.tab1}
										</a>
										{if $smarty.const.PROFILES_PLUGIN == 'true'}
										<a href="#" class="btn-eu" id="old-user-link">
											{$translations.apply.tab2}
										</a>
										{/if}
									</div>

							</div>
							<br><br>

							<div class="col-md-12 col-xs-12" style="padding-left: 40px;">
							<div id="new-user">
							<form role="form" method="post" action="{$BASE_URL}{$URL_APPLY}" enctype="multipart/form-data" >
								<input type="hidden" name="job_id" id="job_id" value="{$job.id}" />
								<input type="hidden" name="new_user" id="new_user" value="1" />
								<input type="hidden" id="external_links" name="external_links" value="0" />

								<div class="col-md-6 col-xs-12 col-mob-pad">
										<h3>{$translations.apply.name}</h3>
										<input required id="apply_name" name="apply_name" type="text" maxlength="500">

										<h3>{$translations.apply.email}</h3>
										<input required type="email" id="apply_email" name="apply_email" maxlength="300">

										<h3>{$translations.apply.location}</h3>
										<input required type="text" id="apply_location" name="apply_location" >

								</div>

								<div class="col-md-6 col-xs-12 col-mob-pad">

									<h3>{$translations.apply.portfolio}</h3>
									<input type="text" id="portfolio" name="portfolio" maxlength="500">

									<h3>{$translations.apply.phone}</h3>
									<input type="tel" id="apply_phone" name="apply_phone">

									<h3>{$translations.apply.occupation_placeholder}</h3>
									<input placeholder="{$translations.apply.occupation_desc}" required type="text" id="occupation" name="occupation" maxlength="500">

								</div>


								<div class="col-md-12 col-xs-12 col-mob-pad">

									<h3>{$translations.js.skills_label}</h3>
									<div class="textarea clearfix skillsTaggle"></div><br />
									
									<h3>{$translations.apply.create_profile_desc}</h3>
									<textarea required id="apply_msg" name="apply_msg" maxlength="500" rows="8" cols="50"></textarea>
									<div class="textarea-feedback-popup" id="textarea_feedback"></div>

									<br /><br />

									<p class="w100">
										<label id="cvLabel" for="cv">{$translations.apply.cv_label}</label><input accept=".doc,.docx, .pdf" name="cv" id="cv" class="inputfile" type="file" /><span class="cv-hint">{$cv_hint}</span><br /><br />
										 <span id="err" class="red ml0 displayNone">{$translations.apply.cv_err}</span>
								    </p>

								</div>


								<div class="col-md-12 col-xs-12 col-mob-pad">
									<div class="SMLinkDiv">
										<a id="addLink" class="green" onclick="return SimpleJobScript.addExternalLink();" href="#">{$translations.js.add_social_media}</a>
										<div id="addLinkBlock"></div>
									</div>

									{if $smarty.const.PROFILES_PLUGIN == 'true'}
										{include file="$modal_snippet"}
									{/if}

									{if $ENABLE_RECAPTCHA}
									<div class="col-md-6 col-xs-12 ml0 pl0 mb50">
											{$captcha_html}
											<div id="captcha_err" class="negative-feedback displayNone ml0" >{$translations.apply.captcha_empty_err}</div>
									</div>
									{/if}

									<div class="row mlpl0">
										<div class="col-md-6 col-xs-12 mlpl0">
											<button type="submit" class="btn btn-modal-a" onclick="return SimpleJobScript.Apply({$MAX_CV_SIZE}, 'new');">{$translations.apply.submit}</button>

											<button type="button" data-dismiss="modal" class="btn btn-modal-c">{$translations.job_detail_section.close}</button>
										</div>

										<div class="col-md-3 col-xs-12">
											<div class="modal-ajax" >
												<i id="fspinner_apply" class="displayNone fa fa-refresh fa-spin fa-lg fa-fw refresh-spinner"></i>
											</div>
										</div>

									</div>

								</div>

								</form>
							</div>
							</div>

							<div class="col-md-12 col-xs-12" style="padding-left: 40px;">
							<div id="old-user" class="hide-me-now">
								<div class="col-md-8 col-xs-12">
									<form role="form" method="post" action="{$BASE_URL}{$URL_APPLY}" enctype="multipart/form-data" >
										<input type="hidden" name="job_id" id="job_id" value="{$job.id}" />
										<input type="hidden" name="new_user" id="new_user" value="0" />

										<h3>{$translations.login.email}</h3>
										<input required id="apply_email_existing" name="apply_email_existing" type="email" maxlength="100" >

										
											<h3>{$translations.login.password}</h3>
											<input required id="apply_pass_existing" name="apply_pass_existing" type="password" maxlength="100" >
										<div class="col-md-12 col-xs-12 tal mt12">
											<div id="err-existing-pass" class="red displayNone">{$translations.login.err_pass_short}</div>
											<br /><br />
										</div>

										<div class="textarea-feedback mt5 tal" >{$translations.apply.newuser_hint}</div>

										<div class="row mlpl0 pl10">

											<div class="col-md-10 col-xs-12 mlpl0 mt75">
												<button type="submit" class="btn btn-modal-a" onclick="return SimpleJobScript.Apply({$MAX_CV_SIZE}, 'existing');">{$translations.apply.submit}</button>

												<button type="button" data-dismiss="modal" class="btn btn-modal-c">{$translations.job_detail_section.close}</button>
											</div>

											<div class="col-md-2 col-xs-12 mlpl0 mt75">
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
</div>