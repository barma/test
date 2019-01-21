<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Cars
 *
 * @property integer $id
 * @property integer $status
 * @property integer $categoryId
 * @property string  $title
 * @property string  $image
 * @property integer $price
 * @property integer $date
 * @property string  $url
 * @property integer $created_at
 * @property integer $updated_at
 *
 */
class Car extends ActiveRecord
{

    /**
     * Path to pictures folder
     */
    const PATH_UPLOAD_PHOTO = '/upload/car/img';

    /**
     * Default picture
     */
    const DEFAULT_IMAGE = '/img/default_image.jpg';

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
        $rules = [
            [['id', 'price', 'categoryId'], 'integer'],
            [['title', 'url'], 'string'],
            [['url'], 'unique'],
            [['date'], 'safe'],
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
            ]
        ];
    }

    /**
     * date to timestamp format
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->date = Yii::$app->formatter->asTimestamp($this->date);

        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'status' => Yii::t('app', 'Status'),
            'title' => Yii::t('app', 'Name'),
            'image' => Yii::t('app', 'Image'),
            'categoryId' => Yii::t('app', 'Category'),
            'price' => Yii::t('app', 'Price'),
            'url' => Yii::t('app', 'Link to page'),
            'date' => Yii::t('app', 'Date of issue'),
            'created_at' => Yii::t('app', 'Date creation'),
            'updated_at' => Yii::t('app', 'Date update'),
        ];

    }

    /**
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
