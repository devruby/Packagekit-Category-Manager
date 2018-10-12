<?php
namespace Devdojo\CategoryManager\Controllers;

use App\Http\Controllers\Controller;
use App\Taxonomy;
use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\FunctionsController;

class OrderController extends Controller
{

    public $order;

    public function __construct(Order $vvv)
    {
        $this->order    = $vvv;
    }


    /**
     * View all Order
     */
    public function getIndex()
    {

        $data = $this->order->index();
        return view('hrms.order.list', compact('data'));
    }

    /**
     * @return Order
     */
    public function getAdd()
    {
        $data = $this->order->add();
        return view('hrms.order.add', compact('data'));
    }

    public function postAdd()
    {
        $this->order->saveAdd();
        return redirect('order/index');
    }

    public function getShow($id)
    {
        $data = $this->order->show($id);
        return view('hrms.order.show', compact('data'));
    }

    /**
     * @return Order
     */
    public function getEdit($id)
    {
        $data = $this->order->edits($id);
        return view('hrms.order.add', compact('data'));
    }

    public function postEdit($id)
    {
        $data = $this->order->saveAdd($id);
        return redirect('order/index');
    }

    public function getDelete($id)
    {
        $this->order->deletes($id);
        return redirect('order/index');
    }

    public function getIndexDetail(){
        $data = $this->order->indexDetail();
        return view('hrms.order.list-detail', compact('data'));
    }

    public function getEditDetail($id){
        $data = $this->order->editDetail($id);
        return view('hrms.order.edit-detail', compact('data'));
    }

    public function postEditDetail($id){
        $data = $this->order->saveEditDetail($id);
        return redirect('order/index-detail');
    }

    public function getDeleteDetail($id){
        $this->order->deleteEditDetail($id);
        return redirect('order/index-detail');
    }

}