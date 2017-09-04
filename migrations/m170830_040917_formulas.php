<?php

use yii\db\Migration;

class m170830_040917_formulas extends Migration
{
    public function safeUp()
    {
        $this->createTable('formula', [
            'id' => $this->primaryKey(),
            'paciente_id' => $this->integer()->notNull(),
            'doctor_id' => $this->integer()->notNull(),
            'fecha' => $this->date()->notNull(),
            'dosis' => $this->integer()->notNull(),
            'capsula' => $this->integer()->notNull(),
            'cajas' => $this->integer()->notNull()
        ]);
		
		// creates index for column `paciente_id`
        $this->createIndex(
            'idx-formula-paciente_id',
            'formula',
            'paciente_id'
        );

        // add foreign key for table `paciente`
        $this->addForeignKey(
            'fk-post-formula_id',
            'formula',
            'paciente_id',
            'paciente',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        echo "m170830_040917_formulas cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }
    public function down()
    {
        echo "m170830_040917_formulas cannot be reverted.\n";

        return false;
    }
    */
}
