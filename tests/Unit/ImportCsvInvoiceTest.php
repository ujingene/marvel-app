<?php

use App\Imports\InvoicesImport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Maatwebsite\Excel\Excel;

uses(CreatesApplication::class);

uses(Tests\TestCase::class, RefreshDatabase::class);

beforeEach()->createApplication();

public function setup(): void
{
    Excel::fake();
}

test('can import csv invoice', function () {
    
    $this->get();

    Excel::assertImported('invoice.csv', 'invoice');
    
    Excel::assertImported('invoice.csv', 'invoice', function(InvoicesImport $import) {
        return true;
    });
    
    Excel::assertImported('invoice.csv', function(InvoicesImport $import) {
        return true;
    });
});
