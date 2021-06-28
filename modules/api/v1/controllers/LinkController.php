<?php

namespace app\modules\api\v1\controllers;

use Core\ShortUrl\Actions\Add;
use Core\ShortUrl\Actions\Find;
use Core\ShortUrl\Actions\FindId;
use yii\helpers\Url;
use yii\web\Controller;

class LinkController extends Controller
{
    /**
     * @throws \JsonException
     * @throws \Throwable
     */
    public function actionCreate(): string
    {
        $args = \Yii::$app->request->post();

        $originalUrl = $args['original_url'] ?? '';
        $originalUrl = trim((string)$originalUrl);

        // Заменить на валидатор.
        if ('' === $originalUrl) {
            return \json_encode(
                (object)[
                    'error' => 'Необходимо указать оригинальные URL-адрес.'
                ],
                JSON_THROW_ON_ERROR
            );
        }

        $id = \Yii::$container->get(FindId::class)->execute($originalUrl);

        if (null === $id) {
            $id = \Yii::$container->get(Add::class)->execute($originalUrl);
        }

        $shortUrlValue = Url::base(true) . '/r/' . $id;

        return \json_encode(
            (object)[
                'shor_url' => $shortUrlValue
            ],
            JSON_THROW_ON_ERROR
        );
    }

    /**
     * @throws \JsonException
     * @throws \Exception
     */
    public function actionGet(string $id): string
    {
        $id = trim($id);

        // Заменить на валидатор.
        if ('' === $id) {
            return \json_encode(
                (object)[
                    'error' => 'Необходимо указать ID.'
                ],
                JSON_THROW_ON_ERROR
            );
        }

        $shortUrl = \Yii::$container->get(Find::class)->execute($id);

        if (null === $id) {
            return \json_encode(
                (object)[
                    'error' => sprintf('Неизвестный ID "%s"', $id),
                ],
                JSON_THROW_ON_ERROR
            );
        }

        return \json_encode(
            (object)[
                'id' => $shortUrl->id,
                'number_of_transitions' => $shortUrl->numberOfTransitions,
            ],
            JSON_THROW_ON_ERROR
        );
    }
}
