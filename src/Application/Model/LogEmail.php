<?php


namespace Domain\Application\Model;


use Database\Factories\LogEmailFactory;
use Domain\Support\Mail\Message;
use Domain\Support\Mail\Messageable;
use Domain\Support\Mail\ShouldBeMessageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class LogEmail extends Model implements ShouldBeMessageable
{
    use HasFactory;
    protected $table = 'logemail';
    protected $guarded = [];
    const QUEUED = 1;
    const SENDING = 2;
    const SENT = 3;
    const ERROR = 9;
    protected $appends = [ 'status_name' ];

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

    public function toMessage() : Messageable
    {
        $message = new Message;
        $message->to($this->name, $this->email);
        $message->body($this->body);
        $message->subject($this->subject);
        $message->id($this->id);
        return $message;
    }

    public function getStatusNameAttribute()
    {
        return Arr::get([
            self::QUEUED => 'Queued', self::SENDING => 'Sending',
            self::SENT => 'Sent', self::ERROR => 'Error'
        ], $this->status, 'N/A');
    }

    public function getCssAttribute()
    {
        return 'text-' . strtolower(Arr::get([
            self::QUEUED => 'Queued bx bxs-add-to-queue',
            self::SENDING => 'Sending bx bx-mail-send',
            self::SENT => 'Sent bx bxs-navigation',
            self::ERROR => 'Error bx bxs-error'
        ], $this->status, 'NA bx bxs-error-alt'));
    }
}