<?php

namespace CottaCush\Cricket\Report\Constants;

class Messages
{
    const RECORD_NOT_FOUND = 'Record not found';

    const ENTITY_REPORT = 'Report';

    public static function getNotFoundMessage($entity = 'Record')
    {
        return sprintf('%s not found', $entity);
    }
}
