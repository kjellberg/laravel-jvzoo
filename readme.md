# JVZoo IPN for Laravel 5

## Installation
#### 1. Include laravel-jvzoo as a dependency in composer.json:
	
	$ composer require kjellberg/laravel-jvzoo

#### 2. Add the ServiceProvider to your provider array within `config/app.php` 

	'providers' => [
		...
		Kjellberg\Jvzoo\JvzooServiceProvider::class,
		...
	]

#### 3. Add your *JVZoo API secret* key to `.env`

	JVZOO_KEY=*************

## Usage

#### Listen to JVZoo events by adding event listeners to `routes.php`

	Event::listen('jvzoo', function( $data ) { /* INSERT CODE HERE */ });
	Event::listen('jvzoo.sale', function( $data ) { /* INSERT CODE HERE */ });
	Event::listen('jvzoo.bill', function( $data ) { /* INSERT CODE HERE */ });
	Event::listen('jvzoo.rfnd', function( $data ) { /* INSERT CODE HERE */ });
	Event::listen('jvzoo.cgbk', function( $data ) { /* INSERT CODE HERE */ });
	Event::listen('jvzoo.insf', function( $data ) { /* INSERT CODE HERE */ });
	Event::listen('jvzoo.cancel.rebill', function( $data ) { /* INSERT CODE HERE */ });
	Event::listen('jvzoo.uncancel.rebill', function( $data ) { /* INSERT CODE HERE */ });


## Example 

	Event::listen('jvzoo.sale', function( $data ) { 

		$password = str_random(12);
	
		User::create([
	        'name' => $data['ccustname'],
	        'email' => $data['ccustemail'],
	        'password' => bcrypt($password),
	    ]);
	
	});
	
	Event::listen('jvzoo.cancel.rebill', function( $data ) { 
	
		if ($user = \App\User::where('email', '=', $data['ccustemail'])->first())
			$user->delete();

	});

That's it! 

**Happy selling!**
