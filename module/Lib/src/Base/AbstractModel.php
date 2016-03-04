<?php
namespace Lib\Base;

Abstract class AbstractModel
{
    //protected $sm;
    protected $mapper;

    public function __construct($mapper)
    {
        $this->mapper = $mapper;
        
    }

    /**
     * get corresponding entity from model
     * @return AbstractEntity
     */
    public function getEntity()
    {
        $modelNameSapce  = get_class($this);
        $entityNameSpace = str_replace('Model','Entity',$modelNameSapce);
        return new $entityNameSpace();
    } 

    public function create(array $data)
    {
        $entity = $this->getEntity();
        $entity->exchangeArray($data);
        $this->mapper->save($entity);
        return $entity;
    }

    public function fetch($id)
    {
        return $this->mapper->find($id);
        // this->entity = $this->mapper->find($id);
        // return $this
    }

    public function fetchAll($offset =0, $limit=100)
    {
        return $this->mapper->findAll($offset, $limit);
    }

    public function update(array $data)
    {
        return $this->create($data);
    }

    public function delete($id)
    {
        return $this->mapper->delete($id);
    }

    // TODO:
    // https://juriansluiman.nl/article/121/interface-injection-with-initializers-in-zend-servicemanager
    // static class that int the sm
    // ToDO:
    // add save function
    // fetch return this object (itself)
    // module.php pass entity to constructor and init new entity
    //
    // example
    //
    // $clientConfig = $clientConfig->load($id);
    // $clientConfig->setConfig('adsfasfa');
    // $clientConfig->setmodified('adfasdf');
    // $clientConfig->params->addParam('key', 'value');
    // $key = $clientConfig->getparams()->getKey();
    // $key->set('key')
    // $key->save();
    // $clientConfig->save();
    //
    // Testing need remove;
    // http://stackoverflow.com/questions/356128/can-i-extend-a-class-using-more-than-1-class-in-php
    /*private $entity;
    public function __call($method, $args)
    {
        $this->entity->$method( implode(', ', $args) );
    }*/

    /*public function setServiceManager($sm)
    {
        $this->sm = $sm;
    }

    protected function getServiceManager()
    {
        return $this->sm;
    }*/

    /**
     * Convert array to object
     *
     * @param array
     */
    /*protected function getMapper($module, $class)
    {
        $this->getServiceManager()->get();
    }*/
    
}
