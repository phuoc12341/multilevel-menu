<?php

return [
    'message' => [
        'file_required' => 'The import file is required !',
        'file_mimes' => 'The import file must be a file of type :format',
        'file_max' => 'The import file may not be greater than :max Kb.',
        'success' => 'Data imported successfully !',
        'error_row_name' => 'Data is invalid at row :row, column :column',
        'error_header' => 'The import file header is missing or invalid',
        'error_element' => 'Not enough fields at row :row',
        'error_age' => 'Age must be number and greater than 0 and less than 150 at row :row, column :column',
        'error_unit_id' => 'Unit not exist at row :row, column :column',
    ],
    'header_text' => [
        'id' => 'コード',
        'katakana_first_name' => 'フリガナ・名',
        'katakana_last_name' => 'フリガナ・姓',
        'kanji_first_name' => '名',
        'kanji_last_name' => '姓',
        'age' => '年齢',
        'unit_id' => '単位',
    ],
    'index' => [
        'title' => 'Import File',
        'error_validation' => 'The validation error message',
        'import' => 'Import',
    ],
];
