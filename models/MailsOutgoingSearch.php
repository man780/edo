<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MailsOutgoing;

/**
 * MailsOutgoingSearch represents the model behind the search form of `app\models\MailsOutgoing`.
 */
class MailsOutgoingSearch extends MailsOutgoing
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'bycreated'], 'integer'],
            [['num', 'date', 'organization', 'description', 'result', 'dcreated'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = MailsOutgoing::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'date' => $this->date,
            'dcreated' => $this->dcreated,
            'bycreated' => $this->bycreated,
        ]);

        $query->andFilterWhere(['like', 'num', $this->num])
            ->andFilterWhere(['like', 'organization', $this->organization])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'result', $this->result]);

        return $dataProvider;
    }
}
