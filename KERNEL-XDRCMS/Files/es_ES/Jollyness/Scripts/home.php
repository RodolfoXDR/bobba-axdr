<?php 

$queryPN = SQL::query('SELECT Id, Title, Summary, Image, Created, Category, Button FROM (
						SELECT xdrcms_promos.Id, xdrcms_promos.Title, xdrcms_promos.Content as Summary, xdrcms_promos.BackGroundImage as Image, xdrcms_promos.TimeCreated as Created, NULL as Category, xdrcms_promos.Button FROM xdrcms_promos	
					UNION ALL
						SELECT xdrcms_news.ID, xdrcms_news.Title, xdrcms_news.Summary, xdrcms_news.Image, xdrcms_news.Created, xdrcms_news.Category, NULL as Button FROM xdrcms_news
					) as PromoNews ORDER BY PromoNews.Created DESC  LIMIT 1');

if($queryPN && $queryPN->num_rows):
	$queryPNRow = $queryPN->fetch_assoc();
	
	switch($queryPNRow['Category']):
		case 0:
			$CategoryPN = "Others";
			break;
		case 1:
			$CategoryPN = "Updates";
			break;
		case 2:
			$CategoryPN = "Competitions & polls";
			break;
		case 3:
			$CategoryPN = "Events";
			break;
		default:
			$CategoryPN = '';
	endswitch;	
	
else:
	$queryPNRow = [
		'Id' => '',
		'Title' => 'Article not found.',
		'Body' => 'We can\'t find the page you\'re looking for. Please check the URL or try starting over from the <a href="' . URL . '">' . HotelName . ' front page</a>.',
		'Image' => '',
		'Created' => '',
		'Summary' => '',
		'Button' => '',
		'Category' => ''
	];
endif;


$querySPN = SQL::query('SELECT Id, Title, Summary, Image, Created, Category, Button FROM (
						SELECT xdrcms_promos.Id, xdrcms_promos.Title, xdrcms_promos.Content as Summary, xdrcms_promos.BackGroundImage as Image, xdrcms_promos.TimeCreated as Created, NULL as Category, xdrcms_promos.Button FROM xdrcms_promos	
					UNION ALL
						SELECT xdrcms_news.ID, xdrcms_news.Title, xdrcms_news.Summary, xdrcms_news.Image, xdrcms_news.Created, xdrcms_news.Category, NULL as Button FROM xdrcms_news
					) as PromoNews ORDER BY PromoNews.Created DESC  LIMIT 3 OFFSET 1');

?>