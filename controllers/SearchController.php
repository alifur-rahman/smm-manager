<?php

namespace Plugins\SmmManagerModule;

// Disable direct access
if (!defined('APP_VERSION'))
    die("Yo, what's up?");

/**
 * Search Controller
 */
class SearchController extends \Controller
{
    const IDNAME = 'smm-manager';

    /**
     * Process
     */
    public function process()
    {
        $AuthUser = $this->getVariable("AuthUser");
        $EmailSettings = \Controller::model("GeneralData", "email-settings");
        $this->setVariable("idname", self::IDNAME);

        // Auth
        if (!$AuthUser){
            header("Location: ".APPURL."/login");
            exit;
        } else if (!$AuthUser->isAdmin() && !$AuthUser->isEmailVerified() && $EmailSettings->get("data.email_verification")) {
            header("Location: ".APPURL."/profile?a=true");
            exit;
        } else if ($AuthUser->isExpired()) {
            header("Location: ".APPURL."/expired");
            exit;
        }

        // Handle POST actions
        $action = \Input::post("action");
        switch ($action) {
            case "search_accounts":
                header("Content-Type: application/json");
                echo json_encode($this->searchAccount());
                exit;

            default:
                // optionally handle other actions or do nothing
                break;
        }
    }

    /**
     * Search accounts for Select2
     */
    private function searchAccount()
    {
        $AuthUser = $this->getVariable("AuthUser");
        $keyword = trim(\Input::post("q"));
        $page = (int) \Input::post("page") ?: 1;
        $pageSize = 8;

        // Load Accounts model
        $Accounts = \Controller::model("Accounts");
        $Accounts->setPageSize($pageSize)
                 ->setPage($page);

        if (!empty($keyword)) {
            $Accounts->where("username", "LIKE", "%{$keyword}%");
        }

        $Accounts->orderBy("id", "DESC")
                 ->fetchData();

        $results = [];
        foreach ($Accounts->getDataAs("Account") as $acc) {
            $results[] = [
                "id" => $acc->get("id"),
                "name" => $acc->get("username"),
                "user_id" => $acc->get("user_id")
            ];
        }

        // Determine if more pages exist
        $totalCount = $Accounts->getTotalCount();
        $hasMore = ($page * $pageSize) < $totalCount;

        return [
            "results" => $results,
            "pagination" => [
                "more" => $hasMore
            ]
        ];
    }
}
