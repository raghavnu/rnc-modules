<?php

namespace Acme;


use Doctrine\ORM\EntityManager;

abstract class AbstractResource
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em = null;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
}