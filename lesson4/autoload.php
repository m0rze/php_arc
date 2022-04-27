<?php

spl_autoload_register(function ($className) {
    $dirs = [
        "Services/ORMs/",
        "Services/Factories/"
    ];
    foreach ($dirs as $dir){
        if(file_exists($dir.$className.".php")){
            include $dir.$className.".php";
        }
    }
});