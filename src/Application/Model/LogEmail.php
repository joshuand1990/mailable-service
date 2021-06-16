<?php


namespace Domain\Application\Model;


use Database\Factories\LogEmailFactory;
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
}