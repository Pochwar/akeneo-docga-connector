<?php

namespace Oniti\Docga\ConnectorBundle\Validator\ConstraintGuesser;

use Oniti\Docga\ConnectorBundle\AttributeType\ExtendedAttributeTypes;
use Pim\Component\Catalog\Model\AttributeInterface;
use Pim\Component\Catalog\Validator\ConstraintGuesser\UrlGuesser as PimUrlGuesser;

/**
 * Url guesser
 *
 * @author    JM Leroux <jean-marie.leroux@akeneo.com>
 * @copyright 2017 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class UrlGuesser extends PimUrlGuesser
{
    /**
     * {@inheritdoc}
     */
    public function supportAttribute(AttributeInterface $attribute)
    {
        return ExtendedAttributeTypes::DOCGA === $attribute->getType();
    }
}