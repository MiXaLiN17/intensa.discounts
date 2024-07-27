<?php

declare(strict_types=1);

namespace Intensa\Discounts;

use Bitrix\Sale\Discount\Formatter;

class SaleCondCtrlGroupBasketPropertyAction extends \Bitrix\Sale\Discount\Actions
{
    /**
     * Basket action.
     *
     * @param array &$order order data.
     * @param array $actionParams discount params
     *    keys are case sensitive:
     *        <ul>
     *        <li> string PROPERTY     Basket property code
     *        <li> string TYPE         Discount type (discount\extra\Closeout)
     *        <li> char UNIT           Discount type (%|value)
     *        <li> int LIMIT_VALUE     Limit
     *        </ul>.
     * @param callable $filter Filter for basket items.
     * @return void
     */
    public static function applyToBasket(array &$order, array $actionParams, $filter)
    {
        $type = $actionParams['TYPE'];

        $limitValue = (int) $actionParams['LIMIT_VALUE'];
        $unit = (string) $actionParams['UNIT'];
        $maxBound = false;

        $extra = -1;
        if ($type == \CSaleActionCtrlBasketGroup::ACTION_TYPE_EXTRA) {
            $extra = 1;
        }

        if ($type === \CSaleActionCtrlBasketGroup::ACTION_TYPE_CLOSEOUT) {
            $unit = self::VALUE_TYPE_CLOSEOUT;
            $extra = 1;
        }

        foreach ($order['BASKET_ITEMS'] as $basketCode => $basketRow) {
            if (!isset($basketRow['PROPERTIES'])) continue;
            if (!isset($basketRow['PROPERTIES'][$actionParams['PROPERTY']])) continue;

            $value = (float) $basketRow['PROPERTIES'][$actionParams['PROPERTY']]['VALUE'];

            list($discountValue, $price) = self::calculateDiscountPrice(
                $extra * $value,
                $unit,
                $basketRow,
                $limitValue,
                $maxBound
            );

            if ($price >= 0) {
                self::fillDiscountPrice($basketRow, $price, -$discountValue);

                $order['BASKET_ITEMS'][$basketCode] = $basketRow;
            }
        }
    }
}
