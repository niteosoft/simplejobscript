
<div class="row board ml0 pl0">

  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" >
    <h2>{$translations.dashboard_recruiter.editjob_headline}</h2>
    <p>{$translations.dashboard_recruiter.editjob_about_tag}</p>
  </div>

  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" >
    <a href="{$BASE_URL}{$URL_DASHBOARD}/{$URL_DASHBOARD_JOBS}"><button type="button" class="btn btn-green tabletmt3p deskFr" >{$translations.dashboard_recruiter.back}</button></a>
  </div>
</div>

<br /><br />

<div class="job-process">
	<form method="post" action="{$BASE_URL}{$URL_JOB_EDITED}" role="form">
		<input type="hidden" id="job_id" name="job_id" value="{$job.id}" />

		<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12" >

			<div class="row checkboxes">
				<div class="col-md-3 col-xs-12">
					<h3 class="process-heading">{$translations.dashboard_recruiter.post_type_label}</h3>
				</div>
				<div class="col-md-5 col-xs-12">								
					<select id="type_select" name="type_select">
						{foreach from=$types key=id item=value}
							<option {if $value == $job.type_name}selected{/if} value="{$id}">{$value}</option>
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
							<option {if $id == $job.category_id}selected{/if} value="{$id}">{$value}</option>
						{/foreach}
					</select>
				</div>
			</div>

			{if $remote_portal == 'deactivated'}
			<div class="row checkboxes">
				<div class="col-md-3 col-xs-12">
					<h3 class="process-heading">{$translations.dashboard_recruiter.post_location_label}</h3>
				</div>
				<div class="col-md-5 col-xs-12">								
					<select id="location_select" name="location_select">
						{foreach from=$cities key=id item=value}
							<option {if $id == $job.city_id}selected{/if} value="{$id}">{$value}</option>
						{/foreach}
					</select>
				</div>
			</div>
			{/if}

			<div class="row checkboxes">
				<div class="col-md-3 col-xs-12">
					<h3 class="process-heading">{$translations.dashboard_recruiter.post_title_label}</h3>
				</div>
				<div class="col-md-5 col-xs-12">
					<input required name="title" id="title" maxlength="400" type="text" value="{$job.title}" class="job-title"  />
				</div>
			</div>


			<div class="row checkboxes">
				<div class="col-md-3 col-xs-12">
					<h3 class="process-heading">{$translations.dashboard_recruiter.salary_label}</h3>
				</div>
				<div class="col-md-5 col-xs-12">
					<input name="salary" class="job-title" id="salary" type="text" value="{$job.salary}"  />
				</div>
			</div>


			<div class="row checkboxes">
				<div class="col-lg-8 col-md-12 col-md-12 col-sm-12 col-xs-12">
					<h3 class="process-heading mb15">{$translations.dashboard_recruiter.post_desc_label}</h3>
				</div>
				<div class="col-md-12 col-xs-12">
					<textarea id="description" name="description" class="process-textarea" rows="12" cols="1">{$job.description}</textarea>
				</div>
			</div>
			<br />

			<div class="acceptance">
				<label>
					<input class="checkbox-custom" type="checkbox" onchange="SimpleJobScript.applyChanged(this.checked);" name="apply_online_switch" id="apply_online_switch" data-size="mini" {if $job.apply_online == '1'}checked{/if} />

					<h4>{$translations.dashboard_recruiter.apply_label}<span class="apply-desc-span" >{$translations.dashboard_recruiter.apply_desc}</span></h4>

				</label>
			</div>
			
			<div id="apply-desc-block" class="row checkboxes {if $job.apply_online == '1'} displayNone{/if}">
				<div class="col-md-12 col-xs-12 mtm20" >
					<h3 class="process-heading green">{$translations.dashboard_recruiter.howto_apply_label}</h3>
		
					<input value="http://{$job.apply_desc}" id="howtoTA" class="process-textarea" id="howtoapply" name="howtoapply"></input>
				</div>
			</div>

		</div>

			<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 mt25 mb50">
				<button type="submit" onclick="return SimpleJobScript.validateDesc();" class="btn mbtn fl" name="submit" id="submit" >{$translations.website_general.text_save}</button>
			</div>

	</form>
</div>