<script src="{$BASE_URL}js/jquery.confirm.min.js"></script>

<div class="confirmDiv">

	<div class="row">
	    <div class="col-md-12 col-sm-12 mb20">
	        <p class="profile-subheadline">
	            {$translations.profile.delete_text}
	        </p>
	    </div>
	</div>

	<div class="row">
	    <div class="col-md-6 col-sm-12">
	    	<a id="deleteConfirm" href="/{$URL_PROFILE}/deleteacc"><button type="button" class="btn mbtn zeromlplLeft">{$translations.profile.delete_txt}</button></a>
	    </div>
	</div>

</div>


<script type="text/javascript">
		$("#deleteConfirm").confirm({
		    text: "{$translations.profile.text_are_you_sure}",
		    confirm: function(button) {
		        window.location.replace(button[0].pathname);
		    },
		    cancel: function(button) {
		    },
		    confirmButton: "{$translations.profile.text_yes}",
		    cancelButton: "{$translations.dashboard_recruiter.text_no}",
		    confirmButtonClass: "btn mbtn cbtn",
		    cancelButtonClass: "btn mbtn cbtn"
		});	
</script>