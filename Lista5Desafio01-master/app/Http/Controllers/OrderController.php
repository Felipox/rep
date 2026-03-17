<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatchOrderRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Services\OrderService;

class OrderController extends Controller
{
    use AuthorizesRequests;
    private $order_service;

    public function __construct(OrderService $order_service)
    {
        $this->order_service = $order_service;
    }

    public function index()
    {
        try{
            $orders = $this->order_service->findAll();

            return response()->json([
                'Sucesso'=> 'Pedidos listados',
                'Pedidos:'=> $orders
            ],200);
        }
        catch(Exception $e){
            return response()->json([
                'Erro'=> 'Erro ao listar pedidos',
                $e->getMessage()
            ],500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        try{
            $data = $request->validated();

            $data['user_id'] = $request->user()->id;

            $order = $this->order_service->create($data);

            return response()->json([
                'message' => 'Pedido criado com sucesso',
                'order'=> $order
            ],201);
           
        }
        catch(Exception $e)
        {
            return response()->json(['Erro'=> $e->getMessage()], $e->getCode()?: 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PatchOrderRequest $request, Order $order)
    {
        try{

            $this->authorize('update', $order);

            $data = $request->validated();
            $order = $this->order_service->update($order->id,$data);
                
            if(!$order){
                return response()->json([
                    'Erro:'=> 'Erro ao atualizar status'
                ], 404);
            }

            return response()->json([
                'message'=> 'Status atualizado com sucesso'
            ],200);
        }
        catch(Exception $e){
            return response()->json([
                'Erro'=> $e->getMessage()
            ],$e->getCode());
        
        }
    }
    public function update(UpdateOrderRequest $request, Order $order)
    {
        try{
            
            $this->authorize('update', $order);

            $data = $request->validated();
            $order = $this->order_service->update($order->id,$data);

            if(!$order){
                return response()->json([
                    'Erro:'=> 'Erro ao atualizar pedido'
                ], 404);
            }

            return response()->json([
                'message'=> 'Pedido atualizado com sucesso',
                'pedido'=> $order
            ],200);
        }
        catch(Exception $e){
            return response()->json([
                'Erro'=> $e->getMessage()
            ],$e->getCode());
        }
    }

}
