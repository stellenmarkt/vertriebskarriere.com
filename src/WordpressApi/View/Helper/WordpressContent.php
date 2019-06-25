<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2017 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\WordpressApi\View\Helper;

use JobsFrankfurt\WordpressApi\Filter\PageIdMap;
use JobsFrankfurt\WordpressApi\Service\WordpressClient;
use Zend\Stdlib\ArrayUtils;
use Zend\View\Helper\AbstractHelper;

/**
 * ${CARET}
 *
 * <pre>

 * $this->wordpress('page', 'pageId')->value();
 * $this->wordpress()->string('page', 'bonifatius', 'title.rendered');
 * $this->wordpress('page', 'pageId')->template('viewScript');
 *
 * $this->wordpress(
 * $this->wordpress(['page', 'pageId'], ['template', 'script']);
 *
 * $this->wordpress()->pagetemplate('script', 'page',
 *
 * $this->proxy()->chain('wordpress', ['page', 'pageId'], ['template', 'script']);
 * $this->proxy()->consecutive('wordpress', ['page', 'pageId'], ['value']);
 *
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class WordpressContent extends AbstractHelper
{
    /**
     *
     *
     * @var Object
     */
    private $result;

    private $client;

    /* @var $idMap \Gastro24\WordpressApi\Filter\PageIdMap */
    private $idMap;

    public function __construct(WordpressClient $client, PageIdMap $idMap)
    {
        $this->client = $client;
        $this->idMap  = $idMap;
    }

    public function __invoke()
    {
        if (!func_num_args()) {
            return $this;
        }

        $args   = func_get_args();
        $method = array_shift($args);

        return call_user_func_array([$this, $method], $args);
    }

    public function __call($method, $args)
    {
        $callback = [$this->client, $method];

        if (is_callable($callback)) {
            $this->result = call_user_func_array($callback, $args);

            return $this;
        }

        throw new \BadMethodCallException('Unknown method: ' . __CLASS__ . ' ::' . $method);
    }

    /**
     *
     *
     * @param int $id
     *
     * @return WordpressContent
     */
    public function page($id)
    {
        $id = $this->idMap->filter($id);

        $this->result = $this->client->wp()->getPage($id);

        return $this;
    }

    public function menu($slug, $render = true)
    {
        $this->result = $this->client->menus()->getMenu($slug);

        if (false === $render) {
            return $this;
        } else if (isset($this->result->error) || !count($this->result->items)) {
            return '';
        }

        $url = $this->getView()->plugin('url');
        $out = '<ul>';
        foreach ($this->result->items as $item) {
            if ('custom' == $item->object) {
                $href = $item->url;
            } else {
                $href = $url('lang/wordpress', ['type' => $item->object, 'id' => basename($item->url)], true);
            }
            $out .= '<li><a href="' . $href . '">'
                  . $item->title . '</a></li>';
        }
        return "$out</ul>";
    }

    public function value($key = null)
    {
        if (!$key) {
            return $this->result;
        }

        if (1 < func_num_args()) {
            $keys = func_get_args();
        } else if (false !== strpos($key, '.')) {
            $keys = explode('.', $key);
        } else if (!is_array($key)) {
            $keys = [$key];
        } else {
            $keys = $key;
        }

        $result = $this->result;
        foreach ($keys as $partKey) {
            if (!isset($result->$partKey)) {
                $result = null;
                break;
            }

            $result = $result->$partKey;
        }

        return $result;
    }

    public function template($name, array $vars = [])
    {
        $renderer = $this->getView();

        if (!method_exists($renderer, 'plugin')) {
            return '';
        }

        $partial = $renderer->plugin('partial');
        $vars['result'] = $this->result;

        return $partial($name, $vars);
    }
}
