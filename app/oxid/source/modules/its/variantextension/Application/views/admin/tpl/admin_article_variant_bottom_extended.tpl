[{$smarty.block.parent}]
[{oxscript include=$oViewConf->getModuleUrl('its/variantextension','out/src/js/alpinejs.min.js') priority=10 }]
<style>
    .sorting {
        font-size: 15px;
    }

    .btn-add {
        background: #2196f3!important;
        color: white!important;
        border: 1px solid #2196f3!important;
    }

    .btn-add:hover {
        background: #1976d2!important;
    }

    .btn-save {
        background: #4caf50!important;
        color: white!important;
        border: 1px solid #4caf50!important;
    }

    .btn-save:hover {
        background: #388e3c!important;
    }

    .btn-abort {
        background: #e53935!important;
        color: white!important;
        border: 1px solid #e53935!important;
    }

    .btn-abort:hover {
        background: #b71c1c!important;
    }
</style>
<script>
    let content = [{$edit->getVariantExtensionJSON()}];
    const i18n = {
        ITS_ARTICLE_VARIANT_BTN_ADD_EXTENSION: "[{oxmultilang ident="ITS_ARTICLE_VARIANT_BTN_ADD_EXTENSION"}]",
        ITS_ARTICLE_VARIANT_BTN_SAVE: "[{oxmultilang ident="ITS_ARTICLE_VARIANT_BTN_SAVE"}]",
        ITS_ARTICLE_VARIANT_BTN_ABORT: "[{oxmultilang ident="ITS_ARTICLE_VARIANT_BTN_ABORT"}]",
        ITS_ARTICLE_VARIANT_TABLE_HEADER_VARIANT_CONTENT_TYPE_COLOR: "[{oxmultilang ident="ITS_ARTICLE_VARIANT_TABLE_HEADER_VARIANT_CONTENT_TYPE_COLOR"}]",
        ITS_ARTICLE_VARIANT_TABLE_HEADER_VARIANT_CONTENT_TYPE_IMAGE: "[{oxmultilang ident="ITS_ARTICLE_VARIANT_TABLE_HEADER_VARIANT_CONTENT_TYPE_IMAGE"}]",
    };

    document.addEventListener("DOMContentLoaded", () =>
    {
    });

    const reloadData = async() => {
        const form = document.querySelector('#variantExtensionReload');
        const formData = new FormData(form);
        return fetch(form.action, {
            method: 'POST',
            body: formData
        }).then((response) => {
            if (!response.ok) alert(`Something went wrong: ${response.status} - ${response.statusText}`)
            return response.json()
        })
    }

    function addRemove() {
        return {
            data: [{$edit->getVariantExtensionJSON()}],
            i18n,
            refreshIndex() {
                let i = 0;
                this.data.forEach(function (record) {
                    record.id = i;
                    i++;
                });
            },
            addNewRecord() {
                const newId = this.data.length;
                this.data.push({
                    id: newId,
                    variantName: '',
                    variantValue: '',
                    variantContentType: '',
                    variantColorCode: '',
                    variantImage: '',
                });
                this.refreshIndex();
            },
            removeRecord(id) {
                this.data = this.data.filter(p => p.id !== id);
                this.refreshIndex();
            },
            moveDown(id) {
                let newData = []

                for (let index = 0; index < this.data.length; index++) {
                    let element = this.data[index];
                    if(element.id === id + 1) {
                        element = this.data.filter(p => p.id === id)[0];
                    } else if(element.id === id ) {
                        element = this.data.filter(p => p.id === id + 1)[0];
                    }
                    newData = [...newData, element]
                }

                this.data = newData;
                this.refreshIndex();
            },
            moveUp(id) {
                let newData = []

                for (let index = 0; index < this.data.length; index++) {
                    let element = this.data[index];
                    if(element.id === id - 1) {
                        element = this.data.filter(p => p.id === id)[0];
                    } else if(element.id === id ) {
                        element = this.data.filter(p => p.id === id - 1)[0];
                    }
                    newData = [...newData, element]
                }

                this.data = newData;
                this.refreshIndex();
            },
            async reloadData() {
                this.data = await reloadData();
            }
        }
    }
</script>

