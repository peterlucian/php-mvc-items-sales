<?php
namespace Bookstore\Core;

class Session {

    public function __construct(){
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
    }

    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function get($key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }

    public function has($key) {
        return isset($_SESSION[$key]);
    }

    public function remove($key) {
        unset($_SESSION[$key]);
    }

    public function clear() {
        session_unset();
    }

    public function destroy() {
        session_destroy();
    }

}