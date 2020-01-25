<?php 
    
    $ex_search = $_REQUEST["string"];
    
    if (isset($_POST['email'])) {

        $class = new Employer();
        $data = $class->getEmployerByEmail($_POST['email']);

        if (empty($data)){
            $smarty->assign('err', $translations['admin']['no_entry_err']);
        }
        else
            $smarty->assign('data', $data);
    }

    if(!empty($ex_search)){
        $sql = "SELECT COUNT(id) as total FROM `company` WHERE `name` LIKE '%".$ex_search."%'";   

    }else{
        $sql = 'SELECT COUNT(id) as total FROM company';  
    }
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        $TOTAL = $row['total'];

    

    //pagination
    $paginatorLink = BASE_URL  . "companies";
    $paginator = new Paginator($TOTAL, SUBSCRIBERS_PER_PAGE, @$_REQUEST['p']);
    $paginator->setLink($paginatorLink);
    $paginator->paginate();
    $offset = $paginator->getFirstLimit();

    if(!empty($ex_search)){
        $sql = "SELECT comp.id,comp.name, emp.id as `emp_id`,emp.confirmed, emp.email 
         FROM company comp 
         INNER JOIN employer emp on comp.employer_id = emp.id
         WHERE comp.name LIKE '%$ex_search%'
         ORDER BY id DESC limit ".$offset.",".SUBSCRIBERS_PER_PAGE;

        
    }else{
         $sql = 'SELECT comp.id, comp.name, emp.id as "emp_id", emp.confirmed, emp.email FROM company comp INNER JOIN employer emp on comp.employer_id = emp.id ORDER BY id DESC limit ' .$offset . ', ' . SUBSCRIBERS_PER_PAGE;
    } 
    $data = $db->query($sql);

    $c = array();
    while ($row = $data->fetch_assoc()) {
     $c[] = $row;
    }

    if ($id === "deleted") {
         $smarty->assign("deletedPopup", true);
    }
    
    $smarty->assign("companies", $c);
    $smarty->assign("pages", $paginator->pages_link);
    $template = 'companies.tpl';

?>
