<?php 

$smarty->assign('msg', $translations['paypal']['paypal_err_msg']  . ' ' . $translations['paypal']['currency_amount_error'] );
$smarty->assign('view', 'paypal-error.tpl');
$template =  'dashboard/dashboard.tpl';
return;

?>