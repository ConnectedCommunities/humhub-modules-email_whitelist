<?php
/**
 * Connected Communities Initiative
 * Copyright (C) 2016  Queensland University of Technology
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */


use yii\helpers\Html;
?>
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>Email</strong> rejected
        </div>
        <div class="panel-body">

            <strong><?php echo Html::encode($message); ?></strong>

            <br />
            <hr>
            <a href="javascript:history.back();" class="btn btn-primary  pull-right"><?php echo Yii::t('base', 'Back'); ?></a>
        </div>
    </div>
</div>