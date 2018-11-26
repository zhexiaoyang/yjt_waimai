<?php

namespace App\Admin\Controllers;

use App\Models\Shop;
use App\Models\ShopDetail;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ShopDetailController extends Controller
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

            $content->header('header');
            $content->description('description');

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
        $shop = Shop::find($id);
        if (!$shop->detail->id)
        {
            $data = ['shop_id' => $id, 'coefficient' => 15];
            ShopDetail::create($data);
        }
        $shop = Shop::find($id);
        $detail_id = $shop->detail->id;

        return Admin::content(function (Content $content) use ($detail_id) {

            $content->header('财务信息');
//            $content->description('description');

            $content->body($this->form()->edit($detail_id));
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

            $content->header('header');
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
        return Admin::grid(ShopDetail::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->created_at();
            $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(ShopDetail::class, function (Form $form) {



            $form->tools(function (Form\Tools $tools) {
//                $tools->append('<a class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;delete</a>');
                // 去掉查看按钮
                $tools->disableView();
                $tools->disableDelete();
                $tools->disableList();
            });

            $form->display('shop.name', '门店名称');

            $form->text('opening_bank', '开户行')->rules('required');
            $form->text('username', '开户名')->rules('required');
            $form->text('account_number', '打款账号')->rules('required');

//            $form->text('is_invoice', '是否开发票')->rules('required');
            $form->radio('is_invoice', '是否开发票')->options(['1' => '是', '0'=> '否'])->default(0);
            $form->radio('type', '票据类型')->options(['1' => '专用', '0'=> '普通'])->default(0);
//            $form->text('type', '票据类型')->rules('required');

            $form->text('name', '开票名称');
            $form->text('number', '票据识别号');
            $form->text('coefficient', '打款系数');

            $form->display('shop.dc', '配送方式')->options(['1' => '自配送', '0'=> '美团配送']);

        });
    }
}
