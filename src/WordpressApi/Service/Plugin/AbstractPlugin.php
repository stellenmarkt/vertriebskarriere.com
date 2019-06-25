<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2017 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\WordpressApi\Service\Plugin;

use JobsFrankfurt\WordpressApi\Service\WordpressClientInterface;
use Zend\Http\Request;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
abstract class AbstractPlugin implements PluginInterface
{
    protected $basePath;

    /**
     *
     *
     * @var WordpressClientInterface
     */
    protected $client;

    protected $invokableMethods = [];

    /**
     * @param WordpressClientInterface $client
     *
     * @return self
     */
    public function setClient(WordpressClientInterface $client)
    {
        $this->client = $client;

        return $this;
    }

    public function __invoke()
    {
        if (!func_num_args()) {
            return $this;
        }

        $args   = func_get_args();
        $method = array_shift($args);

        if (isset($this->invokableMethods[$method])) {
            $method = $this->invokableMethods[$method];

            return $this->$method(...$args);
        }

        throw new \BadMethodCallException('Invalid shortcut ' . $method);
    }

    protected function request($path, array $args = [], $method = Request::METHOD_GET)
    {
        $path = rtrim($this->basePath, '/') . '/' . $path;

        return $this->client->request($path, $args, $method);
    }

    protected function error($code, $message)
    {
        return (object) [ 'error' => true, 'code' => $code, 'message' => $message ];
    }
}