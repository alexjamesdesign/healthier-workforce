<?php if(defined('RM_ADDON_PLUGIN_VERSION') && version_compare(RM_ADDON_PLUGIN_VERSION, RM_PLUGIN_VERSION, '<')) { ?>
<div class="notice notice-error rm-upgrade-issue-notice" style="position: relative;">
    <h3 style="color: red"><span class="dashicons dashicons-warning"></span>
        Your RegistrationMagic Premium Is Outdated 
    </h3>

    <p>
        Please update to the latest version for best user experience and to avoid UI / layout issues. <a href="https://metagauss.com/my-profile/" target="blank">Download here</a>.
    </p>
</div>
<?php }