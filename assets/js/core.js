/**
 * Proxy Manager Pro
 * 
 * @author Alifur Rahman (https://alifurrahman.com)
 * 
 */
var SmmManager = {};

!function(t,n){"object"==typeof exports&&"undefined"!=typeof module?module.exports=n():"function"==typeof define&&define.amd?define(n):(t=t||self).LazyLoad=n()}(this,(function(){"use strict";function t(){return(t=Object.assign||function(t){for(var n=1;n<arguments.length;n++){var e=arguments[n];for(var i in e)Object.prototype.hasOwnProperty.call(e,i)&&(t[i]=e[i])}return t}).apply(this,arguments)}var n="undefined"!=typeof window,e=n&&!("onscroll"in window)||"undefined"!=typeof navigator&&/(gle|ing|ro)bot|crawl|spider/i.test(navigator.userAgent),i=n&&"IntersectionObserver"in window,o=n&&"classList"in document.createElement("p"),r=n&&window.devicePixelRatio>1,a={elements_selector:".lazy",container:e||n?document:null,threshold:300,thresholds:null,data_src:"src",data_srcset:"srcset",data_sizes:"sizes",data_bg:"bg",data_bg_hidpi:"bg-hidpi",data_bg_multi:"bg-multi",data_bg_multi_hidpi:"bg-multi-hidpi",data_poster:"poster",class_applied:"applied",class_loading:"loading",class_loaded:"loaded",class_error:"error",class_entered:"entered",class_exited:"exited",unobserve_completed:!0,unobserve_entered:!1,cancel_on_exit:!0,callback_enter:null,callback_exit:null,callback_applied:null,callback_loading:null,callback_loaded:null,callback_error:null,callback_finish:null,callback_cancel:null,use_native:!1},c=function(n){return t({},a,n)},s=function(t,n){var e,i="LazyLoad::Initialized",o=new t(n);try{e=new CustomEvent(i,{detail:{instance:o}})}catch(t){(e=document.createEvent("CustomEvent")).initCustomEvent(i,!1,!1,{instance:o})}window.dispatchEvent(e)},l="loading",u="loaded",d="applied",f="error",_="native",g="data-",v="ll-status",p=function(t,n){return t.getAttribute(g+n)},b=function(t){return p(t,v)},h=function(t,n){return function(t,n,e){var i="data-ll-status";null!==e?t.setAttribute(i,e):t.removeAttribute(i)}(t,0,n)},m=function(t){return h(t,null)},E=function(t){return null===b(t)},y=function(t){return b(t)===_},A=[l,u,d,f],I=function(t,n,e,i){t&&(void 0===i?void 0===e?t(n):t(n,e):t(n,e,i))},L=function(t,n){o?t.classList.add(n):t.className+=(t.className?" ":"")+n},w=function(t,n){o?t.classList.remove(n):t.className=t.className.replace(new RegExp("(^|\\s+)"+n+"(\\s+|$)")," ").replace(/^\s+/,"").replace(/\s+$/,"")},k=function(t){return t.llTempImage},O=function(t,n){if(n){var e=n._observer;e&&e.unobserve(t)}},x=function(t,n){t&&(t.loadingCount+=n)},z=function(t,n){t&&(t.toLoadCount=n)},C=function(t){for(var n,e=[],i=0;n=t.children[i];i+=1)"SOURCE"===n.tagName&&e.push(n);return e},N=function(t,n,e){e&&t.setAttribute(n,e)},M=function(t,n){t.removeAttribute(n)},R=function(t){return!!t.llOriginalAttrs},G=function(t){if(!R(t)){var n={};n.src=t.getAttribute("src"),n.srcset=t.getAttribute("srcset"),n.sizes=t.getAttribute("sizes"),t.llOriginalAttrs=n}},T=function(t){if(R(t)){var n=t.llOriginalAttrs;N(t,"src",n.src),N(t,"srcset",n.srcset),N(t,"sizes",n.sizes)}},j=function(t,n){N(t,"sizes",p(t,n.data_sizes)),N(t,"srcset",p(t,n.data_srcset)),N(t,"src",p(t,n.data_src))},D=function(t){M(t,"src"),M(t,"srcset"),M(t,"sizes")},F=function(t,n){var e=t.parentNode;e&&"PICTURE"===e.tagName&&C(e).forEach(n)},P={IMG:function(t,n){F(t,(function(t){G(t),j(t,n)})),G(t),j(t,n)},IFRAME:function(t,n){N(t,"src",p(t,n.data_src))},VIDEO:function(t,n){!function(t,e){C(t).forEach((function(t){N(t,"src",p(t,n.data_src))}))}(t),N(t,"poster",p(t,n.data_poster)),N(t,"src",p(t,n.data_src)),t.load()}},S=function(t,n){var e=P[t.tagName];e&&e(t,n)},V=function(t,n,e){x(e,1),L(t,n.class_loading),h(t,l),I(n.callback_loading,t,e)},U=["IMG","IFRAME","VIDEO"],$=function(t,n){!n||function(t){return t.loadingCount>0}(n)||function(t){return t.toLoadCount>0}(n)||I(t.callback_finish,n)},q=function(t,n,e){t.addEventListener(n,e),t.llEvLisnrs[n]=e},H=function(t,n,e){t.removeEventListener(n,e)},B=function(t){return!!t.llEvLisnrs},J=function(t){if(B(t)){var n=t.llEvLisnrs;for(var e in n){var i=n[e];H(t,e,i)}delete t.llEvLisnrs}},K=function(t,n,e){!function(t){delete t.llTempImage}(t),x(e,-1),function(t){t&&(t.toLoadCount-=1)}(e),w(t,n.class_loading),n.unobserve_completed&&O(t,e)},Q=function(t,n,e){var i=k(t)||t;B(i)||function(t,n,e){B(t)||(t.llEvLisnrs={});var i="VIDEO"===t.tagName?"loadeddata":"load";q(t,i,n),q(t,"error",e)}(i,(function(o){!function(t,n,e,i){var o=y(n);K(n,e,i),L(n,e.class_loaded),h(n,u),I(e.callback_loaded,n,i),o||$(e,i)}(0,t,n,e),J(i)}),(function(o){!function(t,n,e,i){var o=y(n);K(n,e,i),L(n,e.class_error),h(n,f),I(e.callback_error,n,i),o||$(e,i)}(0,t,n,e),J(i)}))},W=function(t,n,e){!function(t){t.llTempImage=document.createElement("IMG")}(t),Q(t,n,e),function(t,n,e){var i=p(t,n.data_bg),o=p(t,n.data_bg_hidpi),a=r&&o?o:i;a&&(t.style.backgroundImage='url("'.concat(a,'")'),k(t).setAttribute("src",a),V(t,n,e))}(t,n,e),function(t,n,e){var i=p(t,n.data_bg_multi),o=p(t,n.data_bg_multi_hidpi),a=r&&o?o:i;a&&(t.style.backgroundImage=a,function(t,n,e){L(t,n.class_applied),h(t,d),n.unobserve_completed&&O(t,n),I(n.callback_applied,t,e)}(t,n,e))}(t,n,e)},X=function(t,n,e){!function(t){return U.indexOf(t.tagName)>-1}(t)?W(t,n,e):function(t,n,e){Q(t,n,e),S(t,n),V(t,n,e)}(t,n,e)},Y=["IMG","IFRAME"],Z=function(t){return t.use_native&&"loading"in HTMLImageElement.prototype},tt=function(t,n,e){t.forEach((function(t){return function(t){return t.isIntersecting||t.intersectionRatio>0}(t)?function(t,n,e,i){h(t,"entered"),L(t,e.class_entered),w(t,e.class_exited),function(t,n,e){n.unobserve_entered&&O(t,e)}(t,e,i),I(e.callback_enter,t,n,i),function(t){return A.indexOf(b(t))>=0}(t)||X(t,e,i)}(t.target,t,n,e):function(t,n,e,i){E(t)||(L(t,e.class_exited),function(t,n,e,i){e.cancel_on_exit&&function(t){return b(t)===l}(t)&&"IMG"===t.tagName&&(J(t),function(t){F(t,(function(t){D(t)})),D(t)}(t),function(t){F(t,(function(t){T(t)})),T(t)}(t),w(t,e.class_loading),x(i,-1),m(t),I(e.callback_cancel,t,n,i))}(t,n,e,i),I(e.callback_exit,t,n,i))}(t.target,t,n,e)}))},nt=function(t){return Array.prototype.slice.call(t)},et=function(t){return t.container.querySelectorAll(t.elements_selector)},it=function(t){return function(t){return b(t)===f}(t)},ot=function(t,n){return function(t){return nt(t).filter(E)}(t||et(n))},rt=function(t,e){var o=c(t);this._settings=o,this.loadingCount=0,function(t,n){i&&!Z(t)&&(n._observer=new IntersectionObserver((function(e){tt(e,t,n)}),function(t){return{root:t.container===document?null:t.container,rootMargin:t.thresholds||t.threshold+"px"}}(t)))}(o,this),function(t,e){n&&window.addEventListener("online",(function(){!function(t,n){var e;(e=et(t),nt(e).filter(it)).forEach((function(n){w(n,t.class_error),m(n)})),n.update()}(t,e)}))}(o,this),this.update(e)};return rt.prototype={update:function(t){var n,o,r=this._settings,a=ot(t,r);z(this,a.length),!e&&i?Z(r)?function(t,n,e){t.forEach((function(t){-1!==Y.indexOf(t.tagName)&&(t.setAttribute("loading","lazy"),function(t,n,e){Q(t,n,e),S(t,n),h(t,_)}(t,n,e))})),z(e,0)}(a,r,this):(o=a,function(t){t.disconnect()}(n=this._observer),function(t,n){n.forEach((function(n){t.observe(n)}))}(n,o)):this.loadAll(a)},destroy:function(){this._observer&&this._observer.disconnect(),et(this._settings).forEach((function(t){delete t.llOriginalAttrs})),delete this._observer,delete this._settings,delete this.loadingCount,delete this.toLoadCount},loadAll:function(t){var n=this,e=this._settings;ot(t,e).forEach((function(t){O(t,n),X(t,e,n)}))}},rt.load=function(t,n){var e=c(n);X(t,e)},rt.resetStatus=function(t){m(t)},n&&function(t,n){if(n)if(n.length)for(var e,i=0;e=n[i];i+=1)s(t,e);else s(t,n)}(rt,window.lazyLoadOptions),rt}));

