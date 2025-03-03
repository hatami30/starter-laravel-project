<?php

// namespace Modules\User\Http\Controllers\API;

// use App\Http\Controllers\Controller;
// use Modules\User\Models\User;
// use Modules\User\Http\Requests\UserStoreRequest;
// use Modules\User\Http\Requests\UserUpdateRequest;
// use Modules\User\Http\Resources\UserResource;
// use Illuminate\Support\Facades\Hash;
// use Spatie\Permission\Models\Role;
// use Illuminate\Database\Eloquent\ModelNotFoundException;
// use Illuminate\Support\Facades\Log;

// class UserController extends Controller
// {
//     /**
//      * Menampilkan daftar semua pengguna.
//      *
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function index()
//     {
//         try {
//             $users = User::with('division')->get();
//             return response()->json(UserResource::collection($users));  // Mengembalikan data koleksi pengguna
//         } catch (\Exception $e) {
//             Log::error('Error saat mengambil daftar pengguna: ' . $e->getMessage());
//             return response()->json([
//                 'error' => 'Terjadi kesalahan saat mengambil daftar pengguna.'
//             ], 500);
//         }
//     }

//     /**
//      * Menyimpan data pengguna baru.
//      *
//      * @param UserStoreRequest $request
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function store(UserStoreRequest $request)
//     {
//         try {
//             $userData = $request->validated();
//             $userData['password'] = Hash::make($request->password); // Hash password

//             // Membuat pengguna baru
//             $user = User::create($userData);

//             // Menetapkan role pada pengguna
//             $role = Role::findOrFail($request->role_id);
//             $user->assignRole($role->name);

//             return response()->json([
//                 'message' => 'Pengguna berhasil dibuat.',
//                 'user' => new UserResource($user)  // Menggunakan UserResource untuk format data
//             ], 201);
//         } catch (\Exception $e) {
//             Log::error('Error saat membuat pengguna: ' . $e->getMessage());
//             return response()->json([
//                 'error' => 'Terjadi kesalahan saat membuat pengguna.'
//             ], 500);
//         }
//     }

//     /**
//      * Menampilkan detail pengguna berdasarkan ID.
//      *
//      * @param int $id
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function show($id)
//     {
//         try {
//             $user = User::with('division')->findOrFail($id);
//             return response()->json(new UserResource($user));  // Menggunakan UserResource untuk format data
//         } catch (ModelNotFoundException $e) {
//             return response()->json([
//                 'error' => 'Pengguna tidak ditemukan.'
//             ], 404);
//         } catch (\Exception $e) {
//             Log::error('Error saat mengambil detail pengguna: ' . $e->getMessage());
//             return response()->json([
//                 'error' => 'Terjadi kesalahan saat mengambil detail pengguna.'
//             ], 500);
//         }
//     }

//     /**
//      * Memperbarui data pengguna yang ada.
//      *
//      * @param UserUpdateRequest $request
//      * @param int $id
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function update(UserUpdateRequest $request, $id)
//     {
//         try {
//             $user = User::findOrFail($id);
//             $userData = $request->validated();

//             // Jika password diubah, hash password baru
//             if ($request->has('password')) {
//                 $userData['password'] = Hash::make($request->password);
//             }

//             // Memperbarui data pengguna
//             $user->update($userData);

//             // Memperbarui role jika ada
//             if ($request->has('role_id')) {
//                 $role = Role::findOrFail($request->role_id);
//                 $user->syncRoles([$role->name]);
//             }

//             return response()->json([
//                 'message' => 'Pengguna berhasil diperbarui.',
//                 'user' => new UserResource($user)
//             ], 200);
//         } catch (ModelNotFoundException $e) {
//             return response()->json([
//                 'error' => 'Pengguna tidak ditemukan.'
//             ], 404);
//         } catch (\Exception $e) {
//             Log::error('Error saat memperbarui pengguna: ' . $e->getMessage());
//             return response()->json([
//                 'error' => 'Terjadi kesalahan saat memperbarui pengguna.'
//             ], 500);
//         }
//     }

//     /**
//      * Menghapus pengguna berdasarkan ID.
//      *
//      * @param int $id
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function destroy($id)
//     {
//         try {
//             $user = User::findOrFail($id);
//             $user->delete();  // Soft delete
//             return response()->json([
//                 'message' => 'Pengguna berhasil dihapus.'
//             ], 200);
//         } catch (ModelNotFoundException $e) {
//             return response()->json([
//                 'error' => 'Pengguna tidak ditemukan.'
//             ], 404);
//         } catch (\Exception $e) {
//             Log::error('Error saat menghapus pengguna: ' . $e->getMessage());
//             return response()->json([
//                 'error' => 'Terjadi kesalahan saat menghapus pengguna.'
//             ], 500);
//         }
//     }
// }
