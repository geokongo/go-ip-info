<div class="wrap">
    <?php settings_errors(); ?>

    <form method="post" action="options.php">
        <?php
            settings_fields('go_ip_info_group');
            do_settings_sections('go_ip_info');
            submit_button();
        ?>
    </form>

</div>