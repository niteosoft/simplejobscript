{include file="header.tpl"}

	<div class="admin-content">
	  <div class="admin-wrap-content">
	<!-- 	  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  	<label class="admin-label mb15">Translations</label>
		  </div>			

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb50">		
					<h4  class="upc" style="margin-bottom: 10px;"><a class="blue" href="{$BASE_URL_ADMIN}translations/edit/{$smarty.const.LANG_CODE}/">&rarr;Edit translations</a></h4>
					<div class="subheading">Manage translations (strings on the site + emails).</div>
				</div>


					<div id="translation-langs">
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<h4 class="upc fs13" style="margin-bottom: 20px;">Add a new language</h4>
							<form id="new-lang-frm" method="post" action="" >
									<table class="table table-condensed settings-table">
										<tr class="light-gray fs13"style="opacity: 0.65" ><th>Name (e.g. English)</th><th>Code (e.g. en)</th><th>&nbsp;</th></tr>
										<tr>
											<td><input class="mr15 minput form-control" type="text" id="new-lang-name" /></td>
											<td><input class="mr15 minput form-control" type="text" id="new-lang-code" size="7" maxlength="2" /></td>
											<td><button style="width: 75px" id="add-lang-trigger">Add</button></td>
										</tr>
									</table>
							</form>
						</div>
						
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
 						<h4  class="upc fs13" style="margin-bottom: 20px;">Existing languages</h4>
						<div class="table-responsive">
							<table class="table table-condensed settings-table" cellspacing="0">
								<tr class=" upc fs13" style="opacity: 0.65"><th>Name</th><th>Code</th><th>&nbsp;</th></tr>
								{foreach item=lang from=$languages}
								<tr class="{$lang.code}">
									<td width="200">
										<span class="light-gray fs13">{$lang.name}</span>
										<div class="lang-edit"><form><input class="mr15 minput form-control new-lang-name" type="text" value="{$lang.name}" /></form></div>
									</td>
									<td width="100">
										<span class="light-gray fs13">{$lang.code}</span>
										<div class="lang-edit"><form><input class="mr15 minput form-control new-lang-code" type="text" value="{$lang.code}" size="7" maxlength="2" /></form></div>
									</td>
									 <td width="100">
										<div style="padding-top: 30px; padding-left: 20px;"><a href="#" class="lang-edit-trigger" rel="{$lang.code}"><i class="fa fa-gear fa-lg blueColor mr5" aria-hidden="true"></i></a></div>
									</td>
									<td width="100">
										<div style="padding-top: 30px; padding-left: 20px;"><a href="#" class="lang-delete-trigger" rel="{$lang.id}"><i class="fa fa-trash fa-lg blueColor" aria-hidden="true"></i></a></div>
									</td>
				 					<td align="right" class="no-decor">
										<div style="padding-top: 30px; padding-left: 20px;" class="lang-edit"><button style="width: 75px" class="lang-save-trigger" rel="{$lang.id}">Save</button> &nbsp;or&nbsp; <a class="lang-cancel-trigger" href="#" rel="{$lang.code}">Cancel</a></div>
									</td>  
								</tr>
								{/foreach}
							</table>
						</div>
					</div>
					</div>		 -->

	</div>
	</div>
		
{include file="footer.tpl"}