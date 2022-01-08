<div class="container">
    <div class="row">
        <div class="col-4">
            <img src="[{$oxwArticleDetails->getActPicture()}]" itemprop="image" class="img-fluid img-ajaxmodal">
        </div>
        <div class="col-8">
            [{$oDetailsProduct->oxarticles__oxtitle->value}] [{$oDetailsProduct->oxarticles__oxvarselect->value}]<br>
            [{oxmultilang ident="ARTNUM" suffix="COLON"}] [{$oDetailsProduct->oxarticles__oxartnum->value}]
            <div>
                [{assign var="iRatingValue" value=$oxwArticleDetails->getRatingValue()}]

                [{if $iRatingValue}]
                    [{strip}]
                        <div class="hidden" itemtype="http://schema.org/AggregateRating" itemscope="" itemprop="aggregateRating">
                            <span itemprop="worstRating">1</span>
                            <span itemprop="bestRating ">5</span>
                            <span itemprop="ratingValue">[{$iRatingValue}]</span>
                            <span itemprop="reviewCount">[{$oxwArticleDetails->getRatingCount()}]</span>
                        </div>
                    [{/strip}]
                [{/if}]

                [{if !$oxcmp_user}]
                    [{assign var="_star_title" value="MESSAGE_LOGIN_TO_RATE"|oxmultilangassign}]
                [{elseif !$oxwArticleDetails->canRate()}]
                    [{assign var="_star_title" value="MESSAGE_ALREADY_RATED"|oxmultilangassign}]
                [{else}]
                    [{assign var="_star_title" value="MESSAGE_RATE_THIS_ARTICLE"|oxmultilangassign}]
                [{/if}]


                [{section name="starRatings" start=0 loop=5}]
                    [{if $iRatingValue == 0}]
                        <i class="fa fa-star rating-star-empty"></i>
                    [{else}]
                        [{if $iRatingValue > 1}]
                            <i class="fa fa-star rating-star-filled"></i>
                            [{assign var="iRatingValue" value=$iRatingValue-1}]
                        [{else}]
                            [{if $iRatingValue < 0.5}]
                                [{if $iRatingValue < 0.3}]
                                    <i class="fa fa-star rating-star-empty"></i>
                                [{else}]
                                    <i class="fa fa-star-half-o rating-star-filled"></i>
                                [{/if}]
                            [{assign var="iRatingValue" value=0}]
                            [{elseif $iRatingValue > 0.8}]
                                <i class="fa fa-star rating-star-filled"></i>
                                [{assign var="iRatingValue" value=0}]
                            [{else}]
                                <i class="fa fa-star-half-o rating-star-filled"></i>
                                [{assign var="iRatingValue" value=0}]
                            [{/if}]
                        [{/if}]
                    [{/if}]
                [{/section}]
            </div>
            [{oxhasrights ident="SHOWSHORTDESCRIPTION"}]
                [{if $oDetailsProduct->oxarticles__oxshortdesc->rawValue}]
                    <p class="shortdesc mt-4" id="productShortdesc" itemprop="description">[{$oDetailsProduct->oxarticles__oxshortdesc->rawValue}]</p>
                [{/if}]
            [{/oxhasrights}]
        </div>
    </div>
</div>