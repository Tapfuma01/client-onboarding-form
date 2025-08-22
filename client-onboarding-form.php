<?php
/**
 * Plugin Name: Client Onboarding Form
 * Description: A professional multi-step client onboarding form for WordPress
 * Version: 1.0.0
 * Author: Your Name
 * Text Domain: client-onboarding-form
 * Domain Path: /languages
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Plugin constants
define('COF_VERSION', '1.0.0');
define('COF_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('COF_PLUGIN_URL', plugin_dir_url(__FILE__));

// Activation and deactivation hooks
register_activation_hook(__FILE__, 'cof_activate_plugin');
register_deactivation_hook(__FILE__, 'cof_deactivate_plugin');

function cof_activate_plugin() {
    require_once COF_PLUGIN_DIR . 'includes/class-cof-activator.php';
    COF_Activator::activate();
}

function cof_deactivate_plugin() {
    require_once COF_PLUGIN_DIR . 'includes/class-cof-deactivator.php';
    COF_Deactivator::deactivate();
}

// Main plugin class
class ClientOnboardingForm {
    
    private static $instance = null;
    private $database;
    private $form_handler;
    private $admin;
    private $email; 
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        $this->load_dependencies();
        $this->init_hooks();
    }
    
    private function load_dependencies() {
        require_once COF_PLUGIN_DIR . 'includes/class-cof-database.php';
        require_once COF_PLUGIN_DIR . 'includes/class-cof-form-handler.php';
        require_once COF_PLUGIN_DIR . 'includes/class-cof-admin.php';

     // New includes
        require_once COF_PLUGIN_DIR . 'includes/class-cof-logger.php';
        require_once COF_PLUGIN_DIR . 'includes/class-cof-email-queue.php';
        require_once COF_PLUGIN_DIR . 'includes/class-cof-email.php';
        
        $this->database = new COF_Database();
        $this->form_handler = new COF_Form_Handler();
        $this->admin = new COF_Admin();
        $this->email = new COF_Email(); // initialize email system
    }
    
    private function init_hooks() {
        add_action('plugins_loaded', array($this, 'load_textdomain'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_public_scripts'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        
        // Shortcode registration
        add_shortcode('client_onboarding_form', array($this->form_handler, 'render_form'));
    }
    
    public function load_textdomain() {
        load_plugin_textdomain(
            'client-onboarding-form',
            false,
            dirname(plugin_basename(__FILE__)) . '/languages'
        );
    }
    
    public function enqueue_public_scripts() {
        if (!wp_script_is('jquery', 'enqueued')) {
            wp_enqueue_script('jquery');
        }
        
        wp_enqueue_style(
            'cof-public-style',
            COF_PLUGIN_URL . 'public/css/style.css',
            array(),
            COF_VERSION
        );
        
        wp_enqueue_script(
            'cof-public-script',
            COF_PLUGIN_URL . 'public/js/script.js',
            array('jquery'),
            COF_VERSION,
            true
        );
        
        wp_localize_script('cof-public-script', 'cof_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('cof_form_nonce')
        ));
    }
    
    public function enqueue_admin_scripts($hook) {
        if (strpos($hook, 'client-onboarding') === false) {
            return;
        }
        
        wp_enqueue_style(
            'cof-admin-style',
            COF_PLUGIN_URL . 'admin/assets/admin-style.css',
            array(),
            COF_VERSION
        );
        
        wp_enqueue_script(
            'cof-admin-script',
            COF_PLUGIN_URL . 'admin/assets/admin-script.js',
            array('jquery'),
            COF_VERSION,
            true
        );
    }
}

// Initialize the plugin
function cof_init_plugin() {
    return ClientOnboardingForm::get_instance();
}
add_action('plugins_loaded', 'cof_init_plugin');