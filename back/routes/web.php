<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

//lumen não tem route resource 
$router->post('/models', 'GeneralController@NewModel');
$router->post('/dqc84', 'GeneralController@NewDQC84');
$router->post('/dqc841', 'GeneralController@NewDQC841');
$router->get('/models', 'GeneralController@Models');
$router->get('/dqc84', 'GeneralController@DQC84');
$router->get('/dqc841', 'GeneralController@DQC841');
$router->put('/models/{id}', 'GeneralController@UpdateDQCModels');
$router->put('/dqc84/{id}', 'GeneralController@UpdateDQC84');
$router->put('/dqc841/{id}', 'GeneralController@UpdateDQC841');
$router->delete('/models/{id}', 'GeneralController@DeleteDQCModels');
$router->delete('/dqc84/{id}', 'GeneralController@DeleteDQC84');
$router->delete('/dqc841/{id}', 'GeneralController@DeleteDQC841');
$router->post('/generate', 'GeneralController@Generate');
