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
                    <th><?= __('Order ID'); ?></th>
                    <th><?= __('Service ID'); ?></th>
                    <th><?= __('Service Title'); ?></th>
                    <th><?= __('User'); ?></th>
                    <th><?= __('Link'); ?></th> 
                    <th><?= __('Quantity'); ?></th> 
                    <th class="text-center"><?= __('Actions'); ?></th>
                </tr>
            </thead>
            <tbody>
             
            </tbody>
        </table>
    </div>

  
<?php endif; ?>
