# PHP 反射机制 性能测试


## 测试结果
``` bash
反射类 实例化# 1000000次,耗时591.639 ms
正常实例化# 1000000次,耗时282.152 ms
总耗时 # 873.901 ms
```

```bash

反射类 实例化# 1000次,耗时0.549 ms
正常实例化# 1000次,耗时0.291 ms
总耗时 # 0.906 ms


```

## 结果

在 在利用反射机制与常规类的实例化的测试中 总体性能相差超过一倍<br>
以 Laravel 为例的 PHP 框架开发中, 大量利用反射机制进行服务容器的构建以及依赖注入<br>
关于因此产生的性能问题,框架作者是这样回复的:<br><br>

Firstly, this might seem like a canned response but that doesn't make it any less true. <br>
Performance wise, it makes very little difference unless you are serving a high-traffic platform, most likely the bottleneck will be the filesystem or the database.<br>
If you come to a point where instantiating a lot of classes slow your platform down, you will probably have enough resources to refactor and rewrite. <br>
You should embrace the build now, fix later principle (unless you're learning).
<br><br>
Secondly, the IOC containers are lazy-loaded, i.e. <br>
they are only instantiated if they are referenced in the constructor (using the Reflections API) or via App::make. <br>
If a string is passed to the bind method it is simply stored as a mapping from dependency to class.<br>
If a closure is passed, the closure isn't called unless the IOC container is requested.