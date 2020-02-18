<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\Controller;

use Core\Entity\Exception\NotFoundException;
use JobsFrankfurt\Options\CompanyTemplatesMap;
use JobsFrankfurt\Session\VisitedJobsContainer;
use Laminas\Http\PhpEnvironment\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class RedirectExternalJobs extends AbstractActionController
{

    /**
     *
     *
     * @var \Gastro24\Validator\IframeEmbeddableUri
     */
    private $validator;

    /**
     *
     *
     * @var CompanyTemplatesMap
     */
    private $templatesMap;

    public function __construct(\Gastro24\Validator\IframeEmbeddableUri $validator, CompanyTemplatesMap $templatesMap)
    {
        $this->validator = $validator;
        $this->templatesMap = $templatesMap;
    }

    public function indexAction()
    {
        /* @var Response $response */
        $response = $this->getResponse();

        try {
            /* @var \Jobs\Entity\JobInterface $job */
            $job = $this->initializeJob()->get($this->params());
        } catch (NotFoundException $e) {
            /* @var Response $response */
            $response = $this->getResponse();
            $response->setStatusCode(Response::STATUS_CODE_404);
            return [
                'message' => 'Kein Job gefunden'
            ];
        }

        $appModel = $this->getEvent()->getViewModel();
        $model = new ViewModel(['job' => $job]);
        $jobTemplate = $this->templatesMap->getTemplate($job->getOrganization());
        if (!$job->getLink() || $jobTemplate) {

            $appTemplate = $appModel->getTemplate();
            $internModel = $this->forward()->dispatch('Jobs/Template', ['internal' => true, 'id' => $job->getId(), 'action' => 'view']);
            $internModel->setTemplate($jobTemplate ?: 'jobs-frankfurt/jobs/view-intern');
            $model->addChild($internModel, 'internalJob');
            $model->setVariable('isIntern', true);
            // restore application models' template
            $appModel->setTemplate($appTemplate);
        } else {
            $visitedJobsContainer = new VisitedJobsContainer();
            $isVisited            = $this->params()->fromRoute('isPreview') ? false : $visitedJobsContainer->isVisited($job);
            $isEmbeddable         = $this->validator->isValid($job->getLink());

            if (!$isVisited && !$isEmbeddable) {
                $response->getHeaders()->addHeaderLine('Refresh', '4;' . $job->getLink());
                $visitedJobsContainer->add($job);
            }
            $model->setVariables([
                'isVisited' => $isVisited,
                'isEmbeddable' => $isEmbeddable,
            ]);

        }
        $model->setTemplate('jobs-frankfurt/jobs/view-extern');

        if ($this->params()->fromRoute('isPreview')) {
            $appModel->setVariable('noHeader', true);
            $appModel->setVariable('noFooter', true);
        }

        return $model;
    }
}
