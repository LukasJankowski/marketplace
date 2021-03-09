<?php

namespace Marketplace\Core\Data\Customer\ValueObjects;

class CustomerType
{
    /**
     * @const string[]
     */
    public const TYPES = [
        'marketplace.core.data.field.customer_type.b2b',
        'marketplace.core.data.field.customer_type.b2c',
    ];

    /**
     * CustomerType constructor.
     *
     * @param string $customerType
     */
    private function __construct(private string $customerType) {}

    /**
     * Create a new instance of self.
     *
     * @param string $customerType
     *
     * @return self
     *
     * @throws \InvalidArgumentException
     */
    public static function make(string $customerType): self
    {
        if (!in_array($customerType, self::TYPES, true)) {
            throw new \InvalidArgumentException(
                sprintf('Unknown customer type: %s', $customerType)
            );
        }

        return new self($customerType);
    }

    /**
     * Getter.
     *
     * @return string
     */
    public function getCustomerType(): string
    {
        return $this->customerType;
    }
}
