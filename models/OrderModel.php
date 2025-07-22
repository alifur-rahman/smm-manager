<?php 
namespace Plugins\SmmManagerModule;

// Disable direct access
if (!defined('APP_VERSION')) {
    die("Yo, what's up?"); 
}

/**
 * SMM Order Model
 * Handles database operations for SMM orders.
 */
class SmmOrderModel extends \DataEntry
{
	private $table;

	public function __construct($uniqid = null) // ✅ Default to null instead of 0
	{
		parent::__construct();
		$this->table = TABLE_PREFIX . "smm_orders";

		if (!is_null($uniqid)) {
			$this->select($uniqid);
		}
	}

	public static function create() // ✅ Optional helper
	{
		return new self(null);
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
			"service_name" => "",
			"service_id" => "",
			"order_id" => "",
			"user_id" => "",
			"account_id" => "",
			"link" => "",
			"quantity" => "",
			"runs" => "",
			"interval" => "",
			"order_type" => "",
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
		if ($this->isAvailable()) // ✅ Prevents reusing an already loaded row
			return false;

		$this->extendDefaults();

		$id = \DB::table($this->table)->insert([
			"id" => null,
			"service_name" => $this->get("service_name"),
			"service_id" => $this->get("service_id"),
			"order_id" => $this->get("order_id"),
			"user_id" => $this->get("user_id"),
			"account_id" => $this->get("account_id"),
			"link" => $this->get("link"),
			"quantity" => $this->get("quantity"),
			"runs" => $this->get("runs"),
			"interval" => $this->get("interval"),
			"order_type" => $this->get("order_type"),
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
				"service_name" => $this->get("service_name"),
				"service_id" => $this->get("service_id"),
				"order_id" => $this->get("order_id"),
				"user_id" => $this->get("user_id"),
				"account_id" => $this->get("account_id"),
				"link" => $this->get("link"),
				"quantity" => $this->get("quantity"),
				"runs" => $this->get("runs"),
				"interval" => $this->get("interval"),
				"order_type" => $this->get("order_type"),
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
