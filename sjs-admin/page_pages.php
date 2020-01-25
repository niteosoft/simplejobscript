<?php

	$DIR_CONST = '';
	if (defined('__DIR__'))
		$DIR_CONST = __DIR__;
	else
		$DIR_CONST = dirname(__FILE__);

	$smarty->assign('ACTIVE', 4);
	$smarty->assign('current_category', 'pages');
	
	$result = $db->query('
		SELECT 
			id, url, page_title, is_external, external_url
		FROM 
			'.DB_PREFIX.'pages ORDER BY link_order ASC');
	$pages = array();
	while ($row = $result->fetch_assoc())
	{
		$pages[] = $row;
	}
	$smarty->assign('pages', $pages);

	$isPage = false;

	if ($_app_info['params'][1] == "updated"){
		$smarty->assign('updated', true);
	} else if ($_app_info['params'][1] == "deleted") {
		$smarty->assign('deleted', true);
	} else if ($_app_info['params'][1] == "added") {
		$smarty->assign('added', true);
	}

	if (isset($_app_info['params'][1])) {
		//add or edit
		if (strcmp($_app_info['params'][1], "add") == 0) {
			clear_main_cache();
			$smarty->assign('editor', true);
			$html_title = 'Add new static page / ' . SITE_NAME;
			$template = 'add-page.tpl';

			if (isset($_POST['title'])) {

				$external_page = (isset($_POST['external_switch'])) ? 1 : 0;

				if ($external_page == 0) {
					$url = $_POST['url'];
					$keywords = $_POST['keywords'];
					$desc = $_POST['desc'];
					$DBcontent = $db->getConnection()->real_escape_string($_POST['page_content']);

					$content = str_replace('\r\n', '<br />', $DBcontent);
					$content = stripslashes($content);

				} else {
					$url = $keywords = $desc = $page_content = '';
				}

				if (strpos($_POST['external_url'], "http") === false) {
					$external_url = 'http://' . $_POST['external_url'];
				} else {
					$external_url = $_POST['external_url'];
				}

				//insert into pages
				$result = $db->query('
					INSERT INTO '.DB_PREFIX.'pages (url, page_title, keywords, description, content, link_order, is_external, external_url) 
						 VALUES ("' . $url . '",
						 	"' . $_POST['title'] . '",
						 	"' . $keywords . '",
						 	"' . $desc . '",
						 	"' . $DBcontent . '", ' . $_POST['link_order'] . ',
						 	' . $external_page . ',
						 	"' . $external_url . '")');

				//create new static template in filesystem
				if ($external_page == 0) {
					$file = $DIR_CONST . '/../_tpl/' . $settings['theme'] . '/static/static_' . $_POST['url'] . '.tpl';

					$f = fopen($file, "w");
					chmod($file, 0777);

					$output = str_replace('\r\n', '<br />', $content);
					$output = str_replace('\"', '', $output);

					fwrite($f, $output);
					fclose($f);	
				}
				//redirct to pages tpl
				header('Location: ' . BASE_URL . 'pages/added');
				exit();
			}

		} else if (strcmp($_app_info['params'][1], "delete") == 0) {

		    $q = $db->query('SELECT url FROM '.DB_PREFIX.'pages WHERE id=' . $_app_info['params'][2]);
		    $row = $q->fetch_assoc();
		    $fileName = $row["url"];
		  
			//delete from db
			$db->query('
						DELETE FROM 
						'.DB_PREFIX.'pages 
						WHERE 
						`id` = ' . $_app_info['params'][2]);

			//delete tpl from the filesystem
			$fileToDelete = $DIR_CONST . '/../_tpl/' . $settings['theme'] . '/static/static_' . $fileName . '.tpl';

			unlink($fileToDelete);

			header('Location: ' . BASE_URL . 'pages/deleted');
			exit();
		} else if (strcmp($_app_info['params'][1], "edit") == 0) {
			clear_main_cache();
			//get page to be edited
			$smarty->assign('editor', true);

			$result = $db->query('
						SELECT * FROM 
						'.DB_PREFIX.'pages 
						WHERE 
						`id` = ' . $_app_info['params'][2]);

			$row = $result->fetch_assoc();

			$smarty->assign('data', $row);
			$html_title = 'Edit page / ' . SITE_NAME;
			$template = 'edit-page.tpl';

	
	} else if (strcmp($_app_info['params'][1], "update") == 0) {
		clear_main_cache();

		$PAGE_ID = intval($_POST['id']);
		
		if ($PAGE_ID == 2 || $PAGE_ID == 19 || $PAGE_ID == 20 || $PAGE_ID == 21 || $PAGE_ID == 55) {
			
			// get initial url
			$result = $db->query('
				SELECT url FROM 
				'.DB_PREFIX.'pages 
				WHERE 
				`id` = ' . $PAGE_ID);

			$row = $result->fetch_assoc();

			$path_prefix = $DIR_CONST . '/../_tpl/' . $settings['theme'] . '/static/static_';

			// change the file system name
			rename($path_prefix . $row['url'] . '.tpl', $path_prefix . $_POST['url'] . '.tpl');

			// update DB
			$result = $db->query('
				UPDATE '.DB_PREFIX.'pages 
				SET `url` = "' . $_POST['url'] . '",
					`page_title` = "' . $_POST['title'] . '",
					`keywords` = "' . $_POST['keywords'] . '",
					`description` = "' . $_POST['desc'] . '",
					`link_order` = ' . $_POST['link_order'] . ' WHERE `id` =' . $_POST['id']);

		} else {

			//get initial url
			$result = $db->query('
				SELECT url FROM 
				'.DB_PREFIX.'pages 
				WHERE 
				`id` = ' . $_POST['id']);

			if (intval($_POST['was_external']) == 0) {
				$row = $result->fetch_assoc();
				$oldfile = $DIR_CONST . '/../_tpl/' . $settings['theme'] . '/static/static_' . $row['url'] . '.tpl';
				unlink($oldfile);	
			}

			$external_page = (isset($_POST['external_switch'])) ? 1 : 0;

			if ($external_page == 0) {
				$url = $_POST['url'];
				$keywords = $_POST['keywords'];
				$desc = $_POST['desc'];
				$DBcontent = $db->getConnection()->real_escape_string($_POST['page_content']);

				$content = str_replace('\r\n', '<br />',$DBcontent);
				$content = stripslashes($content);

			} else {
				$url = $keywords = $desc = $page_content = '';
			}

			if ($external_page == 0) {
				$newfile = $DIR_CONST . '/../_tpl/' . $settings['theme'] . '/static/static_' . $_POST['url'] . '.tpl';
				$f = fopen($newfile, "w");
				chmod($newfile, 0777);

				$output = str_replace('\r\n', '<br />', $content);
				$output = str_replace('\"', '', $output);

				fwrite($f, $output);
				fclose($f);	
			}

			if (strpos($_POST['external_url'], "http") === false) {
				$external_url = 'http://' . $_POST['external_url'];
			} else {
				$external_url = $_POST['external_url'];
			}
			
			//pages table
			$result = $db->query('
				UPDATE '.DB_PREFIX.'pages 
				SET `url` = "' . $url . '",
					`page_title` = "' . $_POST['title'] . '",
					`keywords` = "' . $keywords . '",
					`description` = "' . $desc . '",
					`content` = "' . $DBcontent . '",
					`link_order` = ' . $_POST['link_order'] . ',
					`is_external` = ' . $external_page . ',
					`external_url` = "' . $external_url . '" WHERE `id` =' . $_POST['id']);



		}

		header('Location: ' . BASE_URL . 'pages/updated');
		exit();

	}
	else {
		//list
		$smarty->assign('list_pages', true);
		$html_title = 'Pages / ' . SITE_NAME;
		$template = 'pages.tpl';
	}


} else {
		$smarty->assign('list_pages', true);
		$html_title = 'Pages / ' . SITE_NAME;
		$template = 'pages.tpl';
}
		
?>
