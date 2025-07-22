<?php 
    if (!defined('APP_VERSION')) die("Yo, what's up?"); 

 
?>

<div class='skeleton' id="settings">
    <form class="js-ajax-form" 
          action="<?= APPURL . "/e/" . $idname . "/settings" ?>"
          method="POST">
        <input type="hidden" name="action" value="save">

        <div class="container-1200">
            <div class="row clearfix">

                <div class="form-result"></div>

                <div class="col s12 m6 l4 mb-20">
                    <section class="section">  
                        <div class="section-content border-after">
                            <a href="javascript:void(0)" class="pmp-settings-installation-toggler pmp-toggler-button"><span class="mdi mdi-arrow-down icon mr-3"></span><?= __("Module Installation") ?></a>
                        </div>

                        <div class="pmp-settings-installation none">
                            <div class="section-content border-after">
                                <ul class="field-tips field-tips-decimal mt-0">
                                    <li><?= __("Upload the module ZIP file from the <b>Modules</b> section in your admin panel.") ?></li>

                                    <li><?= __("Once uploaded, activate the module for <b>Admin</b> packages from the %s or %s settings page.", "<a href='" . APPURL . "/users" . "' target='_blank'>Users</a>", "<a href='" . APPURL . "/packages" . "' target='_blank'>Packages</a>") ?></li>

                                    <li><?= __("Go to the <b>API Manager</b> section via the sidebar menu to configure your SMM API provider settings.") ?></li>

                                    <li><?= __("Start by selecting a provider (e.g., Crescitaly) and entering your <b>API URL</b> and <b>API Key</b>.") ?></li>

                                    <li><?= __("Click on <b>Test Connection</b> to validate API access by fetching available services or balance.") ?></li>

                                    <li><?= __("Enable or disable API functions (place orders, check status, refill, etc.) as per your operational needs.") ?></li>

                                    <li><?= __("Avoid enabling this module for regular users unless they are permitted to manage API-level features.") ?></li>

                                    <li><?= __("To update the module, remove it via the <b>Modules</b> section and re-install by uploading the new ZIP file.") ?></li>
                                </ul>


                            </div>
                        </div>

                        <div class="section-content border-after">
                            <a href="javascript:void(0)" class="pmp-settings-license-toggler pmp-toggler-button"><span class="mdi mdi-arrow-down icon mr-3"></span><?= __("Setup API") ?></a>
                        </div>

                        <div class="pmp-settings-license none">
                            <div class="section-content border-after">
                                <div class="mb-10 clearfix">
                                    <div class="col s12 m12 l12">
                                       
                                        <label class="form-label"><?= __("API URL") ?></label>
                                        <input class="input api-url" name="api_url" id="api_url" type="text" maxlength="50" placeholder="<?= __("Enter the API URL") ?>" value="<?= htmlchars($SmmSettings->get("api_url")) ?>">
                                    </div>
                                </div>

                                <div class="mb-10 clearfix">
                                    <div class="col s12 m12 l12">
                                       
                                        <label class="form-label"><?= __("API Key") ?></label>
                                        <input class="input api-url" name="api_key" id="api_key" type="text" maxlength="50" placeholder="<?= __("Enter the API Key") ?>" value="<?= htmlchars($SmmSettings->get("api_key")) ?>">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="section-content border-after">
                            <a href="javascript:void(0)" class="pmp-settings-advanced-toggler pmp-toggler-button"><span class="mdi mdi-arrow-down icon mr-3"></span><?= __("Configure automatic order") ?></a>
                        </div>

                        <div class="pmp-settings-advanced none">
                            <div class="section-content border-after">

                                <div class="mb-20 clearfix">
                                    <label>
                                        <input type="checkbox" 
                                            class="checkbox" 
                                            name="auto_order" 
                                            value="1" 
                                            onchange="$('.al_show_if_enable').toggleClass('active');const isEnabled = this.checked;$('.al_show_if_enable input').prop('readonly', !isEnabled);"
                                            <?= $SmmSettings->get("auto_order") ? "checked" : "" ?>
                                           >
                                        <span>
                                            <span class="icon unchecked">
                                                <span class="mdi mdi-check"></span>
                                            </span>
                                            <?= __('Enable') ?>
                                        </span>
                                    </label>
                                </div>


                                <div class="al_show_if_enable <?= $SmmSettings->get("auto_order") ? "active" : "" ?>">

                                <?php $default_service = $SmmSettings->get("default_service"); 

                                    if ($default_service) {
                                        // Convert JSON string to PHP associative array
                                        $serviceData = json_decode($default_service, true);
                                    }
                                
                                ?>

                                <div class="mb-20 clearfix">
                                    <?php if ($default_service): ?>
                                        <div class="col s12 m12 l12">
                                            <p><?= __("Currently the default service is:") ?></p>
                                            <div class="al_services_infos">
                                                <?php if (!empty($serviceData) && is_array($serviceData)) : ?>
                                                    <ul>
                                                        <?php foreach ($serviceData as $key => $value) : ?>
                                                            <li>
                                                                <span class="al_service_label"><?= ucfirst(str_replace('_', ' ', htmlspecialchars($key))) ?>:</span>
                                                                <span><?= is_bool($value) ? ($value ? "Yes" : "No") : htmlspecialchars($value) ?></span>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                        
                                                    <div class="mb-20 clearfix">
                                                        <div class="col s12 m12 l12">
                                                            <label class="form-label"><?= __("Default Quantity") ?></label>
                                                            <input  class="input" name="default_quantity" type="number" min="<?= $serviceData["min"] ?>" max="<?= $serviceData["max"] ?>" value="<?=$SmmSettings->get("default_quantity") ?>">
                                                        </div>
                                                        <small style="color:#ff9b00;"><?= __("Note: Quantity can be Min: %s - Max: %s", $serviceData["min"], $serviceData["max"]) ?></small>
                                                    </div>



                                                <?php else : ?>
                                                    <p style="color:red;"><?= __("No default service set or invalid data format.") ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col s12 m12 l12">
                                            <p><?= __("To change the default service go to this link:") ?></p>
                                            <a style="color:green;" href="<?= APPURL . "/e/smm-manager?a=services" ?>" target="_blank">
                                                <?= APPURL . "/e/smm-manager?a=services" ?>
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <div class="col s12 m12 l12">
                                            <p><?= __("To set the default service go to this link:") ?></p>
                                            <a style="color:green;" href="<?= APPURL . "/e/smm-manager?a=services" ?>" target="_blank">
                                                <?= APPURL . "/e/smm-manager?a=services" ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                  
                                </div>

                            </div>
                        </div>


                        <input class="fluid button button--footer" type="submit" value="<?= __("Save") ?>">
                    </section>
                </div>

                <div class="col s12 s-last m6 m-last l8 l-last mb-20">
                    <section class="section">
                        <div class="section-header clearfix">
                            <h2 class="section-title"><?= __("Additional API Usage From SMM Manager ") ?></h2>
                        </div>
                        <div class="section-content border-after">
                            <ul class="field-tips field-tips-decimal mt-0">
                                <li><?= __("This module allows you to connect with any SMM panel that supports a standard API (e.g., Crescitaly, JustAnotherPanel, SMM Heaven, etc).") ?></li>
                                <li><?= __("To begin using this module, navigate to the <b>API Manager</b> section via the left sidebar after installation.") ?></li>
                                <li><?= __("Click <b>Add API</b> to register a new SMM provider. You will need to enter:") ?>
                                    <ul class="sub-tips">
                                        <li><?= __("API Name (for display purposes)") ?></li>
                                        <li><?= __("API URL (endpoint provided by the SMM panel, e.g., https://example.com/api/v2)") ?></li>
                                        <li><?= __("API Key (you'll find it in your SMM provider’s dashboard)") ?></li>
                                    </ul>
                                </li>
                                <li><?= __("Once saved, the API becomes selectable when placing orders, checking status, or fetching balance.") ?></li>
                                <li><?= __("To place an order manually, the module uses dynamic order fields based on the selected API service type.") ?></li>
                                <li><?= __("You can manage multiple APIs and choose the active one based on service availability and price.") ?></li>
                                <li><?= __("Below is an example of how to use the API class programmatically inside your controller.") ?></li>
                            </ul>

                            <div style="background-color: #1e1e1e; color: #d4d4d4; font-family: 'Fira Code', monospace; font-size: 14px; padding: 20px; border-radius: 8px; margin-top: 20px; overflow-x: auto; box-shadow: 0 0 10px rgba(0,0,0,0.4);">
                                <pre style="margin: 0;"><code><span style="color:#569CD6">// Initialize API connection</span>
                                $api = new CrescitalyApi($api_key);

                                <span style="color:#569CD6">// Fetch available services</span>
                                $services = $api->services();

                                <span style="color:#569CD6">// Place a standard order</span>
                                $order = $api->order([
                                    'service' => 1,
                                    'link' => 'https://example.com',
                                    'quantity' => 100
                                ]);

                                <span style="color:#569CD6">// Check order status</span>
                                $status = $api->status($order->order);

                                <span style="color:#569CD6">// Get account balance</span>
                                $balance = $api->balance();

                                <span style="color:#569CD6">// Refill a specific order</span>
                                $refill = $api->refill($order->order);

                                <span style="color:#569CD6">// Cancel multiple orders</span>
                                $cancel = $api->cancel([123, 456, 789]);
                                </code></pre>
                            </div>

                            <ul class="field-tips field-tips-decimal mt-0">
                                <li><?= __("This module is API-agnostic and structured to work with any panel using JSON-based v2 endpoints.") ?></li>
                                <li><?= __("You may extend the core API class or register multiple providers with different structures, if needed.") ?></li>
                                <li><?= __("Make sure your server supports <b>cURL</b> and <b>SSL</b> to ensure smooth API communication.") ?></li>
                                <li><?= __("Always test your API connection in a staging environment before enabling for customers.") ?></li>
                                <li><?= __("Need help? Contact your SMM provider for API docs, or check our FAQ section for request templates.") ?></li>
                            </ul>
                        </div>


                    </section>
                </div>

            </div>
        </div>
    </form>
</div>