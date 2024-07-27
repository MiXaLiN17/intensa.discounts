<?php

declare(strict_types=1);

namespace Intensa\Discounts;

use Bitrix\Main\Localization\Loc;
use Bitrix\Sale\Discount\Actions;

class SaleCondCtrlGroupBasketProperty extends \CSaleActionCtrlBasketGroup
{
    public static function GetClassName()
    {
        return __CLASS__;
    }

    public static function GetControlID()
    {
        return 'SaleCondCtrlGroupBasketProperty';
    }

    public static function GetControlDescr()
    {
        $description = parent::GetControlDescr();
        $description['SORT'] = 60;

        return $description;
    }

    public static function GetAtoms()
    {
        return static::GetAtomsEx(false, false);
    }

    /**
     * @param $arParams
     * @return array
     */
    public static function GetControlShow($arParams)
    {
        $arAtoms = static::GetAtomsEx(false, false);
        $boolCurrency = false;
        if (static::$boolInit) {
            if (isset(static::$arInitParams['CURRENCY'])) {
                $arAtoms['Unit']['values'][self::VALUE_UNIT_CURRENCY] = str_replace(
                    '#CUR#',
                    static::$arInitParams['CURRENCY'],
                    $arAtoms['Unit']['values'][self::VALUE_UNIT_CURRENCY]
                );
                $boolCurrency = true;
            } elseif (isset(static::$arInitParams['SITE_ID'])) {
                $strCurrency = \Bitrix\Sale\Internals\SiteCurrencyTable::getSiteCurrency(static::$arInitParams['SITE_ID']);
                if (!empty($strCurrency)) {
                    $arAtoms['Unit']['values'][self::VALUE_UNIT_CURRENCY] = str_replace(
                        '#CUR#',
                        $strCurrency,
                        $arAtoms['Unit']['values'][self::VALUE_UNIT_CURRENCY]
                    );

                    $boolCurrency = true;
                }
            }
        }

        if (!$boolCurrency) {
            unset($arAtoms['Unit']['values'][self::VALUE_UNIT_CURRENCY]);
        }

        return [
            'controlId' => static::GetControlID(),
            'group' => false,
            'label' => Loc::getMessage('INTENSA_DISCOUNTS_SALE_ACT_GROUP_BASKET_PROPERTY_LABEL'),
            'defaultText' => Loc::getMessage('INTENSA_DISCOUNTS_SALE_ACT_GROUP_BASKET_PROPERTY_DEF_TEXT'),
            'showIn' => static::GetShowIn($arParams['SHOW_IN_GROUPS']),
            'visual' => static::GetVisual(),
            'control' => [
                Loc::getMessage('INTENSA_DISCOUNTS_SALE_ACT_GROUP_BASKET_PROPERTY_PREFIX'),
                $arAtoms['Type'],
                Loc::getMessage('INTENSA_DISCOUNTS_SALE_ACT_GROUP_BASKET_PROPERTY_POSTFIX'),
                $arAtoms['Property'],
                $arAtoms['Unit'],
                Loc::getMessage('INTENSA_DISCOUNTS_SALE_ACT_MAX_DISCOUNT_GROUP_BASKET_PROPERTY_DESCR'),
                $arAtoms['Max']
            ]
        ];
    }

