<?php
namespace Bookstore\Models;

use Bookstore\Domain\Person;
use Bookstore\Domain\Customer\CustomerFactory;
use Bookstore\Exceptions\NotFoundException;

class CustomerModel extends AbstractModel {
    
    public function getByEmail(string $email, $password): Person {

        $email = $email ?? '';
        $password = $password ?? '';
        $fetchdata = $this->db->getReference('login')->getValue();
        if (!empty($fetchdata)) {
        // Access email and password from the fetched data
        $db_email = $fetchdata['email'] ?? '';
        $db_password = $fetchdata['password'] ?? '';
        $db_id = $fetchdata['id'] ?? '';
        $db_firstname = $fetchdata['firstname'] ?? '';
        $db_surname = $fetchdata['surname'] ?? '';

        if(!empty($email) && !empty($password) && $email === $db_email && $password === $db_password){
            return CustomerFactory::factory(
                'Admin',
                $db_firstname,
                $db_surname,
                $db_email,
                $db_id

            );
        } else {
            throw new NotFoundException();
        }
      }
    }
}