

<div class="categories-menu profileSidebar">
	<h4 class="sidebar-title" style="padding: 20px !important;"><span class="opaque">{$translations.profile.logged_as}</span> {$profile.fullname}</h4>
	<div class="profileWrap">
		<ul class="profileUl">
		  <li class="{if $ACTIVE == $PROFILE_ROUTING_ARR[$URL_PROFILE_EDIT]}act{/if}"><a href="/{$URL_PROFILE}/{$URL_PROFILE_EDIT}"><i class="mr10 fa fa-user-circle" aria-hidden="true"></i>{$translations.profile.menu_edit}</a></li>
		  <li class="{if $ACTIVE ==  $PROFILE_ROUTING_ARR[$URL_PROFILE_APPLICATIONS]}act{/if}"><a href="/{$URL_PROFILE}/{$URL_PROFILE_APPLICATIONS}"><i class="mr10 fa fa-address-card-o " aria-hidden="true"></i>{$translations.profile.menu_apps}</a></li>
		  <li class="{if $ACTIVE == $PROFILE_ROUTING_ARR[$URL_PROFILE_CHANGEPASSWORD]}act{/if}"><a href="/{$URL_PROFILE}/{$URL_PROFILE_CHANGEPASSWORD}"><i class="mr10 fa fa-gears " aria-hidden="true"></i>{$translations.profile.menu_pass}</a></li>

		  <li><a href="/{$URL_PROFILE}/logout"><i class="mr10 fa fa-arrow-circle-o-right " aria-hidden="true"></i>{$translations.profile.menu_logout}</a></li>
		</ul>
	</div>
</div>