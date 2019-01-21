<?php


namespace app\controllers;

use app\models\Image;
use Yii;
use app\models\Car;
use yii\web\Controller;
use app\models\CarSearch;
use yii\web\UploadedFile;
use yii\web\Response;
use yii\helpers\FileHelper;

/**
 * Class CarController
 * @package app\controllers
 */
class CarController extends Controller
{

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex()
    {
        $searchModel = new CarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $pageSize = Yii::$app->params['carsPageSize'];
        $dataProvider->pagination = ['pageSize' => $pageSize];
        $dataProvider->sort = new \yii\data\Sort([
            'attributes' => [
                'price',
                'updated_at'
            ],
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionEdit($id)
    {

        $car = Car::findOne($id);

        if ($car->load(Yii::$app->request->post()) && $car->save()) {
            return $this->redirect(['car/show-car', 'url' => $car->url]);
        }

        $image = new Image();

        return $this->render('edit', [
            'car' => $car,
            'image' => $image
        ]);
    }

    /**
     * @param $url
     * @return string
     */
    public function actionShowCar($url) {
        $model = new Car();

        $car = $model::find()->where(['url' => $url])->one();

        return $this->render('show', [
            'car' => $car,
        ]);
    }

    /**
     * @param integer $id
     * @return string
     * @throws \yii\base\Exception
     */
    public function actionSaveImage($id) {

        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new Car();
        $car = $model::find()->where(['id' => $id])->one();
        $image = new Image();
        $imageFile = UploadedFile::getInstance($image, 'image');

        $directory = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .
            Car::PATH_UPLOAD_PHOTO . DIRECTORY_SEPARATOR;

        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory);
        }

        if ($imageFile) {

            $fileName = sha1_file($imageFile->tempName) . '.' . $imageFile->extension;
            $filePath = $directory . $fileName;

            if ($imageFile->saveAs($filePath)) {

                if (is_file($directory . $car->image)) {
                    unlink($directory . $car->image);
                }

                $car->image = $fileName;
                $car->save();

                return [
                    'files' => [
                        [
                            'name' => $fileName,
                            'size' => $imageFile->size,
                            'url' => $filePath,
                        ],
                    ],
                ];
            }
        }
    }

}