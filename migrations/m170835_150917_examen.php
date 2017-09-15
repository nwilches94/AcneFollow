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

class m170835_150917_examen extends Migration
{
    public function up()
    {
        $this->addColumn('{{%examen}}', 'tipo', $this->string(255)->notNull());
    }

    public function down()
    {
        $this->dropcolumn('{{%examen}}', 'tipo');
    }
}
