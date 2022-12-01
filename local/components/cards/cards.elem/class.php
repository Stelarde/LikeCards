<?php
if ( ! defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

class cardselem extends CBitrixComponent implements \Bitrix\Main\Engine\Contract\Controllerable
{
    public function configureActions()
    {
        return
            [
                'ajaxAddElem' =>
                    [
                        'prefilters' => [],
                        'postfilters' => []
                    ],
                'ajaxDislike' =>
                    [
                        'prefilters' => [],
                        'postfilters' => []
                    ],
                'ajaxLike' =>
                    [
                        'prefilters' => [],
                        'postfilters' => []
                    ],
            ];
    }

    public function executeComponent()
    {
        $arSelect = ['ID', 'NAME', 'PROPERTY_CARD_PICTURE', 'PROPERTY_CARD_DESCRIPTION', 'PROPERTY_LIKE_COUNT'];
        $arFilter = ['IBLOCK_ID' => IBLOCK_ID_CARDS];
        $rsElements = CIBlockElement::GetList([], $arFilter, false, ["nPageSize"=>10], $arSelect);
        $this->arResult['total'] = CIBlockElement::GetList([], $arFilter, [], ["nPageSize"=>10], $arSelect);

        while ($arElement = $rsElements->GetNext())
        {
            $this->arResult['elements'][] = [
                'ID' => $arElement['ID'],
                'NAME' => $arElement['NAME'],
                'CARD_PICTURE_URL' => CFile::GetPath($arElement['PROPERTY_CARD_PICTURE_VALUE']),
                'CARD_DESCRIPTION' => $arElement['PROPERTY_CARD_DESCRIPTION_VALUE'],
                'LIKE_COUNT' => $arElement['PROPERTY_LIKE_COUNT_VALUE']
            ];
        }
        $this->IncludeComponentTemplate();
    }

    public function ajaxAddElemAction(): array
    {
        $arSelect = ['ID', 'NAME', 'PROPERTY_CARD_PICTURE', 'PROPERTY_CARD_DESCRIPTION', 'PROPERTY_LIKE_COUNT'];
        $arFilter = ['IBLOCK_ID' => IBLOCK_ID_CARDS];

        CModule::IncludeModule('iblock');
        $el = new CIBlockElement;

        $rsElements = $el->GetList([], $arFilter, false, ["nPageSize"=>10, "iNumPage"=>$_POST['count']/10+1], $arSelect);
        $countOnNextPage = 0;

        $nHtmlElements = '';
        while ($arElement = $rsElements->GetNext())
        {
            $nHtmlElements .= '<div class="card" style="width: 18rem;" data=' . $arElement['ID'] . '>';
            $nHtmlElements .= '<img class="card-img-top" src="';
            $nHtmlElements .= CFile::GetPath($arElement['PROPERTY_CARD_PICTURE_VALUE']);
            $nHtmlElements .= '" alt="Card image cap">';
            $nHtmlElements .= '<div class="card-body"> <h5 class="card-title">' . $arElement['NAME'] . '</h5> <p class="card-text">';
            $nHtmlElements .= $arElement['PROPERTY_CARD_DESCRIPTION_VALUE'] . '</p> <button class="btn btn-primary" type="submit" id="minus" data="';
            $nHtmlElements .= $arElement['ID']  . '">-</button> <button type="button" class="btn btn-outline-primary" id="like';
            $nHtmlElements .= $arElement['ID'] . '">' . $arElement['PROPERTY_LIKE_COUNT_VALUE'] . '</button> ';
            $nHtmlElements .= '<button class="btn btn-primary" type="submit" id="plus" data="' . $arElement['ID'] . '">+</button>';
            $nHtmlElements .= '</div> </div> <br>';

            $countOnNextPage += 1;
        }

        return
        [
            'countOnNextPage' =>$countOnNextPage,
            'nHtmlElements' => $nHtmlElements
        ];
    }

    public function ajaxDislikeAction(): array
    {
        CModule::IncludeModule('iblock');
        $el = new CIBlockElement;

        $arSelect = ['PROPERTY_CARD_DESCRIPTION'];
        $arFilter = ['ID' => $_POST['id']];
        $rsElement = $el->GetList([], $arFilter, false, [], $arSelect);
        if($arElement = $rsElement->GetNext())
            $elementDes = $arElement['PROPERTY_CARD_DESCRIPTION_VALUE'];

        $countlikes = (int) $_POST['like'] - 1;

        $el->SetPropertyValues(
          $_POST['id'],
          IBLOCK_ID_CARDS,
          [
              'LIKE_COUNT' => $countlikes,
              'CARD_DESCRIPTION' => $elementDes
          ]
        );

        return
        [
            'likes' => $countlikes,
            'error' => $el->LAST_ERROR
        ];
    }

    public function ajaxLikeAction(): array
    {
        CModule::IncludeModule('iblock');
        $el = new CIBlockElement;

        $arSelect = ['PROPERTY_CARD_DESCRIPTION'];
        $arFilter = ['ID' => $_POST['id']];
        $rsElement = $el->GetList([], $arFilter, false, [], $arSelect);
        if($arElement = $rsElement->GetNext())
            $elementDes = $arElement['PROPERTY_CARD_DESCRIPTION_VALUE'];

        $countlikes = (int) $_POST['like'] + 1;

        $el->SetPropertyValues(
            $_POST['id'],
            IBLOCK_ID_CARDS,
            [
                'LIKE_COUNT' => $countlikes,
                'CARD_DESCRIPTION' => $elementDes
            ]
        );

        return
            [
                'likes' => $countlikes,
                'error' => $el->LAST_ERROR
            ];
    }
}
