<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrderCreated implements ShouldQueue {

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

    public function __construct($row) {
        $this->row = $row;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        if (app()->environment() != 'testing' && !app()->runningInConsole()) {
            if ($row = $this->row) {
                if ($row->creator->email) {
                    try {
                        $subject = trans('email.New order created') . ' #' . $row->id.', '.trans('app.Status').':'.$row->status . " - " . appName();
                        $body = trans('app.Order Number') . ': #' . $row->id . ', ' . trans('app.Total') . ':' . $row->total . ' ' . $row->currency->title.', '.trans('app.Status').':'.$row->status;
                        /////////////// Send email to the order creator
                        \Mail::send('emails.orders.created', ['row' => $row], function ($mail) use ($row, $subject) {
                            $mail->to($row->creator->email, $row->creator->name)
                                    ->subject($subject);
                        });
                        //////////////////////////////////
                        ////////////////// Send push to order creator
                        \App\Jobs\SendPushNotification::dispatch($row->created_by, $subject, $body, ['id' => $row->id, 'type' => 'orders']);
                        /////////////////
                        /// Send email to administration
                        \Mail::send('emails.orders.created', ['row' => $row], function ($mail) use ($row, $subject) {
                            $mail->to(env('ORDER_CREATED_EMAIL'), appName() . ' Administration')
                                    ->subject($subject);
                        });
                        /////////////////////////////////////

                    } catch (\Exception $e) {
                        \Log::error('Error: ' . $e->getMessage() . ', File: ' . $e->getFile() . ', Line:' . $e->getLine() . PHP_EOL);
                    }
                }
            }
        }
    }

}
