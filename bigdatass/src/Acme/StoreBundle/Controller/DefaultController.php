<?php
// src/Acme/StoreBundle/Controller/DefaultController.php

namespace Acme\StoreBundle\Controller;

use Acme\StoreBundle\Document\Product;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \MongoClient;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
      $m = new MongoClient();
      $db = $m->selectDB('test');
      $collection = new MongoCollection($db, 'phpmanual');

      // recherche les documents dont l'identifiant est entre 5 < x < 20
      $rangeQuery = array('x' => array( '$gt' => 5, '$lt' => 20 ));

      $tab = [];
      $cursor = $collection->find($rangeQuery);
      foreach ($cursor as $doc)
	$tab = $doc["x"] . "\n";
      return $this->render('AcmeStoreBundle:Default:index.html.twig', array('name' => var_dump($tab)));
    }

    public function createAction()
    {
      $product = new Product();
      $product->setName('A Foo Bar');
      $product->setPrice('19.99');

      $dm = $this->get('doctrine_mongodb')->getManager();
      $dm->persist($product);
      $dm->flush();

      return new Response('Created product id '.$product->getId());
    }

    public function showAction($id)
    {
      $product = $this->get('doctrine_mongodb')
	->getRepository('AcmeStoreBundle:Product')
	->find($id);

      if (!$product) {
	throw $this->createNotFoundException('No product found for id '.$id);
      }
      // do something, like pass the $product object into a template
    }
}
