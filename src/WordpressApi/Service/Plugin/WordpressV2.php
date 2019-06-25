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

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class WordpressV2 extends AbstractPlugin
{
    protected $basePath = 'wp/v2';

    protected $invokableMethods = [
        'page'  => 'getPage',
        'pages' => 'getPages',
    ];

    public function getPosts(array $args = [])
    {
        return $this->request('posts', $args);
    }

    public function getPost($id, array $args = [])
    {
        return $this->request('posts/' . $id, $args);
    }

    public function getPostBySlug($slug, array $args = [])
    {
        return $this->getArticleBySlug('post', $slug, $args);
    }

    public function getPages(array $args = [])
    {
        return $this->request('pages', $args);
    }

    public function getPage($id, array $args = [])
    {
        return $this->request('pages/' . $id, $args);
    }

    public function getPageBySlug($slug, array $args = [])
    {
        return $this->getArticleBySlug('page', $slug, $args);
    }

    private function getArticleBySlug($type, $slug, array $args = [])
    {
        $args   = array_merge($args, ['slug' => $slug]);

        $articles = $this->request($type . 's', $args);

        if (count($articles)) {
            return $articles[0];
        }

        return $this->error('slug_not_found', sprintf('No %s with the slug "%s" was found', $type, $slug));
    }
}