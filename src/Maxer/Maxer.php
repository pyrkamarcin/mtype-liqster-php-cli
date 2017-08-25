<?php

namespace Maxer;

use Maxer\API\Framework\Token;
use Maxer\API\Model\Photo;
use Maxer\API\Model\User;
use Maxer\API\Request\Base\PageRequest;
use Maxer\API\Request\LastPhotosRequest;
use Maxer\API\Request\LoginRequest;
use Maxer\API\Request\ObservedPhotosRequest;
use Maxer\API\Request\RankedPhotosRequest;
use Maxer\API\Request\TokenRequest;
use Maxer\API\Request\VoutePhotoRequest;
use Maxer\API\Response\PhotosResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Maxer
 * @package Maxer
 */
class Maxer
{
    /**
     * Maxer constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param string $username
     * @param string $password
     * @return ResponseInterface
     * @throws \InvalidArgumentException
     */
    public function login(string $username, string $password): ResponseInterface
    {
        $request = new LoginRequest($username, $password);
        return $request->execute();
    }

    /**
     * @param int $limit
     * @return array
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function getLastPhotos(int $limit = 45): array
    {
        $request = new LastPhotosRequest();
        return PhotosResponse::toObjects(PhotosResponse::parse($request->execute(), $limit));
    }

    /**
     * @param int $limit
     * @return array
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function getRankedPhotos(int $limit = 45): array
    {
        $request = new RankedPhotosRequest();
        return PhotosResponse::toObjects(PhotosResponse::parse($request->execute(), $limit));
    }

    /**
     * @param int $limit
     * @return array
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function getObservedPhotos(int $limit): array
    {
        $request = new ObservedPhotosRequest();
        return PhotosResponse::toObjects(PhotosResponse::parse($request->execute(), $limit));
    }

    /**
     * @param User $user
     * @param int $limit
     * @return array
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function getUserPhotos(User $user, int $limit): array
    {
        $link = 'http://www.maxmodels.pl/modelka-' . $user->getName() . '.html';
        $request = new PageRequest($link);
        return PhotosResponse::toObjects(PhotosResponse::parse($request->execute(), $limit));
    }

    /**
     * @param User $user
     * @param int $pageCount
     * @return array
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     * @internal param int $limit
     */
    public function getUserMultiPhotos(User $user, int $pageCount): array
    {
        $array = [];

        for ($a = 0; $a <= $pageCount; $a++) {
            $link = 'http://www.maxmodels.pl/modelka-' . $user->getName() . ',' . $a . '.html';
            $request = new PageRequest($link);
            $array[] = PhotosResponse::toObjects(PhotosResponse::parse($request->execute(), 20));
        }

        return $array;
    }

    /**
     * @param Photo $photo
     * @param int $rate
     * @return ResponseInterface
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function setPhotoVoute(Photo $photo, int $rate): ResponseInterface
    {
        $request = new VoutePhotoRequest(new Token(), $photo, $rate);
        return $request->execute();
    }

    public function getToken()
    {
        $request = new TokenRequest();
        return $request->execute();
    }
}
