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

class m170842_250917_periodo extends Migration
{
    public function up()
    {
		$this->addColumn('{{%periodo}}', 'fechaFin', $this->date()->notNull());
    }

    public function down()
    {
		$this->dropcolumn('{{%periodo}}', 'fechaFin');
    }
}
