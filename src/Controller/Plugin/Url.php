<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\Controller\Plugin;

use Laminas\Mvc\Controller\Plugin\Url as ZfUrl;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class Url extends ZfUrl
{
    public function fromRoute($route = null, $params = [], $options = [], $reuseMatchedParams = false)
    {
        if ('lang/jobs/view' == $route && isset($options['query']['id']) && !isset($params['id'])) {
            $params['id'] = $options['query']['id'];
            unset($options['query']['id']);
        }

        return parent::fromRoute($route, $params, $options, $reuseMatchedParams);
    }

}
