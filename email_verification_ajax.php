<?php

require_once '_config/config.php';

escape($_POST);

$class = new Employer();
$exists = $class->checkIfUserExists($email);

if ($exists) echo json_encode(array('result' => '1'));
else echo json_encode(array('result' => '0'));
exit;

?>