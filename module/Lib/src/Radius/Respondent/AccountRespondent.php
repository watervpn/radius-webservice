<?php
namespace Lib\Radius\Respondent;

use ZF\ApiProblem\ApiProblem;
use Lib\Model\AbstractRespondent;
use Lib\Model\AbstractMapper;
use Lib\Model\Exception as Exception;

class AccountRespondent extends AbstractRespondent{
    private $entity;
    private $mapper;

    public function __construct($mapper)
    {
        /* @var $mapper Lib\Radius\Mapper\AccountMapper */
        $this->mapper = $mapper;
        // TODO: move to abstract
        if(method_exists($mapper, 'getEntity')){
            $this->entity = $mapper->getEntity();
        }else{
            $this->entity = $mapper->getTableGateway()->getResultSetPrototype()->getArrayObjectPrototype();
        }
    }

    /**
     * Create 
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data){
        try{
            $account = $this->mapper->find($data->id);
            return new ApiProblem(405, "Account: {$data->id} already exist!");
        }catch(Exception\ObjectNotFoundException $e){
            //$account = new AccountEntity($data->account_id, $data->passwd, $data->groups, $data->status);
            $this->entity->exchangeArray(get_object_vars($data));
            $this->mapper->save($this->entity);
        }
    }

    /**
     * Update
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data){
        try{
            $account = $this->mapper->find($id);
            if(isset($data->passwd)){ $account->setPasswd($data->passwd); }
            if(isset($data->groups)){ $account->setGroups($data->groups); }
            if(isset($data->status)){ $account->setStatus($data->status); }
            $this->mapper->save($account);
        }catch(Exception\ObjectNotFoundException $e){
            //return new ApiProblem(405, 'The POST method has not been defined');
        }
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function delete($id){
        try{
            $account = $this->mapper->find($id);
            return $this->mapper->delete($account);
        }catch(Exception\ObjectNotFoundException $e){
            //return new ApiProblem(404, "Account Not Found {$id} error: [{$e->getMessage()}]");
        }
    }

    /**
     * Fetch 
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id){
        try{
            return $this->mapper->find($id);
        }catch(Exception\ObjectNotFoundException $e){
            return new ApiProblem(404, "Account Not Found {$id} error: [{$e->getMessage()}]");
        }
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll(){
        try{
            return $this->mapper->findAll();
        }catch(\Exception $e){
            return new ApiProblem(404, "Account Not Found {$id} error: [{$e->getMessage()}]");
        }
    }
}
