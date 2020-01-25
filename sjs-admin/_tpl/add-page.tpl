{include file="header.tpl"}
		<div class="admin-content">
		 <div class="admin-wrap-content" style="padding-right: 35px !important;">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<label class="admin-label">New page</label>
				<div class="subheading">Write URL in lowercase as a single word (eg. "test-page"). Use WYSIWYG editor to create HTML content of your page or copy content from DOC / PDF. ( <a style="opacity: 0.8;" href="{$BASE_URL_ADMIN}pages/">&larr;go back</a> )</div>
				<br />
			</div>
		
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<form method="post" action="{$BASE_URL_ADMIN}pages/add" role="form">
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="form-group">
						<label for="title">Title</label>
						<input  required name="title" id="title" maxlength="50" type="text" class="form-control minput"  />
					</div>
					<div id="url-block" class="form-group">
						<label for="url">Url</label>
						<input  name="url" id="url" maxlength="50" type="text" class="form-control minput"  />
					</div>

					<div class="form-group mb85mobile">
		 			 	<input type="checkbox" onchange="Jobber.pagesExternalSwitched(this.checked);" name="external_switch" id="external_switch" data-size="mini" />
		 			 	<span style="position: absolute; margin-top: -1px">
		 				 	<label style="margin-left: 20px;">external page</label>
		 			 	</span>
		 			 </div>

					<div class="form-group">
						<label for="link_order">Order (1-50)</label>
						<input type="number" required class="form-control minput" name="link_order" id="link_order" />
					</div>


		 		    <div id="external-page-block" class="form-group displayNone mb20" >
		 			 	<label for="url">External URL <span class="fs13">(eg. http://website.com)</span></label>
						<input  name="external_url" id="external_url" type="text" class="form-control minput"  />
		 			</div>


				</div>

				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

					<div id="keywords-block" class="form-group">
						<label for="keywords">SEO keywords</label>
						<textarea maxlength="50" class="noTinymceTA form-control" name="keywords" id="keywords" rows="3" >{$data.description}</textarea>
					</div>

					<div id="desc-block" class="form-group">
						<label for="desc">SEO description</label>
						<textarea class="noTinymceTA form-control" name="desc" id="desc" rows="5" >{$data.description}</textarea>
					</div>

				</div>

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div id="content-block" class="form-group">
						<label for="page_content">Content</label>
						<textarea class="form-control minput" name="page_content" id="page_content" rows="10" style="min-width: 300px !important;"></textarea>
					</div>
				</div>

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="form-group" style="margin-top: 10px;">
						<button type="submit" class="btn btn-default btn-primary mbtn" name="submit" id="submit" >Submit</button>
					</div>
				</div>

				</form>
			</div>

		</div><!-- #content -->
		</div>

{literal}
<script type="text/javascript">
	$(document).ready(function(){
		var theme = "{/literal}{$THEME}{literal}";
		tinymce.init({selector:'textarea:not(.noTinymceTA)', content_css : "/_tpl/" + theme + "/1.5/css/custom-editor.css", height : 300, resize: 'both' , theme: 'modern', toolbar1: 'insertfile undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image', toolbar2: 'preview media | forecolor emoticons', plugins: ["paste advlist autolink lists link image charmap preview hr anchor pagebreak searchreplace wordcount visualblocks visualchars media nonbreaking save table contextmenu directionality emoticons template textcolor colorpicker textpattern "], paste_retain_style_properties: "color font-style font-size",paste_webkit_styles: "color font-style font-size" });
	});
</script>
{/literal}

{include file="footer.tpl"}