<?php namespace Indikator\Backend;

use System\Classes\PluginBase;
use System\Classes\PluginManager;
use System\Classes\SettingsManager;
use Backend\Classes\Controller as BackendController;
use Backend;
use BackendAuth;
use File;
use Event;

class Plugin extends PluginBase
{
    public $elevated = true;

    public function pluginDetails()
    {
        return [
            'name'        => 'indikator.backend::lang.plugin.name',
            'description' => 'indikator.backend::lang.plugin.description',
            'author'      => 'indikator.backend::lang.plugin.author',
            'icon'        => 'icon-cogs',
            'homepage'    => 'https://github.com/gergo85/oc-backend-plus'
        ];
    }

    public function registerSettings()
    {
        return [
            'trash' => [
                'label'       => 'indikator.backend::lang.trash.title',
                'description' => 'indikator.backend::lang.trash.description',
                'icon'        => 'icon-eraser',
                'permissions' => ['indikator.backend.trash'],
                'url'         => Backend::url('indikator/backend/trash'),
                'category'    => SettingsManager::CATEGORY_SYSTEM
            ]
        ];
    }

    public function registerReportWidgets()
    {
        return [
            'Indikator\Backend\ReportWidgets\Cache' => [
                'label'   => 'indikator.backend::lang.widgets.cache.title',
                'context' => 'dashboard'
            ],
            'Indikator\Backend\ReportWidgets\Status' => [
                'label'   => 'indikator.backend::lang.widgets.system.title',
                'context' => 'dashboard'
            ],
            'Indikator\Backend\ReportWidgets\Version' => [
                'label'   => 'indikator.backend::lang.widgets.version.title',
                'context' => 'dashboard'
            ],
            'Indikator\Backend\ReportWidgets\Logs' => [
                'label'   => 'indikator.backend::lang.widgets.logs.title',
                'context' => 'dashboard'
            ],
            'Indikator\Backend\ReportWidgets\Admins' => [
                'label'   => 'indikator.backend::lang.widgets.admins.title',
                'context' => 'dashboard'
            ],
            'Indikator\Backend\ReportWidgets\Logins' => [
                'label'   => 'indikator.backend::lang.widgets.logins.title',
                'context' => 'dashboard'
            ],
            'Indikator\Backend\ReportWidgets\Server' => [
                'label'   => 'indikator.backend::lang.widgets.server.title',
                'context' => 'dashboard'
            ],
            'Indikator\Backend\ReportWidgets\Php' => [
                'label'   => 'indikator.backend::lang.widgets.php.title',
                'context' => 'dashboard'
            ],
            'Indikator\Backend\ReportWidgets\Rss' => [
                'label'   => 'indikator.backend::lang.widgets.rss.title',
                'context' => 'dashboard'
            ],
            'Indikator\Backend\ReportWidgets\Images' => [
                'label'   => 'indikator.backend::lang.widgets.images.title',
                'context' => 'dashboard'
            ]
        ];
    }

    public function registerPermissions()
    {
        return [
            'indikator.backend.trash' => [
                'tab'   => 'indikator.backend::lang.plugin.name',
                'label' => 'indikator.backend::lang.trash.permission'
            ]
        ];
    }

