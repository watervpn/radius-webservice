<?php
namespace Lib\Radius\Entity;

use Lib\Model\AbstractEntity;

class AccountEntity extends AbstractEntity
{
    /**
     * @var string
     * Account Id / User name
     */
    public $id;

    /**
     * @var string
     */
    public $passwd;

    /**
     * @var string
     */
    public $groups = array();

    /**
     * @var string
     */
    public $status;
    
    /**
     * @var array
     */
    public $options = array();

    private $allowGroups = array('pro', 'lite', 'deactivite');

    //const ACTIVE = 'Active'; 
    const ACTIVE = 1; 
    //const INACTIVE = 'Inactive'; 
    const INACTIVE = 2; 


    public function __construct($id = null, $passwd = null, $groups = array(), $status = null, $options = array())
    {
        $this->id = $id;
        $this->passwd = $passwd;
        $this->groups = $groups;
        $this->status = $status;
        $this->options = $options;

        if( $status === self::ACTIVE){
            $this->activite();
        }elseif($status === self::INACTIVE){
            $this->deactivite();
        }
    }
    
    // Getter
    public function getId()
    {
        return $this->id;
    }
    public function getPasswd()
    {
        return $this->passwd;
    }
    public function getGroups()
    {
        return $this->groups;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getOptions()
    {
        return $this->id;
    }

    // Setter
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setPasswd($passwd)
    {
        $this->passwd = $passwd;
    }
    public function setGroups(array $groups)
    {
        $this->groups = $groups;
    }
    public function setStatus($status)
    {
        if( $status === self::ACTIVE){
            $this->activite();
        }elseif($status === self::INACTIVE){
            $this->deactivite();
        }
    }
    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * Add user to group
     *
     * @pram string
     */
    public function addGroup($group){
        // check and add if group not exist
        if(in_array($group, $this->groups)){
            return; // Do nothing if group already exist
        }else{
            $this->groups[] = $group;
        }
    }

    /**
     * Remove user to group
     *
     * @pram string
     */
    public function removeGroup($group){
        // check and add if group not exist
        if(in_array($group, $this->groups)){
            $key = array_search($group, $this->groups);
            unset($this->groups[$key]);
        }
    }

    /**
     * Activite user account
     *
     * @pram string
     */
    public function activite(){
        $this->removeGroup('deactivite');
        $this->status = self::ACTIVE;
    }

    /**
     * Activite user account
     *
     * @pram string
     */
    public function deactivite(){
        $this->addGroup('deactivite');
        $this->status = self::INACTIVE;
    }

    /**
     * return Array
     */
    public function getArrayCopy()
    {
        return array(
            'id'       => $this->id,
            'passwd'   => $this->passwd,
            'groups'   => $this->groups,
            'status'   => $this->status,
            'options'  => $this->options,
        );
    }

    /**
     * return Object
     */
    public function exchangeArray(array $array)
    {
        $this->id     = $array['username'];
        $this->passwd = $array['value'];
        $this->groups = $array['groups'];
        $this->status = $array['status'];
        $this->options  = $array['options'];
    }

}
