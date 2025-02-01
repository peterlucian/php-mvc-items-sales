<?php
namespace Bookstore\Tests\Controllers;

use Bookstore\Controllers\ItemController;
use Bookstore\Core\Request;
use Bookstore\Exceptions\NotFoundException;
use Bookstore\Exceptions\DbException;
use Bookstore\Models\ItemModel;
use Bookstore\Tests\ControllerTestCase;
use Twig_Template;

class ItemControllerTest extends ControllerTestCase {
    private function getController(Request $request = null): ItemController {
        if ($request === null) {
            $request = $this->mock('Core\Request');
        } 
        return new ItemController($this->di, $request);
    }
    
    protected function mockTemplate(
        string $templateName,
        array $params,
        $response
    ) {
        $template = $this->mock(Twig_Template::class);
        $template
            ->expects($this->once())
            ->method('render')
            ->with($params)
            ->will($this->returnValue($response));
        $this->di->get('Twig_Environment')
            ->expects($this->once())
            ->method('loadTemplate')
            ->with($templateName)
            ->will($this->returnValue($template));
    }

    public function testGetData() {
        $result = $this->di->get('firebaseService')->getData('items');

        // Assert expected result
        $this->assertEquals([], $result);
    }
    
    // public function testItemNotFound() {
    //     $itemModel = $this->mock(ItemModel::class);
    //     $itemModel
    //         ->expects($this->once())
    //         ->method('getAll')
    //         ->with(1, 5)
    //         ->will(
    //             $this->throwException(new DbException())
    //         );
    //     $this->di->set('ItemModel', $itemModel);
    //     $response = "Rendered template";
    //     $this->mockTemplate(
    //         'error.twig',
    //         ['errorMessage' => 'No items were found.'],
    //         $response
    //     );
    //     $result = $this->getController()->getAllWithPage(1);
    //     $this->assertSame(
    //         $result, $response,
    //         'Response object is not the expected one.'
    //     );
    // }
    
    // public function testErrorSaving() {
    //     $controller = $this->getController();
        
    //     $itemModel = $this->mock(ItemModel::class);
    //     $itemModel
    //         ->expects($this->once())
    //         ->method('create')
    //         ->with(null)
    //         ->will($this->throwException(new DbException()));
        
    //     $this->di->set('ItemModel', $ItemModel);
    //     $response = "Rendered template";
    //     $this->mockTemplate(
    //         'error.twig',
    //         ['errorMessage' => 'Error adding item.'],
    //         $response
    //     );
    //     $result = $controller->save();
    //     $this->assertSame(
    //         $result, $response,
    //         'Response object is not the expected one.'
    //     );
    // }
    
}