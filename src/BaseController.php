<?php
namespace FamilyTree;

use FamilyTree\helpers\Permissions;

class BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    public function runAction($actionName)
    {
        if (method_exists($this, 'action' . $actionName)) {
            return $this->{'action' . $actionName}();
        }
    }

    protected function checkAccess($action)
    {
        session_start();
        $userRole = strtolower(trim($_SESSION['role'] ?? 'viewer'));

        if(!Permissions::hasAccess($action, $userRole)){
            die('У вас немає прав для цієї дії');
        }
    }
}
