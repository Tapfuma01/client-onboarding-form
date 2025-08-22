<?php
if (!defined('ABSPATH')) {
    exit;
}

class COF_Deactivator {
    
    public static function deactivate() {
        // Cleanup tasks if needed
        flush_rewrite_rules();
    }
}