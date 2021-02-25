<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassSchool;
use Illuminate\Support\Facades\Validator;

class ClassController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return ClassSchool::all();
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @return array
   */
  public function store(Request $request)
  {
    $validator = Validator::make(
      $request->all(), ["class" => ["required"]]);

    if ($validator->fails()) {
      return [
        "status" => false,
        "errors" => $validator->messages()
      ];
    }

    $post = ClassSchool::create([
      "class" => $request->class
    ]);

    return [
      "status" => true,
      "post" => $post
    ];
  }

  /**
   * Display the specified resource.
   *
   * @param int $id
   * @return \Illuminate\Http\JsonResponse|object
   */
  public function show($id)
  {
    $post = ClassSchool::find($id);
    if (!$post) {
      return response() -> json([
        "status" => false,
        "message" => "Post not found"
      ]) -> setStatusCode(404);
    } else {
      return $post;
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }
}
