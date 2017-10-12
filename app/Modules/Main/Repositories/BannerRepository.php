<?php

namespace App\Main\Repositories;


use Acme\AbstractResource;
use App\Main\Entity\Banner;

class BannerRepository extends AbstractResource
{

    /**
     * @param null $slug
     * @return mixed
     */
    public function find($slug = null)
    {
        $banner = $this->em->getRepository(Banner::class)->findOneBy(
            array('slug' => $slug)
        );
        if ($banner) {
            return $banner->getArrayCopy();
        }
    }

    /**
     * @return array
     */
    public function findAll()
    {
        $banners = $this->em->getRepository(Banner::class)->findAll();
        $banners = array_map(
            function ($photo) {
                return $photo->getArrayCopy();
            },
            $banners
        );

        return $banners;
    }
}