<?php


namespace Domain\Mail\Transports;


use Domain\Mail\Messageable;
use InvalidArgumentException;

class MailJetTransport extends ApiBasedTransport
{
    protected array $config = [];


    /**
     * MailJetTransport constructor.
     */
    public function __construct(string $url = null, string $publicKey = null, string $privateKey = null, array $config = [])
    {
        $this->config = $config;
        $this->config['base_uri'] = $url ?? 'https://api.mailjet.com/v3.1';
        if(is_null($publicKey) or is_null($privateKey)) {
            throw new InvalidArgumentException("Public / Private Key not set.");
        }
        $this->config['publicKey'] = $publicKey;
        $this->config['privateKey'] = $privateKey;
        parent::__construct($this->config);
    }

    public function getBaseUrl()
    {
        return $this->config['base_uri'];
    }


    public function submit(Messageable $message)
    {
        // TODO: Implement submit() method.
    }
}