    public function boot()
    {
        Event::listen('backend.form.extendFields', function($form)
        {
            if ($form->model instanceof Backend\Models\Preference) {
                $form->addTabFields([
                    /*
                     * Display settings
                     */
                    'rounded_avatar' => [
                        'tab'     => 'indikator.backend::lang.settings.tab_display',
                        'label'   => 'indikator.backend::lang.settings.avatar_label',
                        'comment' => 'indikator.backend::lang.settings.avatar_comment',
                        'type'    => 'switch',
                        'default' => false
                    ],
                    'topmenu_label' => [
                        'tab'     => 'indikator.backend::lang.settings.tab_display',
                        'label'   => 'indikator.backend::lang.settings.topmenu_label',
                        'comment' => 'indikator.backend::lang.settings.topmenu_comment',
                        'type'    => 'switch',
                        'default' => false
                    ],
                    'sidebar_description' => [
                        'tab'     => 'indikator.backend::lang.settings.tab_display',
                        'label'   => 'indikator.backend::lang.settings.sidebar_desc_label',
                        'comment' => 'indikator.backend::lang.settings.sidebar_desc_comment',
                        'type'    => 'switch',
                        'default' => false
                    ],
                    'sidebar_search' => [
                        'tab'     => 'indikator.backend::lang.settings.tab_display',
                        'label'   => 'indikator.backend::lang.settings.sidebar_search_label',
                        'comment' => 'indikator.backend::lang.settings.sidebar_search_comment',
                        'type'    => 'switch',
                        'default' => false
                    ],
                    'display_elite' => [
                        'tab'     => 'indikator.backend::lang.settings.tab_display',
                        'label'   => 'More cool features',
                        'comment' => 'Change the Account menu and the Profile image style, etc. See the Backend Elite plugin on the Market.',
                        'type'    => 'section'
                    ],

                    /*
                     *  Behavior settings
                     */
                    'focus_searchfield' => [
                        'tab'     => 'indikator.backend::lang.settings.tab_behavior',
                        'label'   => 'indikator.backend::lang.settings.search_label',
                        'comment' => 'indikator.backend::lang.settings.search_comment',
                        'type'    => 'switch',
                        'default' => false
                    ],
                    'context_menu' => [
                        'tab'     => 'indikator.backend::lang.settings.tab_behavior',
                        'label'   => 'indikator.backend::lang.settings.context_menu_label',
                        'comment' => 'indikator.backend::lang.settings.context_menu_comment',
                        'type'    => 'switch',
                        'default' => false
                    ],
                    'virtual_keyboard' => [
                        'tab'     => 'indikator.backend::lang.settings.tab_behavior',
                        'label'   => 'indikator.backend::lang.settings.keyboard_label',
                        'comment' => 'indikator.backend::lang.settings.keyboard_comment',
                        'type'    => 'switch',
                        'default' => false
                    ],
                    'behavior_elite' => [
                        'tab'     => 'indikator.backend::lang.settings.tab_behavior',
                        'label'   => 'More cool features',
                        'comment' => 'Enable the gzip compression, use the wysiwyg editor instead of code editor, etc. See the Backend Elite plugin on the Market.',
                        'type'    => 'section'
                    ]
                ]);
            }
        });

        BackendController::extend(function($controller)
        {
            if (BackendAuth::check()) {
                /*
                 * User settings
                 */
                $preferenceModel = class_exists('Backend\Models\UserPreference')
                    ? Backend\Models\UserPreference::forUser()
                    : Backend\Models\UserPreferences::forUser();
                $preferences = $preferenceModel->get('backend::backend.preferences');

                /*
                 * Display settings
                 */
                if (isset($preferences['rounded_avatar']) && $preferences['rounded_avatar']) {
                    $controller->addCss('/plugins/indikator/backend/assets/css/rounded-avatar.css');
                }

                if (isset($preferences['topmenu_label']) && $preferences['topmenu_label']) {
                    $controller->addCss('/plugins/indikator/backend/assets/css/topmenu-label.css');
                    $controller->addJs('/plugins/indikator/backend/assets/js/topmenu-label.js');
                }

                if (isset($preferences['sidebar_search']) && $preferences['sidebar_search']) {
                    $controller->addCss('/plugins/indikator/backend/assets/css/sidebar-search.css');
                }

                if (isset($preferences['sidebar_description']) && $preferences['sidebar_description']) {
                    $controller->addCss('/plugins/indikator/backend/assets/css/sidebar-description.css');
                }

                /*
                 * Behavior settings
                 */
                if (isset($preferences['focus_searchfield']) && $preferences['focus_searchfield']) {
                    $controller->addCss('/plugins/indikator/backend/assets/css/setting-search.css');
                    $controller->addJs('/plugins/indikator/backend/assets/js/setting-search.js');
                }

                if (isset($preferences['context_menu']) && $preferences['context_menu']) {
                    $controller->addCss('/plugins/indikator/backend/assets/css/context-menu.css');
                    $controller->addJs('/plugins/indikator/backend/assets/js/context-menu.js');
                }

                if (isset($preferences['virtual_keyboard']) && $preferences['virtual_keyboard']) {
                    $controller->addCss('/plugins/indikator/backend/assets/css/ml-keyboard.css');
                    $controller->addJs('/plugins/indikator/backend/assets/js/ml-keyboard.js');
                }
            }
        });
    }
}
