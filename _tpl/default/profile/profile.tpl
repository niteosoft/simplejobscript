{include file="1.5/layout/sjs-header.tpl"}

<div class="candidate-v2">
	<div class="row">

		<div class="col-md-2 col-sm-12">
			<ul>
				<a href="/{$URL_PROFILE}/{$URL_PROFILE_EDIT}"><li class="{if $ACTIVE == $PROFILE_ROUTING_ARR[$URL_PROFILE_EDIT]}active{/if}"><i class="fa fa-user-circle" aria-hidden="true"></i> 
				{$translations.profile.menu_edit}</li></a>

				<a href="/{$URL_PROFILE}/{$URL_PROFILE_APPLICATIONS}"><li class="{if $ACTIVE == $PROFILE_ROUTING_ARR[$URL_PROFILE_APPLICATIONS]}active{/if}"><i class="fa fa-address-card-o" aria-hidden="true"></i>
				{$translations.profile.menu_apps}</li></a>

				<a href="/{$URL_PROFILE}/{$URL_PROFILE_CHANGEPASSWORD}"><li class="{if $ACTIVE == $PROFILE_ROUTING_ARR[$URL_PROFILE_CHANGEPASSWORD]}active{/if}"><i class="fa fa-gears" aria-hidden="true"></i>
				{$translations.profile.menu_pass}</li></a>

				<a href="/{$URL_PROFILE}/logout"><li><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>
				{$translations.dashboard_recruiter.logout_label}</li></a>

			</ul>

								
			{if $smarty.const.BANNER_MANAGER == 'true'}
				{include file="$banners_cdb"}
			{/if}	
				

		</div>

        <div class="col-md-10 col-sm-12">
         <div class="employer-dashboard">
	          <div class="container">
	         	 <div class="row board">
                    <h2>{$title}</h2>
                   
                    {include file="profile/$ACTIVE.tpl"}

                 </div>
	     	  </div>
   		 </div>
  		</div>

	</div>
</div>

{include file="1.5/layout/sjs-footer.tpl"}
