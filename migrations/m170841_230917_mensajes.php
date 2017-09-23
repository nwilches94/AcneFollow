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

class m170841_230917_mensajes extends Migration
{
    public function up()
    {
    	$this->dropcolumn('{{%mensaje}}', 'fecha');
		$this->addColumn('{{%mensaje}}', 'fecha', $this->datetime()->notNull());
		$this->addColumn('{{%mensaje}}', 'ampm', $this->string()->notNull());
    }

    public function down()
    {
		$this->dropcolumn('{{%mensaje}}', 'fecha');
		$this->dropcolumn('{{%mensaje}}', 'ampm');
    }
}
