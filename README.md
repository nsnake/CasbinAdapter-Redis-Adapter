# CasbinAdapter-Redis-Adapter

Redis adapter for Casbin

#composer

```
composer require nsnake/casbin-adapter-redis-adapter
```

# How to use:

```php
<?php
use CasbinAdapter\Redis\Adapter AS RedisAdapter;
$redis_handle  = new Redis(...);
$a = new RedisAdapter(redis_handle,$your_redis_key_name);
$enforcer = new Enforcer("model.conf", $a);
$enforcer->addRule()
$enforcer->addRole()
...

#save
$enforcer->savePolicy();
#load
$enforcer->loadPolicy();
```

# Notice:
PHP redis extensions support RedisCluster and Predis

CasbinAdapter-Redis-Adapter only support savePolicy and loadPolicy function。



##############################################################################

基于redis的Casbin快速存取

#composer安装

```
composer require nsnake/casbin-adapter-redis-adapter
```

# 使用方法:

```php
<?php
use CasbinAdapter\Redis\Adapter AS RedisAdapter;
$redis_handle  = new Redis(...);
$a = new RedisAdapter(redis_handle,$your_redis_key_name);
$enforcer = new Enforcer("model.conf", $a);
$enforcer->addRule()
$enforcer->addRole()
...

#保存规则
$enforcer->savePolicy();
#读取规则
$enforcer->loadPolicy();
```

# 注意:

RedisAdapter为了方便在在不同环境或者框架下都能的运行，因而使用依赖注入的方式，既模块本身不参与redis的连接过程，使用时只需要传入redis的句柄即可（例tp5.1下可以使用Cache::handler的方式获取）。目前支持的php扩展为Redis,RedisCluster和Predis
基于常用场景和执行效率的原因。RedisAdapter不支持自动保存和对单独的policy进行添加或者编辑操作，即和自带的文件存储一样都是整存整取。
