<?php

namespace ExerciseBook\DiscuzQCloudinary;

use ExerciseBook\Flysystem\ImageX\ImageXAdapter as Adapter;
use Exception;
use Illuminate\Cache\Repository;

/**
 * Class LocalAdapter
 * @package ExerciseBook\DiscuzQCloudinary
 */
class ImageXAdapter extends Adapter
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var string
     */
    public $publicUrlPrefix = "";

    /**
     * CloudinaryAdapter constructor.
     *
     * @param array $config
     * @throws Exception
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
        parent::__construct($config);
        $this->publicUrlPrefix = $this->imageXBuildUriPrefix();
    }

    /**
     * @return Repository
     */
    public function getCacheRepository(){
        $cache = app()['cache'];
        return $cache->driver($cache->getDefaultDriver());
    }

    /**
     * 获取本地 图片/附件 Url地址
     *
     * @param $path
     * @return mixed
     */
    public function getUrl($path)
    {
        $prefix = $this->publicUrlPrefix;
        $ret = "$prefix/$path";
        return $ret;
    }
}
