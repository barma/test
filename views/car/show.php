<?php
/* var @car app\models\Car */

use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\Category;

echo DetailView::widget([
    'model' => $car,
    'attributes' => [
        [
            'attribute' => 'categoryId',
            'value' => function($car) {
                return Category::getList()[$car->categoryId];
            }
        ],
        'title',
        [
            'attribute' => 'image',
            'format' => 'html',
            'value' => function($car) {
                return Html::img($car->getImage(), ['width' => '400px']);
            }
        ],
        'price',
        'updated_at:datetime',
    ],
]);
?>

<a href="<?php echo Url::to('/');?>" class="btn btn-default">Back</a>
