<?php
	$companies = array();
	$sanitizer = new Sanitizer();

	$sql = 'SELECT COUNT(c.id) as total FROM company c WHERE c.public_page = 1';

    $result = $db->query($sql);
    $row = $result->fetch_assoc();
    $TOTAL = $row['total'];

    //pagination
    $paginatorLink = BASE_URL  . URL_COMPANIES;
    $paginator = new Paginator($TOTAL, COMPANIES_PER_PAGE, @$_REQUEST['p']);
    $paginator->setLink($paginatorLink);
    $paginator->paginate();
    $offset = $paginator->getFirstLimit();


	$sql = 'SELECT c.id, c.name, c.description, c.logo_path, c.hq FROM company c INNER JOIN employer e on c.employer_id = e.id WHERE c.public_page = 1 AND e.confirmed = 1 ORDER BY c.name DESC LIMIT ' .$offset . ', ' . COMPANIES_PER_PAGE;

	$result = $db->query($sql);
	$comps = array();

	$varnames = array();
	while ($row = $result->fetch_assoc()) {
		$varnames[$row["id"]] = $sanitizer->sanitize_title_with_dashes($row["name"]);
		$row['company_desc_excerpt'] = (strlen($row['description']) > 300) ? strip_tags(substr($row['description'], 0, 300) . "...") : strip_tags($row['description']);
		$comps[] = $row;
	}

 	$smarty->assign("pages", $paginator->pages_link);

	$smarty->assign('varnames', $varnames);
	$smarty->assign('companies', $comps);
	$smarty->assign('companies_count', count($comps));

	$template = 'jobs/companies.tpl';
?>