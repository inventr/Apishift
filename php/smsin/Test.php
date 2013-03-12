<?php

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', false);
ini_set('mongo.utf8', false);

require_once('MongoPagination/MongoPagination.php');

	$services_json = json_decode(getenv("VCAP_SERVICES") , true);
	$mongo_config = $services_json["mongodb-1.8"][0]["credentials"];
	$username = $mongo_config["username"];
	$password = $mongo_config["password"];
	$hostname = $mongo_config["hostname"];
	$port = $mongo_config["port"];
	$db = $mongo_config["db"];
	$name = $mongo_config["name"];
	$connect = "mongodb://${username}:${password}@${hostname}:${port}/${db}";
	$m = new Mongo($connect);
	$db = $m->selectDB($db);
	$collection = $db->smsout;

//  initiate mongo pagination handler
$pagination = new MongoPagination($db);

//  alternate method used for web pages
/*
  $pagination = new MongoPagination($mongoHandler, '/entity/mylist/{{PAGE}}/seo-title.html');
  Note: {{PAGE}} will be resolved inside mongo pagination class, it will place the current page index there.
*/


/*  Sample Code: Pagination with limit  */
print "\n\nSample Code: Pagination\n";
$limit = 20;
$pagination->setQuery(array(
  '#collection'	=>  'smsout',
  '#find'		=>  array(
    'key'	  =>  'tiempo'
  ),
  '#sort'		=>  array(
    'tiempo'	=>  -1
  ),
), $limit);
$dataSet = $pagination->Paginate();
/**
  * $dataset['dataset']     = "ARRAY / STRING - raw data array/string";
  * $dataset['totalItems']  = "INTEGER - total number of documents available with respect to the query";
 */
print_r($dataSet);



/*  Sample Code: Pagination with Page no & items per page   */
print "\n\nSample Code: Pagination\n";
$itemsPerPage   = 5;
$currentPage    = 1;
$pagination->setQuery(array(
  '#collection'	=>  'smsout',
  '#find'		=>  array(
    'key'	  =>  'tiempo'
  ),
  '#sort'		=>  array(
    'tiempo'	=>  -1
  ),
), $currentPage, $itemsPerPage);
$dataSet = $pagination->Paginate();
/**
  * $dataset['dataset']     = "ARRAY / STRING - raw data array/string";
  * $dataset['totalPages']  = "INTEGER - total pages calculated with respect to $itemsPerPage";
  * $dataset['totalItems']  = "INTEGER - total number of documents available with respect to the query";
 */
print_r($dataSet);



/*  Sample Code: Pagination with HTML Pagelinks   */
print "\n\nSample Code: Pagination with HTML Pagelinks\n";
$itemsPerPage   = 5;
$currentPage    = 1;
$pagination->setQuery(array(
  '#collection'	=>  'smsout',
  '#find'		=>  array(
    'key'	  =>  'tiempo'
  ),
  '#sort'		=>  array(
    'tiempo'	=>  -1
  ),
), $currentPage, $itemsPerPage);
$dataSet    = $pagination->Paginate();
$page_links = $pagination->getPageLinks();
/**
  * $dataset['dataset']     = "ARRAY / STRING - raw data array/string";
  * $dataset['totalPages']  = "INTEGER - total pages calculated with respect to $itemsPerPage";
  * $dataset['totalItems']  = "INTEGER - total number of documents available with respect to the query";
 */
print_r($dataSet);
/*  HTML Links   */
print($page_links);



exit();