var lazyLoadInstance = new LazyLoad();

SmmManager.isDefined = function(foo) {
    return typeof(foo) !== 'undefined'
}

/**
 * jToast 
 * A modern & easy-going jQuery Plugin to create Toasts.
 * 
 * Version: 1.0.0
 * Author: Alifur Rahman
 * Author URI: https://alifur.com
 */
if (SmmManager.isDefined(showToast) && SmmManager.isDefined(hideToast)) {
    let toasts = 0;
    let manager = {
        ready: true,
        jobs: [],
        currentWorkingID: 0,
        addJob(job) {
            this.ready = false;
            job.type === "show" ? this.jobs.push({ text: job.text, args: job.args, type: "show" }) : this.jobs.push({ id: job.id, type: "hide" });

            const waitUntilReady = setInterval(() => {
                if (this.workJobOff()) {
                    clearInterval(waitUntilReady);
                }
            }, 250);
        },
        removeJob(id) {
            if (this.currentWorkingID === id) {
                this.ready = true;
            }
        },
        workJobOff() {
            if (this.ready && this.jobs.length > 0) {
                this.jobs[0].type === "show" ? showToast(this.jobs[0].text, this.jobs[0].args) : hideToast(this.jobs[0].id);
                this.jobs.splice(0, 1);
                return true;
            }
        }
    };
    function showToast(text, { duration = 3000, background = "#232323", color = "#fff", borderRadius = "0px", icon_style = false, close = false, progressBar = false, pageReload = false, customCss = "", closeCss = "", loaderCss = "" } = {}) {
        const selectedToast = toasts;
        if (!manager.ready) {
            manager.addJob({ text: text, args: showToast.arguments[1], workingID: selectedToast, type: "show" });
            return;
        }
        manager.currentWorkingID = selectedToast;

        $("#toasts").append(`
            <div style="background: ${background}; color: ${color}; border-radius: ${borderRadius}; ${close ? 'display: flex;' : ''}; ${customCss}" data-toast-id="${toasts}" class="toast">
                ${icon_style ? `<span class="${icon_style}" style="font-size: 18px;line-height: 18px;margin-right: 7px;"></span>` : ""}
                <span style="line-height: 20px;">${text}</span>
                ${progressBar && duration !== "lifetime" ? `<div style="animation-duration: ${duration}ms; background: ${color};" class="progress" style="${loaderCss}"></div>` : ""}
            </div>
        `);

        if (close)
            $(`[data-toast-id="${selectedToast}"]`).append(`
                <div style="height: ${$(`[data-toast-id="${selectedToast}"] > span`).height()}px; ${closeCss}" onclick="hideToast(${selectedToast})" class="close">&times;</div>
            `);

        $(".toast").map((i) => {
            manager.ready = false;
            if (i !== selectedToast) {
                $(".toast").eq(i).animate({
                    "margin-top": "+=" + parseInt($(`[data-toast-id="${selectedToast}"]`).height() + (15 * 2) + 15 + 5) + "px"
                }, 300);

                setTimeout(() => {
                    manager.removeJob(selectedToast);
                }, 300);
            } else {
                setTimeout(() => {
                    $(".toast").eq(i).animate({
                        "margin-top": "25px"
                    }, 300);

                    setTimeout(() => {
                        manager.removeJob(selectedToast);
                    }, 300);
                }, 150);
            }
        });

        if (duration !== "lifetime") {
            setTimeout(() => {
                $(`[data-toast-id="${selectedToast}"]`).animate({
                    "margin-right": "-" + parseInt($(`[data-toast-id="${selectedToast}"]`).width() + (15 * 2) + 25 + 100) + "px"
                }, 300);

                if (selectedToast !== toasts) {
                    $(".toast").map((i) => {
                        if (i < selectedToast) {
                            setTimeout(() => {
                                $(".toast").eq(i).animate({
                                    "margin-top": "-=" + parseInt($(`[data-toast-id="${selectedToast}"]`).height() + (15 * 2) + 15 + 5) + "px"
                                }, 300);
                            }, 300);
                        }
                    });
                }

                setTimeout(() => {
                    $(`[data-toast-id="${selectedToast}"]`).addClass("hidden");
                    if (pageReload) {
                        window.location.reload();
                    }
                }, 300);
            }, duration);
        }

        toasts++;
        return selectedToast;
    }
    function hideToast(id) {
        if (parseInt($(`[data-toast-id="${id}"]`).css("margin-right").replace("px", "")) === 0) {
            $(`[data-toast-id="${id}"]`).animate({
                "margin-right": "-" + parseInt($(`[data-toast-id="${id}"]`).width() + (15 * 2) + 25 + 100) + "px"
            }, 300);

            if (id !== toasts) {
                $(".toast").map((i) => {
                    if (i < id) {
                        setTimeout(() => {
                            $(".toast").eq(i).animate({
                                "margin-top": "-=" + parseInt($(`[data-toast-id="${id}"]`).height() + (15 * 2) + 15 + 5) + "px"
                            }, 300);
                        }, 300);
                    }
                });
            }

            setTimeout(() => {
                $(`[data-toast-id="${id}"]`).addClass("hidden");
            }, 300);
        }
    }
    (() => {
        $("head").append(`
            <style>
                .toast {
                    padding: 15px;
                    color: #fff;
                    position: fixed;
                    right: 25px;
                    top: 0;
                    margin-top: -100px;
                    box-shadow: 0 10px 40px 0 rgba(62,57,107,.07), 0 2px 9px 0 rgba(62,57,107,.12);
                    max-width: 50%;
                    z-index: 2147483647;
                }

                @media screen and (max-width: 800px) {
                    .toast {
                        max-width: 75%;
                    }
                }
                
                @keyframes progress {
                    from { width: 100% }
                    to { width: 0% }
                }
                
                .toast > .progress {
                    position: absolute;
                    height: 2px;
                    width: 100%;
                    margin-left: -15px;
                    bottom: 0;
                    opacity: 0.75;
                    animation: progress linear forwards;
                }
                
                .toast > .close {
                    margin-left: 15px;
                    opacity: 0.75;
                    font-size: 24px;
                    display: flex;
                    align-items: center;
                    cursor: pointer;
                }

                .toast a {
                    color: inherit;
                    text-decoration: underline;
                    text-underline-offset: 2px; 
                }
            </style>
        `);

        $("body").append(`<div id="toasts"></div>`);
    })();
}

