<?php

namespace Ll\DcatConfig;

use Dcat\Admin\Extend\ServiceProvider;

class DcatConfigServiceProvider extends ServiceProvider
{
	protected $js = [
//        'js/index.js',
    ];
	protected $css = [
//		'css/index.css',
	];

    protected $menu = [
        [
            'title' => '系统变量配置',
            'uri'   => 'llconfig',
            'icon'  => 'fa-gear', // 图标可以留空
        ],
    ];

	public function register()
	{
		//
	}

	public function init()
	{
		parent::init();

		//

	}

	public function settingForm()
	{
		return new Setting($this);
	}
}
