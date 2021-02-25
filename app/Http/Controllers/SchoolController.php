<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Validator;

class SchoolController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $str = School::all([
      "name",
      "gender",
      "date",
      "class_id"
    ]);
    return $str;
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
   * @return array|\Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        "name" => ["required"],
        "gender" => ["required"],
        "date" => ["required"],
        "class_id" => ["required"]
      ]
    );

    if ($validator->fails()) {
      return [
        "status" => false,
        "errors" => $validator->messages()
      ];
    }

    $post = School::create([
      "name" => $request->name,
      "gender" => $request->gender,
      "date" => $request->date,
      "class_id" => $request->class_id
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
   * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
   */
  public function show($id)
  {
    $post = School::find($id);
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