/**
 * Add msg to the $resobj and displays it 
 * and scrolls to $resobj
 * @param {$ DOM} $form jQuery ref to form
 * @param {string} type
 * @param {string} msg
 */
var __form_result_timer = null;
SmmManager.DisplayFormResult = function($form, type, msg, time = 10000) {
    var $resobj = $form.find(".form-result");
    msg = msg || "";
    type = type || "error";

    if ($resobj.length != 1) {
        return false;
    }


    var $reshtml = "";
    switch (type) {
        case "error":
            $reshtml = "<div class='error'><span class='sli sli-close icon'></span> "+msg+"</div>";
            break;

        case "success":
            $reshtml = "<div class='success'><span class='sli sli-check icon'></span> "+msg+"</div>";
            break;

        case "info":
            $reshtml = "<div class='info'><span class='sli sli-info icon'></span> "+msg+"</div>";
            break;
    }

    $resobj.html($reshtml).stop(true).fadeIn();

    clearTimeout(__form_result_timer);
    __form_result_timer = setTimeout(function() {
        $resobj.stop(true).fadeOut();
    }, time);

    var $parent = $("html, body");
    var top = $resobj.offset().top - 85;
    if ($form.parents(".skeleton-content").length == 1) {
        $parent = $form.parents(".skeleton-content");
        top = $resobj.offset().top - $form.offset().top - 20;
    }

    $parent.animate({
        scrollTop: top + "px"
    });
}



