# LARAVEL HASHID

为 Laravel 量身定制的类似 Youtube 上的 ID（数字）加密解密扩展包。

## 配置扩展包

在项目根目录下的 `config/sungmee.php` 文件（如没有请新建）中加入以下内容：
```PHP
<?php

return [
    'hashid' => [
        'length'     => 8,
        'salt'       => env(
            'HASHID_SALT',
            3.14159265359
        ),
        'dictionary' => env(
            'HASHID_DICTIONARY',
            'hK2VOPI1UHkF6lj9n8L73JgbtSpyAeYrZcwDWqdB0XNGazsv4R5mfExiouTMQC'
        )
    ]
];
```
其中，`length` 为加密后的字符串长度；`salt` 为加密盐值，必须为数字类型；`dictionary` 为加密字典，即为 a-z,A-Z,0-9 62个字符打乱后的字符串。本扩展包安装成功后，可以用 `dictionary()` 方法生成字典字符串。

然后在 Laravel 配置文件 `config/app.php` 中加入：

```PHP
'providers' => [
    Sungmee\Hashid\HashidServiceProvider::class,
]

'aliases' => [
    'Hashid' => Sungmee\Hashid\Facades\Hashid::class,
]
```

## 使用示例:
```PHP
use Sungmee\Hashid\Hashid;

$id   = 123;

$hash = Hashid::hash($id);
$id   = Hashid::id($hash);
```