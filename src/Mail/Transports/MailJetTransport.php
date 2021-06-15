<?php


namespace Domain\Mail\Transports;


use Domain\Mail\Messageable;

class MailJetTransport extends ApiBasedTransport
{

    /**
     * MailJetBasedTransport constructor.
     */
    public function __construct($config)
    {
        $config['base_uri'];
        parent::__construct([ 'base_uri' => $this->getBaseUrl() ]);
    }


    public function submit(Messageable $message)
    {
        // TODO: Implement submit() method.
    }
}