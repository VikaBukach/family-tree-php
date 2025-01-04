<?php
namespace FamilyTree;

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
}
