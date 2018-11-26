<?php

namespace App\Admin\Controllers;

use App\Models\Deopt;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class DeoptController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('品库列表');
//            $content->description('description');

            $content->body($this->grid());
        });
    }

    /**
     * Show interface.
     *
     * @param $id
     * @return Content
     */
    public function show($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('Detail');
            $content->description('description');

            $content->body(Admin::show(Deopt::findOrFail($id), function (Show $show) {

                $show->id();

                $show->created_at();
                $show->updated_at();
            }));
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('Edit');
            $content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('Create');
            $content->description('description');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Deopt::class, function (Grid $grid) {
            $grid->filter(function($filter){

                // 去掉默认的id过滤器
                 $filter->disableIdFilter();
                // 在这里添加字段过滤器
                // $filter->like('name', 'name');
                $filter->where(function ($query) {

                    $query->where('name', 'like', "%{$this->input}%")
                        ->orWhere('common_name', 'like', "%{$this->input}%")
                        ->orWhere('upc', 'like', "%{$this->input}%");

                }, '关键字');

            });

            $grid->picture('图片')->display(function ($pictures) {

                return explode(",", $pictures)[0];

            })->image('', 100, 100);
//            $grid->column('','名称/通用名')->display(function () {
//                return $this->name . '<br>' . $this->common_name;
//            });
            $grid->name('名称');
            $grid->category('分类');
            $grid->unit('单位');
            $grid->spec('规格');
            $grid->is_otc('OTC')->using(['0' => '否', '1' => '是']);
            $grid->upc('条码');
            $grid->company('厂家');

            $grid->actions(function ($actions) {
                $actions->disableEdit();
                $actions->disableView();
                $actions->disableDelete();
//                $actions->append('<a href="'.url("admin/shops/{$actions->getKey()}/edit").'" class="label label-success">编辑</a> ');
                $actions->append(' <a href="'.url("admin/goods/upGoods/{$actions->getKey()}").'" class="label label-warning">上传药品</a>');
            });
            $grid->disableRowSelector();
            $grid->disableCreateButton();
            $grid->disableExport();

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Deopt::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
