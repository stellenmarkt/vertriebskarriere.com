<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\ContactForm\Controller;

use JobsFrankfurt\ContactForm\Controller\Plugin\ContactMailSender;
use JobsFrankfurt\ContactForm\Form\ContactForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class ContactFormController extends AbstractActionController
{
    /**
     *
     *
     * @var ContactForm
     */
    private $contactForm;

    public function __construct($contactForm)
    {
        $this->contactForm = $contactForm;
    }

    public function indexAction()
    {
        $vars = [
            'sent' => $this->process(),
            'form' => $this->contactForm
        ];

        $model = new ViewModel($vars);
        $model->setTemplate('contactform.view');

        return $model;
    }

    private function process()
    {
        /* @var \Zend\Http\Request $request */
        $request = $this->getRequest();

        if (!$request->isPost()) {
            $this->populateDefaultValues();
            return false;
        }

        $this->contactForm->setData($request->getPost());

        if (!$this->contactForm->isValid()) { return false; }

        $data   = $this->contactForm->getInputFilter()->getValues();
        $plugin = $this->plugin(ContactMailSender::class);

        $plugin->send($data);

        return true;
    }

    private function populateDefaultValues()
    {
        $auth = $this->plugin('auth');

        if (!$auth->isLoggedIn()) { return; }

        /* @var \Auth\Entity\User $user */
        $user = $auth->getUser();
        $org  = $user->getOrganization()->hasAssociation() ? $user->getOrganization()->getOrganization() : null;
        $website = $org ? $org->getContact()->getWebsite() : null;
        $org  = $org ? (($name = $org->getOrganizationName()) ? $name->getName() : null) : null;

        $data = [
            'organization' => $org,
            'name' => $user->getInfo()->getDisplayName(false),
            'email' => $user->getInfo()->getEmail(),
            'website' => $website,
        ];

        $this->contactForm->populateValues($data);
    }
}
