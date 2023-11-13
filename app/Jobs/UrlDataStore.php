<?php

namespace App\Jobs;

use App\Models\Domain;
use App\Models\Url;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UrlDataStore implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->data as $item) {
            $host = $item['host'];
            $url = $item['url'];
            $existingDomain = Domain::query()->where('name', '=', $host)->first();
            if (!empty($existingDomain)) {
                $domainID = $existingDomain->id;
            } else {
                $newDomain = new Domain();
                $newDomain->name = $host;
                $newDomain->save();
                $domainID = $newDomain->id;
            }
            $newUrls = new Url();
            $newUrls->domain_id = $domainID;
            $newUrls->url = $url;
            $newUrls->save();
        }
    }
}
