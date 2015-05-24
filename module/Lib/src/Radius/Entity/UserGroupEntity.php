<?php
namespace Lib\Radius\Entity;

class UserGroupEntity
{
    public $username;
    public $groupname;
    public $priority;

    public function __construct($username = null, $groupname = null, $priority = null)
    {
        $this->username = $username;
        $this->groupname = $groupname;
        $this->priority = $priority;
    }

    // Getter
    public function getUsername()
    {
        return $this->username;
    }
    public function getGroupname()
    {
        return $this->groupname;
    }
    public function getPriority()
    {
        return $this->priority;
    }

    // Setter
    public function setUsername($username)
    {
        $this->username = $username;
    }
    public function setGroupname($groupname)
    {
        $this->groupname = $groupname;
    }
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    public function exchangeArray($data)
    {
        $this->username       = (!empty($data['username'])) ? $data['username'] : null;
        $this->groupname      = (!empty($data['groupname'])) ? $data['groupname'] : null;
        $this->priority       = (!empty($data['priority'])) ? $data['priority'] : null;
    }

    public function getArrayCopy()
    {
        return array(
            'username'    => $this->id,
            'groupname'   => $this->groupname,
            'priority'    => $this->priority,
        );
    }

}
