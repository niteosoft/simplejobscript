<?php 
	$smarty->assign('ACTIVE', 12);

	$cl = new Maintenance();

	if (!empty($id)) {
		if ($id == "tmp"){
			$cl->deleteTmpJobs();
		}
		else if ($id == "exp"){
			if (strcmp(EXPIRED_JOBS_ACTION, "deactivate") === 0) {
				$cl->deactivateExpiredJobs();
			} else {
				$cl->deleteExpiredJobs();
			}
		} else {
			$cl->deleteOldHits();
		}

		$smarty->assign('popup', true);
	}

	$smarty->assign('tmp_count', $cl->getTmpJobs());

	if (strcmp(EXPIRED_JOBS_ACTION, "deactivate") === 0) {
		$smarty->assign('exp_count', $cl->getActiveExpiredJobs());
	} else {
		$smarty->assign('exp_count', $cl->getExpiredJobs());
	}

	$smarty->assign('old_hits_count', $cl->getNumberOfOldHits());

	$template = 'cleaner.tpl';
?>