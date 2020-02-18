<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\ContactForm\View\Helper;

use Laminas\View\Helper\AbstractHelper;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class SetSubject extends AbstractHelper
{
    public function __invoke($subject)
    {
        /* @var \Laminas\View\Renderer\PhpRenderer $view */
        $view = $this->getView();
        $mail = $view->get('mail');

        if (!$mail) { return; }

        $mail->setSubject($subject);

        return;
    }
}
