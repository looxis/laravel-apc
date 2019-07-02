<?php

/*
 * APC Credentials
 */
return [
    //APC Bearer Token
    "key"       => env("APC_API_KEY"),
    //APC site base uri
    "base_uri"  => env("APC_BASE_URI", "https://configurator.loc")
];