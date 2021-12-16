<?php

/**
 * This Software is the property of netAdvising and is protected by copyright law - it is NOT Freeware.
 * Any unauthorized use of this software without a valid license is a violation of the license agreement and will be
 * prosecuted by civil and criminal law.
 *
 * @copyright      (C) netAdvising GmbH
 * @since              Version 1.0
 * @author             Alexander Hirschfeld <info@netadvising.de>
 * @link               https://www.netadvising.de
 */

declare(strict_types=1);

namespace NetAdvising\OxidNext\GraphQL\Category\DataType;

use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

/**
 * @Type()
 */
final class CategorySubTree
{
    /** @var string */
    public string $title = "";

    /** @var string */
    public string $id = "";

    /** @var string */
    public string $link = "";

    public function __construct(
        string $id,
        string $title,
        string $link
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->link = $link;
    }

    /**
     * @Field()
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @Field()
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @Field()
     */
    public function getLink(): string
    {
        return $this->link;
    }
}
