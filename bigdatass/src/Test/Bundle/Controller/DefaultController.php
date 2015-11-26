<?php

namespace Test\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
require_once('/var/www/html/my_project/vendor/j7mbo/twitter-api-php/TwitterAPIExchange.php');
use TwitterAPIExchange;
use MongoCollection;
use MongoClient;

class DefaultController extends Controller
{
    public function indexAction()
    {
	$m = new MongoClient();
	$db = $m->selectDB('bigdatass');
	$collection = new MongoCollection($db, 'tweets');
	$settings = array(
			  'oauth_access_token' => "4283699608-BaKzBztpWnO4JQoXqbGr8tK3eOAHdw0baI1l1KZ",
			  'oauth_access_token_secret' => "pbJVfRMPCrsgdjXddJL5E5y5ymrrO1dkWkUulDoVfu7lW",
			  'consumer_key' => "OVx6GtYWoNqUYLYahKe5x412e",
			  'consumer_secret' => "wQou8ATqr5W7eul932n4UiUUlIlAZDgvvZFDsWfdbWrJsCSp68"
			  );
	$collection->drop();
	$url = 'https://api.twitter.com/1.1/search/tweets.json';
	$today = date("Y-m-d");
	$getfield = "?q=yolo&count=100&result_type=mixed&until={$today}";
	$requestMethod = 'GET';
	$twitter = new TwitterAPIExchange($settings);
	$tweets = json_decode($twitter->setGetField($getfield)->buildOauth($url, $requestMethod)->performRequest(), true);
	foreach($tweets["statuses"] as $status) {
	  $collection->insert($status);
	}
	$tab = [];
	$cursor = $collection->find();
	foreach ($cursor as $doc)
	  $tab[] = $doc["text"] . "\n";
	//	file_put_contents("/var/www/html/test", print_r($tab));
	return $this->render('TestBundle:Default:show.html.twig', array("data" => $tab));
    }

    public function showAction()
    {
      $m = new MongoClient();
      $db = $m->selectDB('bigdatass');
      $collection = new MongoCollection($db, 'tweets');

      $tab = [];
      $cursor = $collection->find();
      foreach ($cursor as $doc)
	$tab[] = $doc["text"] . "\n";
      return $this->render('TestBundle:Default:show.html.twig', array("data", $tab));
    }
}
