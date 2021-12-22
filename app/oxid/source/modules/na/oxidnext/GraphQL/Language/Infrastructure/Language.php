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

namespace NetAdvising\OxidNext\GraphQL\Language\Infrastructure;

use Doctrine\DBAL\Exception;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use function getViewName;

/**
 *
 */
final class Language
{
    /** @var QueryBuilderFactoryInterface */
    private QueryBuilderFactoryInterface $queryBuilderFactory;

    public function __construct(
        QueryBuilderFactoryInterface $queryBuilderFactory
    )
    {
        $this->queryBuilderFactory = $queryBuilderFactory;
    }

    /**
     * @param int $langId
     * @param string $url
     * @return array
     * @throws Exception
     */
    public function getLanguages(int $langId, string $url): array
    {
        // set language
        $languageService = Registry::getLang();
        $languageService->setBaseLanguage($langId);

        // get all seo links
        $queryBuilder = $this->queryBuilderFactory->create();
        $queryBuilder->select('oxobjectid')
            ->from('oxseo', 'seo')
            ->where('seo.oxlang = :langId')
            ->andWhere($queryBuilder->expr()->or(
                $queryBuilder->expr()->eq('seo.oxseourl', ':url'),
                $queryBuilder->expr()->eq('seo.oxstdurl', ':url')
            ))
            ->orderBy('seo.oxlang')
            ->setParameters([
                ':langId' => $langId,
                ':url' => $url,
            ]);


        $languages = $languageService->getLanguageArray();
        $objectId = $queryBuilder->execute()->fetchColumn();

        $queryBuilder = $this->queryBuilderFactory->create();

        $queryBuilder->select(['oxseo.oxlang as languageId', 'oxseo.oxseourl as url'])
            ->from('oxseo', 'oxseo')
            ->where('oxseo.oxobjectid = :oxobjectId')
            ->orWhere('oxseo.oxstdurl = :url')
            ->orderBy('oxseo.oxlang')
            ->setParameters([
                ':oxobjectId' => $objectId,
                ':url' => $url,
            ]);

        $seoUrl = $queryBuilder->execute()->fetchAll();

        foreach ($languages as $language) {
            $language->url = $seoUrl[$language->id]['url'];
        }

        return $languages;
    }
}
