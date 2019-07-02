<?php

namespace Looxis\Laravel\APC;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Looxis\Laravel\APC\Exceptions\APCException;

class APC
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $apcTemplateKey
     * @param string $orderItemId
     * @param string $zipUrl
     * @return array|null
     * @throws APCException
     */
    public function create(string $apcTemplateKey, string $orderItemId, string $zipUrl) :?array
    {
        if (empty($apcTemplateKey)) {
            throw new APCException("Empty APC Template Key");
        }
        $content = [
            "template_key" => $apcTemplateKey,
            "order_id" => $orderItemId,
            "configurations" => [
                0 => [
                    "zip_url" => $zipUrl,
                    "template_configuration_order" => 0
                ]
            ]
        ];


        try {
            $response = $this->client->request("POST", "api/amazon-customizations", [
                "json" => $content,
                "http_errors" => false
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $exception) {
            throw new APCException($exception->getMessage());
        }

        if(empty($result)) {
            throw new APCException("Empty Response");
        }

        if (!empty($result) && !empty($result["message"]) && !empty($result["key"]) && !empty($result["preview"])) {
            return $result;
        }

        $error = "Something went wrong";

        if (!empty($result["errors"])) {
            if(is_string($result["errors"]))
            $error = $result["errors"];
        }

        throw new APCException($error);

    }
}
