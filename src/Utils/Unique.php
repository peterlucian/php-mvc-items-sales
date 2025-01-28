<?php 
namespace Bookstore\Utils; 

trait Unique { 
    protected $id; 
    
    public function setId(int $id = null) { 
        $this->id = $id; 
    } 
    
    public function getId(): int { 
        return $this->id; 
    }
}