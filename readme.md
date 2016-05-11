# JVZoo IPN for Laravel 5

## Installation
Include laravel-jvzoo as a dependency in composer.json:
	"kjellberg/laravel-stripe": "dev-master"

run `composer install` to download the dependency. 

Add the ServiceProvider to your provider array within `config/app.php` 

	'providers' => [
		...
		Kjellberg\Jvzoo\JvzooServiceProvider::class,
		...
	]

Add your *JVZoo API secret* key to `.env`
	JVZOO_KEY=*************

Listen to JVZoo events by adding event listeners to `routes.php`

	Event::listen('jvzoo', function( $data ) { /* INSERT CODE HERE */ });
	Event::listen('jvzoo.sale', function( $data ) { /* INSERT CODE HERE */ });
	Event::listen('jvzoo.bill', function( $data ) { /* INSERT CODE HERE */ });
	Event::listen('jvzoo.rfnd', function( $data ) { /* INSERT CODE HERE */ });
	Event::listen('jvzoo.cgbk', function( $data ) { /* INSERT CODE HERE */ });
	Event::listen('jvzoo.insf', function( $data ) { /* INSERT CODE HERE */ });
	Event::listen('jvzoo.cancel.rebill', function( $data ) { /* INSERT CODE HERE */ });
	Event::listen('jvzoo.uncancel.rebill', function( $data ) { /* INSERT CODE HERE */ });

That's it! 

Happy selling!