
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 edit-company">
	<form method="post" action="{$BASE_URL}{$URL_JOB_POSTED}/" role="form">
		<input type="hidden" id="step" name="step" value="1" />
		<input type="hidden" id="employer_id" name="employer_id" value="{$employer_id}" />
		<input type="hidden" id="jobs_left" name="jobs_left" value="{$jobs_left}" />
		<input type="hidden" id="job_period" name="job_period" value="{$job_period}" />

{if not $lock_post}
					<div class="row " id="step-1">
					 <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 mlpl0">
						
						<div class="row checkboxes">
								<div class="col-md-3 col-xs-12">
									<h3 class="process-heading">{$translations.dashboard_recruiter.post_type_label}</h3>
								</div>
								<div class="col-md-5 col-xs-12">								
									<select id="type_select" name="type_select">
										{foreach from=$types key=id item=value}
											<option {if $DRAFT}{if $draft_data.type_name == {$value}}selected{/if}{/if} value="{$id}">{$value}</option>
										{/foreach}
									</select>
								</div>
							</div>

	 						<div class="row checkboxes">
								<div class="col-md-3 col-xs-12">
									<h3 class="process-heading">{$translations.dashboard_recruiter.post_category_label}</h3>
								</div>
								<div class="col-md-5 col-xs-12">
									<select id="cat_select" name="cat_select">
										{foreach from=$cats key=id item=value}
											<option {if $DRAFT}{if $draft_data.category_id == {$id}}selected{/if}{/if} value="{$id}">{$value}</option>
										{/foreach}
									</select>
								</div>
							</div>

							{if $REMOTE_PORTAL == 'deactivated'}
							 <div class="row checkboxes">
								<div class="col-md-3 col-xs-12">
									<h3 class="process-heading">{$translations.dashboard_recruiter.post_location_label}</h3>
								</div>
								<div class="col-md-5 col-xs-12">
									<select id="location_select" name="location_select">
									{foreach from=$cities key=id item=value}
										<option {if $DRAFT}{if $draft_data.city_id == {$id}}selected{/if}{/if} value="{$id}">{$value}</option>
									{/foreach}
									</select>
								</div>
							</div>
							{/if}

							{if $PAYMENT_MODE == '2'}
							<div class="row checkboxes">
								<div class="col-md-3 col-xs-12">
									<h3 class="process-heading">{$translations.dashboard_recruiter.premium_text}</h3>
								</div>
								<div class="col-md-5 col-xs-12">
									<select id="premium_select" name="premium_select">
										<option value="0">{$translations.dashboard_recruiter.standard_label}</option>
										<option value="1">{$translations.dashboard_recruiter.premium_label} {$FORMATED_CURRENCY}</option>
									</select>
								</div>
							</div>
							{/if}

							<div class="row checkboxes">
								<div class="col-md-3 col-xs-12">
									<h3 class="process-heading">{$translations.dashboard_recruiter.post_title_label}</h3>
								</div>
								<div class="col-md-5 col-xs-12">
									<input required name="title" id="title" maxlength="400" type="text" value="{if $DRAFT == 'true'}{$draft_data.title}{/if}" class="job-title"  />
								</div>
							</div>


							<div class="row checkboxes">
								<div class="col-md-3 col-xs-12">
									<h3 class="process-heading">{$translations.dashboard_recruiter.salary_label}</h3>
								</div>
								<div class="col-md-5 col-xs-12">
									<input name="salary" class="job-title" id="salary" type="text" value="{if $DRAFT == 'true'}{$draft_data.salary}{/if}"  />
								</div>
							</div>

							<div class="row checkboxes">
								<div class="col-lg-8 col-md-12 col-md-12 col-sm-12 col-xs-12">
									<h3 class="process-heading mb15">{$translations.dashboard_recruiter.post_desc_label}</h3>
								</div>
								<div class="col-md-12 col-xs-12">
									<textarea id="description" name="description" class="process-textarea" rows="12" cols="1">{if $DRAFT == 'true'}{$draft_data.description}{/if}</textarea>
								</div>
							</div>
							<br />
				
							<div class="acceptance mb50">
								<label>
									<input class="checkbox-custom" type="checkbox" onchange="SimpleJobScript.applyChanged(this.checked);" name="apply_online_switch" id="apply_online_switch" data-size="mini" checked />

									<h4>{$translations.dashboard_recruiter.apply_label}<span class="apply-desc-span" >{$translations.dashboard_recruiter.apply_desc}</span></h4>

								</label>
							</div>
							<br />
							
							 <div id="apply-desc-block" class="form-group mb20 displayNone" >
								<label class="green tal mb20">{$translations.dashboard_recruiter.howto_apply_label}</label>
								<input id="howtoTA" class="form-control minput" id="howtoapply" name="howtoapply" value="{$job.apply_desc}"></input>
							 </div>
							
						
					</div>

					<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 mlpl0 mt25">
						<button type="submit" onclick="return SimpleJobScript.validateDesc();" class="btn mbtn fl" name="submit" id="submit" >{$translations.dashboard_recruiter.post_submit}</button>
					</div>
				</div>


{else}

	<div class="col-md-10 col-sm-12 locked mt25">
		<div class="modal1">
			<div class="modal fade in" id="myModal" role="dialog" style="display: block;">
				<div class="modal-dialog">
			
					<div class="modal-content">
						<div class="modal-body">
							<h4 class="modal-title md-hide mb25">1/2</h4>
							<p class="tac fs16">{$msg}</p>
							<img class="anim-pic" src="{$BASE_URL}_tpl/default/1.5/images/lock-image.png">
							<a href="{$BASE_URL}{$URL_DASHBOARD}/{$URL_DASHBOARD_ACCOUNT_ORDER}">
								<button type="button" class="btn btn-default btn-lock">{$translations.post_step1.renew}</button>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	

{/if}

	</form>
</div>