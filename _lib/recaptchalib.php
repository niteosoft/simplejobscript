<?php

/** captcha functions **/

function recaptcha_get_html ()
{
  return '<h3>{CAPTCHA_LABEL}</h3><input required type="text" name="captcha" id="captcha" /><img src="data:image/png;base64, {RAW}" />';
}

?>