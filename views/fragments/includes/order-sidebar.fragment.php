<style>
    .select2-container {
        z-index: 999999999999 !important;
    }
</style>

    <div class="smm_side_bar_wrapper ">
        <div class="smm_side_bar_container">
            <form class="js_smm_create_order" action="<?= APPURL . "/e/" . $idname ."/actions" ?>" method="POST">
                <input type="hidden" name="action" value="create_order">
                <input type="hidden" name="service_id" value="">
                <input type="hidden" name="service_name" value="">
                <input type="hidden" name="user_id" value="">
                <div class="smm_side_bar_head">
                    <h3><?= __("Create a custom order") ?></h3>
                    <span class="smm_side_bar_close"><i class="mdi mdi-close"></i></span>
                </div>
               
                <div class="smm_side_bar_body">
                    <div class="smm_form-result" ></div>
                    <div class="smm_sidbar_content">
                        <div class="mb-10 clearfix">
                            <div class="col s12 m12 l12">
                                <label class="form-label"><?= __("Seleted Service") ?></label>
                               <div class="smm_show_selected_service"></div>
                            </div>
                        </div>
                        <div class="mb-20 clearfix">
                            <div class="col s12 m12 l12">
                                <label class="form-label"><?= __("Search & Select account") ?></label>
                                <select class="js-smm-account-search" name="account_id" style="width: 100%;">
                                    <option value=""><?= __("Select an account...") ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-20 clearfix">
                            <div class="col s12 m12 l12">
                                <label class="form-label"><?= __("Link") ?></label>
                                <input  class="input readOnly" readonly name="link" type="text" placeholder="<?= __("Enter Custom Link") ?>" >
                            </div>
                        </div>
                        <div class="mb-20 clearfix">
                            <div class="col s12 m12 l12">
                                <label class="form-label"><?= __("Default Quantity") ?></label>
                                <input  class="input js-quantity-input" name="quantity" type="number" min="" max="" value="">
                            </div>
                            <small class="js-quantity-note" style="color:#ff9b00;"><?= __("Note: Quantity can be Min: %s - Max: %s", 0, 0) ?></small>
                        </div>
                        
                    </div>
                   
                </div>
                <div class="smm_side_bar_footer">
                    <div class="side_bar_buttons_wrapper">
                        <input class="fluid button button--footer" type="submit" value="<?= __("Create Order") ?>">
                    </div>
                </div>
            </form>
        </div>
    </div>