{include file="header.tpl"}
		
<div class="admin-content">
<div class="admin-wrap-content">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
	<label class="admin-label">Candidate details</label>
	<div class="subheading"><a href="/sjs-admin/candidates"><div class="subheading" style="color: #000;opacity: 0.65;">(&larr;go back)</div></a></div>
	</div>

<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mt25">
	{if $data}

		<ul class="list-group">
		  <li class="list-group-item"><strong>Email: </strong>&nbsp;{$data.email}</li>
		  <li class="list-group-item"><strong>Name: </strong>&nbsp;{$data.fullname}</li>
		  <li class="list-group-item"><strong>Occupation: </strong>&nbsp;{$data.occupation}</li>

		  {if $data.skills_formated}
		  	<li class="list-group-item"><strong>Skills: </strong>&nbsp;{$data.skills_formated}</li>
		  {/if}

		  {if $data.location}
		  	<li class="list-group-item"><strong>Location: </strong>&nbsp;{$data.location}</li>
		  {/if}

		  {if $data.phone}
		  	<li class="list-group-item"><strong>Phone: </strong>&nbsp;{$data.phone}</li>
		  {/if}

		  <li class="list-group-item"><strong>Profile message: </strong>&nbsp;<a data-toggle="modal" data-target="#candidateMsgModal" href="#" onclick="return false;"><button type="submit" class="btn btn-default btn-primary mbtn" style="width: 85px !important; margin-left: 10px; font-size: 11px; background-color: #E74C3C">View</button></a></li>

		  {if $data.weblink}
		  <li class="list-group-item"><strong>Portfolio: </strong>&nbsp;{$data.weblink}</li>
		  {/if}

		  {if $data.sm_links}
	      <li class="list-group-item">
	      		<strong>{$translations.js.social_media_label} </strong>&nbsp;&nbsp;&nbsp;
				 {foreach $data.sm_links as $SM_OBJ}
					 	 <a class="mr12" href="{if $SM_OBJ->whatsapp == 'true'}tel:{$SM_OBJ->whatsapp_numb}{else}{$SM_OBJ->linkToShow}{/if}" target="_blank"><i class="fa fa-{$SM_OBJ->icon} fa-lg mt10" aria-hidden="true"></i></a>
				 {/foreach}
	      </li>
	      {/if}


		  {if $data.cv_path != ''}
		  <li class="list-group-item"><strong>CV: </strong><a title="Download cv" target="_blank" href="{$BASE_URL}{$data.cv_path}"><i class="ml10 {$imgPath}" aria-hidden="true"></i></a></li>
		  {/if}
		  <li class="list-group-item"><strong>Account status: </strong>&nbsp;{if $data.confirmed == '1'}<span class="green">confirmed</span>{else}<span class="red">unconfirmed</span>{/if}</li>
		  <li class="list-group-item"><strong>Visibility status: </strong>&nbsp;{if $data.public_profile == '1'}<span class="green">public</span>{else}<span class="red">private</span>{/if}</li>
		  {if $data.confirmed == '1'}
		  <li class="list-group-item"><a target="_blank" href="{$BASE_URL_ADMIN}login-as-candidate/{$data.id}">&nbsp;Login in as this candidate &rarr;</a></li>
		  {/if}
		</ul>

	{/if}
</div>

<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
	{if $data.confirmed == '1'}
		<a href="{$BASE_URL_ADMIN}candidate/unconfirm/{$data.id}" title="Unconfirm account">
			<button type="submit" class="btn btn-default btn-primary mbtn lgbtn" style="margin-top: 25px; background-color: #E74C3C; padding-right: 20px;">UNCONFIRM ACCOUNT</button>
		</a>
	{else}
		<a href="{$BASE_URL_ADMIN}candidate/confirm/{$data.id}" title="Confirm account">
			<button type="submit" class="btn btn-default btn-primary mbtn lgbtn" style="margin-top: 25px; background-color: #E74C3C">CONFIRM ACCOUNT</button>
		</a>
	{/if}
	<a class="ml20Desk" href="{$BASE_URL_ADMIN}candidate/delete/{$data.id}" title="Delete this candidate" onclick="if(!confirm('Are you sure you want to delete this candidate?'))return false;"><button type="submit" class="btn btn-default btn-primary mbtn" style="margin-top: 25px; background-color: #E74C3C">DELETE CANDIDATE</button></a>
</div>

<div id="candidateMsgModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Profile message</h4>
      </div>
      <div class="modal-body">
      		{$data.message}
      </div>
      <div class="modal-footer">
		<button style="float: left" type="button" class="btn btn-default btn-warning mbtn" data-dismiss="modal">Close</button>
		</div>
    </div>

  </div>
</div>

</div>
</div>

{include file="footer.tpl"}