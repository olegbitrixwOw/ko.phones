<?

$file = $_SERVER['DOCUMENT_ROOT'].'/local/modules/ko.phones/admin/mw_phones_settings.php';

if (!file_exists($file)) {
    $file = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/ko.phones/admin/mw_phones_settings.php';
}

require_once($file);
