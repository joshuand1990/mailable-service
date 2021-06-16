<?php


namespace Domain\Support\Logging;

use Illuminate\Support\Facades\DB;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class MySqlLogHandler extends  AbstractProcessingHandler
{
    protected $table;
    /**
     * MySqlLogHandler constructor.
     * @param int $level
     * @param bool $bubble
     */
    public function __construct(int $level = Logger::ERROR, bool $bubble = true)
    {
        $this->table = 'logerror';
        parent::__construct($level, $bubble);
    }

    /**
     * Writes the record down to the log of the implementing handler
     *
     * @param  array $record
     * @return void
     */
    protected function write(array $record) : void
    {
        $class = isset($record['context']['exception']) ? get_class($record['context']['exception']) : "UnknownClass ?404? ";
        $data = [
            'instance'    => gethostname(),
            'message'     => sprintf('%s : %s', $class, $record['message']),
            'channel'     => $record['channel'],
            'level'       => $record['level'],
            'level_name'  => $record['level_name'],
            'context'     => json_encode([ $record['context'], $record['formatted'] ]),
            'remote_addr' => isset($_SERVER['REMOTE_ADDR']) ? ip2long($_SERVER['REMOTE_ADDR']) : null,
            'user_agent'  => $_SERVER['HTTP_USER_AGENT'] ?? null,
            'created_by'  => optional(auth())->id(),
            'created_at'  => $record['datetime']->format('Y-m-d H:i:s')
        ];

        DB::table($this->table)->insert($data);
    }
}