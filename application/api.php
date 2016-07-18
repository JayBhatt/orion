<?php

use Application\Modules\Core\Models\Application;
use Application\Modules\Core\Models\Response;

require_once 'config.php';
require_once BASE_DIR.'/application/modules/core/models/Application.php';

// TODO: Add a logger and log events
// TODO: Write unit tests
try
{
    // Create a new instance of the application, bootstrap it and process the request.
    // $_POST comes in form of args={"action":"action-name","param1":value, "param2" : value} format.
    $application = new Application();
    $application->bootstrap();   
    $application->handleRequest($_POST);

} catch (Exception $ex)
{
    // On exception if the application environment is set to DEV show the detailed message otherwise just show a generic error message.
    $response = new Response();
    $response->setCode(300);
    if(APPLICATION_ENV === "DEV")
    {
        $response->setBody($ex->getMessage());
    }
    else
    {
        $response->setBody("An unknown error occurrred while processing your request. Please try again after sometime.");
    }
    $response->sendResponse();
}
