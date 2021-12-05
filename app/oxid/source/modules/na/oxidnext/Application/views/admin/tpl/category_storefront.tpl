[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign}]

<!-- END add to *.css file -->
<form name="transfer" id="transfer" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="oxid" id="oxid" value="[{$oxid}]">
    <input type="hidden" name="cl" value="category_main">
    <input type="hidden" name="editlanguage" value="[{$editlanguage}]">
</form>

[{if $readonly}]
    [{assign var="readonly" value="readonly disabled"}]
[{else}]
    [{assign var="readonly" value=""}]
[{/if}]

[{if $readonly_fields}]
    [{assign var="readonly_fields" value="readonly disabled"}]
[{else}]
    [{assign var="readonly_fields" value=""}]
[{/if}]

<form name="myedit" id="myedit" enctype="multipart/form-data" action="[{$oViewConf->getSelfLink()}]" method="post">
    <input type="hidden" name="MAX_FILE_SIZE" value="[{$iMaxUploadFileSize}]">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="cl" value="na_oxidnext_admin_category_storefront">
    <input type="hidden" name="fnc" value="">
    <input type="hidden" name="oxid" value="[{$oxid}]">
    <input type="hidden" name="editval[oxcategories__oxid]" value="[{$oxid}]">

    [{if $oViewConf->isAltImageServerConfigured()}]
        <div class="warning">[{oxmultilang ident="ALTERNATIVE_IMAGE_SERVER_NOTE" args=$imageUrl}] [{oxinputhelp ident="HELP_ALTERNATIVE_IMAGE_SERVER_NOTE"}]</div>
    [{/if}]

    <table cellspacing="0" cellpadding="0" border="0" width="98%">
        <tr>
            <td valign="top" class="edittext">
                <table cellspacing="0" cellpadding="0" border="0">
                    <tr>
                        <td class="edittext">
                            [{oxmultilang ident="CATEGORY_MAIN_THUMB"}]
                        </td>
                        <td class="edittext">
                            <input id="oxthumb" type="text" class="editinput" size="42" maxlength="[{$edit->oxcategories__na_sf_banner->fldmax_length}]" name="editval[oxcategories__na_sf_banner]" value="[{$edit->oxcategories__na_sf_banner->value}]">
                            [{oxinputhelp ident="HELP_CATEGORY_MAIN_THUMB"}]
                        </td>
                        <td class="edittext">
                            [{if (!($edit->oxcategories__na_sf_banner->value=="nopic.jpg" || $edit->oxcategories__na_sf_banner->value=="" || $edit->oxcategories__na_sf_banner->value=="nopic_ico.jpg"))}]
                                <a href="Javascript:DeletePic('na_sf_banner');" class="delete left" [{include file="help.tpl" helpid=item_delete}]></a>
                            [{/if}]
                            <input class="editinput" name="myfile[NA_SF_BANNER@oxcategories__na_sf_banner]" type="file"  size="26" [{$readonly}]>
                            ([{oxmultilang ident="GENERAL_MAX_FILE_UPLOAD"}] [{$sMaxFormattedFileSize}], [{oxmultilang ident="GENERAL_MAX_PICTURE_DIMENSIONS"}])
                        </td>
                    </tr>
                    <tr>
                        <td class="edittext">
                        </td>
                        <td class="edittext" colspan="2"><br>
                            <input type="submit" class="edittext" name="save" value="[{oxmultilang ident="CATEGORY_MAIN_SAVE"}]" onClick="Javascript:document.myedit.fnc.value='save'" [{$readonly}]><br>
                        </td>
                    </tr>
                    <tr>
                        <td class="edittext">
                        </td>
                        <td class="edittext" colspan="2"><br>
                            [{include file="language_edit.tpl"}]
                        </td>
                    </tr>
                </table>

            </td>
            <!-- Anfang rechte Seite -->
            <td valign="top" class="edittext" align="left" width="50%">


            </td>
        </tr>
    </table>

</form>
[{include file="bottomnaviitem.tpl"}]

[{include file="bottomitem.tpl"}]