SmmManager.SettingsTogglers = function(){
    var togglers_list = [
        "installation",
        "github",
        "license",
        "advanced",
        "cloudflare",
        "cronjob",
        "telegram",
        "auto-relogin"
    ];

    togglers_list.forEach(tgglr => {
        var pmp_container = $("body").find(".pmp-settings-" + tgglr);
        var pmp_button = $("body").find(".pmp-settings-" + tgglr + "-toggler");

        $("body").find(".pmp-settings-" + tgglr + "-toggler").off("click").on("click", function() {
            pmp_container.toggleClass("none");
            if (!pmp_container.hasClass("none")) {
                localStorage.setItem("pmp_settings_" + tgglr + "_state", 1);
                pmp_button.addClass("opened");
                pmp_button.find(".mdi").removeClass("mdi-arrow-down");
                pmp_button.find(".mdi").addClass("mdi-arrow-up");
            } else {
                localStorage.setItem("pmp_settings_" + tgglr + "_state", 0);
                pmp_button.removeClass("opened");
                pmp_button.find(".mdi").removeClass("mdi-arrow-up")
                pmp_button.find(".mdi").addClass("mdi-arrow-down")
            }
        });

        var state = localStorage.getItem("pmp_settings_" + tgglr + "_state");
        if (state == 1) {
            pmp_container.removeClass("none");
            pmp_button.addClass("opened");
            pmp_button.find(".mdi").removeClass("mdi-arrow-down");
            pmp_button.find(".mdi").addClass("mdi-arrow-up");
        } else if (state == null && (tgglr == "license")) {
            pmp_container.removeClass("none");
            pmp_button.addClass("opened");
            pmp_button.find(".mdi").removeClass("mdi-arrow-down");
            pmp_button.find(".mdi").addClass("mdi-arrow-up");
        }
    });
}

