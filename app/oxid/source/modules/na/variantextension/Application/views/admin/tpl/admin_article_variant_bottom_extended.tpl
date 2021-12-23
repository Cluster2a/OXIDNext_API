[{$smarty.block.parent}]
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<script>
    let content = [{$edit->getVariantExtensionJSON()}];
    const i18n = {
        NA_ARTICLE_VARIANT_BTN_ADD_EXTENSION: "[{oxmultilang ident="NA_ARTICLE_VARIANT_BTN_ADD_EXTENSION"}]",
        NA_ARTICLE_VARIANT_BTN_SAVE: "[{oxmultilang ident="NA_ARTICLE_VARIANT_BTN_SAVE"}]",
        NA_ARTICLE_VARIANT_TABLE_HEADER_VARIANT_CONTENT_TYPE_COLOR: "[{oxmultilang ident="NA_ARTICLE_VARIANT_TABLE_HEADER_VARIANT_CONTENT_TYPE_COLOR"}]",
        NA_ARTICLE_VARIANT_TABLE_HEADER_VARIANT_CONTENT_TYPE_IMAGE: "[{oxmultilang ident="NA_ARTICLE_VARIANT_TABLE_HEADER_VARIANT_CONTENT_TYPE_IMAGE"}]",
    };

    document.addEventListener("DOMContentLoaded", () =>
    {
    });

    function addRemove() {
        return {
            data: [{$edit->getVariantExtensionJSON()}],
            i18n,
            addNewField() {
                this.data.push({
                    id: this.data.length + 1,
                    variantName: '',
                    variantValue: '',
                    variantContentType: '',
                    variantColorCode: '',
                    variantImage: '',
                });
            },
            removeField(id) {
                this.data = this.data.filter(p => p.id !== id);
                let i = 0;
                this.data.forEach(function (record) {
                    record.id = i;
                    i++;
                });
            }
        }
    }
</script>

<div x-cloak>
    <div x-data="addRemove()">
        <form id="variantsDelete" name="variantExtension" action="[{$oViewConf->getSelfLink()}]" method="post">
            [{$oViewConf->getHiddenSid()}]
            <input type="hidden" name="cl" value="article_variant">
            <input type="hidden" name="fnc" value="deleteSingleVariantExtension">
            <input type="hidden" name="oxid" value="[{$oxid}]">
            <input type="hidden" name="voxid" value="[{$oxid}]">
        </form>

        <form id="variantsUpload" name="variantExtension" action="[{$oViewConf->getSelfLink()}]" enctype="multipart/form-data" method="post">
            [{$oViewConf->getHiddenSid()}]
            <input type="hidden" name="cl" value="article_variant">
            <input type="hidden" name="fnc" value="saveVariantExtension">
            <input type="hidden" name="oxid" value="[{$oxid}]">
            <input type="hidden" name="editval[article__oxid]" value="[{$oxid}]">
            <input type="hidden" name="voxid" value="[{$oxid}]">
            <input type="hidden" name="oxparentid" value="[{$oxparentid}]">

            <input type="button" :value="i18n.NA_ARTICLE_VARIANT_BTN_ADD_EXTENSION" @click.prevent="addNewField()">
            <div class="table" style="display: table">
                <table id="variantsUploadWrapper">
                    <tr>
                        <td class="listheader">[{oxmultilang ident="NA_ARTICLE_VARIANT_TABLE_HEADER_VARIANT_NAME"}]</td>
                        <td class="listheader">[{oxmultilang ident="NA_ARTICLE_VARIANT_TABLE_HEADER_VARIANT_VALUE"}]</td>
                        <td class="listheader">[{oxmultilang ident="NA_ARTICLE_VARIANT_TABLE_HEADER_VARIANT_CONTENT_TYPE"}]</td>
                        <td class="listheader">[{oxmultilang ident="NA_ARTICLE_VARIANT_TABLE_HEADER_VARIANT_COLOR_CODE"}]</td>
                        <td class="listheader">[{oxmultilang ident="NA_ARTICLE_VARIANT_TABLE_HEADER_VARIANT_IMAGE"}]</td>
                        <td class="listheader" colspan="2">&nbsp</td>
                    </tr>
                    <template x-for="(variantExtension, index) in data" :key="variantExtension.id">
                        <tr>
                            <td>
                                <input type="text" class="editinput" :value="variantExtension.variantName" :name="'variantName[' + variantExtension.id + ']'">
                            </td>
                            <td>
                                <input type="text" class="editinput" :value="variantExtension.variantValue" :name="'variantValue[' + variantExtension.id + ']'">
                            </td>
                            <td>
                                <label>
                                    <input type="radio" value="color" class="editinput" x-model="variantExtension.variantContentType" :name="'variantContentType[' + variantExtension.id + ']'">
                                    <span x-text="i18n.NA_ARTICLE_VARIANT_TABLE_HEADER_VARIANT_CONTENT_TYPE_COLOR"></span>
                                </label>
                                <label>
                                    <input type="radio" value="image" class="editinput" x-model="variantExtension.variantContentType" :name="'variantContentType[' + variantExtension.id + ']'">
                                    <span x-text="i18n.NA_ARTICLE_VARIANT_TABLE_HEADER_VARIANT_CONTENT_TYPE_IMAGE"></span>
                                </label>
                            </td>
                            <td>
                                <input type="text" class="editinput" :value="variantExtension.variantColorCode" :name="'variantColorCode[' + variantExtension.id + ']'">
                            </td>
                            <td>
                                <input type="text" class="editinput" :value="variantExtension.variantImage" :name="'variantImage[' + variantExtension.id + ']'">
                                <input type="file" class="editinput" :name="'myfile[NA_VARINAT_IMAGES@varinat_image' + variantExtension.id + ']'">
                            </td>
                            <td>
                                <a href="#" class="delete" onmouseout="popDown('item_delete')" onmouseover="popUp(event,'item_delete');return true" @click.prevent="removeField(variantExtension.id);"></a>
                            </td>
                        </tr>
                    </template>
                </table>
            </div>

            <input id="variantsUploadSubmit" type="submit" :value="i18n.NA_ARTICLE_VARIANT_BTN_SAVE">
        </form>
    </div>
</div>