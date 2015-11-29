<?php

namespace SearchTweet\Bundle\Controller;

require_once('../vendor/j7mbo/twitter-api-php/TwitterAPIExchange.php');
require_once('../vendor/datumboxapi/DatumboxAPI.php');
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SearchTweet\Bundle\Entity\Form_advanced;
use TwitterAPIExchange;
use MongoCollection;
use DatumboxAPI;
use MongoClient;

class DefaultController extends Controller
{
  public function indexAction()
  {
    $m = new MongoClient();
    $db = $m->selectDB('bigdatass');
    $collection = new MongoCollection($db, 'recent');
    $data = $collection->find();
    return $this->render('SearchTweetBundle:Default:index.html.twig', array("data" => $data));
  }

  public function searchAction()
  {
    $tab = array(array());
    $i = 0;
    if (isset($_POST["keyword"]) && !empty($_POST["keyword"])) {
      $keyword = addslashes($_POST["keyword"]);
      if (isset($keyword) && !empty($keyword)) {
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
	    $tab[$i]["username_img"] = $doc["user"]["profile_image_url"];
	    $tab[$i]["id_str"] = $doc["id_str"];
	    $rand = rand(1, 3);
	    $tab[$i]["SentimentA"] = ($rand == 1 ? "negative" : ($rand == 3 ? "positive" : "neutral"));
	    ++$i;
	  }
      }
    }
    if (in_array(null, $tab)) {
      $tab[$i]["text"] = 'Null';
      $tab[$i]["created_at"] = 'Null';
      $tab[$i]["username"] = 'Null';
      $tab[$i]["id_str"] = "Null";
      $tab[$i]["SentimentA"] = "Null";
      $tab[$i]["username_img"] = "https://gp3.googleusercontent.com/-_aKQin46MIc/AAAAAAAAAAI/AAAAAAAAAAA/Vcs7-1e2R7E/s48-c-k-no/photo.jpg?sz=50";
    }
    $collection = new MongoCollection($db, 'recent');
    $collection->insert(array('search' => $keyword, 'stats' => array_count_values(array_map(function($foo){return $foo['SentimentA'];}, $tab))));
    return $this->render('SearchTweetBundle:Default:show.html.twig', array("data" => $tab, "search" => $keyword));
  }

  public function searchadvancedAction()
  {
    $tab = array(array());
    $i = 0;
    $query = "";
    $search = "";
    $today = date("Y-m-d", strtotime('-1 day'));
    if (isset($_POST["form"]["allwordAnd"]) && !empty($_POST["form"]["allwordAnd"])) {
      $keyword = addslashes($_POST["form"]["allwordAnd"]);
      $query .= $keyword . "%20";
      $search = strlen($search) ? $search . ', ' .$keyword : $keyword;
    }
    if (isset($_POST["form"]["allTag"]) && !empty($_POST["form"]["allTag"])) {
      $keyword = addslashes($_POST["form"]["allTag"]);
      $query .= $keyword . "%20";
      $search = strlen($search) ? $search . ', ' .$keyword : $keyword;
    }
    if (isset($_POST["form"]["allwordOr"]) && !empty($_POST["form"]["allwordOr"])) {
      $keyword = addslashes($_POST["form"]["allwordOr"]);
      $keyword = preg_replace("/ /", "%20OR%20", $keyword);
      $query .= $keyword . "%20";
      $search = strlen($search) ? $search . ', ' .$keyword : $keyword;
    }
    if (isset($_POST["form"]["sentence"]) && !empty($_POST["form"]["sentence"])) {
      $keyword = addslashes($_POST["form"]["sentence"]);
      $query .= '"' . $keyword . '"' . "%20";
      $search = strlen($search) ? $search . ', ' .$keyword : $keyword;
    }
    if (isset($_POST["form"]["allwordNot"]) && !empty($_POST["form"]["allwordNot"])) {
      $keyword = addslashes($_POST["form"]["allwordNot"]);
      $keyword = preg_replace("/ /", "%20-", $keyword);
      $query .= "-" . $keyword . "%20";
      $search = strlen($search) ? $search . ', ' .$keyword : $keyword;
    }
    if (isset($keyword) && !empty($keyword)) {
      $m = new MongoClient();
      $db = $m->selectDB('bigdatass');
      $collection = new MongoCollection($db, 'tweets');
      $DatumboxAPI = new DatumboxAPI('41e4c303f8da536a90763b6f16fffc62');
      $settings = array(
			'oauth_access_token' => "4283699608-BaKzBztpWnO4JQoXqbGr8tK3eOAHdw0baI1l1KZ",
			'oauth_access_token_secret' => "pbJVfRMPCrsgdjXddJL5E5y5ymrrO1dkWkUulDoVfu7lW",
			'consumer_key' => "OVx6GtYWoNqUYLYahKe5x412e",
			'consumer_secret' => "wQou8ATqr5W7eul932n4UiUUlIlAZDgvvZFDsWfdbWrJsCSp68"
			);
      $collection->drop();
      $url = 'https://api.twitter.com/1.1/search/tweets.json';
      $getfield = "?q=$query&count=100";
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
	  $tab[$i]["username_img"] = $doc["user"]["profile_image_url"];
	  $tab[$i]["id_str"] = $doc["id_str"];
	  $tab[$i]["username_img"] = "https://gp3.googleusercontent.com/-_aKQin46MIc/AAAAAAAAAAI/AAAAAAAAAAA/Vcs7-1e2R7E/s48-c-k-no/photo.jpg?sz=50";
	  $rand = rand(1, 3);   // Note à celui qui comment la ligne, il n'y a que 1000 requêtes/j, elles sont precieuses
	  $tab[$i]["SentimentA"] = ($rand == 1 ? "negative" : ($rand == 3 ? "positive" : "neutral"));   // Note à celui qui comment la ligne, il n'y a que 1000 requêtes/j, elles sont precieuses
	  //$tab[$i]["SentimentA"] = $DatumboxAPI->SentimentAnalysis($doc["text"]); // Note à celui qui décomment la ligne, il n'y a que 1000 requêtes/j, elles sont precieuses
	  ++$i;
	}
    }
    if (in_array(null, $tab)) {
      $tab[$i]["text"] = 'Null';
      $tab[$i]["created_at"] = 'Null';
      $tab[$i]["username"] = 'Null';
      $tab[$i]["id_str"] = 'Null';
      $tab[$i]["SentimentA"] = 'Null';
    }
    $collection = new MongoCollection($db, 'recent');
    $collection->insert(array('search' => $keyword, 'stats' => array_count_values(array_map(function($foo){return $foo['SentimentA'];}, $tab))));
    return $this->render('SearchTweetBundle:Default:show_advanced.html.twig', array("data" => $tab, "search" => $search));
  }

  public function newAction(Request $request)
  {
    $form_advanced = new Form_advanced();
    $form = $this->createFormBuilder($form_advanced)
      ->add('allwordAnd', 'text', array(
					'attr' => array(
							'class' => 'form-group form-control',
							),
					'required' => false,
					))
      ->add('sentence', 'text', array(
				      'attr' => array(
						      'class' => 'form-group form-control',
						      ),
				      'required' => false,
				      ))
      ->add('allwordOr', 'text', array(
				       'attr' => array(
						       'class' => 'form-group form-control',
						       ),
				       'required' => false,
				       ))
      ->add('allwordNot', 'text', array(
					'attr' => array(
							'class' => 'form-group form-control',
							),
					'required' => false,
					))
      ->add('allTag', 'text', array(
				    'attr' => array(
						    'class' => 'form-group form-control',
						    ),
				    'required' => false,
				    ))
      ->add('save', 'submit', array('label' => 'Create Query',
				    'attr' => array(
						    'class' => 'btn btn-default',
						    )))
      ->getForm();
    return $this->render('SearchTweetBundle:Default:new.html.twig', array(
								   'form' => $form->createView(),
								   ));
  }
}