SmmManager.defaultAjaxHandler = function () {
    $("body").on("click", ".smm_send_ajax", function (e) {
        e.preventDefault();
    
        const $btn = $(this);
        const url = $btn.data("url");
        const action = $btn.data("action");
        let rawData = $btn.attr("data-all");
    
        let parsedData = {};
        try {
            parsedData = JSON.parse(rawData);
        } catch (err) {
            console.error("Invalid JSON in data-all attribute:", err);
            NextPost.Alert({
                title: "Error",
                content: "Invalid data format.",
                confirmText: "Close"
            });
            return;
        }
    
        const postData = {
            action: action,
            data: JSON.stringify(parsedData)
        };
    
        $(".al_expand_alert_wrapper").addClass("onprogress");
    
        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: postData,
            success: function (response) {
                $(".al_expand_alert_wrapper").removeClass("onprogress");
    
                if (response && response.result === 1) {
                    NextPost.Alert({
                        title: "Success",
                        content: response.message || "Operation completed successfully.",
                        confirmText: "OK",
                        confirm: function () {
                            if (response.redirect !== null) {
                                window.location.href = response.redirect;
                            }
                        }
                    });
                  
                } else {
                    NextPost.Alert({
                        title: "Error",
                        content: response.message || "Something went wrong.",
                        confirmText: "Close"
                    });
                }
            },
            error: function () {
                $(".al_expand_alert_wrapper").removeClass("onprogress");
    
                NextPost.Alert({
                    title: "Request Failed",
                    content: "Could not complete the request. Please try again.",
                    confirmText: "Close"
                });
            }
        });
    });
    
};


