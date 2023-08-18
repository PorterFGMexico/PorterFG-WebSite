:root {
    <?php foreach ($_['vars'] as $key => $value): ?>
        <?php if ($key === 'opener'): ?>
            --side-menu-<?php echo $key ?>: url('<?php print_unescaped(image_path('side_menu', $value.'.svg')); ?>');
        <?php else: ?>
            --side-menu-<?php echo $key ?>: <?php echo $value ?>;
        <?php endif; ?>
    <?php endforeach; ?>
}

<?php if (empty($_['top-menu-apps']) && empty($_['top-side-menu-apps'])): ?>
    #appmenu {
        display: none;
    }

    #appmenu + nav {
        display: none;
    }
<?php else: ?>
    .app-hidden {
        opacity: 0;
    }
<?php endif; ?>

<?php if ($_['opener-only']): ?>
    #nextcloud {
        display: none;
    }
<?php endif; ?>

<?php if (!$_['display-logo']): ?>
    .side-menu-logo {
        display: none;
    }

    .side-menu-header {
        height: 50px;
    }

    .side-menu-apps-list {
        height: calc(100vh - 49px);
        top: 49px;
    }

    #side-menu.hide-opener .side-menu-header {
        visibility: hidden;
    }

    <?php if ($_['size-text'] === 'hidden'): ?>
        #side-menu, .side-menu-apps-list {
            <?php if ($_['size-icon'] === 'big'): ?>
                width: 55px;
            <?php else: ?>
                width: 52px;
            <?php endif; ?>
        }

        #side-menu .side-menu-opener {
            <?php if ($_['size-icon'] === 'big'): ?>
                margin-left: 1px;
            <?php else: ?>
                margin-left: 0px;
            <?php endif; ?>
        }
    <?php endif; ?>
<?php endif; ?>

<?php if ($_['size-icon'] === 'hidden'): ?>
    .side-menu-app-icon {
        display: none;
    }
<?php elseif ($_['size-icon'] === 'small'): ?>
    .side-menu-app-icon svg {
        width: 15px;
        height: 15px;
    }

    img.side-menu-app-icon {
        width: 15px;
        height: 15px;
    }
<?php elseif ($_['size-icon'] === 'normal'): ?>
    .side-menu-app-icon svg {
        width: 20px;
        height: 20px;
    }

    img.side-menu-app-icon {
        width: 20px;
        height: 20px;
    }
<?php elseif ($_['size-icon'] === 'big'): ?>
    .side-menu-app-icon svg {
        width: 23px;
        height: 23px;
    }

    img.side-menu-app-icon {
        width: 23px;
        height: 23px;
    }
<?php endif; ?>

<?php if ($_['size-text'] === 'hidden'): ?>
    .side-menu-app-text {
        display: none;
    }
<?php elseif ($_['size-text'] === 'small'): ?>
    .side-menu-app-text {
        font-size: 12px;
    }
<?php elseif ($_['size-text'] === 'big'): ?>
    .side-menu-app-text {
        font-size: 16px;
    }
<?php endif; ?>
