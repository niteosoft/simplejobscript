<?php 
	
	$sql = 'SELECT COUNT(id) as total FROM applicant';
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
    $TOTAL = $row['total'];

    //pagination
    $paginatorLink = BASE_URL  . "candidates";
    $paginator = new Paginator($TOTAL, CANDIDATES_PER_PAGE, @$_REQUEST['p']);
    $paginator->setLink($paginatorLink);
    $paginator->paginate();
    $offset = $paginator->getFirstLimit();

    $sql = 'SELECT c.id as "candidate_id", c.fullname as "candidate_name", c.email as"candidate_email", c.public_profile as "public_profile", c.confirmed as "candidate_confirmed" FROM applicant c ORDER BY id DESC limit ' .$offset . ', ' . CANDIDATES_PER_PAGE;
    $data = $db->query($sql);

    if ($id === "deleted") {
         $smarty->assign("deletedPopup", true);
    }

    $cdts = array();
    while ($row = $data->fetch_assoc()) {
     $cdts[] = $row;
    }

    $smarty->assign("candidates", $cdts);
 	$smarty->assign("pages", $paginator->pages_link);

	$template = 'candidates.tpl';

?>
