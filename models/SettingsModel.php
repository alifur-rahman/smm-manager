<?php
namespace Plugins\SmmManagerModule;

if (!defined('APP_VERSION')) 
    die("Yo, what's up?");

class SettingsModel extends \DataList
{
    protected $settings = [];

    public function __construct()
    {
        $this->setQuery(\DB::table(TABLE_PREFIX . "smm_settings"));
        // Don't fetch here, keep as is
    }

    /**
     * Load settings as key=>value pairs into $this->settings
     */
    public function loadSettings()
    {
        $rows = $this->getData();
    
        $this->settings = [];
        if ($rows) {
            foreach ($rows as $row) {
                $this->settings[$row->name] = $row->value;
            }
        }
    
        return $this; // ✅ This is crucial
    }
    

    /**
     * Get a setting value by name
     */
    public function get($key, $default = null)
    {
        if (isset($this->settings[$key])) {
            return $this->settings[$key];
        }
        return $default;
    }

    /**
     * Set a setting value by name
     */
    public function set($key, $value)
    {
        $this->settings[$key] = $value;
        return $this;
    }
}
