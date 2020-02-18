<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\View\Helper;

use Jobs\Entity\JobInterface;
use Laminas\View\Helper\AbstractHelper;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class JobboardApplyUrl extends AbstractHelper
{
    private $urlHelper;

    public function __construct($urlHelper)
    {
        $this->urlHelper = $urlHelper;
    }

    public function __invoke(JobInterface $job)
    {
        $ats = $job->getAtsMode();


        if ($ats->isDisabled()) {
            $url = $job->getLink();
            $pdflink = null;
            $class = "no-apply-link";
            if (strpos($url,"http")) {
                $text = '.pdf' == substr($url, -4) ? 'PDF downloaden' : 'Jetzt bewerben';
            } else {
                $url = null;
            }
        } else if ($ats->isIntern() || $ats->isEmail()) {

            $route = 'lang/apply';
            $params = [
                'applyId' => $job->getApplyId(),
                'lang' => 'de',
            ];

            $url  = $this->urlHelper->__invoke($route, $params);
            $class = 'internal-apply-link';
            $text = 'Jetzt bewerben';
            $pdflink = '.pdf' == substr($job->getLink(), -4) ?$job->getLink() : null;

        } else {
            $url = $ats->getUri();
            $class = 'external-apply-link';
            $text = 'Jetzt bewerben';
            $pdflink = '.pdf' == substr($job->getLink(), -4) ?$job->getLink() : null;
        }

        if ($pdflink) {
            $pdflink = ' <a href="' . $pdflink . '" class="btn btn-primary">PDF downloaden</a>';
        }

        return $url?sprintf('<a href="%s" class="btn btn-primary %s">%s</a>%s', $url, $class, $text, $pdflink):'';
    }
}
