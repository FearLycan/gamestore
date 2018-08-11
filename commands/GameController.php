<?php

namespace app\commands;

use app\models\Game;
use app\models\Platform;
use app\models\Region;
use yii\base\Exception;
use yii\console\Controller;
use yii\helpers\VarDumper;
use yii\httpclient\Client;


class GameController extends Controller
{
    public function actionSynchronization()
    {
        $envDomain = 'sandboxapi.g2a.com'; // for production, domain will be different
        $g2aEmail = 'sandboxapitest@g2a.com'; // customer email
        $apiHash = 'qdaiciDiyMaTjxMt'; // customer API hash
        $apiSecret = 'b0d293f6-e1d2-4629-8264-fd63b5af3207b0d293f6-e1d2-4629-8264-fd63b5af3207'; // customer API secret

        $apiKey = hash('sha256', $apiHash . $g2aEmail . $apiSecret);
        $apiKey = '74026b3dc2c6db6a30a73e71cdb138b1e1b5eb7a97ced46689e2d28db1050875';

        $productsApiUrl = 'https://' . $envDomain . '/v1/products';

        $authorization = $apiHash . ', ' . $apiKey;

        $client = new Client();

        $page = 1;

        do {
            echo "Page: " . $page . "\n";

            $response = $client->createRequest()
                ->setMethod('GET')
                ->setUrl($productsApiUrl)
                ->addHeaders(['Authorization' => $authorization, 'content-type' => 'application/json'])
                ->setData(['page' => $page])
                ->send();

            if ($response->isOk) {
                $totalPages = $response->data['total'];

                foreach ($response->data['docs'] as $g2a) {
                    $game = Game::find()->where(['g2a_id' => $g2a['id']])->one();

                    if (empty($game)) {
                        //nowa gra
                        $game = new Game();
                    }

                    $game->g2a_id = $g2a['id'];
                    $game->name = $g2a['name'];

                    if ($g2a['type'] === 'key') {
                        $game->type = Game::TYPE_KEY;
                    } else {
                        $game->type = Game::TYPE_OTHER;
                    }

                    $game->slug = $g2a['slug'];
                    $game->qty = $g2a['qty'];
                    $game->min_price = $g2a['minPrice'];
                    $game->price = $g2a['minPrice'];
                    $game->thumbnail = $g2a['thumbnail'];
                    $game->smallImage = $g2a['smallImage'];
                    $game->description = $g2a['description'];
                    $game->region_id = Region::check($g2a['region']);
                    $game->developer = $g2a['developer'];
                    $game->publisher = $g2a['publisher'];
                    $game->platform_id = Platform::check($g2a['platform']);
                    $game->restrictions = json_encode($g2a['restrictions']);
                    $game->requirements = json_encode($g2a['requirements']);
                    $game->videos = json_encode($g2a['videos']);
                    $game->status = Game::STATUS_ACTIVE;

                    $game->save();

                    if ($game->errors) {
                        throw new Exception(
                            "Failed save gameID: " . $g2a['id'] . " \n"
                            . VarDumper::dumpAsString($game->errors)
                        );
                    }

                    unset($game);
                }

            } else {
                throw new Exception(
                    "Request to $response->url failed with response: \n"
                    . VarDumper::dumpAsString($response->data)
                );
            }

            $page++;
        } while ($page <= $totalPages);
    }
}