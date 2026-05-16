<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Contact form recipient
    |--------------------------------------------------------------------------
    |
    | Email address that receives portfolio contact form submissions.
    | Falls back to the first admin user, then MAIL_FROM_ADDRESS.
    |
    */

    'contact_to' => env('CONTACT_TO_ADDRESS'),

];
