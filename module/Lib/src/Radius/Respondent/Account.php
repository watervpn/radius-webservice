<?php
namespace Lib\Radius\Respondent;

use ZF\ApiProblem\ApiProblem;
use Lib\Base\AbstractRespondent;
use Lib\Base\Exception as Exception;

/**
 * Respondent fouse on handle return http status
 */
class Account extends AbstractRespondent{

    private $entity;
    private $mapper;

    public function __construct($mapper)
    {
        /* @var $mapper Lib\Radius\Mapper\AccountMapper */
        $this->mapper = $mapper;
        $this->entity = new \Lib\Radius\Entity\AccountEntity();
    }

    /**
     * Create 
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data){
        try{
            $account = $this->mapper->find( $data->id );
            return new ApiProblem( self::ENTITY_ALREADY_EXIST, "Account: {$data->id} already exist!");
        }catch(Exception\ObjectNotFoundException $e){
            //$account = new AccountEntity($data->account_id, $data->passwd, $data->groups, $data->status);
            $this->entity->exchangeArray(get_object_vars($data));
            $this->mapper->save($this->entity);
            return $this->entity;
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
            return $account;
        }catch(Exception\ObjectNotFoundException $e){
            return new ApiProblem( self::ENTITY_NOT_FOUND, "Account Not Found {$id} error: [{$e->getMessage()}]");
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
            return new ApiProblem( self::ENTITY_NOT_FOUND, "Can not delete Account Not Found {$id} error: [{$e->getMessage()}]");
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
            //return new ApiProblem( 404, "Account Not Found {$id} ]");
            return $this->mapper->find($id);
        }catch(Exception\ObjectNotFoundException $e){
            return new ApiProblem( self::ENTITY_NOT_FOUND, "Account Not Found {$id} error: [{$e->getMessage()}]");
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
            return new ApiProblem( self::ENTITY_NOT_FOUND, "Account Not Found {$id} error: [{$e->getMessage()}]");
        }
    }
}
