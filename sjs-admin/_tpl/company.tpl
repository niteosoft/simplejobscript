{include file="header.tpl"}
		
<div class="admin-content">
 <div class="admin-wrap-content">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
	<label class="admin-label">Company details</label>
	<div class="subheading">You can log into employer's dashboard and manage the account on his behalf{if $data.emp_id == '144'}<div class="positive-feedback green">Admin profile works with DATA FEEDER. Is not listed publicly and cannot be deleted.{/if}</div><a href="/sjs-admin/companies"><div class="subheading" style="color: #000;opacity: 0.65;">(&larr;go back)</div></a></div>


<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mt25 fs17">
	{if $data}

		<ul class="list-group">
		  <li class="list-group-item"><strong>Employer email: </strong>&nbsp;{$data.email}</li>
		  <li class="list-group-item"><strong>Employer name: </strong>&nbsp;{$data.employer_name}</li>
		  <li class="list-group-item"><strong>Company name: </strong>&nbsp;{$data.company_name}</li>
		  <li class="list-group-item"><strong>Account status: </strong>&nbsp;
		  {if $data.confirmed == '1'}
		  	<span class="green">confirmed</span>
		  {else}
		    <span class="red">unconfirmed</span>
		  {/if}</li>

		  {if $PROFILE_PLUGIN == '1' and $PAYPAL_PLUGIN == '1' and $PAYMENT_MODE == '2'}
			  <li class="list-group-item"><strong>
			  	Resume database access: </strong>&nbsp;
				  {if $data.cvdb_access == '1'}
				  	<a class="mr10 mb3" id="cvdb-icon-activated" href="javascript:void(0);" onclick="Jobber.DeactivateCvdb('{$BASE_URL_ADMIN}cvdb-deactivate/', {$data.emp_id}, '{$BASE_URL_ADMIN}cvdb-activate/');" title="Remove access"><i class="fa fa-circle fa-lg green-fa" aria-hidden="true"></i></a>
				  {else}
				  	<a  class="mr10 mb3" id="cvdb-icon-deactivated" href="javascript:void(0);" onclick="Jobber.ActivateCvdb('{$BASE_URL_ADMIN}cvdb-activate/', {$data.emp_id}, '{$BASE_URL_ADMIN}cvdb-deactivate/');" title="Grant access"><i class="fa fa-circle-o fa-lg green-fa" aria-hidden="true"></i></a>
				  {/if}
			  </li>
		  {/if}

		   {if $PAYMENT_MODE == '3'}
		   	<li class="list-group-item"><strong>Package plan: </strong>&nbsp;<strong class="bl">{$package_data.name}</strong> - 
		   		<a href="{$BASE_URL_ADMIN}company/{$data.emp_id}/plan-management" title="Manage employer's package plan" style="opacity: 0.5;">[manage]</a>
		   	</li>
		   {/if}

		   {if $data.confirmed == '1'}
		  <li class="list-group-item"><a target="_blank" href="{$BASE_URL_ADMIN}login-as/{$data.emp_id}/{$data.employer_name}">&nbsp;Login in as this employer &rarr;</a></li>
		   {/if}
		</ul>

	{/if}
</div>

<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
	{if $data.confirmed == '1'}
		<a href="{$BASE_URL_ADMIN}company/{$data.emp_id}/unconfirm" title="Unconfirm account">
			<button type="submit" class="btn btn-default btn-primary mbtn lgbtn" style="margin-top: 25px; background-color: #E74C3C">UNCONFIRM ACCOUNT</button>
		</a>
	{else}
		<a href="{$BASE_URL_ADMIN}company/{$data.emp_id}/confirm" title="Confirm account">
			<button type="submit" class="btn btn-default btn-primary mbtn lgbtn" style="margin-top: 25px; background-color: #E74C3C">CONFIRM ACCOUNT</button>
		</a>
	{/if}
		{if $data.emp_id != '144'}
		<a class="ml20Desk" href="{$BASE_URL_ADMIN}company/{$data.emp_id}/delete" title="Delete company" onclick="if(!confirm('Are you sure you want to delete this company?'))return false;"><button type="submit" class="btn btn-default btn-primary mbtn" style="margin-top: 25px; background-color: #E74C3C">DELETE COMPANY</button></a>
		{/if}

</div>


{if $PROFILE_PLUGIN == '1'}
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt15">
	<label style="text-transform: uppercase; margin-top: 10px;">Invoices for this company</label>
	<hr />
	</div>

	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
		<div class="table-responsive job-table">
			<table class="table table-striped table-condensed manage-jobs-table normal-gray">
			    <thead>
			      <tr>
			        <th><strong>{$translations.dashboard_recruiter.date_column}</strong></th>
			        <th><strong>{$translations.dashboard_recruiter.invoice_column}</strong></th>
			      </tr>
			    </thead>
			    <tbody>
			      {if !empty($invoices)}
				      {foreach from=$invoices item=invoice}
				      <tr>
				      	<td>{$invoice.date}</td>
				      	<td><a href="{$invoice.path}" target="_blank"><i class="fa fa-file-pdf-o fa-lg pdf-el" aria-hidden="true"></i></a></td>
				      </tr>
				      {/foreach}
			      {else}
			      	   #there are no invoices for this company
			      	   <br /><br />
			      {/if}
			    </tbody>
			</table>
		</div>
	</div>
{/if}

</div>
</div>

{include file="footer.tpl"}