<?php if (isset($apiError)) : ?>
    <div class="no-data">
        <span class="no-data-icon sli sli-minus"></span>
        <p><?= __('Unable to fetch services. Please try again later.'); ?></p>
    </div>
<?php else: ?>


    <div class="pre-datatable">
        <table class="datatable al_insetDatatable" id="dataTable">
            <thead>
                <tr>
                    <th><?= __('ID'); ?></th>
                    <th><?= __('Category'); ?></th>
                    <th><?= __('Name'); ?></th>
                    <th><?= __('Type'); ?></th>
                    <th><?= __('Rate'); ?> (<?= __('/1000'); ?>) </th>
                    <th><?= __('Min Order'); ?></th>
                    <th><?= __('Max Order'); ?></th>
                    <th class="text-center"><?= __('Actions'); ?></th>
                </tr>
            </thead>
            <tbody>
             
            </tbody>
        </table>
    </div>

<?php require_once(PLUGINS_PATH."/".$this->getVariable("idname")."/views/fragments/includes/order-sidebar.fragment.php"); ?>

  
<?php endif; ?>
