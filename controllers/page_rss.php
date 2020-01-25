<?php

	if ($id != '' && !is_numeric($id))
	{
		$feed = new Feed($id);
		if ($feed->mCategoryId != '')
		{
			$feed->Display();
			exit;
		}
		else
		{
			redirect_to(BASE_URL);
		}
	}
	else
	{
		$smarty->assign('categories',  get_categories());
		$template = 'rss/rss.tpl';
	}
?>