SmmManager.orderActionAjax = function () {
    $("body").on("click", ".smm_js_order_action", function (e) {
        e.preventDefault();
    
        const $btn = $(this);
        const url = $btn.data("url");
        let action = $btn.data("action");
        let orderID = $btn.attr("data-id");
        console.log(action, orderID);

        const postData = {
            action: action,
            id: orderID
        };
    
        $(".al_expand_alert_wrapper").addClass("onprogress");
    
        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: postData,
            success: function (response) {
                $(".al_expand_alert_wrapper").removeClass("onprogress");
    
                if (response && response.result === 1) {
                    NextPost.Alert({
                        title:response.message || "Operation completed successfully.",
                        content:SmmManager.gerDetialHtmlOfdata(response.data),
                        confirmText: "OK"
                    });
                } else {
                    NextPost.Alert({
                        title: "Error",
                        content: response.message || "Something went wrong.",
                        confirmText: "Close"
                    });
                }
            },
            error: function () {
                $(".al_expand_alert_wrapper").removeClass("onprogress");
    
                NextPost.Alert({
                    title: "Request Failed",
                    content: "Could not complete the request. Please try again.",
                    confirmText: "Close"
                });
            }
        });
    });
   
};



SmmManager.gerDetialHtmlOfdata = function (rawData) {
    if (!rawData || typeof rawData !== "object") return "<ul><li>No details available.</li></ul>";

    return `<div class="al_expand_alert_wrapper">
                <div class="al_services_infos">
                    ${SmmManager.renderObjectRecursive(rawData)}
                </div>
            </div>`;
}


SmmManager.renderObjectRecursive =  function (obj) {
    let html = "<ul class='al_status_list'>";

    for (const [key, value] of Object.entries(obj)) {
        const formattedKey = SmmManager.formatKey(key);

        if (typeof value === "object" && value !== null) {
            html += `<li><strong class="al_service_label">${formattedKey}:</strong> ${SmmManager.renderObjectRecursive(value)}</li>`;
        } else {
            html += `<li><strong class="al_service_label">${formattedKey}:</strong> ${value}</li>`;
        }
    }

    html += "</ul>";
    return html;
}

SmmManager.formatKey = function(key) {
    return key.replace(/_/g, ' ')
              .replace(/\b\w/g, char => char.toUpperCase());
}


