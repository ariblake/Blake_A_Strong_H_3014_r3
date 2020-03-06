<?php

function redirect_to($location){
    if($location != null){
        // this line does the redirecting - not the same as an HTML header - it is HTTP header
        header("Location: ".$location);
        exit; //make sure you exit after redirecting
    }
}