<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrderStatusChanged implements ShouldQueue {

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
                        $subject = trans('email.Your order') . ' #' . $row->id.', '.trans('app.Status').':'.$row->status . " - " . appName();
                        \Mail::send('emails.orders.created', ['row' => $row], function ($mail) use ($row, $subject) {
                            $mail->to($row->creator->email, $row->creator->name)
                                    ->subject($subject);
                        });
                        $body = trans('app.Order Number') . ': #' . $row->id . ', ' . trans('app.Total') . ':' . $row->total . ' ' . $row->currency->title.', '.trans('app.Status').':'.$row->status;
                        \App\Jobs\SendPushNotification::dispatch($row->created_by, $subject, $body, ['id' => $row->id, 'type' => 'orders']);
                    } catch (\Exception $e) {
                        \Log::error('Error: ' . $e->getMessage() . ', File: ' . $e->getFile() . ', Line:' . $e->getLine() . PHP_EOL);
                    }
                }
            }
        }
    }

}
