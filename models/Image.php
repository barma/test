<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Class Image
 * @package app\models
 */
class Image extends Model
{

    /**
     * @var
     */
    public $image;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['picture'], 'file',
                'extensions' => ['jpg','png'],
                'checkExtensionByMimeType' => true
            ],
        ];
    }

}
