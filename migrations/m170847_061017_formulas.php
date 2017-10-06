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

class m170847_061017_formulas extends Migration
{
    public function up()
    {
    	$this->dropcolumn('{{%formula}}', 'peso');
        $this->addColumn('{{%formula}}', 'peso', $this->integer(11)->notNull());
    }

    public function down()
    {
        $this->dropcolumn('{{%formula}}', 'peso');
    }
}
