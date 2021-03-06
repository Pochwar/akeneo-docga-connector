<?php

namespace Oniti\Docga\ConnectorBundle\Factory\Value;

use Akeneo\Tool\Component\StorageUtils\Exception\InvalidPropertyTypeException;
use Akeneo\Pim\Structure\Component\AttributeTypes;
use Akeneo\Pim\Enrichment\Component\Product\Factory\Value\ValueFactoryInterface;
use Akeneo\Pim\Enrichment\Component\Product\Model\ValueInterface;
use Akeneo\Pim\Structure\Component\Model\AttributeInterface;


class DocgaValueFactory implements ValueFactoryInterface
{
    /** @var string */
    protected $productValueClass;

    /** @var string */
    protected $supportedAttributeTypes;

    /**
     * @param string $productValueClass
     * @param string $supportedAttributeTypes
     */
    public function __construct($productValueClass, $supportedAttributeTypes)
    {
        $this->productValueClass = $productValueClass;
        $this->supportedAttributeTypes = $supportedAttributeTypes;
    }

    /**
     * {@inheritdoc}
     */
    public function create(AttributeInterface $attribute, ?string $channelCode, ?string $localeCode, $data, bool $ignoreUnknownData = false) : ValueInterface
    {
        $this->checkData($attribute, $data);

        if (null !== $data) {
            $data = $this->convertData($attribute, $data);
        }

        $value = new $this->productValueClass($attribute->getCode(), $data, $channelCode, $localeCode);

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(string $attributeType) : bool
    {
        return $attributeType === $this->supportedAttributeTypes;
    }

    /**
     * @param AttributeInterface $attribute
     * @param mixed              $data
     *
     * @throws InvalidPropertyTypeException
     */
    protected function checkData(AttributeInterface $attribute, $data)
    {
        if (null === $data) {
            return;
        }
    }

    /**
     * @param AttributeInterface $attribute
     * @param mixed              $data
     *
     * @return mixed
     */
    protected function convertData(AttributeInterface $attribute, $data)
    {
        if (is_string($data) && '' === trim($data)) {
            $data = null;
        }

        if (AttributeTypes::BOOLEAN === $attribute->getType() &&
            (1 === $data || '1' === $data || 0 === $data || '0' === $data)
        ) {
            $data = boolval($data);
        }

        return $data;
    }
}
