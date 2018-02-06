<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MailsIncoming;

/**
 * MailsIncomingSearch represents the model behind the search form of `app\models\MailsIncoming`.
 */
class MailsIncomingSearch extends MailsIncoming
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'bycreated'], 'integer'],
            [['in_num', 'in_date', 'out_num', 'out_date', 'organization', 'description', 'deadline', 'result', 'dcreated'], 'safe'],
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
        $query = MailsIncoming::find();

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
            'in_date' => $this->in_date,
            'out_date' => $this->out_date,
            'deadline' => $this->deadline,
            'dcreated' => $this->dcreated,
            'bycreated' => $this->bycreated,
        ]);

        $query->andFilterWhere(['like', 'in_num', $this->in_num])
            ->andFilterWhere(['like', 'out_num', $this->out_num])
            ->andFilterWhere(['like', 'organization', $this->organization])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'result', $this->result]);

        return $dataProvider;
    }
}