SmmManager.createOrderAction = function () {
    $("body").on("click", ".smm_js_create_order", function () {
        const $btn = $(this);
        let serviceDataRaw = $btn.attr("data-all");
        let searchUrl = $btn.data("search-url");

        try {
            let serviceData = JSON.parse(serviceDataRaw); // Parse JSON string

            let popupWrapper = $(".smm_side_bar_wrapper");
            popupWrapper.addClass("active");

            // Use the helper
            let html = SmmManager.renderServiceDataList(serviceData);
            popupWrapper.find(".smm_show_selected_service").html(html);
             // Update form inputs if form exists inside container
             let $form = popupWrapper.find("form.js_smm_create_order");

             if ($form.length > 0) {
                 $form.find('input[name="service_id"]').val(serviceData.service || '');
                 $form.find('input[name="service_name"]').val(serviceData.name || '');
             }
             // Update quantity input min/max and note
            let $quantityInput = popupWrapper.find(".js-quantity-input");
            let $quantityNote = popupWrapper.find(".js-quantity-note");

            if ($quantityInput.length && $quantityNote.length) {
                let min = serviceData.min || 0;
                let max = serviceData.max || 0;

                $quantityInput.attr("min", min);
                $quantityInput.attr("max", max);
                $quantityInput.val(min); // optionally set default value

                $quantityNote.text(`Note: Quantity can be Min: ${min} - Max: ${max}`);
            }
            // Init Select2 after rendering
            SmmManager.initAccountSearchSelect(searchUrl,popupWrapper);

            // Handle close
            let closeBtn = popupWrapper.find(".smm_side_bar_close");
            closeBtn.on("click", function () {
                popupWrapper.removeClass("active");
            });

        } catch (e) {
            console.error("Invalid JSON in data-all:", e);
        }
    });
};


SmmManager.renderServiceDataList = function(serviceData) {
    let listHtml = '<ul>';
    $.each(serviceData, function (key, value) {
        let label = key.replace(/_/g, ' ');
        label = label.charAt(0).toUpperCase() + label.slice(1); // ucfirst

        // Escape and format value
        value = (typeof value === 'boolean')
            ? (value ? 'Yes' : 'No')
            : $('<div>').text(value).html(); // Escape HTML

        listHtml += `
            <li>
                <span class="al_service_label">${label}:</span>
                <span>${value}</span>
            </li>
        `;
    });
    listHtml += '</ul>';
    return listHtml;
};


SmmManager.initAccountSearchSelect = function (searchUrl,popupWrapper) {
    $('.js-smm-account-search').select2({
        placeholder: "Search Accounts username",
        ajax: {
            url: searchUrl,
            type: 'POST',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    page: params.page || 1,
                    action: "search_accounts"
                };
            },
            processResults: function (data) {
                return {
                    results: data.results.map(function (account) {
                        return {
                            id: account.id,
                            text: account.name,
                            user_id: account.user_id 
                        };
                    }),
                    pagination: {
                        more: data.pagination.more
                    }
                };
            },
            cache: true
        },
        minimumInputLength: 2,
        width: '100%'
    }).on('select2:select', function (e) {
        let selected = e.params.data;
        // ✅ Set the user_id to hidden input
        popupWrapper.find('input[name="user_id"]').val(selected.user_id);
        popupWrapper.find('input[name="link"]').val("https://www.instagram.com/" + selected.text);
    });
};

SmmManager.js_smm_create_order = function () {
    const $form = $(".js_smm_create_order");

    $form.on("submit", function (e) {
        e.preventDefault();

        const $submitBtn = $form.find("input[type='submit']");
        const $resultBox = $form.find(".smm_form-result");

        $resultBox.removeClass("success error").html("");
        $submitBtn.prop("disabled", true).val("Submitting...");

        $.ajax({
            url: $form.attr("action"),
            method: "POST",
            data: $form.serialize(),
            dataType: "json",
            success: function (res) {
                if (res.result === 1) {
                    $(".smm_side_bar_wrapper").removeClass("active");
                    $form.trigger("reset");
                    // Reset Select2 dropdowns
                    $form.find('select').val(null).trigger('change');
                    
                    NextPost.Alert({
                        title:res.msg || "Operation completed successfully.",
                        content:SmmManager.gerDetialHtmlOfdata(res.data),
                        confirmText: "OK"
                    });

                } else {
                    $resultBox
                        .addClass("error")
                        .html(`<div class="error-message">${res.msg}</div>`).css("display", "block");
                }
            },
            error: function (xhr, status, error) {
                $resultBox
                    .addClass("error")
                    .html(`<div class="error-message">Request failed: ${error}</div>`).css("display", "block");
            },
            complete: function () {
                $submitBtn.prop("disabled", false).val("Create Order");
            }
        });
    });
};

    
      