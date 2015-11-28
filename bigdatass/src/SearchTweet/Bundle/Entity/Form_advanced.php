<?php
// src/SearchTweet/Bundle/Entity/Form_advanced.php
namespace SearchTweet\Bundle\Entity;

class Form_advanced
{
  /**
   * @Assert\Blank()
   */
  protected $allwordAnd;
  /**
   * @Assert\Blank()
   */
  protected $sentence;
  /**
   * @Assert\Blank()
   */
  protected $allwordOr;
  /**
   * @Assert\Blank()
   */
  protected $allwordNot;
  /**
   * @Assert\Blank()
   */
  protected $allTag;
  /**
   * @Assert\Blank()
   */
  protected $language;
  /**
   * @Assert\Blank()
   */
  protected $usernameFrom;
  /**
   * @Assert\Blank()
   */
  protected $usernameTo;
  /**
   * @Assert\Blank()
   */
  protected $usernameQuoted;
  /**
   * @Assert\Blank()
   */
  protected $geoloc;
  /**
   * @Assert\Blank()
   */
  protected $generation;

  public function allwordAnd()
  {
    return $this->allwordAnd;
  }

  public function sentence()
  {
    return $this->sentence;
  }

  public function allwordOr()
  {
    return $this->allwordOr;
  }

  public function allwordNot()
  {
    return $this->allwordNot;
  }

  public function allTag()
  {
    return $this->allTag;
  }

  public function language()
  {
    return $this->language;
  }

  public function usernameFrom()
  {
    return $this->usernameFrom;
  }

  public function usernameTo()
  {
    return $this->usernameTo;
  }

  public function usernameQuoted()
  {
    return $this->usernameQuoted;
  }

  public function geoloc()
  {
    return $this->geoloc;
  }

  public function generation()
  {
    return $this->generation;
  }

  public function setallwordAnd($allwordAnd)
  {
    $this->allwordAnd = $allwordAnd;
  }

  public function setsentence($sentence)
  {
    $this->sentence = $sentence;
  }

  public function setallwordOr($allwordOr)
  {
    $this->allwordOr = $allwordOr;
  }

  public function setallwordNot($allwordNot)
  {
    $this->allwordNot = $allwordNot;
  }

  public function setallTag($allTag)
  {
    $this->allTag = $allTag;
  }

  public function setlanguage($language)
  {
    $this->language = $language;
  }

  public function setusernameFrom($usernameFrom)
  {
    $this->usernameFrom = $usernameFrom;
  }

  public function setusernameTo($usernameTo)
  {
    $this->usernameTo = $usernameTo;
  }

  public function setusernameQuoted($usernameQuoted)
  {
    $this->usernameQuoted = $usernameQuoted;
  }

  public function setgeoloc($geoloc)
  {
    $this->geoloc = $geoloc;
  }

  public function setgeneration($generation)
  {
    $this->generation = $generation;
  }
}
