<?php
defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();

if (class_exists('intensa_discounts')) {
    return;
}

use Bitrix\Main\EventManager;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class intensa_discounts extends CModule
{
    public $MODULE_ID = 'intensa.discounts';
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;

    public function __construct()
    {
        $arModuleVersion = [];

        include(dirname(__FILE__) . '/version.php');

        $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];

        $this->MODULE_NAME = Loc::getMessage('INTENSA_DISCOUNTS_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('INTENSA_DISCOUNTS_MODULE_DESCRIPTION');

        $this->PARTNER_NAME = Loc::getMessage('INTENSA_DISCOUNTS_PARTNER_NAME');
        $this->PARTNER_URI = Loc::getMessage('INTENSA_DISCOUNTS_PARTNER_URI');
    }

    public function DoInstall()
    {
        \Bitrix\Main\ModuleManager::registerModule($this->MODULE_ID);
        $this->InstallDB();
        $this->installEvents();
    }

    public function DoUninstall()
    {
        \Bitrix\Main\ModuleManager::unRegisterModule($this->MODULE_ID);
        $this->InstallDB();
        $this->unInstallEvents();
    }

    public function installEvents()
    {
        EventManager::getInstance()->registerEventHandler(
            'sale',
            'OnCondSaleActionsControlBuildList',
            $this->MODULE_ID,
            \Intensa\Discounts\SaleCondCtrlGroupOrderProperty::class,
            'GetControlDescr'
        );
    }

    public function unInstallEvents()
    {
        EventManager::getInstance()->unRegisterEventHandler(
            'sale',
            'OnCondSaleActionsControlBuildList',
            $this->MODULE_ID,
            \Intensa\Discounts\SaleCondCtrlGroupOrderProperty::class,
            'GetControlDescr'
        );
    }

    public function InstallDB()
    {

    }

    public function UnInstallDB()
    {

    }
}
