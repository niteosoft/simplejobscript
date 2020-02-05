
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
	<h2 class="centered">{$translations.packages.headline}</h2>
	<p class="centered">{$translations.packages.subheadline}</p>
	<br /><br />

 <div id="package-wrapper">

 	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" >
 	</div>

 	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" >
		 <div class='package'>
		    <div class='name ttu'>{$translations.dashboard_recruiter.pricing_headline}</div>
		    <hr
>		    <ul class="pricing-text"
>		      <li>
		        <strong>{$translations.post_step2.job_post_fee|upper}&nbsp;</strong>
		        {$job_posted_price}
		      </li>
		      <li>
		        <strong>{$translations.dashboard_recruiter.jobs_premium|upper} {$translations.post_step2.job_post_fee|upper}&nbsp;</strong>
		       {$premium_listing_price}
		      </li
>
		      <li>
		        <strong>{$translations.packages.job_period|upper}&nbsp;</strong>
		       {$job_expires}&nbsp;{$translations.date.days}
		      </li
>
		      <li>
		        <strong>{$translations.dashboard_recruiter.top_menu_browse_applicants|upper}&nbsp;</strong>
		         {$cvdb_access_price}
		      </li>	   
		      </ul>
		  </div>
	  </div>

	  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" >
 	  </div>

	   <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
	  	 <a href="/{$URL_REGISTER_RECRUITERS}">

	  	 	<button type="button" name="pricing-btn" id="pricing-btn" class="btn">{$translations.website_general.top_menu_register_label}</button>

	  	 </a>
	   </div>

 </div>
</div>