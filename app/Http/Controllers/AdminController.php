<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Services\AdminService;
use Illuminate\Http\Request;
use App\Services\Interfaces\AdminServiceInterface;

class AdminController extends Controller
{

    protected AdminServiceInterface $AdminService;

    public function __construct(AdminServiceInterface $AdminService){
        $this->AdminService = $AdminService;
    }

    public function showDashboard(Request $request){
        $users = $this->AdminService->getAllUsers();

        return view("dashboard", compact('users'));
    }

    public function getUser($name){

        $user = $this->AdminService->getUserByName($name);

        if (!$user) {
            return response()->json(['error' => 'Продукт не найден'], 404);
        }

        return response()->json($user);
    }

    public function deleteUser(string $name){
        if (!$this->AdminService->deleteUser($name)) {
            return response()->json(['error' => 'Продукт не найден'], 404);
        }

        return response()->json(['message' => 'Продукт успешно удален'], 200);
    }

    public function createUser(CreateUserRequest $request){

            try {
                $user = $this->AdminService->createUser($request->validated());
    
                return response()->json([
                    'success' => true,
                    'message' => 'Пользователь добавлен',
                    'user' => $user,
                ], 201);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ошибка при добавлении пользователя',
                    'error' => $e->getMessage()
                ], 500);
            }
    }

    public function updateUser(Request $request, string $name){
        $updatedUser = $this->AdminService->updateUser($name, $request->all());

        if (!$updatedUser) {
            return response()->json(['success' => false, 'message' => 'Пользователь не найден'], 404);
        }

        return response()->json(['success' => true, 'message' => 'Продукт обновлен']);
    }

}
