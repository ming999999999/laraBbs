<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CalculateActiveUser extends Command
{
    // 供我们调用令
    protected $signature = 'larabbs:calculate-active-user';

    // 命令描述
    protected $description = '生成活跃用户';

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
   *  最终的执行方法
   */
    public function handle(User $user)
    {
        //在命令行打印一行信息
        $this->info('开始计算.....');

        $user->calculateAndCacheActiveUsers();

        $this->info('生成成功!');
    }
}
