<?php
namespace radius\V1\Rest\Account;

class AccountEntity
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
     * @var array
     */
    public $options = array();

    /**
     * @var int
     */
    //public $timestamp;
    
    /**
     * return Array
     */
    public function getArrayCopy()
    {
        return array(
            'id'       => $this->id,
            'passwd'   => $this->passwd,
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
        //$this->options  = $array['options'];
    }


}
