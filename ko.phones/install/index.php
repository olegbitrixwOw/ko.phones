<?
IncludeModuleLangFile(__FILE__);

class mw_phones extends CModule
{
    
    const MODULE_ID = 'ko.phones';
    
    var $MODULE_ID = 'ko.phones';
    
    var $MODULE_VERSION;
    
    var $MODULE_VERSION_DATE;
    
    var $MODULE_NAME;
    
    var $MODULE_DESCRIPTION;
    
    var $MODULE_CSS;
    
    var $strError = '';
    
    function __construct()
    {
        $arModuleVersion = array();
        include (dirname(__FILE__) . "/version.php");
        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        $this->MODULE_NAME = GetMessage("ko.phones_MODULE_NAME");
        $this->MODULE_DESCRIPTION = GetMessage("ko.phones_MODULE_DESC");
        
        $this->PARTNER_NAME = GetMessage("ko.phones_PARTNER_NAME");
        $this->PARTNER_URI = GetMessage("ko.phones_PARTNER_URI");
    }
    
    function InstallDB($arParams = array())
    {
        global $DB, $DBType, $APPLICATION;


        return true;
    }
    
    function UnInstallDB($arParams = array())
    {

        global $DB, $DBType, $APPLICATION;

        return true;
    }
    
    function InstallEvents()
    {
        return true;
    }
    
    function UnInstallEvents()
    {
        return true;
    }
    
    function InstallFiles()
    {
    	$path_src=__DIR__.'/admin';

		if ($dir = opendir($path_src)) {
			while (false !== $item = readdir($dir)) {
				if ($item == '..' || $item == '.') {
					continue;
				}

				$copy_dest=$_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin/' . $item;
				$is_copied=copy($path_src.'/'.$item, $copy_dest);
				if (!$is_copied)
				{
					$a=1;
					// todo: error log/display
				}
			}
			closedir($dir);
		}

        $path_img_from=__DIR__.'/images/' . self::MODULE_ID;
        $path_img_to=$_SERVER['DOCUMENT_ROOT'] . "/bitrix/images/".self::MODULE_ID.'/';

        CopyDirFiles($path_img_from, $path_img_to, true, true);
        
        return true;
    }
    
    function UnInstallFiles()
    {
        if (is_dir($p = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . self::MODULE_ID . '/install/admin')) {
            if ($dir = opendir($p)) {
                while (false !== $item = readdir($dir)) {
                    if ($item == '..' || $item == '.') {
                        continue;
                    }
                    unlink($_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin/' . $item);
                }
                closedir($dir);
            }
        }

        DeleteDirFilesEx("/bitrix/images/" . self::MODULE_ID);
        
        return true;
    }
    
    function DoInstall()
    {
        global $APPLICATION;
        $this->InstallFiles();
        $this->InstallDB();
        $this->InstallEvents();
        RegisterModule(self::MODULE_ID);
    }
    
    function DoUninstall()
    {
        global $APPLICATION, $step;
        
        $step = IntVal($step);

		UnRegisterModule(self::MODULE_ID);

		$this->UnInstallDB(array(
			"savedata" => $_REQUEST["savedata"]
		));
		$this->UnInstallFiles();
		$this->UnInstallEvents();

		$APPLICATION->IncludeAdminFile(GetMessage(self::MODULE_ID . "_UNINSTALL_TITLE"), $_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/" . self::MODULE_ID . "/install/unstep1.php");

    }
}

