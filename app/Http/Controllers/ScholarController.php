<?php

namespace App\Http\Controllers;

use App\Models\Scholar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ScholarController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $scholar = Scholar::paginate(5);
    return $scholar;
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

    $post = Scholar::create([
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
    $scholar = DB::table('schools')->where('class_id', $id)->paginate(5);
    return $scholar;
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
