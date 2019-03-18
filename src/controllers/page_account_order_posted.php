<?php 

if (!defined('PAYPAL_PLUGIN')) {
	$smarty->assign('msg', 'Paypal plugin missing or misconfigured.');
	$smarty->assign('view', 'error.tpl');
	$template = URL_DASHBOARD . '/dashboard.tpl';
} else {

	try {
		include($DIR_CONST . '../../plugins/Paypal/paypal_account_order_snippet.php');
	} catch (Exception $e) {}
}

?>