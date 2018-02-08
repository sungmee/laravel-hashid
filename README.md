# LARAVEL HASHID

为 Laravel 量身定制的类似 Youtube 上的 ID（数字）加密解密扩展包。【不使用 bcpow() 函数】

## 配置扩展包

在项目根目录下的 .env 文件中加入以下内容（如果保持默认，则不需要加入）：

`HASHID_LENGTH` 为加密后的字符串长度:
> HASHID_LENGTH=8

`HASHID_SALT` 为加密盐值，必须为数字类型:
> HASHID_SALT=3.14159265359

`HASHID_DICTIONARY` 为加密字典，即为 a-z,A-Z,0-9 62个字符打乱后的字符串。本扩展包安装成功后，可以用 `dictionary()` 方法生成字典字符串:
> HASHID_DICTIONARY=hK2VOPI1UHkF6lj9n8L73JgbtSpyAeYrZcwDWqdB0XNGazsv4R5mfExiouTMQC

### Laravel 5.5 以上版本到此为止已经配置完毕。

### Laravel 5.5 以下版本还要继续操作：

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
use Sungmee\Hashid\Facades\Hashid;

$id   = 123;

$hash = Hashid::hash($id); // 2LtLgHkF
$id   = Hashid::id($hash); // 123
```

更简单的使用方法：

```PHP
$id   = 123;

$hash = \Hashid::hash($id); // 2LtLgHkF
$id   = \Hashid::id($hash); // 123
```