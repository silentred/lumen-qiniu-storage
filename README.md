# Qiniu 云储存 Lumen Storage

Developed based on https://github.com/zgldh/qiniu-laravel-storage

- Support multiple buckets

## Install

 - `composer require silentred/lumen-qiniu-storage`

 - In `bootstrap/app.php` ，add `$app->register(silentred\QiniuStorage\QiniuFilesystemServiceProvider::class);`

 - In `config/filesystem.php`, find `disks` array, append the following configuration：
 
```php

    'qiniu' => [
        'driver'  => 'qiniu',
        'buckets' => [
            'first'=> [
                'scheme' => 'http',
                'domain' => '7xnpza.com1.z0.glb.clouddn.com',
                'name' => 'app-service'
            ],
            'second' => [
                'scheme' => 'http',
                'domain' => '7xpf8a.com1.z0.glb.clouddn.com',
                'name' => 'im-service'
            ]
        ],
        'access_key'=> '',  //AccessKey
        'secret_key'=> '',  //SecretKey
        'notify_url'=> '',  //callback url, not using
    ]
    
```

** NOTICE: The default bucket is the first one. **
 
## Usage


```php

    $disk = \Storage::disk('qiniu');
    $disk->withBucket('second')                     // change to the second bucket
    $disk->withBucket('first')->exists('file.jpg'); // check if file exists in first bucket;
    //now the following operation is under first bucket

    $disk->exists('file.jpg');                      //文件是否存在
    $disk->get('file.jpg');                         //获取文件内容
    $disk->put('file.jpg',$contents);               //上传文件
    $disk->prepend('file.log', 'Prepended Text');   //附加内容到文件开头
    $disk->append('file.log', 'Appended Text');     //附加内容到文件结尾
    $disk->delete('file.jpg');                      //删除文件
    $disk->delete(['file1.jpg', 'file2.jpg']);

    $disk->copy('old/file1.jpg', 'new/file1.jpg');  //复制文件到新的路径
    $disk->withBucket('first')->toBucket('second')  // copy file.jpg from first bucket to second bucket
         ->copy('old/file.jpg', 'new/file.jpg');

    $disk->move('old/file1.jpg', 'new/file1.jpg');  //移动文件到新的路径
    $disk->withBucket('first')->toBucket('second')  // move file.jpg from first bucket to second bucket
        ->move('old/file1.jpg', 'new/file1.jpg');

    $size = $disk->size('file1.jpg');               //取得文件大小
    $time = $disk->lastModified('file1.jpg');       //取得最近修改时间 (UNIX)
    $files = $disk->files($directory);              //取得目录下所有文件
    $files = $disk->allFiles($directory);               //这个没实现。。。
    $directories = $disk->directories($directory);      //这个也没实现。。。
    $directories = $disk->allDirectories($directory);   //这个也没实现。。。
    $disk->makeDirectory($directory);               //这个其实没有任何作用
    $disk->deleteDirectory($directory);             //删除目录，包括目录下所有子文件子目录
    
    $disk->uploadToken('file.jpg');                //获取上传token
    $disk->downloadUrl('file.jpg');                //获取下载地址
    $disk->downloadUrl('file.jpg', 'https');       //获取HTTPS下载地址
    $disk->privateDownloadUrl('file.jpg');         //获取私有bucket下载地址
    $disk->privateDownloadUrl('file.jpg', 'https');//获取私有bucket的HTTPS下载地址
    $disk->imageInfo('file.jpg');                  //获取图片信息
    $disk->imageExif('file.jpg');                  //获取图片EXIF信息
    $disk->imagePreviewUrl('file.jpg','imageView2/0/w/100/h/200');                         //获取图片预览URL
    $disk->persistentFop('file.flv','avthumb/m3u8/segtime/40/vcodec/libx264/s/320x240');   //执行持久化数据处理
    $disk->persistentFop('file.flv','fop','队列名');   //使用私有队列执行持久化数据处理
    $disk->persistentStatus($persistent_fop_id);       //查看持久化数据处理的状态。

```

## 官方SDK / 手册

 - https://github.com/qiniu/php-sdk
 - http://developer.qiniu.com/docs/v6/sdk/php-sdk.html
