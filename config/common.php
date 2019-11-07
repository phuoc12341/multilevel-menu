<?php

return [
    'item_per_page' => '15',
    'menu' => [
        'type' => [
            'post' => '0',
            'page' => '1',
        ]
    ],
    'import' => [
        'column' => [
            'id' => 'id',
            'katakana_first_name' => 'katakana_first_name',
            'katakana_last_name' => 'katakana_last_name',
            'kanji_first_name' => 'kanji_first_name',
            'kanji_last_name' => 'kanji_last_name',
            'age' => 'age',
            'unit_id' => 'unit_id',
        ],
        'line_max_length' => 1000,
        'batch_size' => 500,
        'path' => 'import_csv',
        'validation' => [
            'name' => [
                'max' => 25,
            ],
            'age' => [
                'min' => 0,
                'max' => 60,
            ],
            'file' => [
                'header' => [
                    'id' => 'import.header_text.id',
                    'katakana_first_name' => 'import.header_text.katakana_first_name',
                    'katakana_last_name' => 'import.header_text.katakana_last_name',
                    'kanji_first_name' => 'import.header_text.kanji_first_name',
                    'kanji_last_name' => 'import.header_text.kanji_last_name',
                    'age' => 'import.header_text.age',
                    'unit_id' => 'import.header_text.unit_id',
                ],
                'type' => ['csv','tsv','xls','xlsx'],
                'max' => 4096,
            ],
        ],
    ],
    'export' => [
        'file_name' => 'Export-%s',
        'types' => [
            'xlsx' => [
                'label' => 'export.file_type.excel',
                'value' => 'xlsx',
                'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                ],
            'csv' => [
                'label' => 'export.file_type.csv',
                'value' => 'csv',
                'mime' => 'text/csv',
                'separation' => [
                    'tab' => [
                        'label' => 'export.separate_char.tab',
                        'value' => '\t',
                    ],
                    'comma' => [
                        'label' => 'export.separate_char.comma',
                        'value' => ',',
                    ],
                    'semi_colon' => [
                        'label' => 'export.separate_char.semi_colon',
                        'value' => ';',
                    ],
                ],
            ],
        ],
        'export_column' => [
            'id' => 'export.header_export.id',
            'katakana_first_name' => 'export.header_export.katakana_first_name',
            'katakana_last_name' => 'export.header_export.katakana_last_name',
            'kanji_first_name' => 'export.header_export.kanji_first_name',
            'kanji_last_name' => 'export.header_export.kanji_last_name',
        ],
        'encoding' => [
            'utf8' => 'UTF-8',
            'shiftjis' => 'Shift-JIS',
            'eucjp' => 'EUC-JP',
        ],
    ],
];
