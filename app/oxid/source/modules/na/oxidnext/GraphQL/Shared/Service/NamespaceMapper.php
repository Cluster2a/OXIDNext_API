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

namespace NetAdvising\OxidNext\GraphQL\Shared\Service;

use OxidEsales\GraphQL\Base\Framework\NamespaceMapperInterface;

final class NamespaceMapper implements NamespaceMapperInterface
{
    public function getControllerNamespaceMapping(): array
    {
        return [
            '\\NetAdvising\\OxidNext\\GraphQL\\Category\\Controller' => __DIR__ . '/../../Category/Controller/',
            '\\NetAdvising\\OxidNext\\GraphQL\\Seo\\Controller' => __DIR__ . '/../../Seo/Controller/',
            '\\NetAdvising\\OxidNext\\GraphQL\\Language\\Controller' => __DIR__ . '/../../Language/Controller/',
        ];
    }

    public function getTypeNamespaceMapping(): array
    {
        return [
            '\\NetAdvising\\OxidNext\\GraphQL\\Category\\Service' => __DIR__ . '/../../Category/Service/',
            '\\NetAdvising\\OxidNext\\GraphQL\\Category\\DataType' => __DIR__ . '/../../Category/DataType/',

            '\\NetAdvising\\OxidNext\\GraphQL\\Product\\Service' => __DIR__ . '/../../Product/Service/',
            '\\NetAdvising\\OxidNext\\GraphQL\\Product\\DataType' => __DIR__ . '/../../Product/DataType/',

            '\\NetAdvising\\OxidNext\\GraphQL\\Language\\Service' => __DIR__ . '/../../Language/Service/',
            '\\NetAdvising\\OxidNext\\GraphQL\\Language\\DataType' => __DIR__ . '/../../Language/DataType/',

            '\\NetAdvising\\OxidNext\\GraphQL\\Seo\\Service' => __DIR__ . '/../../Seo/Service/',
            '\\NetAdvising\\OxidNext\\GraphQL\\Seo\\DataType' => __DIR__ . '/../../Seo/DataType/',
        ];
    }
}
