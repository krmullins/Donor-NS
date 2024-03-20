<?php
    define('PREPEND_PATH', '../');
    $hooks_dir = __DIR__;
    include("$hooks_dir/../lib.php");
 
    insert("OnlineReg",[
        'Name' => Request::val('Name'),
     ]);
 

 
    echo "Thanks for your registration";
 
