<?php 
namespace Bookstore\Domain\Customer; 

use Bookstore\Domain\Person;

class CustomerFactory { 
    public static function factory(
        string $type,
        string $firstname,
        string $surname,
        string $email,
        int $id = null
    ): Person {
        /*switch ($type) { 
        *    case 'basic': 
        *        return new Basic($firstname, $surname, $email, $id); 
        *    case 'premium': 
        *        return new Premium($firstname, $surname, $email, $id); 
        }*/
        $classname = __NAMESPACE__ . '\\' . ucfirst($type); 
        if (!class_exists($classname)) { 
            throw new \InvalidArgumentException('Wrong type.'); 
        } 
        return new $classname($firstname, $surname, $email, $id);
    }
}