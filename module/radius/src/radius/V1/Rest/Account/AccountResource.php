<?php
namespace radius\V1\Rest\Account;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use Lib\Model\Exception as Exception;

class AccountResource extends AbstractResourceListener
{
    protected $mapper;

    public function __construct($mapper)
    {
        $this->mapper = $mapper;
    }
    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        //return new ApiProblem(405, 'The POST method has not been defined');
        try{
            $account = $this->mapper->find($data->account_id);
            return new ApiProblem(405, "Account: {$data->account_id} already exist!");
        }catch(Exception\ObjectNotFoundException $e){
            $account = new AccountEntity($data->account_id, $data->passwd, $data->groups, $data->status);
            $this->mapper->save($account);
        }
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        //return new ApiProblem(405, 'The GET method has not been defined for individual resources');
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
    public function fetchAll($params = array())
    {
        //return new ApiProblem(405, 'The GET method has not been defined for collections');
        return $this->mapper->findAll();
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
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
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
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
}
