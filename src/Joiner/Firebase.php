<?php

namespace Joiner;

use Firebase\FirebaseLib;

/**
 * Class Firebase
 * @package Joiner
 */
class Firebase
{
    /**
     * @return FirebaseLib
     */
    public static function Factory()
    {
        return new FirebaseLib('https://test01-ef4ce.firebaseio.com/', 'OSaFE05MFyjOUtmFFKpIUx1YOysl9io6kqZOriTv');
    }
}
