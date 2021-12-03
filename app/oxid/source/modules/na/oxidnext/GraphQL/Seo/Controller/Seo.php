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

namespace NetAdvising\OxidNext\GraphQL\Seo\Controller;

use Doctrine\DBAL\Exception;
use NetAdvising\OxidNext\GraphQL\Seo\DataType\Common as CommonDataType;
use NetAdvising\OxidNext\GraphQL\Seo\Service\Seo as SeoService;

use TheCodingMachine\GraphQLite\Annotations\Query;

final class Seo
{
    /**
     * @var SeoService
     */
    private SeoService $seoService;

    public function __construct(
        SeoService $seoService
    ) {
        $this->seoService = $seoService;
    }

    /**
     * Returns the object of a seo url.
     *
     * @Query
     *
     * @param string $url
     * @return CommonDataType
     * @throws Exception
     */
    public function objectBySeoUrl(string $url): CommonDataType
    {
        $url = htmlspecialchars($url);

        if($url === '/' || empty($url) === true) {
            $url = 'index.php?cl=start';
        }

        return $this->seoService->getObjectByUrl($url);
    }
}
