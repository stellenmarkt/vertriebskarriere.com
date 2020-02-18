<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\Validator;

use Laminas\Validator\AbstractValidator;
use Laminas\Validator\ValidatorInterface;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class IframeEmbeddableUri extends AbstractValidator
{
    const NOT_EMBEDDABLE = 'NOT_EMBEDDABLE';


    protected $messageTemplates = [
        self::NOT_EMBEDDABLE => 'URI "%value%" is not embeddable in an iframe.',
    ];

    protected $messageVariables = [
        'match' => 'match'
    ];

    protected $options = [
        'invalidUriStart' => [
            'http:',
            'https://www.adecco.ch/',
            'https://jobs.mcdonalds.ch',
            'https://www.gilde.ch/',
        ],
    ];

    protected $match = null;

    public function isValid($value)
    {
        $this->setValue($value);

        foreach ($this->options['invalidUriStart'] as $str) {
            if (0 === strpos($value, $str)) {
                $this->match = $str;
                $this->error(self::NOT_EMBEDDABLE);
                return false;
            }
        }

        return true;
    }
}
