<?php

namespace Joiner\Reposter;

use Alorel\Dropbox\Operation\AbstractOperation;
use Alorel\Dropbox\Operation\Files\Upload;
use Instagram\API\Response\ConfigureMediaResponse;
use Instaxer\Downloader;
use Instaxer\Instaxer;
use Instaxer\Request;
use Intervention\Image\ImageManager;
use Joiner\Shuffle;
use Maxer\API\Model\User;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class Push
 * @package Joiner\Reposter
 */
class Push
{
    /**
     * @param string $url
     * @return \GuzzleHttp\Promise\PromiseInterface|\Psr\Http\Message\ResponseInterface
     */
    public static function downloadPhotoByURLToDropbox(string $url)
    {

        $dirPath = __DIR__ . '/../../../vendor/pyrkamarcin/instaxer/app/storage/';
        $filesystem = new Filesystem();
        $filesystem->mkdir($dirPath);
        $filesystem->touch(__DIR__ . '/../../../vendor/pyrkamarcin/instaxer/app/storage/storage.tmp');

        AbstractOperation::setDefaultAsync(false);
        AbstractOperation::setDefaultToken('MTn5Od3DgSMAAAAAAAAaD2ucStBCuS6I3iuy1dNwqvIoe3HcXnu8nJGXBIuDmmi5');

        if (self::checkUnique($url)) {
            file_put_contents(__DIR__ . '/../../../vendor/pyrkamarcin/instaxer/app/storage/storage_dropbox.tmp', $url . ';', FILE_APPEND);

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

            $op = new Upload();
            $name = '/' . random_int(1, 100000000000000) . '.jpg';

            return $op->raw($name, \GuzzleHttp\Psr7\stream_for(fopen($dirPath . 'test1.jpg', 'r')));
        }

        throw new \RuntimeException('url is not unique');
    }

    /**
     * @param string $url
     * @param Instaxer $instaxer
     * @return ConfigureMediaResponse
     * @throws \Exception
     */
    public static function repostPhotoByURL(string $url, Instaxer $instaxer, User $user): ConfigureMediaResponse
    {
        $dirPath = __DIR__ . '/../../../vendor/pyrkamarcin/instaxer/app/storage/';
        $filesystem = new Filesystem();
        $filesystem->mkdir($dirPath);
        $filesystem->touch(__DIR__ . '/../../../vendor/pyrkamarcin/instaxer/app/storage/storage.tmp');

        AbstractOperation::setDefaultAsync(false);
        AbstractOperation::setDefaultToken('MTn5Od3DgSMAAAAAAAAaD2ucStBCuS6I3iuy1dNwqvIoe3HcXnu8nJGXBIuDmmi5');

        if (self::checkUnique($url)) {
            file_put_contents(__DIR__ . '/../../../vendor/pyrkamarcin/instaxer/app/storage/storage.tmp', $url . ';', FILE_APPEND);


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

            return $requestPublishPhoto->pull($dirPath . 'test1.jpg', 'REPOST FROM maxmodels.pl ' .
                'Model: ' . $user->getName() . ' ' .
                Shuffle::go(' #maxmodels #polishmodel #nudemodel #polishgirl #sexyback #sexylingerie #sexygirl #sexyginger #gingerhair #skinnybody #bodygoals #perfectbody #perfectgirl #sexyass #hotbutt #hotmodel #hotbody #instalingerie #lingerieaddict #sensualmood #boudoirmodel #dessous #nudeart #instagirl #instamood')
            );
        }

        throw new \RuntimeException('url is not unique');
    }

    /**
     * @param string $url
     * @return bool
     */
    private static function checkUnique(string $url): bool
    {
        $repository = file_get_contents(__DIR__ . '/../../../vendor/pyrkamarcin/instaxer/app/storage/storage.tmp');
        $haystack = explode(';', $repository);
        return !in_array($url, $haystack, true);
    }
}
