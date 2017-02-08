<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\User;
use backend\models\Event;
use app\models\UploadForm;
use yii\web\UploadedFile;
use backend\models\CsvForm;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    /** upload File CSV */
    public function actionUpload()
    {
    	$model = new CsvForm();
    	//$file = CUploadedFile::getInstance($model,'csv_file');
    	if(isset($_POST['CsvForm']))
    	{
    		$model->attributes=$_POST['CsvForm'];
    		if(!empty($_FILES['CsvForm']['tmp_name']['csv_file']))
    		{
    			$file = CUploadedFile::getInstance($model,'csv_file');
    	
    	
    			$fp = fopen($file->tempName, 'r');
    			if($fp)
    			{
    				 //$line = fgetcsv($fp, 1000, ",");
    				//  print_r($line); exit;
    				$first_time = true;
    				do {
    					if ($first_time == true) {
    						$first_time = false;
    						continue;
    					}
    					$model = new CsvForm();
    					$model->Event_name = $line[0];
    					$model->Start_Date  = $line[1];
    					$model->End_Date = $line[2];
    					$model->Discription = $line[3];
    					$model->Type = $line[4];
    					$model->Color = $line[5];
    					
    					if (!$model->validate())
    						throw new Exception("Validation failed.");
    		
    					$model->save();
    	
    				}while( ($line = fgetcsv($fp, 1000, ";")) != FALSE);
    				$this->redirect('././index');
    	
    			}
    			//    echo   $content = fread($fp, filesize($file->tempName));x
    	
    		}
    	
    	
    	
    	}
    	
    	
    	$this->render('import', array('model' => $model) );
    	
    	}
  
}
