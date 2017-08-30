<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Examen]].
 *
 * @see Examen
 */
class ExamenQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Examen[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Examen|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
