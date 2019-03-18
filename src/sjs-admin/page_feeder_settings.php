<?php 

global $db;

$smarty->assign('ACTIVE', 50);

$class = new Company();
$data = $class->getAdminCompanyData();

if (isset($_POST['email'])) {
	escape($_POST);
	// update this email
	$class->updateAdminEmployerData($data['employer_id'], $email);
	$data = $class->getAdminCompanyData();
	$smarty->assign('update_popup', true);
}

$smarty->assign('EMAIL', $data['employer_email']);
$template = 'feeder-setting.tpl';

?>
