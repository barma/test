<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Автомобили.
 *
 * @property integer $id         Id
 * @property integer $status     Статус видимости (0 - не опубликован, 1-опубликован)
 * @property integer $categoryId Модельный ряд
 * @property string  $title      Название
 * @property string  $image      Изображение
 * @property integer $price      Цена
 * @property integer $date       Дата выпуска
 * @property string  $url        Ссылка на автомобиль
 * @property integer $created_at Дата создания
 * @property integer $updated_at Дата обновления
 *
 */
class Car extends ActiveRecord
{

    /**
     * Путь к папке с загруженными фото.
     */
    const PATH_UPLOAD_PHOTO = '/upload/car/img';

    /**
     * Картинка по умолчанию
     */
    const DEFAULT_IMAGE = '/img/default_image.jpg';

    /**
     * @var int Количество отображаемых элементов в списке.
     */
    public $pageSize = 5;

    /**
     * список категорий атво
     */
    public static $categories = [1 => 'mercedes', 2 => 'nissan', 3 => 'audi'];


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'car';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        // Необходимо написать правила валидации
        $rules = [
            [['id', 'price', 'categoryId'], 'integer'],
            [['title', 'url'], 'string'],
            [['url'], 'unique'],
            [['image'], 'file', 'extensions' => ['jpg', 'png'], 'checkExtensionByMimeType' => true ]
        ];

        return $rules;
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'status' => Yii::t('app', 'Статус'),
            'title' => Yii::t('app', 'Название'),
            'image' => Yii::t('app', 'Изображение'),
            'categoryId' => Yii::t('app', 'Модельный ряд'),
            'price' => Yii::t('app', 'Цена'),
            'url' => Yii::t('app', 'Ссылка на страницу'),
            'date' => Yii::t('app', 'Дата выпуска'),
            'created_at' => Yii::t('app', 'Дата создания'),
            'updated_at' => Yii::t('app', 'Дата обновления'),
        ];

    }

    /**
     * Картинка либо заглушка
     * return string
     */
    public function getImage()
    {
        if (!empty($this->image)) {
            return $_SERVER['DOCUMENT_ROOT'] . self::PATH_UPLOAD_PHOTO. DIRECTORY_SEPARATOR . $this->image;
        }
        return self::DEFAULT_IMAGE;
    }

}
