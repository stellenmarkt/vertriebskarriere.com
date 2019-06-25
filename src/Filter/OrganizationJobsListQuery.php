<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\Filter;

use Organizations\Repository\Filter\ListJobQuery;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class OrganizationJobsListQuery extends ListJobQuery
{
    public function createQuery($params, $queryBuilder)
    {
        parent::createQuery($params, $queryBuilder);
        $queryBuilder->sort('datePublishStart.date', -1);

        return $queryBuilder;
    }

}
