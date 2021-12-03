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

namespace NetAdvising\OxidNext\GraphQL\Seo\Service;

use Doctrine\DBAL\Exception;
use NetAdvising\OxidNext\GraphQL\Seo\DataType\Common as CommonDataType;
use NetAdvising\OxidNext\GraphQL\Seo\Infrastructure\SeoRepository;
use OxidEsales\Eshop\Application\Model\Article;
use OxidEsales\Eshop\Application\Model\Category;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\GraphQL\Storefront\Product\DataType\Product as ProductDataType;
use OxidEsales\GraphQL\Storefront\Category\DataType\Category as CategoryDataType;

final class Seo
{
    /** @var SeoRepository */
    private SeoRepository $seoRepository;

    public function __construct(
        SeoRepository $seoRepository
    ) {
        $this->seoRepository = $seoRepository;
    }

    /**
     * @param string $url
     * @return CommonDataType
     * @throws Exception
     */
    public function getObjectByUrl(string $url): CommonDataType
    {
        $seoObject = $this->seoRepository->getSeoByUrl($url);

        $langId = $seoObject['oxlang'];
        if(empty($langId) === true) {
            $langId = 0;
        }

        $languageService = Registry::getLang();
        $languageService->setBaseLanguage($langId);

        switch ($seoObject['oxtype']) {
            case 'oxarticle':
                $article = oxNew(Article::class);
                $article->loadInLang($langId, $seoObject['oxobjectid']);

                $articleDataType = new ProductDataType($article);

                return new CommonDataType(
                    $seoObject['oxtype'],
                    $seoObject['oxobjectid'],
                    (int) $seoObject['oxlang'],
                    $articleDataType,
                    null
                );
            case 'oxcategory':
                $category = oxNew(Category::class);
                $category->loadInLang($langId, $seoObject['oxobjectid']);

                $categoryDataType = new CategoryDataType($category);

                return new CommonDataType(
                    $seoObject['oxtype'],
                    $seoObject['oxobjectid'],
                    (int) $seoObject['oxlang'],
                    null,
                    $categoryDataType
                );
            case 'oxcontent':
            case 'dynamic':
            case 'static':
                return new CommonDataType(
                    $seoObject['oxtype'],
                    $seoObject['oxobjectid'],
                    (int) $seoObject['oxlang'],
                    null,
                    null
                );

        }
    }
}
