// src/Acme/StoreBundle/Document/Product.php
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
}
