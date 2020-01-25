<?php 

	if (isset($id)) {
		if (strcmp("delete", $id) == 0) {

            $sql = 'SELECT email FROM '.DB_PREFIX.'subscriptions WHERE id=' . $extra;
            $result = $db->query($sql);
            $row = $result->fetch_assoc();

            sleep(0.2);

			$sql = 'DELETE FROM '.DB_PREFIX.'subscriptions WHERE id=' . $extra;
			$result = $db->query($sql);

            sleep(0.2);

            $sql = 'DELETE FROM '.DB_PREFIX.'subscribers WHERE email="' . $row['email'] . '"';
            $result = $db->query($sql);
		}
	}

    $sql = 'SELECT COUNT(id) as total FROM subscriptions';
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
    $TOTAL = $row['total'];

     //pagination
    $paginatorLink = BASE_URL  . "subscribers";
    $paginator = new Paginator($TOTAL, SUBSCRIBERS_PER_PAGE, @$_REQUEST['p']);
    $paginator->setLink($paginatorLink);
    $paginator->paginate();
    $offset = $paginator->getFirstLimit();

    $sql = 'SELECT id, email, confirmed FROM subscriptions limit ' .$offset . ', ' . SUBSCRIBERS_PER_PAGE;
    $result = $db->query($sql);
    $subscribers = array();
    while ($row = $result->fetch_assoc()) {
       $subscribers[] = $row;
    }

    $smarty->assign("subscribers", $subscribers);
    $smarty->assign("pages", $paginator->pages_link);
    $template = 'subscribers.tpl';
?>
