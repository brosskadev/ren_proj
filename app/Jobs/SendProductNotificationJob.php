<?php

namespace App\Jobs;

use App\Models\Product;
use App\Notifications\ProductCreatedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendProductNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Product $product;
    private string $email;

    /**
     * Create a new job instance.
     */
    public function __construct(Product $product, string $userEmail)
    {
        $this->product = $product;
        $this->email = $userEmail;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Notification::route('mail', $this->email)->notify(new ProductCreatedNotification($this->product));
    }
}
