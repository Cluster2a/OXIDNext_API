<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace NetAdvising\OxidNext\GraphQL\Language\DataType;

use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

/**
 * @Type()
 */
final class NaLanguage
{
    /** @var string */
    public string $name;

    /** @var int */
    public int $id;

    /** @var string */
    public string $abbr;

    /** @var bool */
    public bool $selected;

    /** @var ?string */
    public ?string $url;

    public function __construct(
        int $id,
        string $name,
        string $abbr,
        bool $selected,
        ?string $url
    ) {
        $this->id   = $id;
        $this->name = $name;
        $this->abbr = $abbr;
        $this->selected = $selected;
        $this->url = $url;
    }

    /**
     * @Field()
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @Field()
     */
    public function getAbbr(): string
    {
        return $this->abbr;
    }

    /**
     * @Field()
     */
    public function getSelected(): bool
    {
        return $this->selected;
    }

    /**
     * @Field()
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @Field()
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }
}
