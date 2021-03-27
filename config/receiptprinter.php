<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Printer connector type
    |--------------------------------------------------------------------------
    |
    | Connection protocol to communicate with the receipt printer.
    | Valid values are: cups, network, windows
    |
    */
    'connector_type' => env('PRINTER_TYPE'),
    /*
    |--------------------------------------------------------------------------
    | Printer connector descriptor
    |--------------------------------------------------------------------------
    |
    | Typically printer name or IP address.
    | on linux /dev/usb/lp1   or windows POS58  
    |
    */
    'connector_descriptor' => env('PRINTER_NAME'),
    /*
    |--------------------------------------------------------------------------
    | Printer port
    |--------------------------------------------------------------------------
    |
    | Typically 9100.
    |
    */
    'connector_port' => 9100,
];