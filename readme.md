# Laravel Software Install Script Template/Process

Many developers find it kinda confusing at first on how to go about creating install scripts for clients or users of open source projects. This is a simple template/step-by-step process to help you accomplish that. You can fork, contribute to it or just copy the template/process into your app and improve on it based on your specific need.

It has to do with creating a custom artisan command. If you are not sure how to go about that, please check this comprehensive [blog post](http://goodheads.io/2015/12/18/how-to-create-a-custom-artisan-command-in-laravel-5/)

## Stey by Step Process

1. Open your Terminal and Run the command:

```bash
    php artisan make:console Install
```

This creates a file called `Install.php` in the `app/Console/Commands` directory.

2. Open the file `Install.php` and dump this:

```php
<?php

namespace App\Console\Commands;

use DB;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'software:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install this software without issues, Thanks!';

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

        try {
            DB::connection();
        } catch (Exception $e) {
            $this->error('Unable to connect to database.');
            $this->error('Please fill valid database credentials into .env and rerun this command.');
            return;
        }

        $this->comment('Attempting to install Software - 1.0.0');

        if (! env('APP_KEY')) {
            $this->info('Generating app key');
            Artisan::call('key:generate');
        } else {
            $this->comment('App key exists -- skipping...');
        }

        $this->info('Migrating database...');

        Artisan::call('migrate', ['--force' => true]);

        $this->comment('Database Migrated Successfully...');

        $this->info('Seeding DB data...');

        Artisan::call('db:seed', ['--force' => true]);

        $this->comment('Database Seeded Successfully...');
        $this->comment('Successfully Installed! You can now run the software');
    }
}
```

By adding this, a user can now run `php artisan software:install` from the terminal.

The code goes from:

- ensuring the user has a database on standby with valid database credentials
- to generating app key
- to Migrating the database scripts ( migration files)
- to seeding the database with data ( ensure you have the seeder classes all set up, an example is in this repo)

This process captures the basic install process every user usually goes through in just one script, you can definitely add/improve on it.

## Example User Install Instruction to be given by Developer

- Clone the repo e.g git clone https://github.com/unicodeveloper/laravel-software-install
- Run Composer Install
- Fill the right database credentials in the .env file
- Run `php artisan software:install`
