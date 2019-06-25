<?php
/**
 * YAWIK JobsFrankfurt Module
 *
 * @filesource
 * @license MIT
 * @copyright  2017 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\WordpressApi\Listener;

use JobsFrankfurt\WordpressApi\Filter\PageIdMap;
use JobsFrankfurt\WordpressApi\Service\WordpressClient;
use Zend\EventManager\EventInterface;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class WordpressContentSnippet 
{
    /**
     *
     *
     * @var \Gastro24\WordpressApi\Service\WordpressClient
     */
    private $client;

    private $idMap = [];

    public function __construct(WordpressClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param PageIdMap $idMap
     *
     * @return self
     */
    public function setIdMap(PageIdMap $idMap)
    {
        $this->idMap = $idMap;

        return $this;
    }

    /**
     * @return PageIdMap
     */
    public function getIdMap()
    {
        if (!$this->idMap) {
            $this->setIdMap(new PageIdMap());
        }

        return $this->idMap;
    }

    public function __invoke(EventInterface $event)
    {
        $result = null;

        switch ($event->getName()) {
            default:
            case 'wordpress-page':
                $id = $event->getParam('id');

                if ($id) {
                    $id     = $this->getIdMap()->filter($id);
                    $result = $this->client->getPage($id);
                }
                break;

        }

        if ($key = $event->getParam('key')) {
            foreach (explode('.', $key) as $partKey) {
                if (isset($result->$partKey)) {
                    $result = $result->$partKey;
                } else {
                    $result = '';
                    break;
                }
            }
            return ['content' => $result];
        }

        if ($template = $event->getParam('template')) {
            return ['template' => $template, 'values' => ['result' => $result]];
        }

        return null;
    }
}