<?php
namespace Bookstore\Tests;

use Bookstore\Utils\DependencyInjector;
use Bookstore\Core\Config;
use Monolog\Logger;
use Twig_Environment;
use Kreait\Firebase\Database\Database;
use Kreait\Firebase\Database\Reference;

abstract class ControllerTestCase extends AbstractTestCase {
    protected $di;
    private $databaseMock;
    private $firebaseService;
    
    public function setUp(): void {
         // Mock the Database interface instead of the final class
         $this->databaseMock = $this->createMock(Database::class);

         // Mock Reference
         $referenceMock = $this->createMock(Reference::class);
         $referenceMock->method('getValue')->willReturn([]);
 
         // Ensure getReference() returns the mock Reference
         $this->databaseMock->method('getReference')->willReturn($referenceMock);
 
         // Inject the mock Database into FirebaseService
         $this->firebaseService = new class($this->databaseMock) {
            private Database $database;

            public function __construct(Database $database) {
                $this->database = $database;
            }
        
            public function getData(string $path) {
                return $this->database->getReference($path)->getValue();
            }
        
        };

        $this->di = new DependencyInjector();
        $this->di->set('firebaseService', $this->firebaseService);
        $this->di->set('Utils\Config', $this->mock(Config::class));
        $this->di->set(
            'Twig_Environment',
            $this->mock(Twig_Environment::class)
        );
        $this->di->set('Logger', $this->mock(Logger::class));
    }
}
