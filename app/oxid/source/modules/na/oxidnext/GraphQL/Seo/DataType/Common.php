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

use NetAdvising\OxidNext\GraphQL\Seo\DataType\BreadCrumbs as BreadCrumbsDataType;
use OxidEsales\GraphQL\Storefront\Category\DataType\Category;
use OxidEsales\GraphQL\Storefront\Product\DataType\Product;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

/**
 * @Type()
 */
final class Common
{
    /**
     * @var string
     */
    private string $type;

    /**
     * @var string
     */
    private string $objectid;

    /**
     * @var int
     */
    private int $lang;

    /**
     * @var Product | null
     */
    private ?Product $article;

    /**
     * @var Category | null
     */
    private ?Category $category;

    /**
     * @var BreadCrumbsDataType[]
     */
    private array $breadCrumbs;

    public function __construct(
        string    $type,
        string    $objectid,
        int       $lang,
        ?Product  $article,
        ?Category $category,
        array     $breadCrumbs
    )
    {
        $this->type = $type;
        $this->objectid = $objectid;
        $this->lang = $lang;
        $this->article = $article;
        $this->category = $category;
        $this->breadCrumbs = $breadCrumbs;
    }

    /**
     * @Field()
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @Field()
     */
    public function getId(): string
    {
        return $this->objectid;
    }

    /**
     * @Field()
     */
    public function getLang(): int
    {
        return $this->lang;
    }

    /**
     * @Field()
     */
    public function getArticle(): ?Product
    {
        return $this->article;
    }

    /**
     * @Field()
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @Field()
     * @return BreadCrumbsDataType[]
     */
    public function getBredcrumbs(): array
    {
        return $this->breadCrumbs;
    }
}
