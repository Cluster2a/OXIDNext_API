<?php

/**
 * This Software is the property of ESYON and is protected by copyright law - it is NOT Freeware.
 * Any unauthorized use of this software without a valid license is a violation of the license agreement and will be
 * prosecuted by civil and criminal law.
 *
 * @copyright      (C) netAdvising GmbH
 * @since              Version 1.0
 * @author             Alexander Hirschfeld <info@netadvising.de>
 * @link               https://www.netadvising.de
 */

declare(strict_types=1);

namespace NetAdvising\OxidNext\GraphQL\Seo\DataType;

use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

/**
 * @Type()
 */
final class BreadCrumbs
{
    /**
     * @var string
     */
    private string $link;

    /**
     * @var string
     */
    private string $title;

    public function __construct(
        string $link,
        string $title
    )
    {
        $this->link = $link;
        $this->title = $title;
    }

    /**
     * @Field()
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @Field()
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}
