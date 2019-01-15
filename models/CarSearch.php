<?php


namespace app\models;

use yii\data\ActiveDataProvider;
use yii\base\Model;
use app\models\Car;
use Yii;

/**
 * Class CarSearch
 * @package app\models
 * @property integer $priceFrom
 * @property integer $priceTo
 * @property string $dateUpdateFrom
 * @property string $dateUpdateTo
 */
class CarSearch extends Car
{

    // цена от
    public $priceFrom;
    // цена до
    public $priceTo;
    // дата изменения от
    public $dateUpdateFrom;
    // дата изменения до
    public $dateUpdateTo;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['categoryId', 'priceFrom', 'priceTo', 'dateUpdateFrom', 'dateUpdateTo'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     * @throws \yii\base\InvalidConfigException
     */
    public function search($params)
    {
        $query = Car::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if ($this->dateUpdateFrom) {
            $this->dateUpdateFrom = Yii::$app->formatter->asTimestamp($this->dateUpdateFrom);
        }

        if ($this->dateUpdateTo) {
            $this->dateUpdateTo = Yii::$app->formatter->asTimestamp($this->dateUpdateTo);
        }

        $query->andFilterWhere(['categoryId' => $this->categoryId])
            ->andFilterWhere(['>=','price', $this->priceFrom])
            ->andFilterWhere(['<=','price', $this->priceTo])
            ->andFilterWhere(['>=','updated_at', $this->dateUpdateFrom])
            ->andFilterWhere(['<=','updated_at', $this->dateUpdateTo]);

        return $dataProvider;
    }

}