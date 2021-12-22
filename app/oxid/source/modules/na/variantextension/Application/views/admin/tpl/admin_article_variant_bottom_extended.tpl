[{$smarty.block.parent}]
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<script>
    let content = [{$edit->getVariantExtensionAdminJSON()}];

    document.addEventListener("DOMContentLoaded", () =>
    {
    });

    function calcIndex(data)
    {
        let i = 1;
        data.forEach(function (record) {
            record.id = i;
            i++;
        });

        return data;
    }

    const removeData = async(id) => {
        const form = document.querySelector('#variantsDelete');
        const formData = new FormData(form);
        formData.append('variantId', id);

        return fetch(form.action, {
            method: 'POST',
            body: formData
        }).then((response) => {
            if (!response.ok) alert(`Something went wrong: ${response.status} - ${response.statusText}`)
            return response.json()
        })
    }

    function pushData(data)
    {
        let item = {
            id: data.length + 1,
            variantName: '',
            variantValue: '',
            variantContentType: '',
            variantColorCode: '',
            variantImage: '',
            transferred: false
        };

        return data.concat(item)
    }
</script>

<div x-cloak>
    <div x-data="{ data: content }">
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

            <input type="button" value="add variant extension" @click.prevent="data = pushData(data);">
            <div class="table" style="display: table">
                <table id="variantsUploadWrapper">
                    <tr>
                        <td class="listheader">Name Variante</td>
                        <td class="listheader">Wert Variante</td>
                        <td class="listheader">Inhalt</td>
                        <td class="listheader">Color-Code</td>
                        <td class="listheader">Bild</td>
                        <td class="listheader" colspan="2">&nbsp</td>
                    </tr>
                    <template x-for="(variantExtension, index) in data" :key="variantExtension.id">
                        <tr>
                            <td>
                                <input type="text" class="editinput" x-model="variantExtension.variantName" x-bind:name="'variantName[' + variantExtension.id + ']'">
                            </td>
                            <td>
                                <input type="text" class="editinput" x-model="variantExtension.variantValue" x-bind:name="'variantValue[' + variantExtension.id + ']'">
                            </td>
                            <td>
                                <label>
                                    <input type="radio" value="color" class="editinput" x-model="variantExtension.variantContentType" x-bind:name="'variantContentType[' + variantExtension.id + ']'">
                                    Color
                                </label>
                                <label>
                                    <input type="radio" value="image" class="editinput" x-model="variantExtension.variantContentType" x-bind:name="'variantContentType[' + variantExtension.id + ']'">
                                    Image</label>
                            </td>
                            <td>
                                <input type="text" class="editinput" x-model="variantExtension.variantColorCode" x-bind:name="'variantColorCode[' + variantExtension.id + ']'">
                            </td>
                            <td>
                                <input type="text" class="editinput" x-model="variantExtension.variantImage" x-bind:name="'variantImage[' + variantExtension.id + ']'">
                                <input type="file" class="editinput" x-bind:name="'myfile[NA_VARINAT_IMAGES@varinat_image' + variantExtension.id + ']'">
                            </td>
                            <td>
                                <input type="checkbox" value="true" disabled="" x-model="variantExtension.transferred" class="editinput" x-bind:name="'variantTransferred[' + variantExtension.id + ']'">
                                <a href="#" class="delete" onmouseout="popDown('item_delete')" onmouseover="popUp(event,'item_delete');return true" @click.prevent="data = await removeData(variantExtension.id);"></a>
                            </td>
                        </tr>
                    </template>
                </table>
            </div>

            <input id="variantsUploadSubmit" type="submit" value="speichern">
        </form>
    </div>
</div>