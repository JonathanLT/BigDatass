<?php

// src/OC/PlatformBundle/Controller/AdvertController.php

namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ODM\MongoDB\Mongo;
use OC\PlateformBundle\Document\Product;

class AdvertController
{
  public function indexAction()
  {
    $tab = ["x"];
    return new Response(var_dump($tab));
  }
}