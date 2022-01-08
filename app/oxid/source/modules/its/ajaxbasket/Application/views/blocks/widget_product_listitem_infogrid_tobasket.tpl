<div class="actions">
    <div class="btn-group">
        [{if $blShowToBasket}]
            [{oxhasrights ident="TOBASKET"}]
                <button type="submit" aria-label="[{oxmultilang ident="TO_CART"}]" class="btn btn-outline-dark hasTooltip addtoBasket" data-placement="bottom" title="[{oxmultilang ident="TO_CART"}]" data-container="body">
                    <i class="fa fa-shopping-cart"></i>
                </button>
                [{oxscript add="\$( 'button.addtoBasket' ).its_oxAddToBasket();"}]
            [{/oxhasrights}]
            <a class="btn btn-primary" href="[{$_productLink}]" >[{oxmultilang ident="MORE_INFO"}]</a>
        [{else}]
            <a class="btn btn-primary" href="[{$_productLink}]" >[{oxmultilang ident="MORE_INFO"}]</a>
        [{/if}]
    </div>
</div>