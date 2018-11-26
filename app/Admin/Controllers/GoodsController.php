<?php

namespace App\Admin\Controllers;

use App\Models\Deopt;
use App\Models\Goods;
use App\Http\Controllers\Controller;
use App\Models\Shop;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class GoodsController extends Controller
{
    use ModelForm;

    public function upGoods($deopt_id)
    {
        $deopt = Deopt::find($deopt_id);
//        dd($deopt);
        return Admin::content(function (Content $content) use ($deopt) {

            $content->header('药品列表');
//            $content->description('description');

            Admin::form(Goods::class, function (Form $form) use ($deopt) {

                $form->display('id', 'ID');

                $form->mobile('')->default($deopt->name);

                $form->display('created_at', 'Created At');
                $form->display('updated_at', 'Updated At');
            });
        });
    }

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('药品列表');
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

            $content->body(Admin::show(Goods::findOrFail($id), function (Show $show) {

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
        return Admin::grid(Goods::class, function (Grid $grid) {

            $grid->filter(function($filter){
                // 去掉默认的id过滤器
                $filter->disableIdFilter();
                // 在这里添加字段过滤器
                // $filter->like('name', 'name');
                $filter->where(function ($query) {
                    $keyword = $this->input;
                    $query->whereHas('deopt', function($query) use ($keyword){
                        $query->where('name', 'like', "%$keyword%")->orWhere('id', $keyword)->orWhere('upc', $keyword);
                    });
                }, '关键字');
                $filter->equal('shop_id','药店选择')->select(array_pluck(Shop::all(),'name','id'));
            });

            $grid->shop()->name('药店名称');
            $grid->deopt()->picture('图片')->display(function ($pictures) {
                return explode(",", $pictures)[0];
            })->image('', 100, 100);
            $grid->deopt()->name('名称');
            $grid->price('价格');
            $grid->deopt()->category('分类');
            $grid->deopt()->unit('单位');
            $grid->deopt()->spec('规格');
            $grid->deopt()->is_otc('OTC')->using(['0' => '否', '1' => '是']);
            $grid->deopt()->upc('条码');
            $grid->deopt()->company('厂家');
            $grid->created_at('创建时间');
            $grid->updated_at('更新时间');


            $grid->actions(function ($actions) {
//                $actions->disableEdit();
                $actions->disableView();
//                $actions->disableDelete();
//                $actions->append('<a href="'.url("admin/goods/{$actions->getKey()}/edit").'" class="label label-success">编辑</a> ');
//                $actions->append(' <a href="javascript:void(0);" data-id="'.$actions->getKey().'" class="grid-row-delete label label-danger"">删除</a> ');
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
        return Admin::form(Goods::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
