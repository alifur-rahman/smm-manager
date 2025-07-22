/**
 * Module Namespace
 */
var SmmDataTable = {};

SmmDataTable.go = function(ajaxUrl, appUrl) {

    if (ajaxUrl) {
        let tbsearch = getUrlParameter('tbsearch');
        let dt =  $('#dataTable').DataTable({
            "ajax": {
                "url": ajaxUrl,
            },
            "initComplete": function() {
                // If tbsearch is present, set it to the search input and trigger search
                if (tbsearch) {
                    dt.search(tbsearch).draw();
                    $('#dataTable_filter input').val(tbsearch); // visually show it in input
                }
            },
            "order": [[0, "desc" ]]
            
        });
    } else {
        $('#dataTable').DataTable();
    }

    if (ajaxUrl.includes("?a=servicesAjax")) {
        $("body").on("click", ".al_js_expand", function() {
            var allData = $(this).data("all"); 
            al_expend_alert_data(allData);
        });
      

        
    }else if(ajaxUrl.includes("?a=ordersAjax")){
        $("body").on("click", ".al_js_expand", function() {
            var allData =  $(this).attr("data-all");
            renderOrderPopup(allData);
        });
    }else if(ajaxUrl.includes("?a=refills-historyAjax")){
        $("body").on("click", ".al_js_expand", function() {
            var allData =  $(this).attr("data-all");
            renderRefillsPopup(allData);
        });
    }
    

    
    function al_expend_alert_data(data) {

        const allData = JSON.stringify(data)
        .replace(/"/g, '&quot;') // escape double quotes
    
        var html = `
            <div class="al_expand_alert_wrapper">
                <div class="al_services_infos">
                    <ul>
                        <li>
                            <span class="al_service_label">Service ID:</span>
                            <span>${data.service}</span>
                        </li>
                        <li>
                            <span class="al_service_label">Name:</span>
                            <span>${data.name}</span>
                        </li>
                        <li>
                            <span class="al_service_label">Category:</span>
                            <span>${data.category}</span>
                        </li>
                        <li>
                            <span class="al_service_label">Type:</span>
                            <span>${data.type}</span>
                        </li>
                        <li>
                            <span class="al_service_label">Rate per 1000 :</span>
                            <span>${data.rate}</span>
                        </li>
                        <li>
                            <span class="al_service_label">Min Order:</span>
                            <span>${data.min}</span>
                        </li>
                        <li>
                            <span class="al_service_label">Max Order:</span>
                            <span>${data.max}</span>
                        </li>
                        <li>
                            <span class="al_service_label">Dripfeed:</span>
                            <span>${data.dripfeed ? "Yes" : "No"}</span>
                        </li>
                        <li>
                            <span class="al_service_label">Refill:</span>
                            <span>${data.refill ? "Yes" : "No"}</span>
                        </li>
                        <li>
                            <span class="al_service_label">Cancelation:</span>
                            <span>${data.cancel ? "Yes" : "No"}</span>
                        </li>

                    </ul>
                </div>
                <div class="al_services_actions">
                    <div class="al_services_actions_wrapper">
                        <small> Select accounts & create orders </small>
                        <a class="smm_js_create_order" data-search-url="` + appUrl + `/e/smm-manager/search" href="javascript:void(0);" data-all="${allData}"> 
                            <span>Create New Order</span>
                        </a>
                        <small> Set this service for automatic orders </small>
                        <a class="smm_send_ajax" data-url="` + appUrl + `/e/smm-manager/settings" data-action="set_default_service" data-all="${allData}"> 
                            <span>Set as Default Service </span> 
                        </a>
                        <small> View all orders for this service </small>
                        <a target="_blank" class="" href="` + appUrl + `/e/smm-manager?a=orders&tbsearch=${data.service}"> 
                            <span>View Orders</span> 
                            
                        </a>
                    </div>
                </div>
            </div>
        `;
        


        NextPost.Alert({
            title: data.name,
            content: html,
            confirmText: __("Close"),
            large: true
        });
    }

    function getUrlParameter(name) {
        let url = new URL(window.location.href);
        return url.searchParams.get(name);
    }
    
    function renderOrderPopup(rawData) {
        if (!rawData) return;
    
        let data;
        try {
            data = JSON.parse(rawData);
        } catch (e) {
            console.error("Invalid JSON in data-all:", e);
            return;
        }
    
        let html = `<div class="al_expand_alert_wrapper">
                            <div class="al_services_infos">
                                <ul>`;
    
        for (const [key, value] of Object.entries(data)) {
            html += `
                <li style="margin-bottom:6px;">
                    <span class="al_service_label">${formatKey(key)}:</span>
                    <span>${value}</span>
                </li>`;
        }
    
        html += ` </ul>
                </div>
                <div class="al_services_actions">
                    <div class="al_services_actions_wrapper">
                        <small> Check the current status of this order </small>
                        <a class="smm_js_order_action" data-action="check_status" data-id="${data.order_id}"  data-url="` + appUrl + `/e/smm-manager/actions"> 
                            <span>Check Status</span>
                        </a>
                       
                        <hr class="al_hr">
                        
                        <small> Create a refill for this order </small>
                        <a class="smm_js_order_action" data-action="create_refill" data-id="${data.order_id}" data-url="` + appUrl + `/e/smm-manager/actions" > 
                            <span>Create Refill</span>
                        </a>
                        <small> Cancel this order </small>
                        <a class="smm_js_order_action" data-action="cancel_order" data-id="${data.order_id}" data-url="` + appUrl + `/e/smm-manager/actions" > 
                            <span>Cancel Order</span>
                        </a>
                    </div>
                </div>
            </div>`;
    
    
        NextPost.Alert({
            title: __('Order Details'),
            content: html,
            confirmText: __("Close"),
            large: true
        });
    
      
    }
    function renderRefillsPopup(rawData) {
        if (!rawData) return;
    
        let data;
        try {
            data = JSON.parse(rawData);
        } catch (e) {
            console.error("Invalid JSON in data-all:", e);
            return;
        }
    
        let html = `<div class="al_expand_alert_wrapper">
                            <div class="al_services_infos">
                                <ul>`;
    
        for (const [key, value] of Object.entries(data)) {
            html += `
                <li style="margin-bottom:6px;">
                    <span class="al_service_label">${formatKey(key)}:</span>
                    <span>${value}</span>
                </li>`;
        }
    
        html += ` </ul>
                </div>
                <div class="al_services_actions">
                    <div class="al_services_actions_wrapper">
                        <small> Check the current status of this order </small>
                        <a class="smm_js_order_action" data-action="check_status" data-id="${data.order_id}"  data-url="` + appUrl + `/e/smm-manager/actions"> 
                            <span>Check Status</span>
                        </a>
                        <small> Check the current status of this order </small>
                        <a class="smm_js_order_action" data-action="check_refill_status" data-id="${data.refill_id}" data-url="` + appUrl + `/e/smm-manager/actions"> 
                            <span>Check Refill Status</span>
                        </a>
                    </div>
                </div>
            </div>`;
    
    
        NextPost.Alert({
            title: __('Order Details'),
            content: html,
            confirmText: __("Close"),
            large: true
        });
    
      
    }
    
    // Optional: Make keys look nicer (e.g., service_id → Service ID)
    function formatKey(key) {
        return key.replace(/_/g, ' ')
                  .replace(/\b\w/g, char => char.toUpperCase());
    }
    


}
