<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->addExternalCss('/local/components/cards/cards.elem/templates/.default/css/bootstrap.css');
$this->addExternalCss('/local/components/cards/cards.elem/templates/.default/css/bootstrap-grid.css');
$this->addExternalCss('/local/components/cards/cards.elem/templates/.default/css/bootstrap-reboot.css');
$this->addExternalJS('/local/components/cards/cards.elem/templates/.default/js/bootstrap.bundle.js');
$this->addExternalJS('/local/components/cards/cards.elem/templates/.default/js/bootstrap.js');
CJSCore::Init(array("jquery"));
?>

<div id="cards" data-total="<?=$arResult['total']?>" data-count="10">
<?
foreach ($arResult['elements'] as $value)
{
    ?>
    <div class="card" style="width: 18rem;" data="<?=$value['ID']?>">
        <img class="card-img-top" src="<?=$value['CARD_PICTURE_URL']?>" alt="Card image cap">
        <div class="card-body">
            <h5 class="card-title"><?=$value['NAME']?></h5>
            <p class="card-text"><?=$value['CARD_DESCRIPTION']?></p>
            <button class="btn btn-primary" type="submit" id="minus" data="<?=$value['ID']?>">-</button>
            <button type="button" class="btn btn-outline-primary" id="like<?=$value['ID']?>"><?=$value['LIKE_COUNT']?></button>
            <button class="btn btn-primary" type="submit" id="plus" data="<?=$value['ID']?>">+</button>
        </div>
    </div>
    <br>
<?php } ?>
</div>
<?php
if ($arResult['total'] > 10)
{
?>
    <button type="button" class="btn btn-primary" id="update" >Показать ещё</button>
<?php } ?>

<script>

    $(document).ready(function() {
        $('#update').on('click', function ()
        {
            var targetContainer = $('#cards');
            var request = BX.ajax.runComponentAction('cards:cards.elem', 'ajaxAddElem',
                {
                    mode:'class',
                    data: {count: $('#cards').attr('data-count')}
                });
            request.then(function(response)
            {
                console.log(response['data']);
                targetContainer.append(response['data']['nHtmlElements'])

                if (response['data']['countOnNextPage'] != 10)
                {
                    $('#update').remove();
                }
            });
        });

        $('#cards').on('click', '#minus', function()
        {
            var id = $(this).attr('data');
            var like = $('#like' + id).text();
            var request = BX.ajax.runComponentAction('cards:cards.elem', 'ajaxDislike',
                {
                    mode:'class',
                    data: {like: like, id: id}
                });
            request.then(function(response)
            {
                $('#like' + id).text(response['data']['likes']);
            });
        });

        $('#cards').on('click', '#plus', function()
        {
            var id = $(this).attr('data');
            var like = $('#like' + id).text();
            var request = BX.ajax.runComponentAction('cards:cards.elem', 'ajaxLike',
                {
                    mode:'class',
                    data: {like: like, id: id}
                });
            request.then(function(response)
            {
                $('#like' + id).text(response['data']['likes']);
            });
        });
    });
</script>
