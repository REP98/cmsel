<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
use App\Models\Style;
use App\Models\User;


class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(1);

        $style = new Style ([
            'name' => 'StyleToDefaults',
            'css' => ':root{
                    /* FUENTES */
                    --font-family-alex-brush: \'Alex Brush\', cursive;
                    --font-family-asap: \'Asap\', sans-serif;
                    --font-family-asap-condensed: \'Asap Condensed\', sans-serif;
                    --font-family-montserrat: \'Montserrat\', sans-serif;
                    --font-family-open-sans-condensed: \'Open Sans Condensed\', sans-serif;
                    --font-family-roboto: \'Roboto\', sans-serif;
                    --font-family-roboto-slab: \'Roboto Slab\', serif;

                    /* PESO DE FUENTES*/
                    --font-weight-thin: 100;
                    --font-weight-extraLight: 200;
                    --font-weight-light: 300;
                    --font-weight-regular: 400;
                    --font-weight-medium: 500;
                    --font-weight-semiBold: 600;
                    --font-weight-bold: 700;
                    --font-weight-extraBold: 800;
                    --font-weight-ultraBold: 900;

                    /* RELLENOS */
                    --padding-top: 3.125rem ;
                    --padding-left: 3.125rem ;
                    --padding-bottom: 3.125rem ;
                    --padding-right: 3.125rem ;

                    /* COLORS */
                    --color-dark: #201815;
                    --color-dark-alfa: #55595c;
                    --color-gray: #E9E9E9;
                    --color-brom: #B89A6A;
                    --color-carmesi: #ECDAB5;
                    --color-orange: #d17b53;

                    /* VIDEO */
                    --plyr-color-main: #DDCCB8;
                    --plyr-audio-controls-background: rgb(0 0 0 / 60%);
                    --plyr-audio-control-color: #fff;
                }',
            'js' => '$(() => console.log(\'Welcome for Settings\') )',
            'show' => '-1',
            'level' => '-1',
            'user' => '-1'
        ]);

        $user->styles()->save($style);
        $user->refresh();

        $settings = new Setting([
            'image' => [
                'avatar' => 'storage/default/avatarwithmask.png'
            ],
            'general' => [
                'site_title' => 'artpost',
                'site_description' => 'Otro sistema laravel',
                'site_url' => url('/')
            ],
            'config' => [],
            'pages' => [],
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
                    ],
                    'Entradas' => [
                        'url' => route('post'),
                        'level' => 'ap_post read',
                        'order' => 2,
                        'submenu' => [
                            'Añadir' => [
                                'url' => route('post.new'),
                                'level' => 'ap_post create'
                            ],
                            'Categorias' => [
                                'url' => route('post.category'),
                                'level' => 'ap_post_cat create'
                            ],
                            'Etiquetas' => [
                                'url' => route('post.tag'),
                                'level' => 'ap_post_tag create'
                            ]
                        ]
                    ],
                    'Plantillas' => [
                        'url' => route('template'),
                        'level' => 'ap_page read',
                        'order' => 6,
                        'submenu' => [
                            'Cabezera' => [
                                'url' => route('template.header'),
                                'level' => 'ap_page read create'
                            ],
                            'Sección' => [
                                'url'=> route('template.section'),
                                'level' => 'ap_page read create'
                            ],
                            'Pie' => [
                                'url' => route('template.footer'),
                                'level' => 'ap_page read create'
                            ],
                            'Widget' => [
                                'url' => route('template.widget'),
                                'level' => 'ap_page read create'
                            ]
                        ]
                    ],
                    'Style'=> [
                        'url' => route('editors'),
                        'order' => 9,
                        'level' => 'ap_config_manage read create'
                    ],
                    'Usuarios' => [
                        'url' => route('user'),
                        'order' => 10,
                        'level' => 'ap_user_manager read create',
                        'submenu' => [
                            'Perfil' => [
                                'url' => ['user.profile','id'],
                                'level' => 'ap_sessions_admin read'
                            ],
                            'Nuevo' => [
                                'url' => route('user.new'),
                                'level' => 'ap_user_manager create'
                            ],
                            'Permisos' => [
                                'url' => route('user.permissions'),
                                'level' => 'read create',
                                'role' => 'SuperAdmin|Administrador'
                            ]
                        ]
                    ],
                    'Ajustes' => [
                        'url' => route('setting'),
                        'level' => 'ap_config_manage create read',
                        'role' => 'SuperAdmin|Administrador',
                        'order' => 13
                    ]
                ]
            ],
            'mail'=>[]
        ]);
        $style->settings()->save($settings);
    }
}
