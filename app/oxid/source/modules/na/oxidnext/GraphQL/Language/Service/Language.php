<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace NetAdvising\OxidNext\GraphQL\Language\Service;

use Doctrine\DBAL\Exception;
use NetAdvising\OxidNext\GraphQL\Language\DataType\NaLanguage as LanguageDataType;
use NetAdvising\OxidNext\GraphQL\Language\Infrastructure\Language as LanguageRepository;

final class Language
{
    /** @var LanguageRepository */
    private LanguageRepository $languageRepository;

    public function __construct(
        LanguageRepository $languageRepository
    ) {
        $this->languageRepository = $languageRepository;
    }

    /**
     * @param int $langId
     * @param string $url
     * @return LanguageDataType[]
     * @throws Exception
     */
    public function languages(int $langId, string $url): array
    {
        $languages = $this->languageRepository->getLanguages($langId, $url);
        $result = [];
        foreach ($languages as $language) {
            $result[] = new LanguageDataType(
                $language->id,
                $language->name,
                $language->abbr,
                (bool) $language->selected,
                $language->url
            );
        }

        return $result;
    }
}
