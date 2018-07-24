<?php

$GLOBALS['TL_DCA']['tl_oauth_resource_owner'] = [
    // Config
    'config' => [
        'dataContainer' => 'Table',
        'enableVersioning' => true,
        'sql' => [
            'keys' => [
                'id' => 'primary'
            ]
        ]
    ],

    // Palettes
    'palettes' => [
        '__selector__' => ['type'],
        'default' => '{type_legend},type,name;',
        'github'  => '{type_legend},type,name;{application_legend},application_id,application_secret;{settings_legend},scope',
    ],

    // List
    'list' => [
        'sorting' => [
            'mode'           => 1,
            'fields'         => ['name'],
            'flag'           => 1,
            'panelLayout'    => 'filter;sort,search,limit'
        ],
        'label' => [
            'fields'         => ['name', 'type'],
            'format'         => '%s <span style="color:#ccc">(%s)</span>'
        ],
        'operations' => [
            'edit' => [
                'label'      => &$GLOBALS['TL_LANG']['tl_oauth_resource_owner']['edit'],
                'href'       => 'act=edit',
                'icon'       => 'edit.gif'
            ],
            'delete' => [
                'label'      => &$GLOBALS['TL_LANG']['tl_oauth_resource_owner']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.gif',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ]
        ]
    ],

    // Fields
    'fields' => [
        'id' => [
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ],
        'tstamp' => [
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ],
        'type' => [
            'label' => &$GLOBALS['TL_LANG']['tl_oauth_resource_owner']['type'],
            'inputType' => 'select',
            'options' => ['github'],
            'eval' => [
                'mandatory' => true,
                'tl_class' => 'w50',
                'chosen' => true,
                'submitOnChange' => true
            ],
            'sql' => "varchar(128) NOT NULL default ''"
        ],
        'name' => [
            'label' =>  &$GLOBALS['TL_LANG']['tl_oauth_resource_owner']['name'],
            'inputType' => 'text',
            'eval' => [
                'mandatory' => true,
                'tl_class' => 'w50'
            ],
            'sql' => "varchar(128) NOT NULL default ''"
        ],
        'scope' => [
            'label' =>  &$GLOBALS['TL_LANG']['tl_oauth_resource_owner']['scope'],
            'inputType' => 'text',
            'eval' => [
                'mandatory' => false,
                'tl_class' => 'w50'
            ],
            'sql' => "varchar(128) NOT NULL default ''"
        ],
        'application_id' => [
            'label' =>  &$GLOBALS['TL_LANG']['tl_oauth_resource_owner']['application_id'],
            'inputType' => 'text',
            'eval' => [
                'mandatory' => true,
                'tl_class' => 'w50'
            ],
            'sql' => "varchar(128) NOT NULL default ''"
        ],
        'application_secret' => [
            'label' =>  &$GLOBALS['TL_LANG']['tl_oauth_resource_owner']['application_secret'],
            'inputType' => 'text',
            'eval' => [
                'mandatory' => true,
                'tl_class' => 'w50'
            ],
            'sql' => "varchar(128) NOT NULL default ''"
        ]
    ]
];
