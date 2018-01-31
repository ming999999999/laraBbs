<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Monolog\Logger;
use Monolog\Handle\StreamHandler;


class planTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larabbs:plantest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '计划任务测试';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //在命令行打印一行信息
        $this->info('开始计算...');

        $log = new Logger('name');

        $log->pushHandler(new StreamHandler('path/to/your.log',Logger::WARNING));


        // add records to the log
        $log->waring('Foo');
        $log->error('Bar');
        
        $this->info('成功生成');
    }
}
