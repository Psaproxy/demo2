<?php

namespace app\controllers;

use Core\ShortUrl\Actions\FindOriginUrlById;
use Core\ShortUrl\Actions\IncTransition;
use yii\web\Controller;
use yii\web\Response;

class RedirectController extends Controller
{
    /**
     * @throws \yii\di\NotInstantiableException
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex(string $id): Response
    {
        $id = trim($id);

        $originUrl = null;
        if ('' !== $id) {
            $originUrl = \Yii::$container->get(FindOriginUrlById::class)->execute($id);
        }
        if (null === $originUrl) {
            return $this->redirect('', 404);
        }

        \Yii::$container->get(IncTransition::class)->execute($id);

        return $this->redirect($originUrl, 307);
    }
}
