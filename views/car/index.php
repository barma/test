<?php

/* var @searchModel as app\models\CarSearch */
/* var @dataProvider as  app\models\Car[] */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Car;
use kartik\date\DatePicker;
use yii\helpers\Url;

?>

<div class="col-lg-12">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($searchModel, 'categoryId')->dropDownList(Car::$categories, ['prompt' => 'Выбор категории']) ?>
    <?php echo $form->field($searchModel, 'priceFrom')->textInput(['autofocus' => true])->label('Цена от:') ?>
    <?php echo $form->field($searchModel, 'priceTo')->textInput(['autofocus' => true])->label('Цена до:') ?>

    <?php
    $valueFrom = '';
    if ($searchModel->dateUpdateFrom) {
        $valueFrom = Yii::$app->formatter->asDate($searchModel->dateUpdateFrom);
    }
    ?>
    <div class="form-group">
        <label class="control-label">Дата от:</label>
        <?php echo DatePicker::widget([
            'model' => $searchModel,
            'attribute' => 'dateUpdateFrom',
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'value' => $valueFrom,
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'dd-MM-yyyy'
            ]
        ]);?>
    </div>

    <?php
    $valueTo = '';
    if ($searchModel->dateUpdateTo) {
        $valueTo = Yii::$app->formatter->asDate($searchModel->dateUpdateTo);
    }
    ?>
    <div class="form-group">
        <label class="control-label">Дата до:</label>
        <?php echo DatePicker::widget([
            'model' => $searchModel,
            'attribute' => 'dateUpdateTo',
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'value' => $valueTo,
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'dd-MM-yyyy'
            ]
        ]);?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Filter', ['class' => 'btn btn-primary', 'name' => 'submit']) ?>
        <?= Html::a('Clear', ['/'], ['class' => 'btn btn-info']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<div class="col-lg-12">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            array(
                'attribute' => 'categoryId',
                'value' => function($car) {
                    return Car::$categories[$car->categoryId];
                }
            ),
            'title',
            array(
                'attribute' => 'image',
                'format' => 'html',
                'value' => function($car) {
                    return Html::img($car->getImage(), ['width' => '300px']);
                }
            ),
            'price',
            'date:datetime',
            'updated_at:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'template' => '{view}   {update}',
                'buttons' => [
                    'view' => function ($url, $car) {
                        $url = Url::to(['car/show-car', 'url'=>$car->url]);
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                            $url);
                    },
                    'update' =>  function ($url, $car) {
                        $url = Url::to(['car/edit', 'id'=>$car->id]);
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                            $url);
                    }
                ]
            ]
        ],
    ]);
    ?>
</div>
