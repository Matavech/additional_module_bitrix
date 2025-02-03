<?php

namespace Bitrix\Related\Internals\Model;

use Bitrix\Main\Entity;
use Bitrix\Main\Type\DateTime;

class RelatedProductTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'b_related_related_product';
    }

    public static function getMap()
    {
        return [
            new Entity\IntegerField('ID', [
                'primary' => true,
                'autocomplete' => true
            ]),
            new Entity\IntegerField('DEAL_ID', [
                'required' => true
            ]),
            new Entity\StringField('TITLE', [
                'required' => true,
                'size' => 255
            ]),
            new Entity\FloatField('PRICE', [
                'required' => true
            ]),
            new Entity\DatetimeField('CREATED_AT', [
                'default_value' => function () {
                    return new DateTime();
                }
            ])
        ];
    }
}