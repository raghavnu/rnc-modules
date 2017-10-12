<?php

namespace App\Main\Http\Controllers {

    use App\Main\Repositories\BannerRepository;
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Flash\Messages as Flash;
    use Slim\Views\Twig as View;

    class BannerController
    {
        protected $view;
        protected $flash;
        protected $banner;

        /**
         * BannerController constructor.
         * @param View $view
         * @param BannerRepository $banner
         * @param Flash $flash
         */
        public function __construct(View $view, BannerRepository $banner, Flash $flash)
        {
            $this->view = $view;
            $this->flash = $flash;
            $this->banner = $banner;
        }

        /**
         * @param Response $response
         * @return Response
         */
        public function index(Response $response)
        {
            $data['banners'] = $this->banner->findAll();
            return $this->view->render($response, '@Main\banner\index.twig', $data);
        }

        /**
         * @param Request $request
         * @param Response $response
         * @return Response
         */
        public function show(Request $request, Response $response)
        {
            $slug = $request->getAttribute('route')->getArgument('slug');
            $data['banner'] = $this->banner->find($slug);
            return $this->view->render($response, '@Main\banner\show.twig', $data);
        }
    }
}
