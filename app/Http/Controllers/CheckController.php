<?php

namespace HDSSolutions\Laravel\Http\Controllers;

use App\Http\Controllers\Controller;
use HDSSolutions\Laravel\DataTables\CheckDataTable as DataTable;
use HDSSolutions\Laravel\Http\Request;
use HDSSolutions\Laravel\Models\Check as Resource;
use HDSSolutions\Laravel\Models\Customer;

class CheckController extends Controller {

    public function __construct() {
        // check resource Policy
        $this->authorizeResource(Resource::class, 'resource');
    }

    public function index(Request $request, DataTable $dataTable) {
        // check only-form flag
        if ($request->has('only-form'))
            // redirect to popup callback
            return view('backend::components.popup-callback', [ 'resource' => new Resource ]);

        // load resources
        if ($request->ajax()) return $dataTable->ajax();

        // load customers
        $customers = Customer::all();

        // return view with dataTable
        return $dataTable->render('payments::checks.index', compact('customers') + [
            'count'                 => Resource::count(),
            'show_company_selector' => !backend()->companyScoped(),
        ]);
    }

    public function show(Request $request, Resource $resource) {
        // load resource relations
        $resource->load([
            'partnerable',
        ]);

        // show check details
        return view('payments::checks.show', compact('resource'));
    }

}
