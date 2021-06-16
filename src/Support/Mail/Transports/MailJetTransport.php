<?php


namespace Domain\Support\Mail\Transports;


use Domain\Support\Mail\Messageable;
use Exception;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use Illuminate\Http\Response;
use InvalidArgumentException;

class MailJetTransport extends ApiBasedTransport
{
    protected array $config = [];
    const VERSION = 'v3.1';
    /**
     * MailJetTransport constructor.
     */
    public function __construct(string $url = null, string $apiKey = null, string $secretKey = null, array $config = [])
    {
        $this->config = $config;
        $this->config['base_uri'] = $url ?? 'https://api.mailjet.com/';
        if(is_null($apiKey) or is_null($secretKey)) {
            throw new InvalidArgumentException("Public / Private Key not set.");
        }
        $this->config['apiKey'] = $apiKey;
        $this->config['secretKey'] = $secretKey;
        parent::__construct($this->config);
    }

    public function getBaseUrl()
    {
        return $this->config['base_uri'];
    }

    public function submit(Messageable $message)
    {
        try {
            $response = $this->emailClient($message);
            if ($response->getStatusCode() == Response::HTTP_OK) {
                return true;
            }
            throw new TransferException($response->getStatusCode());
        } catch (TransferException $e){
            throw $e;
        }

    }

    public function formatMessage(Messageable $message) : array
    {
        $to = [];
        foreach ($message->getTo() as $email => $name) {
            $to[] = [ "Email" => $email, 'Name' => $name ];
        }
        return  [
            'Messages' => [
                [
                    'From' => [ 'Email' => $message->getFromEmail(),  'Name' => $message->getFromName() ],
                    'To' => $to,
                    'Subject' => $message->getSubject(),
                    'TextPart' => $message->getBody()
                ]
            ]
        ];
    }

    protected function emailClient(Messageable $message)
    {
        return $this->request('POST', self::VERSION.'/send', [
            'header' => ['Content-Type' => 'application/json'],
            'json' => $this->formatMessage($message),
            'auth' => [ $this->config['apiKey'], $this->config['secretKey'] ] ]);

    }
}