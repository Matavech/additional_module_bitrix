<?
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

Class related extends CModule
{
    var $MODULE_ID = "related";
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_CSS;
    var $MODULE_GROUP_RIGHTS = "Y";

    public function __construct()
    {
        $arModuleVersion = array();

        include(__DIR__.'/version.php');

        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];

        $this->MODULE_NAME = Loc::getMessage('RELATED_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('RELATED_MODULE_DESCRIPTION');
    }


    function InstallDB($install_wizard = true)
    {
        global $DB, $APPLICATION;

        $errors = null;
        $sqlFile = __DIR__ . "/db/mysql/install.sql";

        if (!$DB->Query("SELECT 'x' FROM b_related_related_products", true))
            $errors = $DB->RunSQLBatch($sqlFile);

        if (!empty($errors))
        {
            $APPLICATION->ThrowException(implode("", $errors));
            return false;
        }

        RegisterModule("related");

        $this->InstallEvents();

        return true;
    }

    function UnInstallDB($arParams = Array())
    {
        global $DB, $APPLICATION;

        $errors = null;
        if(array_key_exists("savedata", $arParams) && $arParams["savedata"] != "Y")
        {
            $sqlFile = __DIR__ . "/db/mysql/uninstall.sql";
            $errors = $DB->RunSQLBatch($sqlFile);

            if (!empty($errors))
            {
                $APPLICATION->ThrowException(implode("", $errors));
                return false;
            }
            \Bitrix\Main\Config\Option::delete($this->MODULE_ID);
        }

        $this->UnInstallEvents();

        UnRegisterModule("related");

        return true;
    }

    function InstallEvents()
    {
        $eventManager = Bitrix\Main\EventManager::getInstance();

        $eventManager->registerEventHandler(
            'crm',
            'OnAfterCrmControlPanelBuild',
            'related',
            '\Bitrix\Related\Internals\Integration\Crm\CrmControlPanelBuildListener',
            'onAfterCrmControlPanelBuild'
        );
        return true;
    }

    function UnInstallEvents()
    {
        $eventManager = Bitrix\Main\EventManager::getInstance();

        $eventManager->unRegisterEventHandler(
            'crm',
            'OnAfterCrmControlPanelBuild',
            'related',
            '\Bitrix\Related\Internals\Integration\Crm\CrmControlPanelBuildListener',
            'onAfterCrmControlPanelBuild'
        );

        return true;
    }

    function InstallFiles()
    {
        if($_ENV["COMPUTERNAME"]!='BX')
        {
            CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/related/install/admin", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin", true);
            CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/related/install/components", $_SERVER["DOCUMENT_ROOT"]."/bitrix/components", true, true);
            CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/related/install/tools", $_SERVER["DOCUMENT_ROOT"]."/bitrix/tools", true, true);
        }
        return true;
    }

    function UnInstallFiles()
    {
        return true;
    }

    function DoInstall()
    {
        $this->InstallFiles();
        $this->InstallDB(false);
    }

    function DoUninstall()
    {
        $this->UnInstallDB();
        $this->UnInstallFiles();
    }
}
?>