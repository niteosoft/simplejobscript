{include file="header.tpl"}
		<div class="admin-content">
			<div class="admin-wrap-content" >
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb25">
					<label class="admin-label">Categories</label>
					<div class="subheading">After changes click blue icon to save the setting. Drag and drop by green border handle to change the order. Title, Desc and Keyword = SEO Meta tags. Write URL in lowercase as a single word (eg. "mobile-development")</div>
				</div>
				<br /><br />

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div id="categoriesContainer">
					{foreach from=$categories item=category}
						<div class="categoryItem" rel="{$category.id}">
							<div class="categoryHandle"></div>
							<div class="categoryWrapper">
								<div class="row-fluid">
									<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12" >
										<label><span class="gray typesPadding">Name:</span><input class="ml5 form-control minput" type="text" size="60" name="name[{$category.id}]" value="{$category.name}" /></label>
										<label><span class="gray typesPadding">Title:</span><input class="form-control minput" type="text" size="60" name="title[{$category.id}]" value="{$category.title}" /></label>
										<label><span class="gray typesPadding">Desc:&nbsp;</span><input class="ml5 form-control minput" type="text" size="60" name="desc[{$category.id}]" value="{$category.description}"/></label>
										<label><span class="gray typesPadding">Keywords:</span><input class="ml5 form-control minput" type="text" size="60" name="keys[{$category.id}]" value="{$category.keywords}" /></label>
										<label><span class="gray typesPadding">URL:</span><input class="ml5 form-control minput" type="text" size="60" name="url[{$category.id}]" value="{$category.var_name}" /></label>
									</div>

									<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
										<a href="#" title="Delete this category" class="deleteCategory"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a>
										<a href="#" title="Save changes" class="saveCategory mr10 mtSave"><i class="fa fa-save fa-lg blue-fa" aria-hidden="true"></i></a>
									</div>

								</div>
							</div>
						</div>
					{/foreach}
					</div>
				<p></p>
				<p>
					<a href="#" title="Add new category"><i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i></a>
				</div>
		</div><!-- #content -->
		</div>

{include file="footer.tpl"}