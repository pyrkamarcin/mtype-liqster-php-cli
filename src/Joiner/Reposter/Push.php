<?php

namespace Joiner\Reposter;

use Instagram\API\Response\ConfigureMediaResponse;
use Instaxer\Downloader;
use Instaxer\Instaxer;
use Instaxer\Request;
use Intervention\Image\ImageManager;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class Push
 * @package Joiner\Reposter
 */
class Push
{
    /**
     * @param string $url
     * @param Instaxer $instaxer
     * @return ConfigureMediaResponse
     * @throws \Symfony\Component\Filesystem\Exception\IOException
     */
    public static function repostPhotoByURL(string $url, Instaxer $instaxer): ConfigureMediaResponse
    {
        $dirPath = __DIR__ . '/../../../vendor/pyrkamarcin/instaxer/app/storage/';
        $filesystem = new Filesystem();
        $filesystem->mkdir($dirPath);

        $downloader = new Downloader();
        $downloader->drain('http://' . $url);

        $manager = new ImageManager(array('driver' => 'gd'));
        $imageBg = $manager->canvas(1080, 1080, '#ffffff');

        $image = $manager
            ->make($dirPath . 'test.jpg')
            ->resize(1080, 1080, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save($dirPath . 'test.jpg');

        $imageBg->insert($image, 'center')->save($dirPath . 'test1.jpg');

        $requestPublishPhoto = new Request\PublishPhoto($instaxer);

        return $requestPublishPhoto->pull($dirPath . 'test1.jpg', 'REPOST FROM maxmodels.pl #maxmodels #polishmodel #nudemodel #polishgirl #sexyback #sexylingerie #sexygirl #sexyginger #gingerhair #skinnybody #bodygoals #perfectbody #perfectgirl #sexyass #hotbutt #hotmodel #hotbody #instalingerie #lingerieaddict #sensualmood #boudoirmodel #dessous #nudeart #instagirl #instamood');
    }
}
