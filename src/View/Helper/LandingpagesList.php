<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2017 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\View\Helper;

use JobsFrankfurt\WordpressApi\Service\WordpressClient;
use Laminas\View\Helper\AbstractHelper;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class LandingpagesList extends AbstractHelper
{

    /**
     *
     *
     * @var \Gastro24\WordpressApi\Service\WordpressClient
     */
    private $client;

    /**
     *
     *
     * @var array
     */
    private $idMap;

    /**
     *
     *
     * @var \Laminas\View\Helper\Url
     */
    private $urlHelper;

    public function __construct(WordpressClient $client, array $idMap)
    {
        $this->client = $client;
        $this->idMap  = $idMap;
    }

    /**
     * @param \Laminas\View\Helper\Url $urlHelper
     *
     * @return self
     */
    public function setUrlHelper(\Laminas\View\Helper\Url $urlHelper)
    {
        $this->urlHelper = $urlHelper;

        return $this;
    }

    /**
     * @return \Laminas\View\Helper\Url
     */
    public function getUrlHelper()
    {
        if (!$this->urlHelper) {
            $this->setUrlHelper($this->getView()->plugin('url'));
        }

        return $this->urlHelper;
    }



    public function __invoke()
    {
        $result = $this->client->wp('pages', ['parent' => 58, 'include' => implode(',', array_values($this->idMap))]);
        $map    = array_flip($this->idMap);
        $url    = $this->getUrlHelper();

        $out = '<ul>';
        foreach ($result as $page) {
            $out .= '<li><a href="' . $url('lang/landingPage', ['q' => $map[$page->id], 'format' => 'html'], true) .'">'
                  . $page->title->rendered . '</a></li>';
        }
        $out .= '</ul>';

        return $out;
    }
}