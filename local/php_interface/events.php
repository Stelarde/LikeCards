<?php
AddEventHandler("iblock", "OnBeforeIBlockElementDelete", Array("CardsMailEventsHandler", "OnBeforeIBlockElementDeleteHandler"));

class CardsMailEventsHandler
{
    function OnBeforeIBlockElementDeleteHandler($ID)
    {
        CModule::IncludeModule('iblock');
        $arSelect = ['ID'];
        $arFilter = ['IBLOCK_ID' => IBLOCK_ID_CARDS];
        $rsElements = CIBlockElement::GetList(['PROPERTY_LIKE_COUNT' => 'DESC'], $arFilter, false, [], $arSelect);
        if($arElement = $rsElements->GetNext())
            $elementId = $arElement['ID'];

        if($ID == $elementId)
        {
            $EVEN_TYPE = 'DELETE_TOP_CARD';
            $SITE_ID = 's1';

            CEvent::Send($EVEN_TYPE, $SITE_ID, []);
        }
    }
}
