<?php


namespace Domain\Support\Mail\Transports;


use Domain\Support\Mail\Messageable;
use Exception;
use InvalidArgumentException;

class SendGridTransport extends ApiBasedTransport
{

    protected array $config;
    const VERSION = 'v3';

    /**
     * SendGridTransport constructor.
     */
    public function __construct(string $apiKey = null, $config = [])
    {
        $this->config = $config;
        $this->config['base_uri'] = 'https://api.sendgrid.com/';
        if(is_null($apiKey)) {
            throw new InvalidArgumentException("Public / Private Key not set.");
        }
        $this->config['apiKey'] = $apiKey;
        parent::__construct($this->config);
    }

    public function submit(Messageable $message)
    {
        try {
            $response = $this->request('POST', self::VERSION . '/mail/send', [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->config['apiKey']),
                    'Content-Type' => 'application/json'
                ],
                'json' => $this->formatMessage($message),
            ]);
        }catch (Exception $e){
            throw $e;
        }

    }

    public function formatMessage(Messageable $message)
    {
        $to = [];
        foreach ($message->getTo() as $email => $name) {
            $to[] = [ "email" => $email, 'name' => $name ];
        }
        return  [
            'personalizations' => [ [ 'to' => $to,  'subject' => $message->getSubject() ] ],
            'from' => [ 'email' => $message->getFromEmail(), 'name' => $message->getFromName() ],
            'reply_to' => [ 'email' => $message->getFromEmail(), 'name' => $message->getFromName() ],
            'content' => [ ['type' => 'text/plain', 'value' => $message->getBody() ] ]
        ];
    }
}