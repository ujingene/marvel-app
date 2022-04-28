<?php

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Importer;
use Maatwebsite\Excel\Concerns\Importable;

test('can import csv invoice', function () {
    $import = new class implements ToArray
        {
            use Importable;

            /**
             * @param  array  $array
             */
            public function array(array $array)
            {
                $this->assertEquals([
                    [
                        '536365','71053','WHITE METAL LANTERN','6','12/01/2010 08:26','3.39','17850','United Kingdom'
                    ],
                    [
                        '536365','71053','WHITE METAL LANTERN','6','12/01/2010 08:26','3.39','17850','United Kingdom'
                    ],
                ], $array);
            }
        };

        $imported = $import->import('import.csv');

        $this->assertInstanceOf(Importer::class, $imported);
});
