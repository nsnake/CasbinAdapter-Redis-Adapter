<?php

namespace CasbinAdapter\Redis;

use Casbin\Exceptions\CasbinException;
use Casbin\Exceptions\NotImplementedException;
use Casbin\Model\Model;

/**
 * Redis Adapter.
 */
class Adapter implements \Casbin\Persist\Adapter
{

    /**
     * @var object
     */
    protected $redis_handle;

    /**
     * @var string
     */
    public $key_name = '';

    /**
     * Adapter constructor.
     *
     * @param object
     * @param string
     * @return void
     * @throws CasbinException
     */
    public function __construct(object $redis_handle, $key_name = 'casbin_policy:')
    {
        if ($redis_handle instanceof \Redis ||
            $redis_handle instanceof \Predis\Client ||
            $redis_handle instanceof \RedisCluster
        ) {
            $this->redis_handle = $redis_handle;
            $this->key_name = $key_name;
        } else {
            throw new CasbinException('unsupported redis driver');
        }
    }


    /**
     * loads all policy rules from the storage.
     *
     * @param Model $model
     */
    public function loadPolicy($model): void
    {
        $data = $this->redis_handle->hMGet($this->key_name, ['p', 'g']);
        if (isset($data['p']) && $data['p']) {
            $model->model['p'] = unserialize($data['p']);
        }
        if (isset($data['g']) && $data['g']) {
            $model->model['g'] = unserialize($data['g']);
        }

    }


    /**
     * save all policy rules to redis
     * @param Model $model
     * @return bool|int
     */
    public function savePolicy($model)
    {
        $data = [];
        if (isset($model->model['p'])) {
            $data['p'] = serialize($model->model['p']);
        }

        if (isset($model->model['g'])) {
            $data['g'] = serialize($model->model['g']);
        }
        return $this->redis_handle->hMSet($this->key_name, $data);
    }

    /**
     * adds a policy rule to the storage.
     *
     * @param string $sec
     * @param string $ptype
     * @param array $rule
     *
     * @return mixed|void
     *
     * @throws NotImplementedException
     */
    public function addPolicy($sec, $ptype, $rule)
    {
        throw new NotImplementedException('not implemented');
    }

    /**
     * removes a policy rule from the storage.
     *
     * @param string $sec
     * @param string $ptype
     * @param array $rule
     *
     * @return mixed|void
     *
     * @throws NotImplementedException
     */
    public function removePolicy($sec, $ptype, $rule)
    {
        throw new NotImplementedException('not implemented');
    }

    /**
     * removes policy rules that match the filter from the storage.
     *
     * @param string $sec
     * @param string $ptype
     * @param int $fieldIndex
     * @param mixed ...$fieldValues
     *
     * @return mixed|void
     *
     * @throws NotImplementedException
     */
    public function removeFilteredPolicy($sec, $ptype, $fieldIndex, ...$fieldValues)
    {
        throw new NotImplementedException('not implemented');
    }

    /**
     * 清除所有的数据规则
     * @return int
     */
    public function flush()
    {
        return $this->redis_handle->del($this->key_name);
    }
}
