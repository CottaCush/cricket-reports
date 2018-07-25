<?php

namespace CottaCush\Cricket\Report\Libs;

use Hashids\Hashids;

class Utils
{
    /**
     * @author Olawale Lawal <wale@cottacush.com>
     * @param $message
     * @param $params
     * @return mixed
     */
    public static function replaceTemplate($message, $params)
    {
        foreach ($params as $param => $value) {
            $message = str_replace('{{' . $param . '}}', $value, $message);
        }
        return $message;
    }

    public static function encodeId($id)
    {
        $hashids = new Hashids(getenv('HASH_SALT'), 10);
        $id = $hashids->encode($id);
        return $id;
    }

    public static function decodeId($id)
    {
        $hashids = new Hashids(getenv('HASH_SALT'), 10);
        $id = $hashids->decode($id);
        return $id;
    }
}
