<?php 

$smarty->assign('HIDE_PCG_PLAN', '0');

//$id ~ user_id
$class = new Employer();
$result_conformation = $class->confirmUserPackage($id);
$_SESSION['user'] = $id;
//packages option
$sql = 'SELECT id, name, jobs_left, job_period, cv_downloads, price FROM packages';
$result = $db->query($sql);
$data = array();
while ($row = $result->fetch_assoc()) {
	$data[$row['id']] = $row['name'];
}				
$smarty->assign('packages', $data);
//end of packages

if (VAT_KOEFICIENT != 0) {
	$smarty->assign('VAT', true);
	$price_vat_total = format_currency(WEBSITE_CURRENCY, $price + ($price * VAT_KOEFICIENT));
	$price_vat = format_currency(WEBSITE_CURRENCY, $price * VAT_KOEFICIENT);
	$smarty->assign('PRICE_VAT_TOTAL', $price_vat_total);
	$smarty->assign('PRICE_VAT', $price_vat);

} 

$smarty->assign('confirm_result', $result_conformation);
$template = 'auth/register_recruiters_packages.tpl';

?>