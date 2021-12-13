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

use OxidEsales\GraphQL\Base\Framework\PermissionProviderInterface;

final class PermissionProvider implements PermissionProviderInterface
{
    public function getPermissions(): array
    {
        return [
            'oxidadmin' => [
                'VIEW_INACTIVE_ACTION',
                'VIEW_INACTIVE_ATTRIBUTE',
                'VIEW_INACTIVE_BANNER',
                'VIEW_INACTIVE_CATEGORY',
                'VIEW_INACTIVE_CONTENT',
                'VIEW_ALL_CUSTOMERS',
                'VIEW_INACTIVE_LINK',
                'VIEW_INACTIVE_MANUFACTURER',
                'VIEW_INACTIVE_PRODUCT',
                'VIEW_INACTIVE_PROMOTION',
                'VIEW_INACTIVE_REVIEW',
                'VIEW_INACTIVE_VENDOR',
                'VIEW_USER',
                'VIEW_WISHED_PRICES',
                'DELETE_WISHED_PRICE',
                'VIEW_RATINGS',
                'DELETE_RATING',
                'DELETE_REVIEW',
                'VIEW_INACTIVE_COUNTRY',
                'DELETE_DELIVERY_ADDRESS',
                'DELETE_BASKET',
                'CREATE_BASKET',
                'VIEW_BASKET',
                'ADD_PRODUCT_TO_BASKET',
                'REMOVE_BASKET_PRODUCT',
                'ADD_VOUCHER',
                'REMOVE_VOUCHER',
                'PLACE_ORDER',
            ],
            'oxidnotyetordered' => [
                'CREATE_BASKET',
                'VIEW_BASKET',
                'ADD_PRODUCT_TO_BASKET',
                'REMOVE_BASKET_PRODUCT',
                'ADD_VOUCHER',
                'REMOVE_VOUCHER',
                'PLACE_ORDER',
            ],
            'oxidcustomer' => [
                'CREATE_BASKET',
                'VIEW_BASKET',
                'ADD_PRODUCT_TO_BASKET',
                'REMOVE_BASKET_PRODUCT',
                'ADD_VOUCHER',
                'REMOVE_VOUCHER',
                'PLACE_ORDER',
            ],
            'oxidanonymous' => [
                'CREATE_BASKET',
                'ADD_PRODUCT_TO_BASKET',
                'REMOVE_BASKET_PRODUCT',
                'ADD_VOUCHER',
                'REMOVE_VOUCHER',
                'PLACE_ORDER',
                '3RDPARTY_EXPRESS_APPROVAL'
            ],
        ];
    }
}
