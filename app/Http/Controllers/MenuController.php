<?php

namespace App\Http\Controllers;

use App\Menu;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class MenuController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     */
    function __construct()
    {
        $this->middleware('permission:menu-list|menu-create|menu-edit|menu-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:menu-create', ['only' => ['create','store']]);
        $this->middleware('permission:menu-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:menu-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $menus = Menu::select('menu_name')->get();

        return $this->sendResponse($menus, 'menus retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'vat_number' => 'required|digits:10',
            'street' => 'required',
            'city' => 'required',
            'post_code' => 'required|regex:/^([0-9]{2})(-[0-9]{3})?$/i',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $menu = menu::create($input);

        return $this->sendResponse($menu->toArray(), 'menu created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  menu  $menu
     * @return Response
     */
    public function show(Menu $menu)
    {
        if ($menu instanceof ModelNotFoundException) {
            return $this->sendError('menu not found.');
        }

        return $this->sendResponse($menu, 'menu retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  menu  $menu
     * @return Response
     */
    public function update(Request $request, Menu $menu)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'vat_number' => 'required|digits:10',
            'street' => 'required',
            'city' => 'required',
            'post_code' => 'required|regex:/^([0-9]{2})(-[0-9]{3})?$/i',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $menu->name = $input['name'];
        $menu->vat_number = $input['vat_number'];
        $menu->street = $input['street'];
        $menu->city = $input['city'];
        $menu->post_code = $input['post_code'];
        $menu->email = $input['email'];
        $menu->save();

        return $this->sendResponse($menu->toArray(), 'menu updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  menu  $menu
     * @return Response
     * @throws \Exception
     */
    public function destroy(menu $menu)
    {
        $menu->delete();

        return $this->sendResponse($menu->toArray(), 'menu deleted successfully.');
    }

    public function displayMenu($menu_name)
    {
        $menu = Menu::where('menu_name', $menu_name)->select('link_name', 'custom_url')->get();

        return $this->sendResponse($menu, 'menu retrieved successfully.');
    }
}