<div x-cloak>
    <div x-data="addRemove()">
        <form id="variantExtensionReload" name="variantExtensionReload" action="[{$oViewConf->getSelfLink()}]" method="post">
            [{$oViewConf->getHiddenSid()}]
            <input type="hidden" name="cl" value="article_variant">
            <input type="hidden" name="fnc" value="loadVariantExtensions">
            <input type="hidden" name="oxid" value="[{$oxid}]">
            <input type="hidden" name="voxid" value="[{$oxid}]">
        </form>

        <form id="variantExtensionMain" name="variantExtensionMain" action="[{$oViewConf->getSelfLink()}]" enctype="multipart/form-data" method="post">
            [{$oViewConf->getHiddenSid()}]
            <input type="hidden" name="cl" value="article_variant">
            <input type="hidden" name="fnc" value="saveVariantExtension">
            <input type="hidden" name="oxid" value="[{$oxid}]">
            <input type="hidden" name="editval[article__oxid]" value="[{$oxid}]">
            <input type="hidden" name="voxid" value="[{$oxid}]">
            <input type="hidden" name="oxparentid" value="[{$oxparentid}]">

            <input type="button" class="btn-add" :value="i18n.ITS_ARTICLE_VARIANT_BTN_ADD_EXTENSION" @click.prevent="addNewRecord()">
            <div class="table" style="display: table">
                <table id="variantsUploadWrapper">
                    <tr>
                        <td class="listheader">&nbsp</td>
                        <td class="listheader">[{oxmultilang ident="ITS_ARTICLE_VARIANT_TABLE_HEADER_VARIANT_NAME"}]</td>
                        <td class="listheader">[{oxmultilang ident="ITS_ARTICLE_VARIANT_TABLE_HEADER_VARIANT_VALUE"}]</td>
                        <td class="listheader">[{oxmultilang ident="ITS_ARTICLE_VARIANT_TABLE_HEADER_VARIANT_CONTENT_TYPE"}]</td>
                        <td class="listheader">[{oxmultilang ident="ITS_ARTICLE_VARIANT_TABLE_HEADER_VARIANT_COLOR_CODE"}] [{oxinputhelp ident="ITS_ARTICLE_VARIANT_TABLE_HEADER_VARIANT_COLOR_CODE_HELP"}]</td>
                        <td class="listheader">[{oxmultilang ident="ITS_ARTICLE_VARIANT_TABLE_HEADER_VARIANT_IMAGE"}]</td>
                        <td class="listheader" colspan="2">&nbsp</td>
                    </tr>
                    <template x-for="(variantExtension, index) in data" :key="variantExtension.id">
                        <tr>
                            <td class="listitem">
                                <input type="button" class="edittext sorting" value="&#9650;" @click.prevent="moveUp(variantExtension.id);" x-bind:disabled="variantExtension.id === 0">
                                <input type="button" class="edittext sorting" value="&#9660;" @click.prevent="moveDown(variantExtension.id);" x-bind:disabled="variantExtension.id === data.length - 1">
                            </td>
                            <td class="listitem">
                                <input type="text" class="editinput" x-model="variantExtension.variantName" :name="'variantName[' + variantExtension.id + ']'">
                            </td>
                            <td class="listitem">
                                <input type="text" class="editinput" x-model="variantExtension.variantValue" :name="'variantValue[' + variantExtension.id + ']'">
                            </td>
                            <td class="listitem">
                                <label>
                                    <input type="radio" value="color" class="editinput" x-model="variantExtension.variantContentType" :name="'variantContentType[' + variantExtension.id + ']'">
                                    <span x-text="i18n.ITS_ARTICLE_VARIANT_TABLE_HEADER_VARIANT_CONTENT_TYPE_COLOR"></span>
                                </label>
                                <label>
                                    <input type="radio" value="image" class="editinput" x-model="variantExtension.variantContentType" :name="'variantContentType[' + variantExtension.id + ']'">
                                    <span x-text="i18n.ITS_ARTICLE_VARIANT_TABLE_HEADER_VARIANT_CONTENT_TYPE_IMAGE"></span>
                                </label>
                            </td>
                            <td class="listitem">
                                <input type="text" class="editinput" x-model="variantExtension.variantColorCode" :name="'variantColorCode[' + variantExtension.id + ']'">
                            </td>
                            <td class="listitem">
                                <input type="text" class="editinput" x-model="variantExtension.variantImage" :name="'variantImage[' + variantExtension.id + ']'">
                                <input type="file" class="editinput" :name="'myfile[ITS_VARINAT_IMAGES@varinat_image' + variantExtension.id + ']'">
                            </td>
                            <td class="listitem">
                                <a href="#" class="delete" onmouseout="popDown('item_delete')" onmouseover="popUp(event,'item_delete');return true" @click.prevent="removeRecord(variantExtension.id);"></a>
                            </td>
                        </tr>
                    </template>
                </table>
            </div>

            <input class="btn-save" type="submit" :value="i18n.ITS_ARTICLE_VARIANT_BTN_SAVE">
            <input class="btn-abort" type="button" :value="i18n.ITS_ARTICLE_VARIANT_BTN_ABORT" @click.prevent="reloadData()">
        </form>
    </div>
</div>