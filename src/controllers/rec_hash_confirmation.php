<?php

//$id ~ hash
$class = new Employer();
$result = $class->confirmUser($id);

//set status
$smarty->assign('confirm_result', $result);
$template = 'auth/confirmation.tpl';

?>