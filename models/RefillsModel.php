<?php
namespace Plugins\SmmManagerModule;

if (!defined('APP_VERSION')) 
    die("Yo, what's up?");

class SmmRefillsModel extends \DataList
{

    public function __construct()
    {
        $this->setQuery(\DB::table(TABLE_PREFIX . "smm_refill_requests"));
       
    }

    public function getData()
    {
        return $this->data;
    }

}