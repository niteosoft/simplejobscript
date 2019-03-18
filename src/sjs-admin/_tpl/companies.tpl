{include file="header.tpl"}
		
<div class="admin-content">
 <div class="admin-wrap-content">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
	<label class="admin-label">Companies</label>
	<div class="subheading">Red color indicates unconfirmed email address</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="search_box" style="padding: 20px 0px">

			<input value="" class="form-control" type="text" id="search_company" placeholder="Company name">	
			<input type="hidden" value="{$BASE_URL_ADMIN}companies" name="url_search" id="url_search">
			<button id="search_by_name" class="btn btn-default btn-primary" style="margin-top: 15px !important;">SEARCH</button>							
								
		</div>
	</div>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<ul class="applicants-list ">  
				{foreach item=company from=$companies name=obj} 
				    <li class="p40"> 

				    <span><span class="{if $company.confirmed == '1'}green{else}red{/if}">{$company.name}</span>&nbsp;/&nbsp;{$company.email}</span>

			    	<div style="float:right;">

				    	<a href="{$BASE_URL_ADMIN}company/{$company.emp_id}"><button type="submit" class="btn btn-default btn-primary mbtn" style="width: 100px !important; background-color: #E74C3C">Detail</button></a>

				    </div>


					</li>
				{/foreach}
			</ul>

		{if $pages}
		<div id="pagination-id" class="row pagination-cl" >
			<div class="col-md-12">
					{$pages}
			</div>
		</div>
		<br />
		{/if}

    </div>
    <script type="text/javascript">
$("#search_by_name").click(function(){
	var string = $("#search_company").val();
	var inputvalue = $("#url_search").val();
	window.location.replace(inputvalue+'?string='+string);

})	

</script>
    {if $deletedPopup == 'true'}
      <script type="text/javascript">
       setTimeout(function(){
       	jobberBase.messages.add('Company has been deleted');
       }, 1000);
      </script>
    {/if}
 </div>
</div>

{include file="footer.tpl"}