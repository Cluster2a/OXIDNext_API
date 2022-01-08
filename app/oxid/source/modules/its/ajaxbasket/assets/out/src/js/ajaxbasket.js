! function(a) {
    itsOxAjax = {
        loadingScreen: {
            start: function (a, b) {
                var c = Array();
                return $(a).each(function () {
                    var a = document.createElement("div");
                    if (a.innerHTML = '<div class="loadingfade"></div><div class="loadingicon"></div><div class="loadingiconbg"></div>', $("div", a).css({
                        position: "absolute",
                        left: $(this).offset().left - 10,
                        top: $(this).offset().top - 10,
                        width: $(this).width() + 20,
                        height: $(this).height() + 20
                    }), b && b.length) {
                        var d = Math.round(b.offset().left - 10 - $(this).offset().left + b.width() / 2),
                            e = b.offset().top,
                            f = Math.round(e - 10 - $(this).offset().top + (b.last().offset().top - e + b.last().height()) / 2);
                        $("div.loadingiconbg, div.loadingicon", a).css({
                            "background-position": d + "px " + f + "px"
                        })
                    }
                    $("div.loadingfade", a).css({
                        opacity: 0
                    }).animate({
                        opacity: 0.55
                    }, 200), $("body").append(a), c.push(a);
                }), c
            },
            stop: function (a) {
                $.each(a, function (a, b) {
                    $("div", b).not(".loadingfade").remove(), $("div.loadingfade", b).stop(!0, !0).animate({
                        opacity: 0
                    }, 100, function () {
                        $(b).remove();
                    })
                })
            }
        },
        updatePageErrors: function (a) {
            if (a.length) {
                var b = $("#content > .status.error");
                if (0 == b.length && ($("#content").prepend("<div class='status error corners'>"), b = $("#content > .status.error")), b) {
                    b.children().remove();
                    var c;
                    for (c = 0; c < a.length; c++) {
                        var d = document.createElement("p");
                        $(d).append(document.createTextNode(a[c])), b.append(d);
                    }
                }
            } else $("#content > .status.error").remove()
        },
        ajax: function (a, b) {

            var blFileUpload = false;

            var c = this,
                d = {},
                e = "",
                f = "";
            "FORM" == a[0].tagName ? ($("input, textarea, select", a).each(function () {
                switch (this.type) {
                    case "hidden":
                    case "password":
                    case "text":
                    case "number":
                    case "textarea":
                    case "select-one":
                        return void (d[this.name] = this.value);
                        break;
                    case "checkbox":
                        if (this.checked)
                            return void (d[this.name] = 1);
                        else
                            return void (d[this.name] = 0);
                        break;
                    case "radio":
                        if (this.checked)
                            return void (d[this.name] = this.value);
                        break;
                    case 'file':
                        blFileUpload = true;
                        break;
                }

            }), e = a.attr("action"), f = a.attr("method")) : "A" == a[0].tagName && (e = a.attr("href")), b.additionalData && $.each(b.additionalData, function (a, b) {
                d[a] = b
            });
            var g = {},
                h = Array();

            for (var i in d) d.hasOwnProperty(i) && h.push(i);

            var form_data = new FormData();
            if(blFileUpload === true) {
                var logo = $(a[0]).find("input[type='file']").prop('files')[0];
                form_data.append('logo', logo);
            }


            h.sort().forEach(function (a) {
                if(blFileUpload === true) {
                    form_data.append(a, d[a]);
                } else {
                    g[a] = d[a];
                }
            });

            var j = null;
            var z = b.dataType;

            var processData = true;
            contentType = "application/json; charset=utf-8";
            if(blFileUpload === true) {
                g = form_data;

                processData = false;
                contentType = false;
            }

            var ajax = {};
            ajax.data = g;
            ajax.url = e;
            ajax.type = f;
            ajax.cache = false;
            ajax.processData = processData;
            if(blFileUpload === true) {
                ajax.contentType = false;
            }
            ajax.dataType = z;
            ajax.timeout = 3e4;
            ajax.beforeSend = function (a, b) {
                b.url = b.url.replace("&&", "&");
            };
            ajax.error = function (a, d, e) {
                j && c.loadingScreen.stop(j), b.onError && b.onError(a, d, e);
            };
            ajax.success = function (a) {
                j && c.loadingScreen.stop(j), void 0 != a.debuginfo && a.debuginfo && $("body").append(a.debuginfo), void 0 != a.errors && void 0 != a.errors.default ? c.updatePageErrors(a.errors.default) : c.updatePageErrors([]), b.onSuccess && b.onSuccess(a, d)
            };

            b.targetEl && (j = c.loadingScreen.start(b.targetEl, b.iconPosEl)), f || (f = "get"), jQuery.ajax(ajax);

        },
        reportJSError: function (a) {
            "undefined" != typeof console && void 0 !== console.error && console.error(a);
        },
        evalScripts: function (container) {
            var self = this;
            try {
                $("script", container).each(function () {
                    try {
                        if ("" != this.src && 0 == $('body > script[src="' + this.src + '"]').length) return $("body").append(this), document.body.appendChild(this), !0;
                        eval(this.innerHTML);
                    } catch (e) {
                        self.reportJSError(e);
                    }
                    $(this).remove();
                })
            } catch (e) {
                self.reportJSError(e);
            }
        }
    };

let its_oxAddToBasket = {
    _create: function () {
        const b = this,
            c = (b.options, b.element);

        c.click(function () {
            const form = a(this).closest("form");
            b.submitForm(form);
            return false;
        })
    },

    submitForm: function (form) {
        const addData = {};
        addData.doAjax = true;
        itsOxAjax.ajax(form, {
            dataType: 'json',
            additionalData: addData,
            onSuccess: function (data) {
                if (data.success === true) {
                    a("div#itsItemAddedModal").find("div#itsItemAddedModalinnerBody").html(data.contentModal);
                    a("div#itsItemAddedModal").modal("show");
                    a("span#basketCounter").text(data.itemAmount);

                    let $contents = $('a.fixed-header-link').first().contents();
                    $contents[$contents.length - 1].nodeValue = ' ' + data.itemAmount;

                    a("div.minibasket-menu-box").html(data.contentMiniBasket);
                }
            }
        })
    }
};
a.widget("ui.its_oxAddToBasket", its_oxAddToBasket)
}(jQuery);