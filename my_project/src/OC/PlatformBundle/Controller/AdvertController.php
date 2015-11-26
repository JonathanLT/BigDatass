<?php
// src/OC/PlatformBundle/Controller/AdvertController.php

namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use MongoCollection;
use MongoClient;

class AdvertController
{
  public function indexAction()
  {
    $m = new MongoClient();
    $db = $m->selectDB('test');
    $collection = new MongoCollection($db, 'phpmanual');

    // recherche les documents dont l'identifiant est entre 5 < x < 20
    $rangeQuery = array('x' => array( '$gt' => 5, '$lt' => 20 ));
    $tab = [];
    $cursor = $collection->find($rangeQuery);
    foreach ($cursor as $doc)
      $tab[] = $doc["x"] . "\n";
    return new Response(var_dump($tab));
  }
}