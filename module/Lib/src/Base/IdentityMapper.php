<?php
namespace Lib\Base;

//use Zend\Stdlib\Hydrator;

/**
 * Identity map pattern
 * To improve performance by providing a context-specific, 
 * in-memory cache to prevent duplicate retrieval of the same object data from the database.
 */
class IdentityMapper
{
    protected static $identities = array();


    // TODO: set stat identities as adapter
    // set cacheAdapter();

    /**
     * Register object to identity cache
     *
     * @param  AbstractEntity $model
     * @param  mixed|array $ids
     */
    public static function registerObject($model, $ids)
    {
       $class = get_class($model);
       $key   = static::getKey($class, $ids);
       static::$identities[$key] = $model;
    }

    /**
     * get object to identity cache
     *
     * @param  AbstractEntity $model
     * @param  mixed|array $ids
     */
    public static function getObject($class, $ids)
    {
        $key = static::getKey($class, $ids);
        if (isset(static::$identities[$key])){
            return static::$identities[$key];
        }
        return false;
    }

    /**
     * reset identity cache
     */
    public static function reset()
    {
        static::$identities = null; 
    }

    /**
     * generate identity cache unique key
     */
    protected static function getKey($class, $ids)
    {
        if(is_array($ids)){
            $key = $class. '-' .implode('_', $ids); 
        }else{
            $key = $class. '-' .$ids; 
        }
        return $key;
    }

}

