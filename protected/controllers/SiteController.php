<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$model = new Search;
		
		if(isset($_POST['Search']))
		{
			$model->attributes=$_POST['Search'];
			$string = $model->string;
			
			if($string!=null)
			{
				$string = addcslashes($string, '%_');
				if($model->check == 0)
				{
					$criteria = new CDbCriteria( array(
					'condition' => "name LIKE :string OR surname Like :string OR number LIKE :string",
					'params'    => array(':string' => "%$string%")
				));
				}
				else{
					$criteria = new CDbCriteria( array(
						'condition' => "name =:string OR surname =:string OR number =:string",
						'params'    => array(':string' => "$string")
					));
				}
				$dataProvider = Contacts::model()->findAll($criteria);
				$model->unsetAttributes();
			}
			
			$this->render('index',array('model'=>$model, 'dataProvider'=>$dataProvider));
		}
		
		else
		{
			$this->render('index',array('model'=>$model));
		}
	}
	
	public function actionAddContact(){
	
		$model = new Contacts;
		$state = false;
	
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		if(isset($_POST['Contacts'])){
			$model->attributes=$_POST['Contacts'];
			if($model->save()){
				$state = true;
				$model->unsetAttributes();
				
			}
		}
		
		//unset($_POST['state']);
		
		$this->render('add',array('model'=>$model, 'state'=>$state));
		
	
	}
	
	public function actionEditContact($id=null){
	
		$state = false;
	
		if($id!=null)
		{
			$model=Contacts::model()->findByPk($id);
		}
		
		if(isset($_POST['Contacts'])){
			$model->attributes=$_POST['Contacts'];
			if($model->save())
			{
				$state = true;
			}
		}
		
		$this->render('edit',array('model'=>$model, 'state'=>$state));
	
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

}