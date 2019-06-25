<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2016 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\SimpleImport;

use Core\Entity\Tree\AbstractLeafs;
use Core\Entity\Tree\EmbeddedLeafs;
use Core\Entity\Tree\NodeInterface;
use Core\Form\Hydrator\Strategy\TreeSelectStrategy as YkTreeSelectStrategy;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Hydrator strategy for TreeSelect form element.
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @since 0.29
 */
class TreeSelectStrategy extends YkTreeSelectStrategy
{
    private $defaultLeaf;

    /**
     * @return string
     */
    public function getDefaultLeaf()
    {
        return $this->defaultLeaf;
    }

    /**
     * @param string $defaultLeaf
     *
     * @return self
     */
    public function setDefaultLeaf($defaultLeaf)
    {
        $this->defaultLeaf = $defaultLeaf;

        return $this;
    }


    public function hydrate($value)
    {
        $object = $this->getAttachedLeafs();

        $root = $this->getTreeRoot();
        $items = new ArrayCollection();

        if (!$this->allowSelectMultipleItems()) {
            $value = [$value];
        }

        foreach ($value as $itemValue) {
            $leaf = $this->findLeaf($root, $itemValue);

            if ($leaf) {
                $items->add($leaf);
            }
        }

        if (!count($items)
            && ($defaultLeaf = $this->getDefaultLeaf())
            && ($leaf = $this->findLeaf($root, $defaultLeaf))
        ) {
            $items->add($leaf);
        }

        $object->setItems($items);

        return $object;
    }

    /**
     * Find a leaf with a concrete value in the tree.
     *
     * @param NodeInterface $leaf
     * @param string        $value
     *
     * @return NodeInterface|null
     */
    private function findLeaf(NodeInterface $leaf, $value)
    {
        $parts = is_array($value) ? $value : explode($this->shouldUseNames() ? ' | ': '-', $value);
        $value = array_shift($parts);

        /* @var NodeInterface $item */
        foreach ($leaf->getChildren() as $item) {
            $compare = $this->shouldUseNames() ? $item->getName() : $item->getValue();
            if ($compare == $value) {
                if (count($parts)) {
                    return $this->findLeaf($item, $parts);
                }

                return $item;
            }
        }

        if ($value && $this->shouldCreateLeafs()) {
            $nodeClass = get_class($leaf);
            $node = new $nodeClass($value);
            $leaf->addChild($node);
            if (count($parts)) {
                return $this->findLeaf($node, $parts);
            }

            return $node;
        }

        return null;
    }
}
