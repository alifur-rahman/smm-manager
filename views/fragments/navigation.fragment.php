
<li class="<?= $Nav->activeMenu == $idname ? "active" : "" ?>">
    <a href="<?= APPURL."/e/".$idname ?>">
        <span class="special-menu-icon" style="<?= empty($config["icon_style"]) ? "" : $config["icon_style"] ?>">
            <span class="sli sli-shuffle"></span>
        </span>

        <?php $name = "SMM Manager" ?>
        <span class="label"><?= $name ?></span>

        <span class="tooltip tippy" 
              data-position="right"
              data-delay="100" 
              data-arrow="true"
              data-distance="-1"
              title="<?= $name ?>"></span>
    </a>
</li>