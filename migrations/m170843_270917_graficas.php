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

class m170843_270917_graficas extends Migration
{
    public function up()
    {
    	$this->addColumn('{{%grafica}}', 'paciente_id', $this->integer()->notNull());
    }
	
    public function down()
    {
        $this->dropcolumn('{{%grafica}}', 'paciente_id');
    }
}
