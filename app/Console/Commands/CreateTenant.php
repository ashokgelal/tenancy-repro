<?php

namespace App\Console\Commands;

use App\User;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Models\Customer;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use Illuminate\Console\Command;

class CreateTenant extends Command
{
    protected $signature = 'tenant:create {name}';

    protected $description = 'Create a tenant with the provided name';

    public function handle()
    {
        $name = $this->argument('name');
        $email = $name . '@example.com';

        // create a customer
        $customer = new Customer;
        $customer->name = $name;
        $customer->email = $email;
        $customer->save();

        // associate the customer with a website
        $website = new Website;
        $website->customer()->associate($customer);
        app(WebsiteRepository::class)->create($website);

        // associate the website with a hostname
        $hostname = new Hostname;
        $hostname->fqdn = "{$name}.example.com";
        $hostname->customer()->associate($customer);
        app(HostnameRepository::class)->attach($hostname, $website);

        // create a dummy user
        User::create(['name' => $name, 'email' => $email, 'password' => bcrypt('secret')]);
    }
}
