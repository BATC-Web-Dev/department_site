<?php

$current = isset($_GET['tab']) ? sanitize_key($_GET['tab']) : 'tools';

$tabs = array(
    'tools' => __("Settings", "gd-bbpress-tools"), 
    'bbcode' => __("BBCodes", "gd-bbpress-tools"), 
    'views' => __("Views", "gd-bbpress-tools"), 
    'update' => __("Tools", "gd-bbpress-tools"), 
    'faq' => __("FAQ", "gd-bbpress-tools"), 
    'toolbox' => __("Toolbox", "gd-bbpress-tools"), 
    'd4p' => __("Dev4Press", "gd-bbpress-tools"), 
    'about' => __("About", "gd-bbpress-tools")
);

if (!isset($tabs[$current])) {
    $current = 'tools';
}

if ($current != 'toolbox') {
    $this->upgrade_notice();
}

$to_load = $current;
if ($current == 'update') {
    if (isset($_GET['tool']) && isset($_GET['_nonce']) && $_GET['tool'] == 'wp44') {
        if (wp_verify_nonce($_GET['_nonce'], 'gdbbp-tools-wp44')) {
            $to_load = 'wp44';
        }
    }
}

?>
<div class="wrap">
    <h2>GD bbPress Tools</h2>
    <div id="icon-tools" class="icon32"><br></div>
    <h2 class="nav-tab-wrapper">
    <?php

    foreach($tabs as $tab => $name){
        $class = ($tab == $current) ? ' nav-tab-active' : '';

        if ($tab == 'toolbox') {
            $class.= ' d4p-tab-toolbox';
        }

        echo '<a class="nav-tab'.$class.'" href="edit.php?post_type=forum&page=gdbbpress_tools&tab='.$tab.'">'.$name.'</a>';
    }

    ?>
    </h2>
    <div id="d4p-panel" class="d4p-panel-<?php echo $current; ?>">
        <?php include(GDBBPRESSTOOLS_PATH.'forms/tabs/'.$to_load.'.php'); ?>
    </div>
</div>