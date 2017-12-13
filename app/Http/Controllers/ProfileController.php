<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function Symfony\Component\VarDumper\Tests\Caster\reflectionParameterFixture;

class ProfileController extends Controller
{
    public function update(){
        request()->user()->update(request()->only('name','email'));
        return response()->json(['status'=>true]);
    }
}
