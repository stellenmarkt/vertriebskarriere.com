<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\ContactForm\Controller\Plugin;

use Core\Mail\MailService;
use JobsFrankfurt\ContactForm\Options\ContactFormOptions;
use Laminas\Mvc\Controller\Plugin\AbstractPlugin;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class ContactMailSender extends AbstractPlugin
{
    /**
     *
     *
     * @var MailService
     */
    private $mailer;

    /**
     *
     *
     * @var ContactFormOptions
     */
    private $options;

    public function __construct(MailService $mailer, ContactFormOptions $options)
    {
        $this->mailer = $mailer;
        $this->options = $options;
    }

    public function send(array $data)
    {
        /* @var \Core\Mail\HTMLTemplateMessage $mail */
        $mail = $this->mailer->get('htmltemplate');
        $mail->setVariables($data);
        $mail->setTemplate('contactform.mail');
        $mail->setTo($this->options->getEmail());

        /* Due to how mail is assembled in \Laminas\Mail\Transport\Sendmail,
         * we need to force the rendering of the mail in order to
         * make the subject kind of persist.
         *
         * @see Sendmail lines 124, and the references methods.
         * basically, prepare subject is called BEFORE prepareBody (where
         * the subject is set, because HTMLTemplateMessage works this way.
         */
        $mail->getBodyText();

        $this->mailer->send($mail);
    }

}
