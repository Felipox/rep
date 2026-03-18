<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Services\NotificationService;

class NotificationLogController extends Controller
{
    private $notification_service;

    public function __construct(NotificationService $notification_service)
    {
        $this->notification_service = $notification_service;
    }

    public function index(Request $request)
    {
        try{
            $notifications = $this->notification_service->findAllByUser($request->user()->id);

            return response()->json([
                'Sucesso'=> 'Pedidos listados',
                'Pedidos:'=> $notifications
            ],200);
        }
        catch(Exception $e){
            return response()->json([
                'Erro'=> 'Erro ao listar pedidos',
                $e->getMessage()
            ],500);
    }
}
}
