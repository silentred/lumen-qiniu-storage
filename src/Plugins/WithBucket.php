<?php
    /**
     * Created by PhpStorm.
     * User: ZhangWB
     * Date: 2015/4/21
     * Time: 16:42
     */

    namespace silentred\QiniuStorage\Plugins;

    use League\Flysystem\Plugin\AbstractPlugin;

    /**
     * Class PrivateDownloadUrl
     * 得到公有资源下载地址 <br>
     * $disk        = \Storage::disk('qiniu'); <br>
     * $re          = $disk->getDriver()->downloadUrl('foo/bar1.css'); <br>
     * @package zgldh\QiniuStorage\Plugins
     */
    class WithBucket extends AbstractPlugin
    {

        /**
         * Get the method name.
         *
         * @return string
         */
        public function getMethod()
        {
            return 'withBucket';
        }

        public function handle($key)
        {
            $adapter = $this->filesystem->getAdapter();
            return $adapter->withBucket($key);
        }
    }