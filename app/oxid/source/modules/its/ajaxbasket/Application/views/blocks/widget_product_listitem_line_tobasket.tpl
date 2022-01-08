[{if $blShowToBasket}]
    [{oxhasrights ident="TOBASKET"}]

    <div class="form-group">
        <div class="input-group">
            <input id="amountToBasket_[{$testid}]" type="text" name="am" value="1" size="3" autocomplete="off" class="form-control amount">
            <span class="input-group-append">
                <button id="toBasket_[{$testid}]" type="submit" aria-label="[{oxmultilang ident="TO_CART"}]" class="btn btn-primary hasTooltip addtoBasket" title="[{oxmultilang ident="TO_CART"}]" data-container="body">
                    <i class="fa fa-shopping-cart"></i>
                </button>
                [{oxscript add="$( 'button.addtoBasket' ).its_oxAddToBasket();"}]
                [{if $removeFunction && (($owishid && ($owishid==$oxcmp_user->oxuser__oxid->value)) || (($wishid==$oxcmp_user->oxuser__oxid->value)) || $recommid)}]
                    <button triggerForm="remove_[{$removeFunction}][{$testid}]" type="submit" class="btn btn-danger removeButton hasTooltip" title="[{oxmultilang ident="REMOVE"}]">
                        <i class="fa fa-times"></i>
                    </button>
                [{/if}]
            </span>
        </div>
    </div>
    [{/oxhasrights}]
[{else}]
    <a class="btn btn-primary" href="[{$_productLink}]">[{oxmultilang ident="MORE_INFO"}]</a>

    [{if $removeFunction && (($owishid && ($owishid==$oxcmp_user->oxuser__oxid->value)) || (($wishid==$oxcmp_user->oxuser__oxid->value)) || $recommid)}]
        <button triggerForm="remove_[{$removeFunction}][{$testid}]" type="submit" class="btn btn-danger btn-block removeButton">
            <i class="fa fa-times"></i> [{oxmultilang ident="REMOVE"}]
        </button>
    [{/if}]
[{/if}]