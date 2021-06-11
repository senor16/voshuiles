<?php

namespace App\Controllers;
use App\Controller;

class Errors extends Controller{
	public function showError(string $message){
		return '<span class="form-error">'.$message.'</span>';
	}
}
