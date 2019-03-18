<?php

    $smarty->assign('ACTIVE', 3);

    if (!empty($id)) {

     //get job id and substract in statistics ...
     $result = $db->query('
     SELECT job_id FROM '.DB_PREFIX.'job_applications where id =' . intval($extra));

     $row = $result->fetch_assoc();

     if (!empty($row)) {
       $today = date("Y-m-d");
       $result = $db->query('
       UPDATE '.DB_PREFIX.'statistics SET applications = applications - 1 WHERE job_id =' . $row['job_id']) . ' AND date = "' . $today . '"';
     }
   
     //delete job application
     $result = $db->query('
        DELETE FROM '.DB_PREFIX.'job_applications where id =' . intval($extra));

     $smarty->assign('deleted_popup', true);

    } 

    $sql = 'SELECT COUNT(a.id) as total FROM job_applications a, jobs b 
                WHERE a.job_id = b.id';
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
    $TOTAL = $row['total'];

     //pagination
    $paginatorLink = BASE_URL  . "job-applications";
    $paginator = new Paginator($TOTAL, APPLICATIONS_PER_PAGE, @$_REQUEST['p']);
    $paginator->setLink($paginatorLink);
    $paginator->paginate();
    $offset = $paginator->getFirstLimit();

    $sql = 'SELECT a.id, a.status as "status", c.sm_link_1, c.sm_link_2, c.sm_link_3, c.sm_link_4, c.fullname as "name", c.message as "message", c.email as "email", c.phone as "phone", c.weblink as "website", c.cv_path as "cv_path", a.job_id, b.title, b.company, DATE_FORMAT(a.created_on, "' . '%d-%m-%Y' . '") AS created_on
                FROM job_applications a, jobs b, applicant c
                WHERE a.applicant_id=c.id AND a.job_id = b.id AND c.fullname != ""
                ORDER BY a.created_on DESC, c.fullname ASC limit ' .$offset . ', ' . APPLICATIONS_PER_PAGE;
    $result = $db->query($sql); 

    $applicants = array();
    while ($row = $result->fetch_assoc()) {

            $sm_links = array();

            if (!empty($row['sm_link_1']) && $row['sm_link_1'] != "-") {
                $sm_links["first"] = deconstructSMlink($row['sm_link_1']);
            }

            if (!empty($row['sm_link_2']) && $row['sm_link_2'] != "-") {
                $sm_links["second"] = deconstructSMlink($row['sm_link_2']);
            }

            if (!empty($row['sm_link_3']) && $row['sm_link_3'] != "-") {
                $sm_links["third"] = deconstructSMlink($row['sm_link_3']);
            }

            if (!empty($row['sm_link_4']) && $row['sm_link_4'] != "-") {
                $sm_links["fourth"] = deconstructSMlink($row['sm_link_4']);
            }

            $row['sm_links'] = $sm_links;

        $applicants[] = $row;
    }
    $cvs = array();

    foreach ($applicants as $applicant) {
        if ($applicant['cv_path'] != "") {
            $var = explode(".", $applicant['cv_path']);
            $ext = end($var);
            if (strcmp($ext, "pdf") == 0){
                $cvs[$applicant['id']] = 'fa fa-file-pdf-o fa-lg pdf-el';
            }
            else {
                $cvs[$applicant['id']] = 'fa fa-file-word-o fa-lg word-el';
            }  
        }
    }

    $smarty->assign("pages", $paginator->pages_link);
    $smarty->assign('cvs', $cvs);
    $smarty->assign('applicants', $applicants);
    $smarty->assign('applicants_count', $TOTAL);
	$smarty->assign('current_category', 'applicants');
    $smarty->assign('cv_path', '/' . FILE_UPLOAD_DIR);
    $template = 'applicants.tpl';
?>
