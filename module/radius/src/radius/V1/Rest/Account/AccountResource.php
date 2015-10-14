<?php
namespace radius\V1\Rest\Account;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use Lib\Radius\Entity\AccountEntity;
use Lib\Base\Exception as Exception;

class AccountResource extends AbstractResourceListener
{
    protected $respondent;

    public function __construct($respondent)
    {
        /* @var $respondent Lib\Radius\Respondent\Account*/
        $this->respondent = $respondent;
    }
    /**
     * Create a resource
     * HTTP HOST method
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        //return new ApiProblem(405, 'The POST method has not been defined');
        return $this->respondent->create($data);
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        //return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
       return $this->respondent->delete($id);
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
     * HTTP GET method
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        //return new ApiProblem(405, 'The GET method has not been defined for individual resources');
        return $this->respondent->fetch($id);
    }

    /**
     * Fetch all or a subset of resources
     * HTTP GET method for collections
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll()
    {
        return $this->respondent->fetchAll();
    }

    /**
     * Patch (partial in-place update) a resource
     * HTTP PATCH method
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        return $this->respondent->update($id, $data);
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
     * HTTP PUT method
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        return $this->respondent->update($id, $data);
    }
}
