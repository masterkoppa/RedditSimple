<?php
/**
 * Step 1: Require the Slim Framework
 *
 * If you are not using Composer, you need to require the
 * Slim Framework and register its PSR-0 autoloader.
 *
 * If you are using Composer, you can skip this step.
 */
require 'Slim/Slim.php';
require 'RedditAPI/reddit.php';

\Slim\Slim::registerAutoloader();

/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */
$app = new \Slim\Slim();

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, `Slim::patch`, and `Slim::delete`
 * is an anonymous function.
 */

// ROOT PAGE
$app->get(
    '/',
    function () {
        require 'Templates/Default.php'; // Load the php from this file
    }
);

//REDDIT API CALLS

/**
* Reddit Login
*
* Expects a json object with the parameters described bellow.
* Params:
*     - user: The username
*     - pass: The users password
* Returns:
*     - 400: If there's an auth error
*     - 200: If the login was successful, a cookie is saved with the modhash
*/
$app->post(
    '/login',
    function() use ($app) {
        $json = $app->request->getBody();
    }
);

$app->get(
    '/subreddit',
    function() use ($reddit) {
        header("Content-Type: application/json; charset=UTF-8");
        echo $reddit->subredditArticles("",""); //Get the front page posts
    }
);

// POST route
$app->post(
    '/post',
    function () {
        echo 'This is a POST route';
    }
);

// PUT route
$app->put(
    '/put',
    function () {
        echo 'This is a PUT route';
    }
);

// PATCH route
$app->patch('/patch', function () {
    echo 'This is a PATCH route';
});

// DELETE route
$app->delete(
    '/delete',
    function () {
        echo 'This is a DELETE route';
    }
);

/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();
