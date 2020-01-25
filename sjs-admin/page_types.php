<?php
global $cache;

$smarty->assign('ACTIVE', 7);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && key_exists('action', $_POST)) 
{
	// clear cache types
    $cache->removeCache(CACHE_TYPES);
	
	switch ($_POST['action']) {
	
		case 'newType':
			$type = new Types();
			$type->setName(0);
			$type->setVarName(0);
			$type->insertType();
			clear_main_cache();
			
			echo $type->getId();
			break;
		case 'deleteType':
			$type = new Types();
			if(!$type->verifyAreJobs(intval($_POST['id'])))
			{
				$type->setId(intval($_POST['id']));
				$type->deleteType();
				clear_main_cache();
				echo json_encode(array('result' => '1'));
				break;
			}
			echo json_encode(array('result' => '0'));
			break;
		
		case 'saveType':
			$type = new Types();
			$type->setVarName($_POST['var_name']);
			$type->setName($_POST['name']);
			$type->setId(intval($_POST['id']));
			$type->updateType();
			clear_main_cache();
			break;
	}
	exit();
}
	
$template = 'types.tpl';
$js[] = 'types';
$type = new Types();
$type->getAllTypes();
$types = $type->getTypesArray();
$smarty->assign('types', $types);
$smarty->assign('current_category', 'types');
?>