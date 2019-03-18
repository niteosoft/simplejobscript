
<div class="contact-us">
    <div class="container">
        <h2>{$CONTACT_FORM_HEADLINE}</h2>

		{if $response}
		<br />

		<div class="row">
		  <div class="col-md-6 col-xs-12">
			<div class="{$response_class}">
				{$response_msg}
			</div>
		  </div>
		</div>

		<br /><br /><br />
		{/if}

        <div class="row">
            <div class="col-md-6 col-xs-12">
                <form id="contactus-form" role="form"  enctype="multipart/form-data" method="post" action="{$BASE_URL}{$CONTACT_PAGE_URL}" >

                    <h3>{$translations.contact.name_label}</h3>
                    <input required value="{if $current_form}{$current_form.name}{/if}" id="contact_name" name="contact_name" type="text" >

                    <h3>{$translations.contact.email_label}</h3>
                    <input required value="{if $current_form}{$current_form.email}{/if}" id="contact_email" name="contact_email" type="text" >
      
                    <h3>{$translations.contact.message_label}</h3>
                    <textarea name="contact_msg" id="contact_msg" cols="50" rows="6" maxlength="1200">{if $current_form}{$current_form.message}{/if}</textarea>
               
               		{if $ENABLE_RECAPTCHA}
						{$captcha_html}
						{if $captcha_err}<div class="negative-feedback">{$response_msg}</div>{/if}
					{/if}

					<button type="submit" name="submit" id="submit" class="btn">{$translations.detail_sidebar.modal_submit}</button>

                </form>
            </div>
            <div class="col-md-6 col-xs-12">
                <div class="map-main">
                    <div id="map">
                    </div>
                </div>
            </div>
        </div>
    </form>

    </div>
</div>