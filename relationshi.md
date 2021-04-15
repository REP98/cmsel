# Styles #
## Possible Data ##
```
[
    'slug' => 'mi-style',
    'name' 'Mi Style',
    'css' => '.body{color:#f00}',
    'js' => '$(() => console.log(algo))',
    'show' => -1, // -1 todos lados, 0 solo index (pt-id) id de la seccion especifica a mostrar,
    'level' => -1 // todo el mundo 0 solo usuarios registrados  (pt-id) área especifica, (pt-id-0) área especifica y solo usuarios registrados
    'user' => 0 // id del usuario activo que puede ver estos estilos
    'user_id' => User::class
]
```

## relations ##
```
One  =<  Many
User =<  Styles
```

### Example of use ###
``` php
$u = \App\Models\User::find(1);
$s = new \App\Models\Style ([
    'name' => 'Stylo witch default',
    'css' => '.style{background:#f00; color:var(--color-black);}',
    'js' => '$(() => console.log(\'algo\')',
    'show' => '-1',
    'level' => '-1',
    'user' => '-1'
]);
$u->styles()->save($s);
$u->refresh();
echo "<pre>";
var_dump(\App\Models\Style::with('users')->get());
echo "</pre>";
```


# Settings #
## Possible Data ##
```
[
    'img' => [
        'logo' => '',
        'favicon' => '',
        'body_background' => '', // cualquier dato soportado por la propiedad CSS background-image
        'avatar' => 'img/avatarwithmask.png',
        'preloader' => '',
        'metaIcon' => []
    ],
    'general' => [
        'site_title' => 'artpost',
        'site_description' => 'Otro sistema laravel',

    ],
    'config' => [
        ...
    ],
    'pages' => [
        '{id}' => [
            'type' => '', // tipo de pagina [index,category,post,custom_post_type,archive]
            'condition' => null // condicion para mostrar esta página
        ],
        ...
    ],
    'menu' => [
        'name_menu' => [ //name indica poscion del menu.  footer(n), sidebar(n), header(n)
            'item_name' => [
                'url' => '',
                'level' => -1, // si se muestra a todos los usuario(-1) o a usarios con session activa(0) o solo a un usuario(id)
                'page' => -1, // todas las paginas(-1), solo pagina, entrada, categoria ... especifica (pt-id)
                'order' => 1,
                'submenu' => [
                    'item_name' => [
                        'url' => '',
                        'level' => -1, // si se muestra a todos los usuario(-1) o a usarios con session activa(0) o solo a un usuario(id)
                        'page' => -1, // todas las paginas(-1), solo pagina, entrada, categoria ... especifica (pt-id)
                        'order' => 1,
                        'submenu' => [
                            ...
                        ]
                    ]
                ]
            ]
        ],
        ...
        'dashboard' => [
            'Página'=>[
                'url'=>route('page.index'),
                'level' => 'ap_page read',
                'order' => 1,
                'submenu'=> [
                    'Nueva' => [
                        'url' => route('page.create'),
                        'level' => 'ap_page create'
                    ]
                ]
            ]
        ]
    ],
    'mail' => [
        'to'=>'admin@email.com',
        'from'=>'',
        'password'=>''
        ...
    ],
    'style' => Styles::class
]
```

## relations ##
```
One    =< Many (ONE)
Styles =< Settings
```

### Example of use ###
```php
$u = \App\Models\Style::find(1);
$s = new \App\Models\Setting ([
    'image' => [
        'logo' => '',
        'favicon' => '',
        'body_background' => '', // cualquier dato soportado por la propiedad CSS background-image
        'avatar' => 'img/avatarwithmask.png',
        'preloader' => '',
        'metaIcon' => []
    ],
    'general' => [
        'site_title' => 'artpost',
        'site_description' => 'Otro sistema laravel',
    ],
    'config' => [
        'editor' => 'ckeditor'
    ],
    'pages' => [
        1 => [
            'type' => 'index', // tipo de pagina [index,category,post,custom_post_type,archive]
            'condition' => null // condicion para mostrar esta página
        ],
    ],
    'menu' => [
        'dashboard' => [
            'Página'=>[
                'url'=>route('page.index'),
                'level' => 'ap_page read',
                'order' => 1,
                'submenu'=> [
                    'Nueva' => [
                        'url' => route('page.create'),
                        'level' => 'ap_page create'
                    ]
                ]
            ]
        ]
    ],
    'mail' => [
        'to'=>'admin@email.com',
        'from'=>'',
        'password'=>''
    ],
]);
$u->settings()->save($s);
$u->refresh();
echo "<pre>";
var_dump(\App\Models\Setting::with('styles')->get());
echo "</pre>";
```

# Templates #
## Possible Data ##
```
[
    'name' => 'header1',
    'shotcode' => '[header id="1"]',
    'content' => '<header><a href="/">Name Site</a></header> ,
    'type' => '', // tipo de templante puede ser section, header, footer, widget, slider, component, form
   	'slug',
    'style_id',
    'user_id'
]
```

## relations ##
```
One  =<  Many
User =< Templates
Many  =<  Many
Style <=> Templates
```

