<?php

namespace App\Api\Http\Controllers {

    use App\Main\Repositories\BannerRepository;
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Views\Twig as View;

    class BannerController
    {
        protected $view;
        protected $banner;

        public function __construct(View $view, BannerRepository $banner)
        {
            $this->view = $view;
            $this->banner = $banner;
        }

        public function index(Request $request, Response $response)
        {
            $data['data'] = $this->banner->findAll();
            return $response->withJSON($data,200,JSON_PRETTY_PRINT);
        }

        public function show(Request $request, Response $response)
        {
            $slug = $request->getAttribute('route')->getArgument('slug');
            $data['data'] = $this->banner->find($slug);

            return $response->withJSON($data,200,JSON_PRETTY_PRINT);
        }
    }
}
