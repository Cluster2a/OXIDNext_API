[{assign var="oSelections" value=$oSelectionList->getSelections()}]
[{if $oSelections}]
    <div class="form-group dropDown">
        [{if !$blHideLabel}]
            <p class="variant-label"><strong>[{$oSelectionList->getLabel()}][{oxmultilang ident="COLON"}]</strong></p>
        [{/if}]
        <div class="dropdown">
            [{assign var="oActiveSelection" value=$oSelectionList->getActiveSelection()}]
            [{if $oSelectionList->isEnriched() !== true}]
                <button type="button" class="btn btn-outline-dark btn-sm dropdown-toggle" data-toggle="dropdown">
                    [{assign var="oActiveSelection" value=$oSelectionList->getActiveSelection()}]
                    [{if $oActiveSelection}]
                        <span class="float-left">[{$oActiveSelection->getName()}]</span>
                    [{elseif !$blHideDefault}]
                        <span class="float-left">
                        [{if $sFieldName == "sel"}]
                            [{oxmultilang ident="PLEASE_CHOOSE"}]
                        [{else}]
                            [{$oSelectionList->getLabel()}] [{oxmultilang ident="CHOOSE_VARIANT"}]
                        [{/if}]
                    </span>
                    [{/if}]
                </button>
            [{/if}]

            [{if $editable !== false}]
                <input type="hidden" name="[{$sFieldName|default:"varselid"}][[{$iKey}]]" value="[{if $oActiveSelection}][{$oActiveSelection->getValue()}][{/if}]">
                [{if $oSelectionList->isEnriched() === true}]
                    [{* ICONS MARKUP *}]
                    <ul class="d-inline-flex mb-0 pl-0 [{$sJsAction}][{if $sFieldName != "sel"}] vardrop[{/if}]" role="menu">
                        [{foreach from=$oSelections item=oSelection}]
                            <a class="mx-3 mt-2 mb-0[{if $oSelection->isDisabled()}] disabled js-disabled[{/if}]" title="[{$oSelection->getName()}]" href="[{$oSelection->getLink()}]" data-selection-id="[{$oSelection->getValue()}]">
                                [{if $oSelection->getType() === 'color'}]
                                    <span style="background-color: [{$oSelection->getColorCode()}];[{if $oSelection->isActive()}] box-shadow: 0 0 0 2px #fff, 0 0 0 calc(3px + 2px) [{$oSelection->getColorCode()}], 0 0 #0000;[{/if}]" class="color-picker[{if $oSelection->isActive()}] active[{/if}] [{if $oSelection->isDisabled()}] disabled js-disabled[{/if}]"></span>
                                [{else}]
                                    <img width="40" height="40" data-toggle="popover" data-placement="bottom" data-trigger="hover" title="[{$oSelection->getName()}]" data-content="<img src='[{$oSelection->getImage()}]'>" class="variant-image[{if $oSelection->isActive()}] active[{/if}]" alt="[{$oSelection->getName()}]" src="[{$oSelection->getImage()}]">
                                [{/if}]
                            </a>
                        [{/foreach}]
                    </ul>
                [{else}]
                    <ul class="dropdown-menu [{$sJsAction}][{if $sFieldName != "sel"}] vardrop[{/if}]" role="menu">
                        [{if $oActiveSelection && !$blHideDefault}]
                            <li class="dropdown-menu-item">
                                <a href="#" rel="" class="dropdown-menu-link">
                                    [{if $sFieldName == "sel"}]
                                        [{oxmultilang ident="PLEASE_CHOOSE"}]
                                    [{else}]
                                        [{oxmultilang ident="CHOOSE_VARIANT"}]
                                    [{/if}]
                                </a>
                            </li>
                        [{/if}]
                        [{foreach from=$oSelections item=oSelection}]
                            <li class="dropdown-menu-item[{if $oSelection->isDisabled()}] disabled js-disabled[{/if}]">
                                <a href="[{$oSelection->getLink()}]" data-selection-id="[{$oSelection->getValue()}]" class="dropdown-menu-link[{if $oSelection->isActive()}] active[{/if}]">[{$oSelection->getName()}]</a>
                            </li>
                        [{/foreach}]
                    </ul>
                [{/if}]
            [{/if}]
        </div>
    </div>
[{/if}]