### Example of use ###
``` php
// Ususrio Activo
$u = \App\Models\User::find(1);
$s = new \App\Models\Style([
    'name' => 'Stylo for body templaste',
    'css' => '.style{font-size:\'asap\'; color:var(--color-black);}',
    'js' => '$(() => console.log(\'index\')',
    'show' => '0',
    'level' => '-1',
    'user' => '-1'
]);
$u->styles()->save($s);

$t = new \App\Models\Template([
    'name' => 'Tobar 1',
    'shotcode' => '[header]',
    'content' => htmlentities('<header><h1>Hola Mundo</h1></header>'),
    'type' => 'header'
]);
$u->templates()->save($t);

$s->templates()->attach($t->id);

echo "<pre>";
var_dump(\App\Models\Template::All());
echo "</pre>";
```

# Pages #
## Possible Data ##
```
[
    'slug' => 'hola-mundo',
    'title' => 'hola mundo',
    'parent_id'=> -1,
    'description' => [] // SEO,
    'content' => '',
    'style_id' => '',
    'user_id' => ''
]
```

## relations ##
```
One  =<  Many
User =< Pages
Many  =<  Many
Style <=> Pages
```

### Example of use ###
``` php
// Ususrio Activo
$u = \App\Models\User::find(1);
$s = new \App\Models\Style([
    'name' => 'Style from index',
    'css' => '.style{font-size:\'asap\'; color:var(--color-black);}',
    'js' => '$(() => console.log(\'index page\')',
    'show' => '0',
    'level' => '-1',
    'user' => '-1'
]);
$u->styles()->save($s);

$t = new \App\Models\Page([
    'title' => 'index',
    'description' => [
        'title'=>'page firsts',
        'description' => 'Example Page'
    ],
    'content' => htmlentities('<p>Hola Mundo</p>'),
    'parent_id' => 0
]);
$u->pages()->save($t);

$s->pages()->attach($t->id);

echo "<pre>";
var_dump(\App\Models\Page::All());
echo "</pre>";
```

# Tags #
## Possible Data ##
```
[
    'tag_type' => 'post',
    'tag' => 'php',
    'slug' => 'php',
    'description',
    'image'
],
[
    'tag_type' => 'art',
    'tag' => 'astradto',
    'slug' => 'astradto',
    'description',
    'image'
]
```

## relations ##
```
-----------
```

### Example of use ###
``` php
// Solo para generar datos aleatorios
$faker = Faker\Factory::create();
$tagsType = ['artista', 'post', 'gallery', 'museo', 'life'];
// Vamos a crear 5 etiquetas aleatorios
for($i = 0; $i <= 5; $i++){
    $name = $faker->name();
    \App\Models\Tag::create([
        'tag_type' => Arr::random($tagsType),
        'tag' => $name,
        'description' => [
            'title' => $name,
            'descriptions' =>  $faker->text()
        ],
        'image' => [$faker->name()]
    ]);
}
echo "<pre>";
var_dump(\App\Models\Tag::All());
echo "</pre>";
```

# Categorys #
## Possible Data ##
```
[
    'cat_type'  => 'art',
    'category',
    'slug',
    'description',
    'image' => [],
    'parent_id'
],
...
```

## relations ##
```
One = One
PostCategorys = PostCategorys
```
### Example of use ###
``` php
// Solo para generar datos aleatorios
$faker = Faker\Factory::create();
$catsType = ['artista', 'post', 'gallery', 'museo', 'life'];
$CatChildren = [1 => 3, 4 => 5];
for($i = 0; $i <= 5; $i++){
    $name = $faker->name();
    $parent = array_search($i, $CatChildren);
    \App\Models\Category::create([
        'cat_type' => Arr::random($catsType),
        'category' => $name,
        'description' => $faker->text(),
        'image' => [$faker->name()],
        'parent_id' => $parent === false ? 0 : $parent
    ]);
}
echo "<pre>";
var_dump(\App\Models\Category::All());
echo "</pre>";
```

# Posts #
## Possible Data ##
```
[
    'post_type' => 'post',
	'post_title' => 'title',
	'post_slug',
	'post_img' => [],
	'status_post' => 'public',
	'resumen_post',
	'post_content' => [],
	'post_categorie_id',
	'style_id',
	'post_tag_id',
	'user_id',
	'comment_id'
],
...
```

## relations ##
```
One  =<  Many
User =< Pages
---------------
|... =< Posts |
---------------
Many <=> Many
PostCategorys <=> Posts
PostTags <=> Posts
Styles <=> Posts
```

### Example of use ###
``` php
// Solo para generar datos aleatorios
$faker = Faker\Factory::create();
$postsType = ['artista', 'post', 'gallery', 'museo', 'life'];

// Ususrio Activo
$u = \App\Models\User::find(1);
// Guardamos el Nuevo POST
$p = new \App\Models\Post([
    'post_type' => Arr::random($postsType),
    'post_title' => $faker->name(),
    'post_img' => [
        'img/'.$faker->name().".jpg",
        'img/'.$faker->name().".jpg"
    ],
    'status_post' => 'publish',
    'resumen_post' => Str::limit($faker->text(), 10, ' (...)'),
    'post_content' => [
        'form_input1' => $faker->text(),
        'form_input2' => $faker->text(),
        'form_input3' => $faker->text(),
    ]
]);
$u->posts()->save($p);
$p->tags()->attach([1, 3, 5]);
$p->categories()->attach(1);
$p->styles()->attach(3);

echo "<pre>";
var_dump(\App\Models\Post::All());
echo "</pre>";
```