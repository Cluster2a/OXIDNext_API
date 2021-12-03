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

namespace NetAdvising\OxidNext\GraphQL\Seo\Infrastructure;

use Doctrine\DBAL\Exception;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;

class SeoRepository
{
    private QueryBuilderFactoryInterface $queryBuilderFactory;

    public function __construct(QueryBuilderFactoryInterface $queryBuilderFactory)
    {
        $this->queryBuilderFactory = $queryBuilderFactory;
    }

    /**
     * @param string $url
     * @return array
     * @throws Exception
     */
    public function getSeoByUrl(string $url): array
    {
        $queryBuilder = $this->queryBuilderFactory->create();

        $queryBuilder
            ->select(['oxtype', 'oxobjectid', 'oxlang', 'oxparams'])
            ->from('oxseo')
            ->where($queryBuilder->expr()->or(
                $queryBuilder->expr()->eq('oxseo.oxseourl', ':url'),
                $queryBuilder->expr()->eq('oxseo.oxstdurl', ':url')
            ))
            ->setParameters([
                'url' => $url
            ]);

        return $queryBuilder->execute()->fetch();
    }
}