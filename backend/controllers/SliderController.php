<?php

namespace backend\controllers;

use Yii;
use common\models\Slider;
use backend\models\SliderSearch;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class SliderController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'toggle-active' => ['POST'],
                    'move-up' => ['POST'],
                    'move-down' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new SliderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->redirect(['index']);
    }

    public function actionCreate()
    {
        $model = new Slider();
        $model->is_active = 1;
        $model->button_type = Slider::BUTTON_COURSE;

        if ($model->load(Yii::$app->request->post())) {
            $model->uploadAndSetImagePath();

            if (!$model->image_path) {
                $model->addError('imageFile', 'Image cannot be blank.');
            }

            if (!$model->hasErrors() && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->uploadAndSetImagePath();

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    public function actionToggleActive($id)
    {
        $model = $this->findModel($id);
        $model->is_active = $model->is_active ? 0 : 1;
        $model->save(false, ['is_active', 'updated_at']);
        return $this->redirect(['index']);
    }

    public function actionMoveUp($id)
    {
        $model = $this->findModel($id);

        $prev = Slider::find()
            ->where(['<', 'sort_order', $model->sort_order])
            ->orderBy(['sort_order' => SORT_DESC, 'id' => SORT_DESC])
            ->one();

        if ($prev) {
            $db = Yii::$app->db;
            $tx = $db->beginTransaction();
            try {
                $tmp = $model->sort_order;
                $model->sort_order = $prev->sort_order;
                $prev->sort_order = $tmp;
                $model->save(false, ['sort_order', 'updated_at']);
                $prev->save(false, ['sort_order', 'updated_at']);
                $tx->commit();
            } catch (\Throwable $e) {
                $tx->rollBack();
                throw $e;
            }
        }

        return $this->redirect(['index']);
    }

    public function actionMoveDown($id)
    {
        $model = $this->findModel($id);

        $next = Slider::find()
            ->where(['>', 'sort_order', $model->sort_order])
            ->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_ASC])
            ->one();

        if ($next) {
            $db = Yii::$app->db;
            $tx = $db->beginTransaction();
            try {
                $tmp = $model->sort_order;
                $model->sort_order = $next->sort_order;
                $next->sort_order = $tmp;
                $model->save(false, ['sort_order', 'updated_at']);
                $next->save(false, ['sort_order', 'updated_at']);
                $tx->commit();
            } catch (\Throwable $e) {
                $tx->rollBack();
                throw $e;
            }
        }

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Slider::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
