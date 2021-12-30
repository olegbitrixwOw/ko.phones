<?
require_once ($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;

Loc::loadMessages(__FILE__);

global $APPLICATION, $CACHE_MANAGER;

$moduleId = "ko.phones";
Loader::includeModule($moduleId);

$RIGHT = $APPLICATION->GetGroupRight("main");
if ($RIGHT == "D") {
    $APPLICATION->AuthForm(GetMessage("MW_PHONES_SETTINGS_ACCESS"));
}

$siteList = array();
$rsSites = \CSite::GetList($by = "sort", $order = "asc", Array());
while ($arRes = $rsSites->Fetch()) {
    $siteList[] = array(
        "ID" => $arRes["ID"],
        "NAME" => $arRes["NAME"]
    );
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && check_bitrix_sessid()) {
    if ($_REQUEST["phones_save"]) {
    	$fields=array(
			'phone_mobile',
			'phone_city',
		);

        foreach ($fields as $field)
        {
            $value = $_REQUEST[$field];

            Option::set($moduleId, $field, $value);
//			foreach ($siteList as $site)
//			{
//				Option::set($moduleId, $field, $value, $site['ID']);
//			}
        }

        if (defined('BX_COMP_MANAGED_CACHE')) {
            $CACHE_MANAGER->ClearByTag("mw_phones");
        }
    }
    LocalRedirect($APPLICATION->GetCurPageParam());
}

$APPLICATION->SetTitle(Loc::getMessage('MW_PHONES_SETTINGS_TITLE'));
require ($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php");
$aTabs = array(
    array(
        "DIV" => "mw_phones",
        "TAB" => Loc::getMessage("MW_PHONES_SETTINGS_TAB"),
        "TITLE" => Loc::getMessage("MW_PHONES_SETTINGS_PHONES")
    )
);

$tabControl = new CAdminTabControl("tabControl", $aTabs);

?>
<style>
/*#mw_phones_settings td {*/
/*	width: 50%;*/
/*}*/
</style>
<form id="mw_phones_settings" method="POST"
	action="<?=$APPLICATION->GetCurPageParam('lang='.LANG, array('lang'))?>"
	name="mw_phones_settings">
<?
echo bitrix_sessid_post();
$tabControl->Begin();
$tabControl->BeginNextTab();

$mobile=Option::get($moduleId, 'phone_mobile', '');
$city=Option::get($moduleId, 'phone_city', '');
?>
	<tr id="mw_phones_tr_mobile">
		<td class="adm-detail-content-cell-l" valign="top">
			<label for="phone_mobile"><?=Loc::getMessage("MW_PHONES_SETTINGS_MOBILE");?></label>:
		</td>
		<td class="adm-detail-content-cell-r">
			<input id="phone_mobile" name="phone_mobile" value="<?=$mobile?>"></input>
		</td>
	</tr>
	<tr id="mw_phones_tr_city">
		<td class="adm-detail-content-cell-l" valign="top">
			<label for="phone_city"><?=Loc::getMessage("MW_PHONES_SETTINGS_CITY");?></label>:
		</td>
		<td class="adm-detail-content-cell-r">
			<input id="phone_city" name="phone_city" value="<?=$city?>"></input>
		</td>
	</tr>



<?
$tabControl->Buttons();
?>
<input type="submit" id="phones_save" name="phones_save"
		value="<?=Loc::getMessage("MW_PHONES_SETTINGS_BUTTON_SAVE")?>"
		class="adm-btn-save" />
<?
$tabControl->End();
?>
</form>
<?
echo BeginNote();
echo Loc::getMessage("MW_PHONES_SETTINGS_NOTE");
echo EndNote();

require ($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php");

