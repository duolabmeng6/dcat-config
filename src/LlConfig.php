<?php
namespace Ll\DcatConfig;

use Illuminate\Support\Facades\Schema;
use Ll\DcatConfig\Models\LlConfig as LlConfigModel;

class LlConfig {
    public static function load()
    {
        if (Schema::hasTable('llconfig')) {
            foreach (LlConfigModel::all(['name', 'value']) as $config) {
                config([$config['name'] => $config['value']]);
            }
        }

    }
}
