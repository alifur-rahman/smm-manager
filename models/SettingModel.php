<?php 
namespace Plugins\SmmManagerModule;

// Disable direct access
if (!defined('APP_VERSION')) {
    die("Yo, what's up?"); 
}

/**
 * Setting Model
 * Handles database operations for the SMM Manager plugin settings.
 * 
 * @author 
 */
class SettingModel extends \DataEntry
{	
	private $table;

	public function __construct($uniqid = 0)
	{
		parent::__construct();
		$this->table = TABLE_PREFIX . "smm_settings";
	
		if ($uniqid === 0) {
			$first = \DB::table($this->table)->orderBy("id", "ASC")->limit(1)->get();
			if (!empty($first)) {
				$this->select(["id" => $first[0]->id]);
			}
		} else {
			$this->select($uniqid);
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
			"api_url" => "",
			"api_key" => "",
			"status" => 1,
			"default_service" => "",
			"default_quantity" => "",
			"auto_order" => 0,
			"expairy_day_before" => "",
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
			"api_url" => $this->get("api_url"),
			"api_key" => $this->get("api_key"),
			"status" => $this->get("status"),
			"default_service" => $this->get("default_service"),
			"default_quantity" => $this->get("default_quantity"),
			"auto_order" => $this->get("auto_order"),
			"expairy_day_before" => $this->get("expairy_day_before"),
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
				"api_url" => $this->get("api_url"),
				"api_key" => $this->get("api_key"),
				"status" => $this->get("status"),
				"default_service" => $this->get("default_service"),
				"default_quantity" => $this->get("default_quantity"),
				"auto_order" => $this->get("auto_order"),
				"expairy_day_before" => $this->get("expairy_day_before"),
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
