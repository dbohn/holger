# Holger Lib

[![StyleCI](https://styleci.io/repos/53442008/shield)](https://styleci.io/repos/53442008)

This library is a tool to interact with routers that support the TR-064 standard.
It is mainly tested with a Fritz!Box 7360 by AVM.

## Why?
Using SOAP APIs is a real pain. There are a lot of obscure URNs, strange XML description files and a lot of XML responses.
 Although PHP provides a quite good SOAPClient class, it is still nearly impossible to see the intent of the code.

 This library aims to provide a friendly interface to the API.

## Installation

The library can be installed via composer. Run the following command:

```
composer require davidbohn/holger
```

## Usage

Instantiate the Holger\Holger class by passing the host name and, if necessary, a username and password, that can be used to authenticated against the router interface.
Then you can query the different endpoints like this:

```php
<?php

require_once "vendor/autoload.php";

$credentials = [
    'username' => 'user',
    'password' => 'password'
];

if (file_exists('config.php')) {
    $loadedCredentials = include 'config.php';

    $credentials = array_merge($credentials, $loadedCredentials);
}

$holger = new Holger\Holger('192.168.178.1', $credentials['password'], $credentials['username']);

var_dump($holger->ip->externalIP());

var_dump($holger->ip->externalIPv6());
var_dump($holger->ip->getIPv6Prefix());
var_dump($holger->ip->status());

```

## Contributing

1. Fork it!
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin my-new-feature`
5. Submit a pull request!

## History

### 0.8
Add powerline module to fetch the power consumption, which is measured by a powerline adapter, that has a outlet.

### 0.6
Add fetching of mesh list and add call feature using call assistance.

### 0.5
New API structure, that uses central Holger class to access all modules. Breaking changes!
Thanks to [sbreiler](https://github.com/sbreiler) for the addition of the WANMonitor module.

### 0.3
Retrieval of answering machine messages from Fritz!Box routers was added.

### 0.2
This release adds some new endpoints and also introduces new features for the phonebook.

### 0.1
Initial version, that is in no way feature complete but shows how stuff could work.
Currently basic reading of the phonebook, info about DECT handsets, resolving of substation ids (given by call monitor).

## Credits

This library is currently mainly developed by [David Bohn](https://david-bohn.de).

Contributions are highly welcome!

## License

The MIT License (MIT)

Copyright (c) 2016 David Bohn

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
