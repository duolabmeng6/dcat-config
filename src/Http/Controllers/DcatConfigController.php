<?php

namespace Ll\DcatConfig\Http\Controllers;

use Dcat\Admin\Layout\Content;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Ll\DcatConfig\Models\LlConfig;
use Str;

class DcatConfigController extends AdminController
{
    public function title()
    {
        return '系统变量配置';
    }

    public function index(Content $content)
    {
        return $content
            ->title($this->title())
            ->description('config("变量名") 获取变量名对应的值')
            ->body($this->grid());
    }

    protected function grid()
    {
        $grid = new Grid(new LlConfig());
        $grid->disableRefreshButton();
//        $grid->disableFilterButton();

        $grid->id('ID')->sortable();
        $grid->column('name', '变量名')->editable();

        $grid->column('value', '设置值')->display(function ($title, $column) {
            $optArr = [];
            if ($this->option) {
                $options = explode("\r\n", $this->option);
                foreach ($options as $option) {
                    if (str_contains($option, '=')) {
                        $opt             = explode("=", $option);
                        $optArr[$opt[0]] = $opt[1];
                    }
                }
            }
            // 如果这一列的status字段的值等于1，直接显示title字段
            if ($this->type == 0) {
                return $column->editable();
            }
            if ($this->type == 1) {
                return $column->switch();
            }
            if ($this->type == 2) {
                return $column->select($optArr);
            }
            if ($this->type == 4) {
                return $column->radio($optArr);
            }
            if ($this->type == 3 or $this->type == 5) {
                return $column->checkbox($optArr);
            }
            if ($this->type == 5) {
                return $column->checkbox($optArr);
            }
            if ($this->type == 6) {
                return $column->textarea()->width(200);
//                return $column->textarea()->display(function($v){
//                    return Str::limit($v,10);
//                });
            }
            if ($this->type == 7) {
//                return $column->editable('time');
            }
            if ($this->type == 8) {
//                return $column->editable('date');
            }
            if ($this->type == 9) {
//                return $column->editable('datetime');
            }
            // 否则显示为editable
            return $column->editable();
        });

        $grid->column('变量值')->display(function ($title, $column) {
            if ($this->type == 6) {
                return Str::limit($this->value, 10);
            }

            return $this->value;
        });
        $grid->column('description', '说明')->editable();
        $grid->disableViewButton();
        $grid->enableDialogCreate();
        $grid->filter(function ($filter) {
            $filter->panel();
//            $filter->expand(true);
            $filter->disableIdFilter();
            $filter->like('name', '变量名');
            $filter->like('value', '搜索值');
            $filter->like('description', '描述');
        });
        return $grid;
    }

    protected function form()
    {
        return Form::make(new LlConfig(), function (Form $form) {
            $form->hidden('id', 'ID');
            $form->text('name', '变量名')->rules('required');
            $form->select('type', '变量类型')->options([
                0 => '文本类型',
                6 => '长文本类型',
                1 => '开关类型',
                2 => '下拉单选框',
                3 => '下拉多选框',
                4 => '单选框',
                5 => '多选框',
                7 => '时间类型',
                8 => '日期类型',
                9 => '时间日期类型',
                // 8 => '图片'
            ])
                ->default(0);

            $optArr = [];
            if ($form->model()->option) {
                $options = explode("\r\n", $form->model()->option);
                foreach ($options as $option) {
                    if (str_contains($option, '=')) {
                        $opt             = explode("=", $option);
                        $optArr[$opt[0]] = $opt[1];
                    }
                }
            }
            switch ($form->model()->type) {
                case 1:
                    $form->switch('value', '设置值');
                    break;
                case 2:
                    $form->select('value', '设置值')->options($optArr);
                    break;
                case 3:
                    $form->multipleSelect('value', '设置值')->options($optArr);
                    break;
                case 4:
                    $form->radio('value', '设置值')->options($optArr);
                    break;
                case 5:
                    $form->checkbox('value', '设置值')->options($optArr);
                    break;
                case 6:
                    $form->textarea('value', '设置值');
                    break;
                case 7:
                    $form->time('value', '设置值');
                    break;
                case 8:
                    $form->date('value', '设置值');
                    break;
                case 9:
                    $form->datetime('value', '设置值');
                    break;
                default:
                    $form->text('value', '设置值');
            };
            $form->textarea('option', '选项')->placeholder("选项的数据,示例如下:\r\n0=变量值0\r\n1=变量值1\r\n2=变量值2")->rules('required_if:type,2,3,4,5')->default("")->help("每行一条选项数据,变量名=设置值");
            $form->textarea('description', '说明');
        })->saving(function (Form $form) {

        });
    }
}
