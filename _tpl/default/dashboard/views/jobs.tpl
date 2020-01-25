
  
<style type="text/css">
.modal-body {
padding: 5% 3% !important;
}
.modal-dialog {
	margin-top: 10% !important;
}
</style>

<div class="row board">
  <h2>{$translations.dashboard_recruiter.jobs_headline}</h2>
  <p>{$translations.dashboard_recruiter.jobs_about_tag}</p>
</div>
<br /><br />

<div class="row board mt0">
	<div class="table-responsive job-table">
		<table class="table table-striped">
		    <thead height="20">
		      <tr>
		        <th>{$translations.dashboard_recruiter.jobs_title}</th>
		        <th>{$translations.dashboard_recruiter.jobs_status}</th>
		        <th>{$translations.dashboard_recruiter.jobs_views}</th>
		        <th>{$translations.dashboard_recruiter.jobs_applications}</th>
		        <th>{$translations.dashboard_recruiter.jobs_statistics}</th>
		        <th>{$translations.dashboard_recruiter.info}</th>
		        <th>{$translations.dashboard_recruiter.jobs_edit}</th>
		        <th>{$translations.apply.table_jobs_delete}</th>
		      </tr>
		    </thead>
		    <tbody>
		      {foreach from=$dash_jobs item=job}
		      <tr>
		      	{if $job.is_active == '1'}
		      		<td><a rel="canonical" href="{$BASE_URL}{$URL_JOB}/{$job.url_title}-{$job.location_asci}/{$job.id}" target="_blank" >{$job.title}</a></td>
		      	{else}
		      		<td><s>{$job.title}</s></td>
		      	{/if}

		      	{if $job.is_active == '1'}
		      		<td>{$translations.dashboard_recruiter.jobs_active}</td>
		      	{else}
		      		<td class="red">{$translations.dashboard_recruiter.jobs_inactive}</td>
		      	{/if}

		      	<td>{$job.views_count}</td>
		      	<td>{$apps_array[$job.id]}</td>
		      	<td class="opaque"><a href="{$BASE_URL}{$URL_DASHBOARD}/{$URL_DASHBOARD_STATISTICS}/{$job.id}/{$job.views_count}-{$apps_array[$job.id]}"><i class="fa fa-bar-chart-o fa-lg jobsIcon" aria-hidden="true"></i></a></td>
		      	<td><a data-toggle="modal" data-target="#modal_{$job.id}" href="#"><i class="jobsIcon fa fa-file-text-o fa-lg" aria-hidden="true"></i>
		      	<td class="opaque"><a href="{$BASE_URL}{$URL_DASHBOARD}/{$URL_DASHBOARD_EDIT_JOB}/{$job.id}"><i class="jobsIcon fa fa-wrench fa-lg" aria-hidden="true"></i></a></td>
		      	<td class="opaque"><a id="deleteConfirm-{$job.id}"  href="{$BASE_URL}{$URL_DASHBOARD}/{$URL_DASHBOARD_DELETE_JOB}/{$job.id}"><i class="jobsIcon fa fa-trash fa-lg" aria-hidden="true"></i></a></td>
		      </tr>
		      {/foreach}
		    </tbody>
		</table>
	</div>
</div>

{foreach from=$dash_jobs item=job}
<script type="text/javascript">
	$("#deleteConfirm-{$job.id}").confirm({
		    text: "{$translations.dashboard_recruiter.delete_job_message}",
		    confirm: function(button) {
		        window.location.replace(button[0].pathname);
		    },
		    cancel: function(button) {
		    },
		    confirmButton: "{$translations.dashboard_recruiter.yes_i_do}",
		    cancelButton: "{$translations.dashboard_recruiter.text_no}",
		    confirmButtonClass: "btn btn-green",
		    cancelButtonClass: "btn btn-gray"
	});
</script>
{/foreach}