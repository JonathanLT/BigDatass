<?php

namespace Test\Bundle\Controller;

require_once('../vendor/j7mbo/twitter-api-php/TwitterAPIExchange.php');
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TwitterAPIExchange;
use MongoCollection;
use MongoClient;

class DefaultController extends Controller
{
  public function indexAction()
  {
    return $this->render('TestBundle:Default:index.html.twig');
  }

  public function searchAction()
  {
    $tab = array(array());
    $i = 0;
    if (isset($_POST["keyword"]) && !empty($_POST["keyword"])) {
      $keyword = addslashes($_POST["keyword"]);
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
      $today = date("Y-m-d", strtotime('-1 day'));
      $getfield = "?q={$keyword}&count=100&result_type=mixed&since={$today}";
      $requestMethod = 'GET';
      $twitter = new TwitterAPIExchange($settings);
      $tweets = json_decode($twitter->setGetField($getfield)->buildOauth($url, $requestMethod)->performRequest(), true);
      foreach($tweets["statuses"] as $status)
	$collection->insert($status);

      $cursor = $collection->find();
      foreach ($cursor as $doc)
	{
	  $tab[$i]["text"] = $doc["text"];
	  $tab[$i]["created_at"] = $doc["created_at"];
	  $tab[$i]["username"] = $doc["user"]["screen_name"];
	  ++$i;
	}
    }
    if (in_array(null, $tab)) {
      $tab[$i]["text"] = 'Null';
      $tab[$i]["created_at"] = 'Null';
      $tab[$i]["username"] = 'Null';
    }
    return $this->render('TestBundle:Default:show.html.twig', array("data" => $tab));
  }

  //  public function showAction()
  //{
  //$m = new MongoClient();
  //$db = $m->selectDB('bigdatass');
  //$collection = new MongoCollection($db, 'tweets');
  //$tab = [];
  //$cursor = $collection->find();
  //foreach ($cursor as $doc)
  //  {
  //	$tab["text"] = $doc["text"];
  //	$tab["username"] = $doc["user"]["screen_name"];
  //  }
  //return $this->render('TestBundle:Default:show.html.twig', array("data", $tab));
  //}
}
