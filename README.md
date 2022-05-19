# ClashOfClans Wrapper In PHP



[![Discord](https://discordapp.com/api/guilds/870241007395041280/embed.png)](https://discord.gg/Z6REfNgc)


This is a wrapper for SuperCell's official Clash Of Clans-API located at https://developer.clashofclans.com/#/  and best to use with Discord PHP Wrapper for interaction with Clash API.

You have to create an account on their website and provide credential in the script. The script will auto create an key.


Key Features
-------------
- Trying to cover everything of ClashOfClans API.
- Email/password login removes the stress of managing tokens
- Optimised for speed, memory and performance



## Requirements
**PHP 7 or higher with cURL support.**

Getting Started
================

### Login 

```php
$start = new ClashAPILogin();
$login = $start->login("youremail@gmail.com","yourpass");
echo $login; // this will return the api key generated 
```

### GEt Clan By Name

```php
$api = new ClashOfClans();
$results = $api->searchClanByName("The Order"); //returns an array containing all search results
$clan = new CoC_Clan($results->items[0]); //gets the first result from the array
```

### Get Clan Details
```php
$clan = new CoC_Clan("#2PP"); 
$clan->getName(); //returns clan name
$clan->getLevel(); //returns level of clan
```


### Quick Example to interact with Discord API
```php
<?php
require_once "./API/API.class.php";
require_once "./API/Login.class.php";
include __DIR__.'/vendor/autoload.php';
use Discord\Discord;
use Discord\Parts\Channel\Message;
use Psr\Http\Message\ResponseInterface;
use React\EventLoop\Factory;
use React\Http\Browser;
$discord = new Discord([
    'token' => 'token',
]);
$discord->on('ready', function ($discord) {
    echo "Bot is ready!", PHP_EOL;
	$start = new ClashAPILogin();
	//$login = $start->login($dev_email,$dev_password);
	$login = $start->login("",""); //insert your credentials


    // Listen for messages.
	$discord->on('message', function (Message $message, Discord $discord) {
		if($message->content == 'clan' && ! $message->author->bot){
			$foxforce = new CoC_Clan("#2PP");
			$message->reply($foxforce->getName());
		}
		
	});
});
$discord->run();
?>
```



Contributing
--------------
Contributing is fantastic and much welcomed! If you have an issue, feel free to open an issue and start working on it.


Reach me on discord my username is Shavy#0504


Links
------
- [Official Clash of Clans API Page](https://developer.clashofclans.com/)
- [Contact Me Discord Server](https://discord.gg/Z6REfNgc)

Disclaimer
-----------
This content is not affiliated with, endorsed, sponsored, or specifically
approved by Supercell and Supercell is not responsible for it.
For more information see [Supercell's Fan Content Policy.](https://www.supercell.com/fan-content-policy)
