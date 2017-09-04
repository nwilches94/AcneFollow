<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Nav;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\User $user
 */

$this->title = Yii::t('user', 'Create a user account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('@vendor/dektrium/yii2-user/views/_alert', ['module' => Yii::$app->getModule('user'),]) ?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
            	
            	<h1><?= Html::encode($this->title) ?></h1><br>
            	
                <?= $this->render('_formCreate', [
				    'user' => $user
				]) ?>
	
            </div>
        </div>
    </div>
</div>
