<?php 
namespace Bookstore\Domain;

use Bookstore\Utils\Unique;

class Person { 
    use Unique;

    protected $firstname; 
    protected $surname; 
    protected $email;
    
    public function __construct(
        string $firstname, 
        string $surname,
        string $email,
        int $id = null
    ) { 
        $this->firstname = $firstname; 
        $this->surname = $surname;
        $this->email = $email;
        $this->setId($id);
    } 
    
    public function getFirstname(): string { 
        return $this->firstname; 
    } 
    public function getSurname(): string { 
        return $this->surname; 
    } 
    public function getEmail(): string { 
        return $this->email; 
    } 
    public function setEmail(string $email) { 
        $this->email = $email; 
    }
}