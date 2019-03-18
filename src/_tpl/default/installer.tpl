


<div class="container content top-offset">
		<div class="installer-block" style="width: 450px; margin: 0 auto; margin-top: 150px;">

			<img class="logo img-responsive" src="{$BASE_URL}{$INVOICE_LOGO_PATH}" alt="Installer logo" style="margin: 0 auto;">

			<form name="publish_form" id="publish_form" method="post" action="installer.php">
			<fieldset>
				Database host(usually localhost):<input type="text" name="host" value="localhost" /><br />
				Database port:<input type="text" name="port" value="3306" /><br />
				Database username:<input name="username" type="text" /><br />
				Database password:<input name="password" type="password" /><br />
				Database name:<input name="db_name" type="text" /><br />
				<input type="hidden" name="install" value="install" />
				<input type="submit" name="submit" id="submit" value="Save" />
			</fieldset>
			</form>
		</div>
</div>



