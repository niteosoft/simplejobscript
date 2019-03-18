{include file="header.tpl"}
		<div class="admin-content">
		  <div class="admin-wrap-content" >
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label class="admin-label">Job types</label>
					<div class="subheading">After changes click blue icon to save the setting. Employers can select a job category from this list when posting a job. Write permalink in lowercase as a single word (eg. "part-time").</div>
				</div>

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div id="typesContainer">
					{section name=tmp loop=$types}
						<div class="typeItem" rel="{$types[tmp]->getId()}">
							<div class="typeWrapper">

								<a href="#" title="Delete job type" class="deleteType"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a>
								<label><span class="gray">Name:</span><input class="light-text minput" type="text" size="25" name="name[{$types[tmp]->getId()}]" value="{$types[tmp]->getName()}" /></label>
								<a href="#" title="Save changes" class="saveType mtSave"><i class="fa fa-save fa-lg blue-fa" aria-hidden="true"></i></a>

								<label class="sec-column"><span class="gray typesPadding">Permalink:</span><input class="light-text minput" type="text" size="25" id="nr" name="var_name[{$types[tmp]->getId()}]" value="{$types[tmp]->getVarName()}" /></label>
							</div>
						</div>
					{/section}
					</div>
				<p></p>
				<p>
					<a href="#" title="Add new type"><i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i></a></p>
				</div>
		 </div><!-- #content -->
		</div>

{include file="footer.tpl"}
