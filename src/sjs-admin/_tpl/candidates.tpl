{include file="header.tpl"}
		
<div class="admin-content">
 <div class="admin-wrap-content">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
	<label class="admin-label">Candidates</label>
	<div class="subheading">Red color indicates unconfirmed email address</div>
	</div>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<ul class="applicants-list ">  
				{foreach item=candidate from=$candidates name=obj} 
				    <li class="p40"> 

				    <span><span class="{if $candidate.candidate_confirmed == '1'}green{else}red{/if}">{$candidate.candidate_name}</span>&nbsp;/&nbsp;{$candidate.candidate_email}</span>

			    	<div style="float:right;">

				    	<a href="{$BASE_URL_ADMIN}candidate/{$candidate.candidate_id}"><button type="submit" class="btn btn-default btn-primary mbtn" style="width: 100px !important; background-color: #E74C3C">Detail</button></a>

				    </div>


					</li>
				{/foreach}
			</ul>
			<br />

			{if $pages}
			<div id="pagination-id" class="row pagination-cl" >
				<div class="col-md-12">
						{$pages}
				</div>
			</div>
			<br />
			{/if}

    </div>

    {if $deletedPopup == 'true'}
      <script type="text/javascript">
       setTimeout(function(){
       	jobberBase.messages.add('Candidate has been notified and deleted');
       }, 1000);
      </script>
    {/if}
 </div>
</div>

{include file="footer.tpl"}