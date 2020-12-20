<?php 
    $menu = new Menu();
    ?>
<div class="nano">
<div class="nano-content">
        <nav id="menu" class="nav-main" role="navigation">
                <ul class="nav nav-main">
                <?php
                    $menu->print_menu($menu->getMenuItems());
                ?>
                </ul>
        </nav>

</div>

<script>
        // Preserve Scroll Position
        if (typeof localStorage !== 'undefined') {
                if (localStorage.getItem('sidebar-left-position') !== null) {
                        var initialPosition = localStorage.getItem('sidebar-left-position'),
                                sidebarLeft = document.querySelector('#sidebar-left .nano-content');

                        sidebarLeft.scrollTop = initialPosition;
                }
        }
</script>

</div>