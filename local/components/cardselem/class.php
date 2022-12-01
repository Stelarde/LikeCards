<?php
if ( ! defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

class cardselem extends CBitrixComponent
{
    public function configureActions()
    {
        return
            [
                'addElem' =>
                    [
                        'prefilters' => [],
                        'postfilters' => []
                    ]
            ];
    }

    public function executeComponent()
    {
        $arSelect = ['NAME', 'PROPERTY_CARD_PICTURE', 'PROPERTY_CARD_DESCRIPTION', 'PROPERTY_LIKE_COUNT'];
        $arFilter = ['IBLOCK_ID'=>'5'];
        $res = CIBlockElement::GetList([], $arFilter, false, ["nPageSize"=>10], $arSelect);

        while ($element = $res->GetNext())
        {
            $arResult[]['NAME'] = $element['NAME'];
            $arResult[]['CARD_PICTURE'] = $element['PROPERTY_CARD_PICTURE_VALUE'];
            $arResult[]['CARD_DESCRIPTION'] = $element['PROPERTY_CARD_DESCRIPTION_VALUE'];
            $arResult[]['LIKE_COUNT'] = $element['PROPERTY_LIKE_COUNT_VALUE'];
        }

        echo "<pre>";
        print_r($arResult);
        echo "</pre>";
        $this->IncludeComponentTemplate();
    }
}
