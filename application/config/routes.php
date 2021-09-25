<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['user/login'] = 'api/User_controller/login';
$route['user/logout'] = 'api/User_controller/logoutUser';

 $route['user/fileUpload'] = 'api/User_controller/fileUpload';
// $route['user/existuser'] = 'api/User_controller/existuser';
// $route['user/existemail'] = 'api/User_controller/existemail';
// $route['user/forgotpassword'] = 'api/User_controller/forgot_password';
// $route['user/resetPassword/(:any)'] = 'api/User_controller/reset_password';

// $route['user/fetch-userType'] = 'api/User_controller/fetch_usertype';
// $route['user/fetch-currentUserType/(:any)'] = 'api/User_controller/fetch_multipleUsertype/$1';
// $route['user/add-userType'] = 'api/User_controller/add_usertype';
// $route['user/edit-userType/(:any)'] = 'api/User_controller/edit_usertype/$1';
// $route['user/delete-userType/(:any)'] = 'api/User_controller/deleteUserType/$1';

// $route['user/accept-invitaion'] = 'api/User_controller/accept_invitaion';
// $route['user/add_videotype'] = 'api/User_controller/add_videotype';
// $route['user/fetch_videotype'] = 'api/User_controller/fetch_videotype';
// $route['user/fetch-currentVideoType/(:any)'] = 'api/User_controller/fetchParticularVideo/$id';
// $route['user/delete-videoType/(:any)'] = 'api/User_controller/deleteVideo/$1';
// $route['user/edit-videoType/(:any)'] = 'api/User_controller/updateVideoType/$1';
// $route['user/edit-videoType/(:any)'] = 'api/User_controller/updateVideoType/$1';
// $route['user/fetch-Alluser'] = 'api/User_controller/fetch_user';



// $route['pusher/presence_auth'] = 'api/PusherController/presence_auth';
// $route['pusher/auth'] = 'api/PusherController/auth';



// $route['client/add-client'] = 'api/ClientDetails_controller/addClient';
// $route['client/fetch-allClient'] = 'api/ClientDetails_controller/fetch_client';
// $route['client/edit-client/(:any)'] = 'api/ClientDetails_controller/editClient/$1';
// $route['client/fetch-currentClient/(:any)'] = 'api/ClientDetails_controller/fetchParticularClient/$1';
// $route['client/delete-client/(:any)'] = 'api/ClientDetails_controller/deleteClient/$1';

// $route['organization/fetch-allOrganization'] = 'api/Organization_controller/fetch_organization';
// $route['organization/fetch-ClientByOrg/(:any)'] = 'api/Organization_controller/getclientbyOrg/$1';
// $route['organization/add-organization'] = 'api/Organization_controller/addOrganisation';
// $route['organization/edit-organization/(:any)'] = 'api/Organization_controller/updateOrganization/$1';
// $route['organization/delete-organization/(:any)'] = 'api/Organization_controller/deleteOrganization/$1';

// $route['communication/add-communication'] = 'api/Communication_Controller/addCommunication';
// $route['communication/fetch-communication'] = 'api/Communication_Controller/fetchCommunication';




// $route['project/add-project'] = 'api/Project_controller/addProject';
// $route['project/fetch-project'] = 'api/Project_controller/fetchProject';
// $route['project/edit-project/(:any)'] = 'api/Project_controller/updateProject/$1';
// $route['project/delete-project/(:any)'] = 'api/Project_controller/deleteProject/$1';
// $route['project/add-projectLiveStatus'] = 'api/Project_controller/add_projectLiveStatus';
// $route['project/fetch-projectLiveStatus'] = 'api/Project_controller/fetch_projectLiveStatus';

// $route['module/add-module'] = 'api/Module_controller/addModule';
// $route['module/fetch-module'] = 'api/Module_controller/fetchModule';
// $route['module/edit-module/(:any)'] = 'api/Module_controller/updateModule/$1';
// $route['module/delete-module/(:any)'] = 'api/Module_controller/deleteModule/$1';
// $route['module/fetch-currentModule/(:any)'] = 'api/Module_controller/fetchParticularModule/$1';

// $route['team/fetch-team'] = 'api/Team_controller/team';
// $route['team/add-team'] = 'api/Team_controller/addTeam';
// $route['team/edit-team/(:any)'] = 'api/Team_controller/updateTeam/$1';
// $route['team/delete-team/(:any)'] = 'api/Team_controller/deleteTeam/$1';
// $route['team/fetch-current/(:any)'] = 'api/Team_controller/fetchParticularTeam/$1';


// $route['team-member/add'] = 'api/TeamMember_controller/add';
// $route['team-member/edit'] = 'api/TeamMember_controller/edit';
// $route['team-member/delete'] = 'api/TeamMember_controller/deleteTeamMember';
// $route['team-member/fetchAll'] = 'api/TeamMember_controller/fetchAllTeamMember';
// $route['team-member/fetch-current/(:any)'] = 'api/TeamMember_controller/fetchParticularTeamMember/$1';








