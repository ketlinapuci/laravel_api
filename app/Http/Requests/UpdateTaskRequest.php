<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

//since we need the same validation rules as the store task reques, we remove everything inside the class
//extend from storetaskrequest
class UpdateTaskRequest extends StoreTaskRequest
{

}
