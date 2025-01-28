<?php
namespace Bookstore\Core;

class SessionMiddleware {

    public function handle(){
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
    }
}