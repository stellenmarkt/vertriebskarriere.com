<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2017 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\Controller;

use JobsFrankfurt\WordpressApi\Service\Plugin\WordpressV2;
use Laminas\Mvc\Controller\AbstractActionController;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class WordpressPageController extends AbstractActionController
{
    /**
     *
     *
     * @var WordpressV2
     */
    private $client;

    public function __construct(WordpressV2 $client)
    {
        $this->client = $client;
    }

    public function indexAction()
    {
        $type = $this->params()->fromRoute('type', 'page');
        $id = $this->params()->fromRoute('id');

        if (!is_numeric($id) || 0 === strpos($id, '~')) {
            $article = 'page' == $type ? $this->client->getPageBySlug($id) : $this->client->getPostBySlug($id);
        } else {
            $article = 'page' == $type ? $this->client->getPage($id) : $this->client->getPost($id);
        }

        if (isset($article->error) && $article->error) {
            $this->getResponse()->setStatusCode(404);
            return [
                'message' => sprintf('[%s] %s', $article->code, $article->message)
            ];
        }
        return [ 'article' => $article ];
    }
}