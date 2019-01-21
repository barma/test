<?php
/* var @car app\models\Car */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\Category;
use kartik\date\DatePicker;
use dosamigos\fileupload\FileUpload;

?>
<div class="cars-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($car, 'categoryId')->dropDownList(Category::getList()) ?>

    <?php echo $form->field($car, 'title')->textInput(['maxlength' => true]) ?>

    <div class="car-image">
        <img src="<?php echo $car->getImage() ?>" alt="">
    </div>

    <?php echo FileUpload::widget([
        'model' => $image,
        'attribute' => 'image',
        'url' => ['car/save-image', 'id' => $car->id], // your url, this is just for demo purposes,
        'clientOptions' => [
            'maxFileSize' => 4000000
        ],
        'clientEvents' => [
            'fileuploaddone' => 'function(e, data) {
                                console.log(e);
                                console.log(data);
                            }',
            'fileuploadfail' => 'function(e, data) {
                                console.log(e);
                                console.log(data);
                            }',
        ],
    ]); ?>

    <?php echo $form->field($car, 'price')->textInput() ?>

    <?php echo $form->field($car, 'url')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <label class="control-label">Date of issue:</label>
        <?php echo DatePicker::widget([
            'model' => $car,
            'attribute' => 'date',
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'options' => [
                'value' => ($car->date) ? Yii::$app->formatter->asDate($car->date) : '',
                'placeholder' => 'Enter date creation'
            ],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'dd-MM-yyyy'
            ]
        ]);?>
    </div>

    <div class="form-group">
        <?php echo Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
