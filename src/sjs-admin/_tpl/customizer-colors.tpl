{include file="header.tpl"}
		
<div class="admin-content">
 <div class="admin-wrap-content">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
	<label class="admin-label">SJS CUSTOMIZER</label>
	<div class="subheading">Change the design of your website by selecting new skin</div>
	
	<p>(<a style="opacity: 0.8;" href="{$BASE_URL_ADMIN}customizer/">&larr;go back</a>)</p>
	</div>

	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mt25">
	    <form method="post" action="{$BASE_URL_ADMIN}customize-colors" role="form" enctype="multipart/form-data">
 
	    	<div class="form-group">
	    	 <label>Job board theme color:</label><br />
			 <input type='text' id="cp">
			</div>
		
			<br />

			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mlpl0">
 				<button  onclick="setCpColor(); return false;" type="submit"  class="btn btn-default btn-primary mbtn" name="submit" id="submit" class="mt25" >SAVE</button>
 			</div>

		</form>
    </div>

    </div>
</div>

<script type="text/javascript">
$(document).ready(function()
{
	$("#cp").spectrum({
	    color: "{$active_color}",
	    cancelText: "Reset",
	    chooseText: "Select",
	    preferredFormat: "hex",
	    showInput: true,
	    togglePaletteOnly: true
	});
});

function setCpColor(){
	// send ajax request and save new color into db

	$.ajax({ url: '/ajax_save_cp_color.php',
	         data: "cp_color=" + $("#cp").spectrum("get").toHexString(),
	         type: 'post'
		}).done(function(msg) {
			 jobberBase.messages.add('New Color Theme Saved');
	});

}
</script>

{include file="footer.tpl"}