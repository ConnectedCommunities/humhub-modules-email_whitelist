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

class AdminController extends Controller
{
     public $subLayout = "application.modules_core.admin.views._layout";

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'expression' => 'Yii::app()->user->isAdmin()',
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Configuration Action for Super Admins
     */
    public function actionIndex() {


        $model = new EmailWhitelist('search');

        $this->render('index', array(
            'model' => $model
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

        // Define Form Eleements
        $definition['elements']['EmailWhitelist'] = array(
            'type' => 'form',
            'elements' => array(
                'domain' => array(
                    'type' => 'text',
                    'class' => 'form-control',
                    'maxlength' => 25,
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
        $form['EmailWhitelist']->model = EmailWhitelist::model();

        // Save new karma
        if($form->submitted('save') && $form->validate()) {
            
            $emailWhitelistModel = new EmailWhitelist;
            $emailWhitelistModel->domain = $form['EmailWhitelist']->model->domain;
            $emailWhitelistModel->save();

            $this->redirect($this->createUrl('index'));

        }


        $this->render('add', array('form' => $form));

    }


    /** 
     * Edit a whitelist record
     */
    public function actionEdit()
    {

        $_POST = Yii::app()->input->stripClean($_POST);

        $id = (int) Yii::app()->request->getQuery('id');
        $user = User::model()->resetScope()->findByPk($id);
        $emailWhiteList = EmailWhitelist::model()->resetScope()->findByPk($id);

        if ($emailWhiteList == null)
            throw new CHttpException(404, "EmailWhitelist record not found!");

        // Build Form Definition
        $definition = array();
        $definition['elements'] = array();

        $groupModels = Group::model()->findAll();

        // Define Form Eleements
        $definition['elements']['EmailWhitelist'] = array(
            'type' => 'form',
            'title' => 'Edit whitelisted email',
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
        $form['EmailWhitelist']->model = $emailWhiteList;

        if ($form->submitted('save') && $form->validate()) {
            $this->forcePostRequest();

            if($form['EmailWhitelist']->model->save()) {
                $this->redirect($this->createUrl('edit', array('id' => $emailWhiteList->id)));
                return;
            }
        }

        if ($form->submitted('delete')) {
            $this->redirect(Yii::app()->createUrl('email_whitelist/admin/delete', array('id' => $user->id)));
        }

        $this->render('edit', array('form' => $form));

    }


    /**
     * Deletes a whitelist record
     */
    public function actionDelete()
    {

        $id = (int) Yii::app()->request->getQuery('id');
        $doit = (int) Yii::app()->request->getQuery('doit');

        $emailWhitelist = EmailWhitelist::model()->resetScope()->findByPk($id);

        if ($emailWhitelist == null) {
            throw new CHttpException(404, "Karma record not found");
        } 

        if ($doit == 2) {

            $this->forcePostRequest();

            $emailWhitelist->delete();
            $this->redirect($this->createUrl('index'));

        }

        $this->render('delete', array('model' => $emailWhitelist));
    }
}