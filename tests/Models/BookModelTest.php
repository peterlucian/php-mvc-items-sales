<?php
namespace Bookstore\Tests\Models;

use Bookstore\Models\BookModel;
use Bookstore\Domain\Book;
use Bookstore\Tests\ModelTestCase;
use ReflectionClass;

class BookModelTest extends ModelTestCase {
    protected $tables = [
        'borrowed_books',
        'customer',
        'book'
    ];
    protected $model;
    
    public function setUp() {
        parent::setUp();
        $this->model = new BookModel($this->db);
    }
    
    protected function buildBook(array $properties): Book {
        $book = new Book();
        $reflectionClass = new ReflectionClass(Book::class);
        foreach ($properties as $key => $value) {
            $property = $reflectionClass->getProperty($key);
            $property->setAccessible(true);
            $property->setValue($book, $value);
        }
        return $book;
    }
    
    protected function addBook(array $params) {
        $default = [
            'id' => null,
            'isbn' => 'isbn',
            'title' => 'title',
            'author' => 'author',
            'stock' => 1,
            'price' => 10.0
        ];
        $params = array_merge($default, $params);
        $query = <<<SQL
insert into book (id, isbn, title, author, stock, price)
values(:id, :isbn, :title, :author, :stock, :price)
SQL;
        $this->db->prepare($query)->execute($params);
    }
    
    protected function addCustomer(array $params) {
        $default = [
            'id' => null,
            'firstname' => 'firstname',
            'surname' => 'surname',
            'email' => 'email',
            'type' => 'basic'
        ];
        $params = array_merge($default, $params);
        $query = <<<SQL
insert into customer (id, firstname, surname, email, type)
values(:id, :firstname, :surname, :email, :type)
SQL;
        $this->db->prepare($query)->execute($params);
    }
    
    /**
    * @expectedException \Bookstore\Exceptions\DbException 
    */
    public function testBorrowBookNotFound() {
        $book = $this->buildBook(['id' => 123]);
        $this->model->borrow($book, 123);
    }
    
    /**
    * @expectedException \Bookstore\Exceptions\DbException
    */
    public function testBorrowCustomerNotFound() {
        $book = $this->buildBook(['id' => 123]);
        $this->addBook(['id' => 123]);
        $this->model->borrow($book, 123);
    }
    
    public function testBorrow() {
        $book = $this->buildBook(['id' => 123, 'stock' => 12]);
        $this->addBook(['id' => 123, 'stock' => 12]);
        $this->addCustomer(['id' => 123]);
        $this->model->borrow($book, 123);
        $this->assertTrue(true, 'Borrowed book');
    }
}
