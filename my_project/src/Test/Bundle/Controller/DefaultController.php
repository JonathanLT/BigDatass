<?php

namespace Test\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
require_once('/var/www/html/my_project/vendor/j7mbo/twitter-api-php/TwitterAPIExchange.php');

class DefaultController extends Controller
{
    public function indexAction($name)
    {
	$settings = array(
    	'oauth_access_token' => "4283699608-BaKzBztpWnO4JQoXqbGr8tK3eOAHdw0baI1l1KZ",
    	'oauth_access_token_secret' => "pbJVfRMPCrsgdjXddJL5E5y5ymrrO1dkWkUulDoVfu7lW",
    	'consumer_key' => "OVx6GtYWoNqUYLYahKe5x412e",
    	'consumer_secret' => "wQou8ATqr5W7eul932n4UiUUlIlAZDgvvZFDsWfdbWrJsCSp68"
	);
	$url = 'https://api.twitter.com/1.1/search/tweets.json';
	$getfield = '?q=swag';
	$requestMethod = 'GET';
	$twitter = new TwitterAPIExchange($settings);
	echo $twitter->setGetField($getfield)->buildOauth($url, $requestMethod)->performRequest();
        return $this->render('TestBundle:Default:index.html.twig', array('name' => $name));
    }
}
