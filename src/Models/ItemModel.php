<?php
namespace Bookstore\Models;

use Bookstore\Domain\Book;
use Bookstore\Exceptions\DbException;
use Bookstore\Exceptions\NotFoundException;
use PDO;

class ItemModel extends AbstractModel {
    
    public function getAll(int $page, int $pageLength): array {
        $fetchdata = $this->db->getReference('items')->getValue();
        return $fetchdata;
    }
    
    public function create($data) {
        $ref = $this->db->getReference('items');
        $postData = $ref->push($data);
        if(!$postData){
            throw new DbException();
        }
    }

}