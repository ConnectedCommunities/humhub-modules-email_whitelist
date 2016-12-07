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

use humhub\modules\email_whitelist\models\EmailWhitelistSearch;
use Yii;
use humhub\models\Setting;
use yii\helpers\Url;
use humhub\compat\HForm;
use humhub\modules\anon_accounts\forms\AnonAccountsForm;
use humhub\libs\ProfileImage;
use humhub\modules\email_whitelist\models\EmailWhitelist;

class AdminController extends \humhub\modules\admin\components\Controller
{
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'acl' => [
                'class' => \humhub\components\behaviors\AccessControl::className(),
                'adminOnly' => true
            ]
        ];
    }

    /**
     * Configuration Action for Super Admins
     */
    public function actionIndex() {

        $searchModel = new EmailWhitelistSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', array(
            'dataProvider' => $dataProvider,
            'model' => EmailWhitelist::find()
        ));


    }
     


    /** 
     * Add a whitelist record
     */
    public function actionAdd()
    {

        // Build Form Definition
        $definition = array();
        $definition['elements'] = array();

        // Define Form Elements
        $definition['elements']['EmailWhitelist'] = array(
            'type' => 'form',
            'title' => 'EmailWhitelist',
            'elements' => array(
                'domain' => array(
                    'type' => 'text',
                    'class' => 'form-control',
                    'maxlength' => 400,
                ),
            ),
        );

        // Get Form Definition
        $definition['buttons'] = array(
            'save' => array(
                'type' => 'submit',
                'class' => 'btn btn-primary',
                'label' => 'Create'
            ),
        );

        $form = new HForm($definition);
        $form->models['EmailWhitelist'] = new EmailWhitelist();

        // Save new email for whitelist
        if($form->submitted('save') && $form->validate()) {
            $form->models['EmailWhitelist']->save();
            return $this->redirect(Url::to(['index']));
        }

        return $this->render('add', array('hForm' => $form));

    }


    /** 
     * Edit a whitelist record
     */
    public function actionEdit()
    {

        $id = (int) Yii::$app->request->get('id');
        $emailWhiteList = EmailWhitelist::findOne(['id' => $id]);

        if ($emailWhiteList == null)
            throw new \yii\web\HttpException(404, "EmailWhitelist record not found!");

        // Build Form Definition
        $definition = array();
        $definition['elements'] = array();

        // Define Form Eleements
        $definition['elements']['EmailWhitelist'] = array(
            'type' => 'form',
            'title' => 'Domain',
            'elements' => array(
                'domain' => array(
                    'type' => 'text',
                    'class' => 'form-control',
                    'maxlength' => 400,
                ),
            ),
        );


        // Get Form Definition
        $definition['buttons'] = array(
            'save' => array(
                'type' => 'submit',
                'label' => 'Save',
                'class' => 'btn btn-primary',
            ),
            'delete' => array(
                'type' => 'submit',
                'label' => 'Delete',
                'class' => 'btn btn-danger',
            ),
        );

        $form = new HForm($definition);
        $form->models['EmailWhitelist'] = $emailWhiteList;

        if ($form->submitted('save') && $form->validate()) {
            if ($form->save()) {
                return $this->redirect(Url::toRoute(['edit', 'id' => $emailWhiteList->id]));
            }
        }


        if ($form->submitted('delete')) {
            return $this->redirect(Url::toRoute(['delete', 'id' => $karma->id]));
        }

        return $this->render('edit', array('hForm' => $form));

    }


    /**
     * Deletes a whitelist record
     */
    public function actionDelete()
    {

        $id = (int) Yii::$app->request->get('id');
        $doit = (int) Yii::$app->request->get('doit');

        $emailWhitelist = EmailWhitelist::findOne(['id' => $id]);

        if ($emailWhitelist == null)
            throw new \yii\web\HttpException(404, "EmailWhitelist record not found!");

        if ($doit == 2) {
            $this->forcePostRequest();
            $emailWhitelist->delete();
            return $this->redirect(Url::toRoute('index'));

        }

        return $this->render('delete', array('model' => $emailWhitelist));

    }
}