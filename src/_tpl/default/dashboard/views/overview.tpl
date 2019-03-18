
<div class="row board">
  <h2>{$translations.dashboard_recruiter.overview_headline}</h2>
  <p>{$translations.dashboard_recruiter.welcome_message_overview}</p>
</div>
<div class="row activity">
  <h3>{$translations.dashboard_recruiter.activity}</h3>

  <div class="col-md-4 col-xs-12 boxes">
   <h4>{$overview_data.jobs_posted}</h4>
   <h5 class="custom-h5">{$translations.dashboard_recruiter.overview_jobs_posted}</h5>
 </div>

 <div class="col-md-4 col-xs-12 boxes">
   <h4>{$overview_data.applications}</h4>
   <h5>{$translations.dashboard_recruiter.overview_applications}</h5>
 </div>

 <div class="col-md-4 col-xs-12 boxes">
   <h4>{$overview_data.performance} %</h4>
   <h5>{$translations.dashboard_recruiter.overview_performance}</h5>
 </div>
</div>

<div class="row news mb40">
<h3>{$translations.dashboard_recruiter.overview_news}</h3>

{foreach from=$news item=obj}
<h4>{$obj->date}</h4>
<p>{$obj->msg}</p>
{/foreach}
</div>