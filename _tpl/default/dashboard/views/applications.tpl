
<style type="text/css">
.modal-body {
padding: 5% 3% !important;
}
.modal-dialog {
	margin-top: 10% !important;
}
</style>

<div class="row board mb25">
  <h2>{$translations.dashboard_recruiter.jobs_apps_headline}</h2>
  <p>{$translations.dashboard_recruiter.jobs_apps_desc}</p>
</div>
<br /><br />

<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mlpl0 mb25">
	<form role="form">
		<label class="mb15" for="job_select">{$translations.dashboard_recruiter.select_jobs_title}</label>
			<i id="apps_spinner" class="ml15 displayNone fa fa-refresh fa-spin fa-lg fa-fw refresh-spinner"></i>
			<select id="job_select" name="job_select" class="form-control minput">
				{foreach from=$jobs_select key=id item=value}
					{if $select_job_id}
						{if $select_job_id == $id}
						<option selected value="{$id}">{$value}</option>
						{else}
						<option value="{$id}">{$value}</option>
						{/if}
					{else}
						<option value="{$id}">{$value}</option>
					{/if}
					}
				{/foreach}
			</select>
	</form>
</div>
<br /><br />

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mlpl0">
	<div class="table-responsive applications-table">
		<table class="table table-striped">
		    <thead>
		      <tr>
		      	<th id="ur-job-title" class="displayNone"><strong>{$translations.dashboard_recruiter.jobs_title}</strong></th>
		        <th><strong>{$translations.apply.table_applicant}</strong></th>
		        <th><strong>{$translations.apply.occupation_label}</strong></th>
		        <th><strong>{$translations.apply.skills}</strong></th>
		        <th><strong>{$translations.apply.located}</strong></th>
		        <th><strong>{$translations.applications.cv}</strong></th>
		        <th><strong>{$translations.apply.table_message}</strong></th>
		        <th id="review-id"><strong>{$translations.apply.table_review}</strong></th>
		        <th id="hire-id" class="displayNone"><strong>{$translations.apply.hire_label}</strong></th>
		        <th><strong>{$translations.apply.table_delete}</strong></th>
		      </tr>
		    </thead>
		    <tbody id="ajax-content"></tbody>
		</table>
	</div>
</div>


{if $HIRED_APPS =='true'}
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mlpl0 mb25">
	<div class="row board">
	  <h2>{$translations.dashboard_recruiter.hired_candidates_headline}</h2>
	  <p>{$translations.dashboard_recruiter.hired_candidates_subheadline}</p><br /><br />
	</div>
</div>

<br /><br />

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mlpl0">
	<div class="table-responsive applications-table">
		<table class="table table-striped">
		    <thead>
		      <tr>
		      	<th><strong>{$translations.dashboard_recruiter.jobs_title}</strong></th>
		        <th><strong>{$translations.apply.table_applicant}</strong></th>
		        <th><strong>{$translations.apply.occupation_label}</strong></th>
		        <th><strong>{$translations.apply.skills}</strong></th>
		        <th><strong>{$translations.apply.located}</strong></th>
		        <th><strong>{$translations.applications.cv}</strong></th>
		        <th><strong>{$translations.apply.table_message}</strong></th>
		        <th id="delete-id"><strong>{$translations.apply.table_jobs_delete}</strong></th>
		      </tr>
		    </thead>
		    <tbody id="ajax-hire-content">
			    {if $HIRED_APPS_DATA}
				 {section name=index loop=$HIRED_APPS_DATA}
				 		     <tr id="tr-{$HIRED_APPS_DATA[index].id}">
						    	<td><strong><a href="{$HIRED_APPS_DATA[index].job_url}" target="_blank">{$HIRED_APPS_DATA[index].job_name}</a></strong></td>
						    	<td><strong>{$HIRED_APPS_DATA[index].name}</strong></td>
						    	<td><strong>{$HIRED_APPS_DATA[index].occupation}</strong></td>
						    	<td><ul class="tags jatul">{$HIRED_APPS_DATA[index].skills_formated}</ul></strong></td>
						    	<td><strong>{$HIRED_APPS_DATA[index].location}</strong></td>


						    	<td><a href="{$BASE_URL}{$HIRED_APPS_DATA[index].cv_path}" download="{$BASE_URL}{$HIRED_APPS_DATA[index].cv_path}{$HIRED_APPS_DATA[index].cv_path}"><i class="{$HIRED_APPS_DATA[index].fa_class}" aria-hidden="true"></i></a></td>


						    	<td><a data-toggle="modal" data-target="#hired_modal_{$HIRED_APPS_DATA[index].id}" href="#"><i class="fa fa-address-card-o fa-lg" aria-hidden="true"></i></a></td>
						    	<td>
						    		<a name="{$HIRED_APPS_DATA[index].id}" id="hired-{$HIRED_APPS_DATA[index].id}" href="#">
						    			<i class="fa fa-trash fa-lg" aria-hidden="true"></i>
						    		</a>
						    	</td>
						     </tr>
				 {/section}
				{/if}
		    </tbody>
		</table>
	</div>
</div>

{/if}



