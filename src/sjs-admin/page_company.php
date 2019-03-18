<?php 
	
	if (isset($_POST['email'])) {

		$class = new Employer();
		$data = $class->getEmployerByEmail($_POST['email']);

		if (empty($data)){
			$smarty->assign('err', $translations['admin']['no_entry_err']);
		}
		else
			$smarty->assign('data', $data);
	}

	if (isset($id)) {

	    if (isset($extra) && $extra === "confirm" || $extra === "unconfirm") {
	    	// confirm / unconfirm
	    	$flag = ($extra === "confirm") ? 1 : 0;
	    	$sql = 'UPDATE employer SET confirmed = ' . $flag . ' WHERE id=' . intval($id);
	    	$db->query($sql);
	    } else if (isset($extra) && $extra === "delete") {

	    	//delete all jobs from this user and user himself
			$class = new Employer();
			$class->deactivateAccount($id);

			//delete his company and unlink the logo file
			$company = new Company();
			$company->deleteCompanyDataByEmployerId($id);

			redirect_to(BASE_URL . '/companies/deleted'); exit;
	    }

		$EMP_ID = intval($id);
	    $sql = 'SELECT comp.id , comp.name as "company_name", emp.id as "emp_id", emp.name as "employer_name", emp.confirmed, emp.email, emp.cvdb_access as "cvdb_access", emp.package_id as "package_id" FROM company comp INNER JOIN employer emp on comp.employer_id = emp.id WHERE emp.id = ' . $EMP_ID;
	    $data = $db->query($sql);
	    $row = $data->fetch_assoc();

	    if (PAYMENT_MODE == '3') {
	 
	    	if (isset($extra) && $extra == "plan-management") {

	    		if (isset($_POST['package_updated'])) {

	    			$jl = intval($_POST['jl']);
	    			$cvdl = intval($_POST['cvdl']);
	    			$jp = intval($_POST['jp']);

	    			$q = 'UPDATE employer SET jobs_left = ' . $jl . ', job_period = ' . $jp . ', cv_downloads_left = ' . $cvdl . ' WHERE id =' . $EMP_ID;
	    			$db->query($q);

	    			$smarty->assign('RES_UPDATED_POPUP', true);
	    		}

	    		// get current plan resources
	    		$s = 'SELECT pck.name, emp.jobs_left, emp.cv_downloads_left, emp.job_period FROM employer emp LEFT JOIN packages pck ON emp.package_id = pck.id WHERE emp.id =' . $EMP_ID;
	    		$r = $db->query($s);
	    		$package_data = $r->fetch_assoc();

	    		$smarty->assign("package_data", $package_data);

	    		$template = 'plan-management.tpl';
	    		$smarty->assign("data", $row);
	    		return;
	    	}

		    $s = 'SELECT name FROM packages WHERE id =' . intval($row['package_id']);
		    $d = $db->query($s);
		    $r = $d->fetch_assoc();
		    $smarty->assign("package_data", $r);
	    }

	    // get invoices
	    $class = new Employer();
	    $invoices = $class->getInvoicesByEmployerId($EMP_ID);

	} else {
		$data = null;
	}

    $smarty->assign("data", $row);
	$smarty->assign('invoices', $invoices);
	$template = 'company.tpl';

?>