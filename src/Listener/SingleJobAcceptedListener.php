<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\Listener;

use Jobs\Listener\Events\JobEvent;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class SingleJobAcceptedListener 
{


    private $orders;
    private $mailer;

    public function __construct(\Orders\Repository\Orders $orders, \Core\Mail\MailService $mailer)
    {
        $this->orders = $orders;
        $this->mailer = $mailer;
    }

    public  function __invoke(JobEvent $event)
    {
        $job = $event->getJobEntity();

        if ($job->getUser()) { return; }

        /* @var \Orders\Entity\Order $order */
        $order = $this->orders->findByJobId($job->getId());

        if (!$order) { return; }

        $invoice = $order->getInvoiceAddress();

        $this->mailer->send($this->mailer->get(
            'JobsFrankfurt/SingleJobMail',
            [
                'template' => 'jobs-frankfurt/mail/single-job-accepted',
                'subject'  => 'Ihre Anzeige wurde veröffentlicht.',
                'email'    => $invoice->getEmail(),
                'name'     => $invoice->getName(),
                'vars'     => [
                    'job' => $job,
                    'invoice' => $invoice,
                ],
            ]
        ));
    }
}
