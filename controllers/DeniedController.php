<?php
/**
 * Connected Communities Initiative
 * Copyright (C) 2016 Queensland University of Technology
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

namespace humhub\modules\email_whitelist\controllers;

use Yii;
use humhub\components\Controller;

class DeniedController extends Controller
{

    public $layout = "@humhub/modules/user/views/layouts/main";
    public $subLayout = "_layout";

    /**
     * Show email not on whitelist page
     */
    public function actionIndex() {
        return $this->render('index', array());
    }
     

}