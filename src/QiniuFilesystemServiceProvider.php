<?php namespace silentred\QiniuStorage;

use League\Flysystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use silentred\QiniuStorage\Plugins\DownloadUrl;
use silentred\QiniuStorage\Plugins\ImageExif;
use silentred\QiniuStorage\Plugins\ImageInfo;
use silentred\QiniuStorage\Plugins\ImagePreviewUrl;
use silentred\QiniuStorage\Plugins\PersistentFop;
use silentred\QiniuStorage\Plugins\PersistentStatus;
use silentred\QiniuStorage\Plugins\PrivateDownloadUrl;
use silentred\QiniuStorage\Plugins\ToBucket;
use silentred\QiniuStorage\Plugins\UploadToken;
use silentred\QiniuStorage\Plugins\WithBucket;
use Storage;

class QiniuFilesystemServiceProvider extends ServiceProvider
{

    public function boot()
    {
        Storage::extend('qiniu', function ($app, $config) {
            $qiniu_adapter = new QiniuAdapter(
                $config['access_key'],
                $config['secret_key'],
                $config['buckets'],
                $config['notify_url']?$config['notify_url']:null
            );

            $file_system = new Filesystem($qiniu_adapter);
            $plugins = [
                PrivateDownloadUrl::class,
                DownloadUrl::class,
                ImageExif::class,
                ImageInfo::class,
                ImagePreviewUrl::class,
                PersistentFop::class,
                PersistentStatus::class,
                WithBucket::class,
                ToBucket::class,
                UploadToken::class
            ];

            foreach ($plugins as $plugin) {
                $file_system->addPlugin(new $plugin);
            }

            return $file_system;
        });
    }

    public function register()
    {
        //
    }
}
