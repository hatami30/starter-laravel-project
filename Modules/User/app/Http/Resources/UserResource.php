<?php

// namespace Modules\User\Http\Resources;

// use Illuminate\Http\Resources\Json\JsonResource;
// use Carbon\Carbon;

// class UserResource extends JsonResource
// {
//   public function toArray($request)
//   {
//     return [
//       'id' => $this->id,
//       'name' => $this->name,
//       'email' => $this->email,
//       'email_verified_at' => Carbon::parse($this->email_verified_at)->format('F d, Y h:i A'),
//       'created_at' => Carbon::parse($this->created_at)->format('F d, Y h:i A'),
//       'updated_at' => Carbon::parse($this->updated_at)->format('F d, Y h:i A'),
//       'status' => $this->status,
//       // Jika diperlukan, tambahkan relasi lain seperti divisi
//       'division' => $this->division ? $this->division->name : null,
//     ];
//   }
// }
