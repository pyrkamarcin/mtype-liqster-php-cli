<?php

namespace Joiner\Connections;

use Symfony\Component\Filesystem\Filesystem;

/**
 * Class Path
 * @package Joiner\Connections
 */
class Path
{
    /**
     * @var string
     */
    private $dirPath;
    /**
     * @var
     */
    private $username;

    /**
     * Path constructor.
     * @param $username
     * @throws \Symfony\Component\Filesystem\Exception\IOException
     */
    public function __construct($username)
    {
        $this->dirPath = __DIR__ . '/../../../var/cache/instaxer/profiles';
        if (!is_dir($this->dirPath)) {
            $this->generateDir();
        }

        $this->username = $username;
    }

    /**
     * @throws \Symfony\Component\Filesystem\Exception\IOException
     */
    private function generateDir()
    {
        $fs = new Filesystem();
        $fs->mkdir($this->dirPath);
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->dirPath . '/' . $this->username . '.profile.json';
    }
}
