<?php
    /**
     * Main file, responsible to run API application
     * 
     * @author Emanuel Pires Ferreira
     * @filesource core/bootstrap.php
     */

    define("API_PATH", __DIR__ . "/../");

    // require the API base controller
    require_once API_PATH . "/controllers/api/BaseController.php";

    // require other controllers
    require API_PATH . "/controllers/api/BalanceController.php";
    require API_PATH . "/controllers/api/EventController.php";
    require API_PATH . "/controllers/api/ResetController.php";

    $balance = new BalanceController();
    $event = new EventController();
    $reset = new ResetController();
    
    // require the models
?>