<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\Entity;

use Core\Entity\EntityInterface;
use Core\Entity\EntityTrait;
use Core\Entity\IdentifiableEntityInterface;
use Core\Entity\IdentifiableEntityTrait;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * ${CARET}
 *
 * @ODM\Document(collection="gastro24.userproducts", repositoryClass="\Core\Repository\DefaultRepository")
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class UserProduct implements EntityInterface, IdentifiableEntityInterface
{
    use EntityTrait, IdentifiableEntityTrait;

    /**
     *
     * @ODM\EmbedOne(discriminatorField="_entity")
     * @var Product\ProductInterface
     */
    private $product;

    /**
     * @return Product\ProductInterface
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param Product\ProductInterface $product
     *
     * @return self
     */
    public function setProduct(Product\ProductInterface $product)
    {
        $this->product = $product;

        return $this;
    }



}
