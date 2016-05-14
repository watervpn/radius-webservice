<?php
namespace Lib\Base;

//use Zend\Stdlib\Hydrator;

Abstract class AbstractEntity
{

    public function __construct(){
    }

    protected function getMapper()
    {
        $mapperNameSpace = explode('\\', get_class($this) );
        return \Lib\ServiceManager::getMapper($mapperNameSpace[1], $mapperNameSpace[3]);
    }

    public function load($id)
    {
        return $this->getMapper()->find($id);
    }

    public function save()
    {
        $this->getMapper()->save($this);
        return $this;
    }

    public function update()
    {
        return $this->save();
    }

    public function delete()
    {
        return $this->getMapper()->delete($this);
    }

    public function fetch($id)
    {
        return $this->getMapper()->find($id);
    }

    public function fetchAll($orderby=null, $sort=null, $offset=0, $limit=100)
    {
        return $this->getMapper()->findAll($orderby, $sort, $offset, $limit);
    }

    /**
     * Convert array to object
     *
     * @param array
     */
    abstract public function exchangeArray(array $data);

    /**
     * Convert object to array
     *
     * @return array
     */
    abstract public function getArrayCopy();

    /**
     * Convert object to array
     *
     * @return array
     */
    public function toArray()
    {
        return $this->getArrayCopy();
    }
}
