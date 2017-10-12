<?php

namespace App\Main\Http\Controllers {


    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Views\Twig as View;

    class DashboardController
    {
        protected $view;

        public function __construct(View $view)
        {
            $this->view = $view;
        }

        public function index(Request $request, Response $response)
        {
            return $this->view->render($response, '@Main\dashboard\index.twig');
        }
    }
}
