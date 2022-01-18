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

    // require the models
?>