{include file="login_header.tpl"}

	<div class="form-box">
	
	<img class="adminLogo" src="{$BASE_URL}{$SITE_LOGO_PATH}">

		<div class="login-recruiter-headline admin-login-top">

			<label class="login-form-title">Backoffice</label>
			<div class="subheadline">
				Site manager
			</p>

		</div>
		<div class="login-container admin-wrap" >
			<form id="login" method="post" action="{$BASE_URL_ADMIN}">
				
					<div class="form-group">
						<div class="group{if $errors.username} error{/if}">
							<input required placeholder="username" type="text" name="username" id="username" class="form-control grayInput" value="{$smarty.post.username}" />
						</div>
					</div>

					<div class="form-group">
						<div class="group{if $errors.password} error{/if}">
							<input required placeholder="password" type="password" name="password" class="form-control grayInput" id="password"value="" />
						</div>
					</div>

					<div class="form-group">
						<div class="negative-feedback">
						{$errors.incorrect}
						</div>
					</div>
					
					<div class="form-group">
						<div class="group_submit">
							<button class="btn btn-default btn-primary mbtn" type="submit" name="submit" id="submit"><i class="fa fa-check fa-lg" aria-hidden="true"></i></button>
							<input type="hidden" name="action" value="login" />
						</div>
					</div>
			
			</form>
		</div><!-- #content -->
	</div>

{include file="footer.tpl"}
