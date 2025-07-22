<?php
namespace Plugins\SmmManagerModule;

if (!defined('APP_VERSION')) 
    die("Yo, what's up?");

class SmmOrdersModel extends \DataList
{

    public function __construct()
    {
        $this->setQuery(\DB::table(TABLE_PREFIX . "smm_orders"));
       
    }

    public function getData()
    {
        return $this->data;
    }

}