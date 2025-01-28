<?php
namespace Bookstore\Controllers;

use Bookstore\Models\ItemModel;
use Bookstore\Exceptions\NotFoundException;
use Bookstore\Exceptions\DbException;

class ItemController extends AbstractController {
    const PAGE_LENGTH = 10;
    public function getAllWithPage($page): string {
        $itemModel = new ItemModel($this->db);
        $items = $itemModel->getAll($page, self::PAGE_LENGTH);
        $userid = $this->request->getSession()->get('user');
        $properties = [
            'items' => $items,
            'userid' => $userid
            //'currentPage' => $page,
            //'lastPage' => count($books) < self::PAGE_LENGTH
            ];
        return $this->render('items.twig', $properties);
    }

    public function getAll(): string {
        return $this->getAllWithPage(1);
    }

    public function saveItem(): string {
        if (!$this->request->isPost()) {
            return $this->render('save_item.twig', []);
        }
        $params = $this->request->getParams();
        if (!$params->has('productName') && !$params->has('productDescription') && !$params->has('price') && !$params->has('imageUrl')) {
            $params = ['errorMessage' => 'No info provided.'];
            return $this->render('save_item.twig', $params);
        }

        $productName = $params->getString('productName');
        $productDescription = $params->getString('productDescription');
        $imageUrl = $params->getString('imageUrl');
        $price = $params->getInt('price');

        $data = [
            'productName' => $productName,
            'description' => $productDescription,
            'imageUrl' => $imageUrl,
            'price' => $price
        ];

        $itemModel = new ItemModel($this->db);

        try {
            $itemModel->create($data);
        } catch (\Exception $e) {
            $properties = [ 'errorMessage' => 'Error adding item.' ];
            //$this->log->error( 'Error buying book: ' . $e->getMessage() );
            return $this->render('error.twig', $properties);
        }


        //$newController = new ItemController($this->di, $this->request);
        return $this->getAll();
        
    }
    
}