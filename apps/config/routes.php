<?php  defined('BASEPATH') or die('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "welcome";
$route['404_override'] = '';
$route['member/([0-9a-fA-F]{8}\-?[0-9a-fA-F]{4}\-?[0-9a-fA-F]{4}\-?[0-9a-fA-F]{4}\-?[0-9a-fA-F]{12})/like'] = 'member/like/$1';
$route['member/([0-9a-fA-F]{8}\-?[0-9a-fA-F]{4}\-?[0-9a-fA-F]{4}\-?[0-9a-fA-F]{4}\-?[0-9a-fA-F]{12})/comment'] = 'member/comment/$1';
$route['member/([0-9a-fA-F]{8}\-?[0-9a-fA-F]{4}\-?[0-9a-fA-F]{4}\-?[0-9a-fA-F]{4}\-?[0-9a-fA-F]{12})/reply'] = 'member/reply/$1';
$route['restaurant/query/(:any)'] = 'restaurant/query/$1';
$route['restaurant/add'] = 'restaurant/add';
$route['restaurant/save'] = 'restaurant/save';
$route['restaurant/save/(:any)'] = 'restaurant/save/$1';
$route['restaurant/feature'] = 'restaurant/feature';
$route['restaurant/feature/(:any)'] = 'restaurant/feature/$1';
$route['restaurant/edit/(:any)'] = 'restaurant/edit/$1';
$route['restaurant/like/(:any)'] = 'restaurant/like/$1';
$route['restaurant/dislike/(:any)'] = 'restaurant/dislike/$1';
$route['restaurant/comment/([0-9a-fA-F]{8}\-?[0-9a-fA-F]{4}\-?[0-9a-fA-F]{4}\-?[0-9a-fA-F]{4}\-?[0-9a-fA-F]{12})'] = 'restaurant/comment/$1';
$route['restaurant/comment/([0-9a-fA-F]{8}\-?[0-9a-fA-F]{4}\-?[0-9a-fA-F]{4}\-?[0-9a-fA-F]{4}\-?[0-9a-fA-F]{12})/like'] = 'restaurant/commentLike/$1';
$route['restaurant/comment'] = 'errors/page_missing';
$route['restaurant/reply/([0-9a-fA-F]{8}\-?[0-9a-fA-F]{4}\-?[0-9a-fA-F]{4}\-?[0-9a-fA-F]{4}\-?[0-9a-fA-F]{12})'] = 'restaurant/reply/$1';
$route['restaurant/reply/([0-9a-fA-F]{8}\-?[0-9a-fA-F]{4}\-?[0-9a-fA-F]{4}\-?[0-9a-fA-F]{4}\-?[0-9a-fA-F]{12})/like'] = 'restaurant/commentLike/$1';
$route['restaurant/reply'] = 'errors/page_missing';
$route['restaurant/([0-9a-fA-F]{8}\-?[0-9a-fA-F]{4}\-?[0-9a-fA-F]{4}\-?[0-9a-fA-F]{4}\-?[0-9a-fA-F]{12})'] = 'restaurant/profile/$1';
$route['restaurant/([0-9a-fA-F]{8}\-?[0-9a-fA-F]{4}\-?[0-9a-fA-F]{4}\-?[0-9a-fA-F]{4}\-?[0-9a-fA-F]{12})/comment'] = 'restaurant/comment/$1';
$route['restaurant/([0-9a-fA-F]{8}\-?[0-9a-fA-F]{4}\-?[0-9a-fA-F]{4}\-?[0-9a-fA-F]{4}\-?[0-9a-fA-F]{12})/(:any)'] = 'restaurant/profile/$1/$2';
$route['restaurant/(:num)'] = 'restaurant/profile/$1';
$route['restaurant/(:num)/(:any)'] = 'restaurant/profile/$1/$2';
$route['restaurant/(\w+)'] = 'restaurant/profile/$1';
$route['restaurant/(\w+)/comment'] = 'restaurant/comment/$1';
$route['restaurant/(\w+)/(:any)'] = 'restaurant/profile/$1/$2';

/* End of file routes.php */
/* Location: ./application/config/routes.php */