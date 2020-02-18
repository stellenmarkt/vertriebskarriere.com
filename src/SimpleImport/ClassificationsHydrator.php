<?php
/**
 * @filesource
 * @copyright (c) 2013 - 2017 Cross Solution (http://cross-solution.de)
 * @license MIT
 * @author Miroslav Fedeleš <miroslav.fedeles@gmail.com>
 * @since 0.30
 */
namespace JobsFrankfurt\SimpleImport;

use Jobs\Repository\Categories;
use Jobs\Entity\Classifications;
use InvalidArgumentException;
use SimpleImport\Hydrator\Job\ClassificationsHydrator as YkClassificationsHydrator;

class ClassificationsHydrator extends YkClassificationsHydrator
{
    
    /**
     * @var TreeSelectStrategy
     */
    private $treeStrategy;

    /**
     * @var Categories
     */
    private $categories;

    /**
     * @var array
     */
    private $availableClassifications;

    /**
     * Root category cache
     *
     * @var array
     */
    private $roots = [];

    private $defaultLeaf = [
        'employmentTypes' => 'Festanstellung'
    ];
    /** @noinspection PhpMissingParentConstructorInspection */

    /**
     * @param TreeSelectStrategy $treeStrategy
     * @param Categories $categories
     * @param array $availableClassifications
     */
    public function __construct(TreeSelectStrategy $treeStrategy, Categories $categories, array $availableClassifications)
    {
        $this->treeStrategy = $treeStrategy;
        $this->categories = $categories;
        $this->availableClassifications = $availableClassifications;
    }
    
    /**
     * {@inheritDoc}
     * @see \Laminas\Hydrator\HydrationInterface::hydrate()
     */
    public function hydrate(array $data, $classifications)
    {
        if (!$classifications instanceof Classifications) {
            throw new InvalidArgumentException(sprintf('Object must be instance of "%s"', Classifications::class));
        }
        
        if (!$this->availableClassifications) {
            return;
        }
        
        $this->treeStrategy->setAllowSelectMultipleItems(true)
            ->setShouldCreateLeafs(false)
            ->setShouldUseNames(true);
        
        foreach ($this->availableClassifications as $availableClassification) {
            $this->treeStrategy->setDefaultLeaf(isset($this->defaultLeaf[$availableClassification]) ? $this->defaultLeaf[$availableClassification] : null);
            $this->treeStrategy->setAttachedLeafs($classifications->{"get$availableClassification"}())
                ->setTreeRoot($this->getTreeRoot($availableClassification))
                ->hydrate($data[$availableClassification]);
        }
    }
    
    /**
     * @param string $value
     * @return \Jobs\Entity\Category
     */
    private function getTreeRoot($value)
    {
        if (!isset($this->roots[$value])) {
            $this->roots[$value] = $this->categories->findOneBy(['value' => $value]);
        }

        return $this->roots[$value];
    }
}
