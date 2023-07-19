<?php

if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/local/modules/dev.site/include.php')) {
  require_once ($_SERVER['DOCUMENT_ROOT'] . '/local/modules/dev.site/include.php');
}

use Bitrix\Main\EventManager;

$eventManager = EventManager::getInstance();

$eventManager->addEventHandler(
    'iblock',
    'OnAfterIBlockElementUpdate',
    array('\Dev\Site\Handlers\Iblock', 'addLog')
);

$eventManager->addEventHandler(
    'iblock',
    'OnAfterIBlockElementAdd',
    array('\Dev\Site\Handlers\Iblock', 'addLog')
);














