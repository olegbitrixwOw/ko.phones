<?

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$aMenu = array(
    'parent_menu' => 'global_menu_settings',
    'text' => GetMessage('MW_PHONES_MENU_ROOT'),
    // todo: сделать чтобы иконка работала
    'icon' => 'icon_phone',
    'title' => GetMessage('MW_PHONES_MENU_ROOT'),
    'sort' => 500,
    "items_id" => "menu_mw_phones",
    'more_url' => array(
        'mw_phones_settings.php',
    ),
	'url' => 'mw_phones_settings.php?lang=' . LANGUAGE_ID,
//    'items' => array(
//        array(
//            'text' => GetMessage('MW_PHONES_MENU_SETTINGS'),
//            'title' => GetMessage('MW_PHONES_MENU_SETTINGS'),
//            'url' => 'mw_phones_settings.php?lang=' . LANGUAGE_ID
//        ),
//    )
);

return $aMenu;

