{include file="header.tpl"}
		<div class="admin-content">
		   <div class="admin-wrap-content">
				 <label class="admin-label">Password change</label>
				 <div class="subheading">Change your SJS admin password</div><br />
				 <a href="/sjs-admin/settings"><div class="subheading">&larr;go back</div></a>
				<br />
				{if $error}
					<div class="negative-feedback">
						{$error}
					</div>
				{/if}

				{if $success}
					<div class="positive-feedback">
						{$success}
					</div>
				{/if}
				
				<form id="change_password" action="{$smarty.server.REQUEST_URI}" method="post">
					<div>
						<div class="form-group {if $error} error{/if}">
							<input required placeholder="new password" class="form-control minput" type="password" name="new_password" id="new_password" size="30" />
						</div>
						<div class="form-group {if $error} error{/if}">
							<input required placeholder="repeat password" class="form-control minput" type="password" name="verify_password" id="verify_password" size="30" />
						</div>
					<div class="button-holder-np form-group" >
						<button type="submit" class="btn btn-default btn-primary mbtn" name="submit" id="submit" >Change password</button>
					</div>
				</form>
			</div>
		</div><!-- #content -->

	{literal}
		<script type="text/javascript">
			$(document).ready(function()
			{
				$('#new_password').focus();
				
				$("#change_password").validate({
					rules: {
						new_password: { required: true },
						verify_password: { equalTo: "#new_password" }
					}
				});
			});
		</script>
		{/literal}

{include file="footer.tpl"}