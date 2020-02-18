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

use Auth\Listener\Events\AuthEvent;
use JobsFrankfurt\Entity\UserProduct;
use Laminas\EventManager\EventManager;
use Laminas\Mvc\MvcEvent;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class UserRegisteredListener 
{
    /**
     *
     *
     * @var null|string
     */
    private $productType;

    /**
     *
     *
     * @var \Laminas\Http\PhpEnvironment\Response
     */
    private $response;

    /**
     *
     *
     * @var \Laminas\Router\RouteStackInterface
     */
    private $router;

    /**
     *
     *
     * @var \Auth\AuthenticationService
     */
    private $authService;

    /**
     *
     *
     * @var \Auth\Entity\User
     */
    private $user;

    public function __construct($productType = null, $router, $response, $authService, EventManager $eventManager)
    {
        $this->productType = ucfirst($productType);
        $this->router      = $router;
        $this->response    = $response;
        $this->authService = $authService;

        // run before Core\Repository\DoctrineMongoODM\PersistenceListener
        $eventManager->attach(MvcEvent::EVENT_FINISH, [$this, 'onMvcFinish'], 200);
    }

    public function __invoke(AuthEvent $event)
    {
        if (!$this->productType) {
            return;
        }

        $productClass = '\Gastro24\Entity\Product\\' . $this->productType;

        if (!class_exists($productClass)) {
            return;
        }

        /* @var \Auth\Entity\User $user
         * @var \Gastro24\Entity\UserProduct $wrapper */
        $user    = $event->getUser();
        $wrapper = $user->createAttachedEntity(UserProduct::class);
        $product = new $productClass();
        $wrapper->setProduct($product);

        $uri = $this->router->assemble(['action' => 'edit'], ['name' => 'lang/jobs/manage', 'only_return_path' => true]);
        $this->response->setStatusCode(302);
        $this->response->getHeaders()->addHeaderLine('Location', $uri);

        $this->authService->getStorage()->write($user->getId());

        $this->user = $user;
    }

    public function onMvcFinish(MvcEvent $event)
    {
        if (!$this->user) {
            return;
        }

        /* @var \Orders\Entity\InvoiceAddressSettings $settings */
        $info = $this->user->getInfo();
        $settings = $this->user->getSettings('Orders');
        $settings->enableWriteAccess(true);
        $settings = $settings->getInvoiceAddress();

        $settings->setGender($info->getGender());
        $settings->setName($info->getDisplayName(false));
        $settings->setCompany($this->user->getOrganization()->getOrganization()->getOrganizationName()->getName());
        $settings->setStreet($info->getStreet());
        $settings->setHouseNumber($info->getHouseNumber());
        $settings->setZipCode($info->getPostalCode());
        $settings->setCity($info->getCity());
        $settings->setCountry($info->getCountry());
        $settings->setEmail($info->getEmail());

        $repos = $event->getApplication()->getServiceManager()->get('repositories');
        $repos->store($this->user);
        $repos->flush();

    }
}
