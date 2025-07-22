<?php 
namespace Plugins\SmmManagerModule;

if (!defined('APP_VERSION')) {
    die("Yo, what's up?"); 
}

class SmmRefillModel extends \DataEntry
{	
    private $table;

    public function __construct($uniqid = 0)
    {
        parent::__construct();
        $this->table = TABLE_PREFIX . "smm_refill_requests";

        // Only select if an actual ID is passed
        if ($uniqid > 0) {
            $this->select($uniqid);
        } else {
            $this->data = []; // prevent loading any existing record
            $this->is_available = false;
        }
    }

    public function select($uniqid)
    {
        $where = [];

        if (is_array($uniqid)) {
            $where = $uniqid;
        } elseif (is_int($uniqid) || (is_string($uniqid) && ctype_digit($uniqid))) {
            if ($uniqid > 0) {
                $where["id"] = $uniqid;
            }
        }

        if ($where) {
            $query = \DB::table($this->table);

            foreach ($where as $k => $v) {
                $query->where($k, "=", $v);
            }

            $query->limit(1)->select("*");

            if ($query->count() > 0) {
                $row = $query->get()[0];
                foreach ($row as $field => $value) {
                    $this->set($field, $value);
                }
                $this->is_available = true;
            } else {
                $this->data = [];
                $this->is_available = false;
            }
        }

        return $this;
    }

    public function extendDefaults()
    {
        $defaults = [
            "refill_id" => "",
            "order_id" => "",
            "service_id" => "",
            "user_id" => "",
            "link" => "",
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s")
        ];

        foreach ($defaults as $field => $value) {
            if (is_null($this->get($field))) {
                $this->set($field, $value);
            }
        }
    }

    public function insert()
    {
        if ($this->isAvailable())
            return false;

        $this->extendDefaults();

        $id = \DB::table($this->table)->insert([
            "id" => null,
            "refill_id" => $this->get("refill_id"),
            "order_id" => $this->get("order_id"),
            "service_id" => $this->get("service_id"),
            "user_id" => $this->get("user_id"),
            "link" => $this->get("link"),
            "created_at" => $this->get("created_at"),
            "updated_at" => $this->get("updated_at")
        ]);

        $this->set("id", $id);
        $this->markAsAvailable();
        return $id;
    }

    public function update()
    {
        if (!$this->isAvailable())
            return false;

        $this->extendDefaults();
        $this->set("updated_at", date("Y-m-d H:i:s"));

        \DB::table($this->table)
            ->where("id", "=", $this->get("id"))
            ->update([
                "refill_id" => $this->get("refill_id"),
                "order_id" => $this->get("order_id"),
                "service_id" => $this->get("service_id"),
                "user_id" => $this->get("user_id"),
                "link" => $this->get("link"),
                "updated_at" => $this->get("updated_at")
            ]);

        return $this;
    }

    public function delete()
    {
        if (!$this->isAvailable())
            return false;

        \DB::table($this->table)->where("id", "=", $this->get("id"))->delete();
        $this->is_available = false;
        return true;
    }
}
