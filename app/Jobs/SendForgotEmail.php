<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendForgotEmail implements ShouldQueue {

    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $row;
    public $password;

    public function __construct($row, $password) {
        $this->row = $row;
        $this->password = $password;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        if (app()->environment() != 'testing' && !app()->runningInConsole()) {
            if ($row = $this->row) {
                try {
                    \Mail::send('emails.users.forgot', ['row' => $row, 'password' => $this->password], function ($mail) use ($row) {
                        $subject = trans('email.Reset password') . " - " . appName();
                        $mail->to($row->email, $row->name)
                                ->subject($subject);
                    });
                } catch (\Exception $e) {
                    \Log::error('Error: ' . $e->getMessage() . ', File: ' . $e->getFile() . ', Line:' . $e->getLine() . PHP_EOL);
                }
            }
        }
    }

}
