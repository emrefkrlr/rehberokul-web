<?php
session_start();

error_reporting(E_ERROR | E_PARSE);

require('Security.php');

function requireDir($path) {
    $dir = new RecursiveDirectoryIterator($path);
    $iterator = new RecursiveIteratorIterator($dir);
    foreach ($iterator as $file) {
        $fname = $file->getFilename();
        if (preg_match('%\.php$%', $fname)) {
            require($file->getPathname());
        }
    }
}
require('./config.php');
require('Message.php');
require('Bootstrap.php');
require('Controller.php');
require('helper/DateHelper.php');
require('helper/URLHelper.php');
require('helper/FileUploader.php');
require('db/Model.php');
require('db/DBOperation.php');


requireDir('./controllers');
requireDir('./models');

