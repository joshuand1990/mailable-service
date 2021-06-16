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

    protected static function newFactory()
    {
        return LogEmailFactory::new();
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