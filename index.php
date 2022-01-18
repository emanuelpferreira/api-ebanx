<?php
    header("Access-Control-Allow-Origin: *");
    
    require __DIR__ . "/core/bootstrap.php";

    //get initial params from URL
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = explode( '/', $uri );

    //identify the desired endpoint
    $endpoint = strval($uri[1]);

    $requests_allowed = ['POST', 'GET'];

    $request_type = $_SERVER['REQUEST_METHOD'];
    //check if the request is allowed to continue
    if (!isset($request_type) || !in_array($request_type, $requests_allowed)) {
        header("HTTP/1.1 404 Not Found");
        exit();
    }

    $endpoints_allowed = ['reset', 'balance', 'event'];
    //check if the endpoint exists to continue
    if (isset($endpoint) && !in_array($endpoint, $endpoints_allowed)) {
        header("HTTP/1.1 404 Not Found");
        exit();
    }

    //calling endpoint
    $$endpoint->process();
?>