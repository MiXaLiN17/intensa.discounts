<?php

declare(strict_types=1);

namespace Intensa\Discounts;

use Bitrix\Main\Localization\Loc;

class SaleCondCtrlGroupOrderProperty extends \CSaleActionCtrlBasketGroup
{
    public static function GetClassName()
    {
        return __CLASS__;
    }

    public static function GetControlID()
    {
        return 'SaleCondCtrlGroupOrderPropertyAction';
    }

    public static function GetControlDescr()
    {
        $description = parent::GetControlDescr();
        $description['SORT'] = 50;

        return $description;
    }

    public static function GetAtoms()
    {
        return static::GetAtomsEx(false, false);
    }

    /**
     * метод закончен
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
                $arAtoms['Unit']['values'][self::VALUE_UNIT_SUMM] = str_replace(
                    '#CUR#',
                    static::$arInitParams['CURRENCY'],
                    $arAtoms['Unit']['values'][self::VALUE_UNIT_SUMM]
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

                    $arAtoms['Unit']['values'][self::VALUE_UNIT_SUMM] = str_replace(
                        '#CUR#',
                        $strCurrency,
                        $arAtoms['Unit']['values'][self::VALUE_UNIT_SUMM]
                    );

                    $boolCurrency = true;
                }
            }
        }

        if (!$boolCurrency) {
            unset($arAtoms['Unit']['values'][self::VALUE_UNIT_CURRENCY]);
            unset($arAtoms['Unit']['values'][self::VALUE_UNIT_SUMM]);
        }

        return [
            'controlId' => static::GetControlID(),
            'group' => true,
            'label' => Loc::getMessage('INTENSA_DISCOUNTS_SALE_ACT_GROUP_BASKET_LABEL'),
            'defaultText' => Loc::getMessage('INTENSA_DISCOUNTS_SALE_ACT_GROUP_BASKET_DEF_TEXT'),
            'showIn' => static::GetShowIn($arParams['SHOW_IN_GROUPS']),
            'visual' => static::GetVisual(),
            'control' => [
                Loc::getMessage('INTENSA_DISCOUNTS_SALE_ACT_GROUP_BASKET_PREFIX'),
                $arAtoms['Property'],
                $arAtoms['Unit'],
                Loc::getMessage('INTENSA_DISCOUNTS_SALE_ACT_MAX_DISCOUNT_GROUP_BASKET_DESCR'),
                $arAtoms['Max'],
                Loc::getMessage('INTENSA_DISCOUNTS_SALE_ACT_GROUP_BASKET_DESCR_EXT'),
                $arAtoms['All'],
                $arAtoms['True']
            ],
            'mess' => [
                'ADD_CONTROL' => Loc::getMessage('INTENSA_DISCOUNTS_SALE_SUBACT_ADD_CONTROL'),
                'SELECT_CONTROL' => Loc::getMessage('INTENSA_DISCOUNTS_SALE_SUBACT_SELECT_CONTROL'),
                'DELETE_CONTROL' => Loc::getMessage('INTENSA_DISCOUNTS_SALE_ACT_GROUP_DELETE_CONTROL')
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
                        self::VALUE_UNIT_PERCENT => Loc::getMessage('INTENSA_DISCOUNTS_SALE_ACT_GROUP_BASKET_SELECT_PERCENT'),
                        self::VALUE_UNIT_CURRENCY => Loc::getMessage('INTENSA_DISCOUNTS_SALE_ACT_GROUP_BASKET_SELECT_CUR_EACH'),
                        self::VALUE_UNIT_SUMM => Loc::getMessage('INTENSA_DISCOUNTS_SALE_ACT_GROUP_BASKET_SELECT_CUR_ALL')
                    ],
                    'defaultText' => Loc::getMessage('INTENSA_DISCOUNTS_SALE_ACT_GROUP_BASKET_SELECT_UNIT_DEF'),
                    'defaultValue' => self::VALUE_UNIT_SUMM,
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
            ],
            'All' => [
                'JS' => [
                    'id' => 'All',
                    'name' => 'aggregator',
                    'type' => 'select',
                    'values' => [
                        'AND' => Loc::getMessage('INTENSA_DISCOUNTS_SALE_ACT_GROUP_BASKET_SELECT_ALL_EXT'),
                        'OR' => Loc::getMessage('INTENSA_DISCOUNTS_SALE_ACT_GROUP_BASKET_SELECT_ANY_EXT')
                    ],
                    'defaultText' => Loc::getMessage('INTENSA_DISCOUNTS_SALE_ACT_GROUP_BASKET_SELECT_DEF'),
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
                        'True' => Loc::getMessage('INTENSA_DISCOUNTS_SALE_ACT_GROUP_BASKET_SELECT_TRUE'),
                        'False' => Loc::getMessage('INTENSA_DISCOUNTS_SALE_ACT_GROUP_BASKET_SELECT_FALSE')
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
            ]
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
        $mxResult = '';
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

        $unit = '';
        if (!$boolError) {
            switch ($arOneCondition['Unit']) {
                case self::VALUE_UNIT_PERCENT:
                    $unit = \Bitrix\Sale\Discount\Actions::VALUE_TYPE_PERCENT;
                    break;
                case self::VALUE_UNIT_CURRENCY:
                    $unit = \Bitrix\Sale\Discount\Actions::VALUE_TYPE_FIX;
                    break;
                case self::VALUE_UNIT_SUMM:
                    $unit = \Bitrix\Sale\Discount\Actions::VALUE_TYPE_SUMM;
                    break;
                default:
                    $boolError = true;
                    break;
            }
        }

        if (empty($arOneCondition['Property'])) {
            $boolError = true;
        }

        $actionParams = [];
        if (!$boolError) {
            $actionParams = [
                'PROPERTY' => (string)$arOneCondition['Property'],
                'UNIT' => $unit,
                'LIMIT_VALUE' => $arOneCondition['Max'] ? (int)$arOneCondition['Max'] : 0,
            ];
        }

        if (!$boolError) {
            if (!empty($arSubs)) {
                $filter = '$saleact'.$arParams['FUNC_ID'];

                if ($arOneCondition['All'] == 'AND') {
                    $prefix = '';
                    $logic = ' && ';
                    $itemPrefix = ($arOneCondition['True'] == 'True' ? '' : '!');
                } else {
                    $itemPrefix = '';
                    if ($arOneCondition['True'] == 'True') {
                        $prefix = '';
                        $logic = ' || ';
                    } else {
                        $prefix = '!';
                        $logic = ' && ';
                    }
                }

                $commandLine = $itemPrefix . implode($logic . $itemPrefix, $arSubs);

                if ($prefix != '') {
                    $commandLine = $prefix.'('.$commandLine.')';
                }

                $mxResult = self::startGenerate();
                $mxResult .= $filter.'=function($row){';
                $mxResult .= 'return ('.$commandLine.');';
                $mxResult .= '};';
                $mxResult .=  '\\' . __NAMESPACE__ . '\\SaleCondCtrlGroupOrderPropertyAction::applyToBasket('
                    . $arParams['ORDER']
                    . ', ' . var_export($actionParams, true)
                    . ', '.$filter.');'
                    .self::endGenerate()
                ;
                unset($filter);
            } else {
                $mxResult = self::startGenerate()
                    . '\\'. __NAMESPACE__ . '\\SaleCondCtrlGroupOrderPropertyAction::applyToBasket('
                    . $arParams['ORDER'] . ', '
                    . var_export($actionParams, true)
                    . ', "");'
                    . self::endGenerate()
                ;
            }

            unset($actionParams, $unit);
        }

        if ($boolError) {
            return false;
        }

        $result = [
            'COND' => $mxResult,
        ];

        if ($arOneCondition['Unit'] === self::VALUE_UNIT_SUMM) {
            $result['OVERWRITE_CONTROL'] = array('EXECUTE_MODULE' => 'sale');
        }

        return $result;
    }

    private static function endGenerate()
    {
        return '}';
    }
}
