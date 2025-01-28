<?php
namespace Bookstore\Controllers;

class ErrorController extends AbstractController {
    public function notFound(): string {
        $properties = ['errorMessage' => 'Page not found!'];
        //$properties = ['path' => $this->request->getPath(), 'domain' => $this->request->getDomain(), 'url' => $this->request->getUrl()];
        return $this->render('error.twig', $properties);
    }
}