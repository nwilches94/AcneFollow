<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use dektrium\user\migrations\Migration;

class m170837_180917_controlCajas extends Migration
{
    public function up()
    {
        $this->addColumn('{{%controlCaja}}', 'formula_id', $this->integer(11)->notNull());
		
		// creates index for column `paciente_id`
        $this->createIndex(
            'idx-controlCaja-formula_id',
            'controlCaja',
            'formula_id'
        );
		
		// add foreign key for table `formula`
        $this->addForeignKey(
            'fk-formula-controlCaja_id',
            'controlCaja',
            'formula_id',
            'formula',
            'id',
            'CASCADE'
        );
    }
	
    public function down()
    {
        $this->dropcolumn('{{%controlCaja}}', 'formula_id');
    }
}
