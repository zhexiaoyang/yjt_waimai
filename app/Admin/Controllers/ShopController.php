<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\ChangeShopOnline;
use App\Models\Shop;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Illuminate\Http\Request;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Extensions\Tools\OnlineShop;
use Waimai\Waimai;

class ShopController extends Controller
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

            $content->header('药店管理');
//            $content->description('description');

            $content->body($this->grid());
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

            $content->header('药店管理');
//            $content->description('description');

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

            $content->header('药店管理');
//            $content->description('description');

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
        return Admin::grid(Shop::class, function (Grid $grid) {
            $grid->paginate(10);
            $grid->model()->orderBy('id', 'desc');
            $grid->id('ID')->sortable();
            $grid->name('药店名称');
            $grid->promotion_info('门店推广信息')->editable('textarea');
            $grid->address('药店地址');
            $grid->detail()->coefficient('系数');
//            $grid->created_at('创建时间');
//            $grid->updated_at('更新时间');

            $grid->column('状态', '状态')->display(function () {
                $str = '';
                $meituan = Waimai::Meituan(config('wmconfig'));
                $params = [
                    'app_poi_codes' => $this->meituan_id,
                ];
                $data = $meituan->shop->mget($params);
                if (isset($data['data'][0]))
                {
                    $is_online = (int)$data['data'][0]['is_online'];
                    $open_level = (int)$data['data'][0]['open_level'];
                     $a = new ChangeShopOnline($this->id);
                     return $a->render('上线') . " " . $a->render('上线');

//                    (int)$data['data'][0]['is_online'] === 1 ? $str .= "<span class='label label-success'>上线</span>" : $str .= "<span class='label label-danger'>下线</span>";
//                    $str .= " ";
//                    (int)$data['data'][0]['open_level'] === 1 ? $str .= "<span class='label label-success'>营业</span>" : $str .= "<span class='label label-danger'>休息</span>";
//                    return $str;
                }
                return '';
            });

            $grid->actions(function ($actions) {
                $actions->disableEdit();
                $actions->disableView();
                $actions->disableDelete();
                $actions->append('<a href="'.url("admin/shops/{$actions->getKey()}/edit").'" class="label label-success">编辑</a> ');
                $actions->append(' <a href="'.url("admin/shopDetails/{$actions->getKey()}/edit").'" class="label label-success">财务</a>');
//                $actions->append('<a href=""><i class="fa fa-paper-plane"></i></a>');
            });

            $grid->disableExport();

            $grid->tools(function ($tools) {
                $tools->batch(function ($batch) {
                    $batch->disableDelete();
                    $batch->add('上线', new OnlineShop(2));
                    $batch->add('休息', new OnlineShop(1));
                });
            });

            $grid->filter(function($filter){
                $filter->disableIdFilter();
                $filter->like('meituan_id', '美团ID');
                $filter->like('name', '药店名称');
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Shop::class, function (Form $form) {

            $form->tools(function (Form\Tools $tools) {
//                $tools->append('<a class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;delete</a>');
                // 去掉查看按钮
                $tools->disableView();
                $tools->disableDelete();
                $tools->disableList();
            });


            $form->display('id', '门店ID');
            $form->text('name', '名称')->rules('required');
            $form->text('address', '地址')->rules('required');
            $form->text('longitude', '经度')->rules('required');
            $form->text('latitude', '纬度')->rules('required');
//            $form->text('pic_url', 'Logo地址')->rules('required');
            $form->text('phone', '客服电话')->rules('required');
            $form->text('standby_tel', '门店电话');
            $form->text('shipping_fee', '配送费')->rules('required');
            $form->text('min_price', '起送价')->rules('required');
            $form->text('shipping_time', '营业时间')->rules('required')->help('注意格式，且保证不同时间段之间不存在交集(7:00-9:00,11:30-19:00)');
            $form->text('promotion_info', '门店推广信息');
            $form->radio('is_online', '上下线状态')->options(['1' => '上线', '0'=> '下线'])->default('1');
            $form->radio('open_level', '营业状态')->options(['1' => '可配送', '3'=> '休息中'])->default('1');
            $form->radio('invoice_support', '是否支持发票')->options(['1' => '是', '0'=> '否'])->default('1');
            $form->text('invoice_min_price', '发票最小金额')->rules('required');

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }

    public function status(Request $request)
    {
        foreach (Shop::find($request->get('ids')) as $shop) {
            $shop->is_online = $request->get('action');
            $shop->save();
        }
    }

}