    /**
     *
     * @param $strControlID
     * @param $boolEx
     * @return \array[][]|array[]
     */
    public static function GetAtomsEx($strControlID = false, $boolEx = false)
    {
        $boolEx = (true === $boolEx ? true : false);

        $arAtomList = [
            'Type' => array(
                'JS' => array(
                    'id' => 'Type',
                    'name' => 'extra',
                    'type' => 'select',
                    'values' => array(
                        self::ACTION_TYPE_DISCOUNT => Loc::getMessage('INTENSA_DISCOUNTS_SALE_ACT_GROUP_BASKET_PROPERTY_SELECT_TYPE_DISCOUNT'),
                        self::ACTION_TYPE_EXTRA => Loc::getMessage('INTENSA_DISCOUNTS_SALE_ACT_GROUP_BASKET_PROPERTY_SELECT_TYPE_EXTRA'),
                        self::ACTION_TYPE_CLOSEOUT => Loc::getMessage('INTENSA_DISCOUNTS_SALE_ACT_GROUP_BASKET_PROPERTY_SELECT_TYPE_CLOSEOUT_EXT')
                    ),
                    'defaultText' => Loc::getMessage('BT_SALE_ACT_GROUP_BASKET_SELECT_TYPE_DEF'),
                    'defaultValue' => self::ACTION_TYPE_DISCOUNT,
                    'first_option' => '...'
                ),
                'ATOM' => array(
                    'ID' => 'Type',
                    'FIELD_TYPE' => 'string',
                    'FIELD_LENGTH' => 255,
                    'MULTIPLE' => 'N',
                    'VALIDATE' => 'list'
                )
            ),
            'Property' => [
                'JS' => [
                    'id' => 'Property',
                    'name' => 'extra_size',
                    'type' => 'input'
                ],
                'ATOM' => [
                    'ID' => 'Property',
                    'FIELD_TYPE' => 'string',
                    'MULTIPLE' => 'N',
                    'VALIDATE' => ''
                ]
            ],
            'Unit' => [
                'JS' => [
                    'id' => 'Unit',
                    'name' => 'extra_unit',
                    'type' => 'select',
                    'values' => [
                        self::VALUE_UNIT_CURRENCY => Loc::getMessage('INTENSA_DISCOUNTS_SALE_ACT_GROUP_BASKET_PROPERTY_SELECT_CUR_EACH'),
                        self::VALUE_UNIT_PERCENT => Loc::getMessage('INTENSA_DISCOUNTS_SALE_ACT_GROUP_BASKET_PROPERTY_SELECT_PERCENT')
                    ],
                    'defaultText' => Loc::getMessage('INTENSA_DISCOUNTS_SALE_ACT_GROUP_BASKET_PROPERTY_SELECT_UNIT_DEF'),
                    'defaultValue' => self::VALUE_UNIT_CURRENCY,
                    'first_option' => '...'
                ],
                'ATOM' => [
                    'ID' => 'Unit',
                    'FIELD_TYPE' => 'string',
                    'FIELD_LENGTH' => 255,
                    'MULTIPLE' => 'N',
                    'VALIDATE' => 'list'
                ]
            ],
            'Max' => [
                'JS' => [
                    'id' => 'Max',
                    'name' => 'max_value',
                    'type' => 'input',
                ],
                'ATOM' => [
                    'ID' => 'Max',
                    'FIELD_TYPE' => 'int',
                    'MULTIPLE' => 'N',
                    'VALIDATE' => ''
                ]
            ]/*,
            'All' => [
                'JS' => [
                    'id' => 'All',
                    'name' => 'aggregator',
                    'type' => 'select',
                    'values' => [
                        'AND' => Loc::getMessage('INTENSA_DISCOUNTS_SALE_ACT_GROUP_BASKET_PROPERTY_SELECT_ALL_EXT'),
                        'OR' => Loc::getMessage('INTENSA_DISCOUNTS_SALE_ACT_GROUP_BASKET_PROPERTY_SELECT_ANY_EXT')
                    ],
                    'defaultText' => Loc::getMessage('INTENSA_DISCOUNTS_SALE_ACT_GROUP_BASKET_PROPERTY_SELECT_DEF'),
                    'defaultValue' => 'AND',
                    'first_option' => '...'
                ],
                'ATOM' => [
                    'ID' => 'All',
                    'FIELD_TYPE' => 'string',
                    'FIELD_LENGTH' => 255,
                    'MULTIPLE' => 'N',
                    'VALIDATE' => 'list'
                ]
            ],
            'True' => [
                'JS' => [
                    'id' => 'True',
                    'name' => 'value',
                    'type' => 'select',
                    'values' => [
                        'True' => Loc::getMessage('INTENSA_DISCOUNTS_SALE_ACT_GROUP_BASKET_PROPERTY_SELECT_TRUE'),
                        'False' => Loc::getMessage('INTENSA_DISCOUNTS_SALE_ACT_GROUP_BASKET_PROPERTY_SELECT_FALSE')
                    ],
                    'defaultText' => Loc::getMessage('INTENSA_DISCOUNTS_CLOBAL_COND_GROUP_SELECT_DEF'),
                    'defaultValue' => 'True',
                    'first_option' => '...'
                ],
                'ATOM' => [
                    'ID' => 'True',
                    'FIELD_TYPE' => 'string',
                    'FIELD_LENGTH' => 255,
                    'MULTIPLE' => 'N',
                    'VALIDATE' => 'list'
                ]
            ]*/
        ];

        if (!$boolEx) {
            foreach ($arAtomList as &$arOneAtom) {
                $arOneAtom = $arOneAtom['JS'];
            }

            unset($arOneAtom);
        }

        return $arAtomList;
    }

    private static function startGenerate()
    {
        return 'if (\Bitrix\Main\Loader::includeModule("intensa.discounts")) { ';
    }

    public static function Generate($arOneCondition, $arParams, $arControl, $arSubs = false)
    {
        $boolError = false;

        foreach (static::GetAtomsEx(false, false) as $atom) {
            if (!isset($arOneCondition[$atom['id']])) {
                $boolError = true;
            }
        }
        unset($atom);

        if (!isset($arSubs) || !is_array($arSubs)) {
            $boolError = true;
        }

        $type = '';
        if (!$boolError) {
            switch ($arOneCondition['Type']) {
                case self::ACTION_TYPE_DISCOUNT:
                    $type = self::ACTION_TYPE_DISCOUNT;
                    break;
                case self::ACTION_TYPE_EXTRA:
                    $type = self::ACTION_TYPE_EXTRA;
                    break;
                case self::ACTION_TYPE_CLOSEOUT:
                    $type = self::ACTION_TYPE_CLOSEOUT;
                    break;
                default:
                    $boolError = true;
                    break;
            }
        }

        $unit = '';
        if (!$boolError) {
            switch ($arOneCondition['Unit']) {
                case self::VALUE_UNIT_PERCENT:
                    $unit = Actions::VALUE_TYPE_PERCENT;
                    break;
                case self::VALUE_UNIT_CURRENCY:
                    $unit = Actions::VALUE_TYPE_FIX;
                    break;
                default:
                    $boolError = true;
                    break;
            }
        }

        if (empty($arOneCondition['Property'])) {
            $boolError = true;
        }

        if ($type === self::ACTION_TYPE_CLOSEOUT && $unit === Actions::VALUE_TYPE_PERCENT) {
            $boolError = true;
        }

        if ($boolError) {
            return false;
        }

        $actionParams = [
            'PROPERTY' => (string) $arOneCondition['Property'],
            'TYPE' => $type,
            'UNIT' => $unit,
            'LIMIT_VALUE' => $arOneCondition['Max'] ? (int)$arOneCondition['Max'] : 0,
        ];

        $mxResult = self::startGenerate()
            . '\\'. __NAMESPACE__ . '\\SaleCondCtrlGroupBasketPropertyAction::applyToBasket('
            . $arParams['ORDER'] . ', '
            . var_export($actionParams, true)
            . ', "");'
            . self::endGenerate()
        ;
        unset($actionParams, $unit, $type);

        $result = [
            'COND' => $mxResult,
        ];

        return $result;
    }

    private static function endGenerate()
    {
        return '}';
    }
}