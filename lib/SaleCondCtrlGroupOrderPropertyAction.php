<?php

declare(strict_types=1);

namespace Intensa\Discounts;

class SaleCondCtrlGroupOrderPropertyAction extends \Bitrix\Sale\Discount\Actions
{
    /**
     * Basket action.
     *
     * @param array &$order Order data.
     * @param array $actionParams Action detail
     *    keys are case sensitive:
     *        <ul>
     *        <li>float|int VALUE                Discount value.
     *        <li>char UNIT                    Discount type.
     *        <li>string CURRENCY                Currency discount (optional).
     *        <li>char MAX_BOUND                Max bound (optional).
     *        </ul>.
     * @param callable $filter Filter for basket items.
     * @return void
     */
    public static function applyToBasket(array &$order, array $actionParams, $filter)
    {
        if (empty($actionParams['PROPERTY'])) {
            return;
        }

        $personTypeId = (int)$order['PERSON_TYPE_ID'];

        if (!$personTypeId) {
            return;
        }

        $propertyId = self::getProperty($personTypeId, $actionParams['PROPERTY']);

        if (!$propertyId) {
            return;
        }

        $value = $order['ORDER_PROP']
            ? ($order['ORDER_PROP'][$propertyId] ? (float)$order['ORDER_PROP'][$propertyId] : 0)
            : 0;

        if ($value === 0) {
            return;
        }

        if ($actionParams['UNIT'] === static::VALUE_TYPE_SUMM && $value > $order['ORDER_PRICE']) {
            $value = $order['ORDER_PRICE'];
        }

        if ($actionParams['UNIT'] === static::VALUE_TYPE_PERCENT && $value > 100) {
            $value = 100;
        }

        $action['VALUE'] = -1 * $value;
        $action['UNIT'] = $actionParams['UNIT'];
        $action['LIMIT_VALUE'] = $actionParams['LIMIT_VALUE'];
        $action['CURRENCY'] = static::getCurrency();

        parent::applyToBasket($order, $action, $filter);
    }

    private static function getProperty($personTypeId, $propertyCode)
    {
        $iterator = \Bitrix\Sale\Internals\OrderPropsTable::getList([
            'select' => ['ID', 'CODE', 'PERSON_TYPE_ID'],
            'filter' => [
                'PERSON_TYPE_ID' => $personTypeId,
                'CODE' => $propertyCode,
                'ACTIVE' => 'Y'
            ],
        ]);

        if ($res = $iterator->fetch()) {
            return (int)$res['ID'];
        }

        return false;
    }
}