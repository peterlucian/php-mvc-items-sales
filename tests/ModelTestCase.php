<?php
namespace Bookstore\Tests;

use Bookstore\Core\Config;
use PDO;

abstract class ModelTestCase extends AbstractTestCase {
    protected $db;
    protected $tables = [];
    
    public function setUp() {
        $config = new Config();
        $dbConfig = $config->get('db');
        $this->db = new PDO(
            'mysql:host=' . getenv('IP') . ';dbname=bookstore;port=3306',
            $dbConfig['user'],
            $dbConfig['password']
        );
        $this->db->beginTransaction();
        $this->cleanAllTables();
    }
    
    public function tearDown() {
        $this->db->rollBack();
    }
    
    protected function cleanAllTables() {
        foreach ($this->tables as $table) {
            $this->db->exec("delete from $table");
        }
    }
}
    