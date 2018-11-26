<?php

namespace App\Admin\Extensions;

use Encore\Admin\Admin;

class ChangeShopOnline
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    protected function script()
    {
        return <<<SCRIPT

$('.grid-check-row').on('click', function () {
    var id = $(this).data('id');

    swal({
        title: "确定通过吗?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "确认",
        closeOnConfirm: false,
        cancelButtonText: "取消",
        showLoaderOnConfirm: true
    },
    function(){
        $.ajax({
            method: 'put',
            url: '/admin/shops/' + id,
            data: {
                _token:LA.token,
                name: 1
            },
            success: function (data) {
                $.pjax.reload('#pjax-container');

                if (typeof data === 'object') {
                    if (data.status) {
                        swal(data.message, '', 'success');
                    } else {
                        swal(data.message, '', 'error');
                    }
                }
            }
        });
    });
    
    console.log($(this).data('id'));

});

SCRIPT;
    }

    public function render($status)
    {
        Admin::script($this->script());

        return "<a class='btn btn-xs btn-success fa grid-check-row' data-id='{$this->id}'>{$status}</a>";
    }

    public function __toString()
    {
        return $this->render();
    }
}