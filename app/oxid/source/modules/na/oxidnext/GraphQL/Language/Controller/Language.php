<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace NetAdvising\OxidNext\GraphQL\Language\Controller;

use Doctrine\DBAL\Exception;
use NetAdvising\OxidNext\GraphQL\Language\DataType\NaLanguage as LanguageDataType;
use NetAdvising\OxidNext\GraphQL\Language\Service\Language as LanguageService;
use TheCodingMachine\GraphQLite\Annotations\Query;

final class Language
{
    /** @var LanguageService */
    private LanguageService $languageService;

    public function __construct(
        LanguageService $languageService
    ) {
        $this->languageService = $languageService;
    }

    /**
     * Returns a list of languages.
     *
     * @Query
     *
     * @param int $langId
     * @param string $url
     * @return LanguageDataType[]
     * @throws Exception
     */
    public function languages(int $langId, string $url): array {
        $url = htmlspecialchars($url);

        if($url === '/' || empty($url) === true) {
            $url = 'index.php?cl=start';
        }

        return $this->languageService->languages($langId, $url);
    }
}
