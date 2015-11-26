// src/OC\PlatformBundle/Document/Product.php
namespace OC\PlatformBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Product
{
  /**
   * @MongoDB\Id
   */
  protected $id;

  /**
   * @MongoDB\Integer
   */
  protected $value;

  public function getId()
  {
    return $this->id;
  }

  public function getValue()
  {
    return $this->value;
  }

  public function setValue($value)
  {
    $this->value = $value;
  }
}
