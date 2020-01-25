<?php

	//delete all jobs from this user and user himself
	$class = new Employer();
	$class->deactivateAccount($id);

	//delete his company and unlink the logo file
	$company = new Company();
	$company->deleteCompanyDataByEmployerId($id);

	unset($_SESSION['user']);
	unset($_SESSION['name']);

	redirect_to(BASE_URL . 'deactivation-successful');
?>