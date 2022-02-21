<?php

namespace App\Application\Actions\Common;

use App\Application\Actions\Action;
use App\Domain\DomainException\DomainRecordNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class ViewUploadAction extends Action
{

    private $view;

    public function __construct (Twig $twig) {
        $this->view = $twig;
    }

    protected function action(): Response {
        $viewData = [
            'title' => '데이터베이스 webpage',
            'now' => date('Y-m-d H:i:s'),
        ];
        return $this->view->render(
            $this->response,
            'home\home.twig',
            $viewData
        );
    }
}