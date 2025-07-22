
<aside class="skeleton-aside al_tableWidth">
    <div class="al_show_current_balance">
        <span class="al_subMTitle"><?= __('Current Balance') ?>:</span></br>
        <span id="current-balance"><?= number_format($balance->balance, 3) . ' ' . $balance->currency ?></span>
    </div>
    <div class="aside-list ">
        <div class="aside-list-item <?= $action == 'services' ? "active" : "" ?>">
            <div class="clearfix">
                <span class="circle"><span>1</span></span>
                <div class="inner">
                    <div class="title"><?=__('All Services'); ?></div>
                    <div class="sub"><?=__('List of all services'); ?></div>
                </div>
                <a class="full-link" href="<?= $baseUrl."?a=services" ?>"></a>
            </div>
        </div>
        <div class="aside-list-item <?= $action == 'orders' ? "active" : "" ?>">
            <div class="clearfix">
                <span class="circle"><span>2</span></span>
                <div class="inner">
                    <div class="title"><?=__('All Orders'); ?></div>
                    <div class="sub"><?=__('List of all orders'); ?></div>
                </div>
                <a class="full-link" href="<?= $baseUrl."?a=orders" ?>"></a>
            </div>
        </div>

        <div class="aside-list-item <?= $action == 'refills-history' ? "active" : "" ?>">
            <div class="clearfix">
                <span class="circle"><span>2</span></span>
                <div class="inner">
                    <div class="title"><?=__('All Refills'); ?></div>
                    <div class="sub"><?=__('List of all refill orders'); ?></div>
                </div>
                <a class="full-link" href="<?= $baseUrl."?a=refills-history" ?>"></a>
            </div>
        </div>
      
    </div>
</aside>
