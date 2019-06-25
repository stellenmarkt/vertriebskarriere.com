<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2016 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\Listener;

use Core\Entity\Collection\ArrayCollection;
use Core\Entity\Hydrator\EntityHydrator;
use JobsFrankfurt\Entity\UserProduct;
use Jobs\Listener\Events\JobEvent;
use Orders\Entity\Order;
use Orders\Entity\OrderInterface;
use Orders\Entity\Product;
use Orders\Entity\Snapshot\Job\Builder;
use Orders\Entity\InvoiceAddress;
use Zend\Session\Container;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class CreateJobOrder 
{
    /**
     *
     *
     * @var \Orders\Options\ModuleOptions
     */
    protected $options;

    /**
     *
     *
     * @var \Jobs\Options\ProviderOptions
     */
    protected $providerOptions;
    /**
     *
     *
     * @var \Zend\Filter\FilterInterface
     */
    protected $priceFilter;

    /**
     *
     *
     * @var \Orders\Repository\Orders
     */
    protected $orderRepository;

    protected $draftRepository;

    public function __construct($options, $providerOptions, $priceFilter, $orderRepository, $invoiceAddress)
    {
        $this->priceFilter     = $priceFilter;
        $this->options         = $options;
        $this->providerOptions = $providerOptions;
        $this->orderRepository      = $orderRepository;
        $this->invoiceAddress = $invoiceAddress;
    }

    public function __invoke(JobEvent $event)
    {
        $job = $event->getJobEntity();


        $invoiceAddress = $this->invoiceAddress;
        $snapshotBuilder = new Builder();
        $snapshot = $snapshotBuilder->build($job);
        $products = new ArrayCollection();

        $org = $job->getOrganization()->isHiringOrganization() ? $job->getOrganization()->getParent() : $job->getOrganization();
        $user = $org->getUser();
        $productWrapper = $user->getAttachedEntity(UserProduct::class);

        if ($productWrapper) {

            $userProduct = $productWrapper->getProduct();
            $product     = new Product();

            $product->setName(str_replace('Gastro24\Entity\Product\\', '', get_class($userProduct)))
                    ->setQuantity(1);

            $products->add($product);
        }

        $data = [
            'type' => OrderInterface::TYPE_JOB,
            'taxRate' => $this->options->getTaxRate(),
            'price' => $this->priceFilter->filter($job->getPortals()), // must come after tax rate!
            'invoiceAddress' => $invoiceAddress,
            'currency' => $this->options->getCurrency(),
            'currencySymbol' => $this->options->getCurrencySymbol(),
            'entity' => $snapshot,
            'products' => $products,
        ];

        $order = $this->orderRepository->create($data);
        $this->orderRepository->store($order);
    }
}
