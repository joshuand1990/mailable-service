<?php


namespace Domain\Application\Model;


use Database\Factories\LogEmailFactory;
use Domain\Support\Mail\Message;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogEmail extends Model
{
    use HasFactory;
    protected $table = 'logemail';
    protected $guarded = [];
    const QUEUED = 1;
    const SENDING = 2;
    const SENT = 3;
    const ERROR = 9;

    protected static function newFactory()
    {
        return LogEmailFactory::new();
    }

    public function setAsSending()
    {
        $this->status = self::SENDING;
        return $this;
    }


    public function setAsSent()
    {
        $this->status = self::SENT;
        return $this;
    }

    public function setAsError()
    {
        $this->status = self::ERROR;
        return $this;
    }
    public function toMessage()
    {
        $message = new Message;
        $message->to($this->name, $this->email);
        $message->body($this->body);
        $message->subject($this->subject);
        $message->id($this->id);
        return $message;
    }
}