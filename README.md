# WordPress with React app running in theme

This is example of two ways how you can include and run React app in WordPress.

If you don't want to use WordPress REST API and then read JSON in React, there are still some simple options how to get data from WordPress to React.

## Installation

Copy theme file to folder 

``
{root_folder}/wp-content/themes/
``

## 1. way without building the app (using BABEL)

Edit your app in 
``
{root_folder}/wp-content/themes/twentynineteen/js/my-react-app.js
``

Include js file and pass data to react js in theme file ``
{root_folder}/wp-content/themes/twentynineteen/template-parts/content/content-page.php
`` like this:

```
// Register the script
wp_register_script( 'my-react-app', get_stylesheet_directory_uri() . '/js/my-react-app.js' );

// Localize the script with new data
$data_array = array(
	'yourName' => 'Radek',
	'yourWebsite' => 'http://www.mezulanik.cz',
);
//Pass data to Javascript
wp_localize_script( 'my-react-app', 'personData', $data_array );

// Enqueued script with localized data.
wp_enqueue_script( 'my-react-app' );
```

Then in `content-page.php` create app root container `<div id="myApp"></div>` so the app will run inside.

In React app you will be able to access variable personData easily

```
constructor(props) {
    super(props);
    this.state = personData;
}
```

We're not building this app and JS file will stay uncompiled. To be able to run JSX code in WP, you have to change include type to `babel` in end of the ``functions.php`` file:
```
add_filter('style_loader_tag', 'javascript_to_babel', 10, 2);
add_filter('script_loader_tag', 'javascript_to_babel', 10, 2);
function javascript_to_babel($tag, $handle) {
		return str_replace( "<script type='text/javascript'", "<script type='text/babel'", $tag );
}
```

## 2. way with standalone app included into WP

Edit your classic React app in 
``
{root_folder}/wp-content/themes/twentynineteen/myReactApp/
``
and build it using 
```
yarn build
```

Go to end of the ``functions.php`` and include all JS and CSS files to WordPress:
```
add_action( 'wp_enqueue_scripts', 'enqueue_my_react_app' );
function enqueue_my_react_app(){
	foreach( glob( get_template_directory(). '/myReactApp/build/static/js/*.js' ) as $file ) {
		// $file contains the name and extension of the file
		$filename = substr($file, strrpos($file, '/') + 1);
		wp_enqueue_script( $filename, get_template_directory_uri().'/myReactApp/build/static/js/'.$filename);
	}
	foreach( glob( get_template_directory(). '/myReactApp/build/static/css/*.css' ) as $file ) {
		// $file contains the name and extension of the file
		$filename = substr($file, strrpos($file, '/') + 1);
		wp_enqueue_style( $filename, get_template_directory_uri().'/myReactApp/build/static/css/'.$filename);
	}
}
```

Then in `content-page.php` create app root container `<div id="root"></div>` so the app will run inside.

You can pass data from PHP to React by inserting script into this theme file:
```
<script>
    window.reactInit = {
			scriptData: "<?php echo get_template_directory_uri().'/myReactApp/'; ?>"
		};
</script>
```

In React app you will be able to access variable scriptData like this

```
<img src={window.reactInit.scriptData+'public/media/logo.svg'} className="App-logo" alt="logo" />
```

I'm using a public folder for logo here, because relative path to the logo is different in WP than in React, so you can pass custom path as parameter.

## FAQ
If you know about some better way how to do this, feel free to let me know on 
[www.mezulanik.cz](http://mezulanik.cz).