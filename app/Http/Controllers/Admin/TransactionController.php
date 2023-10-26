<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {

            $query = Transaction::with(['user']);

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                <div class="btn-group">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle mr-1 mb-1" type="button" data-toggle="dropdown">
                            Action
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('transaction.edit', $item->id) . '">
                                Edit
                            </a>
                            <form action="' . route('transaction.destroy', $item->id) . '" method="POST">
                                ' . method_field('delete') . csrf_field() . '
                                <button type="submit" class="dropdown-item text-danger">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                ';
                })
                ->editColumn('transaction_status', function ($item) {
                    if ($item->transaction_status == 'PENDING' ? 'selected' : '') {
                        return '<span class="badge badge-danger">PENDING</span>';
                    } elseif ($item->transaction_status == 'SUCCESS' ? 'selected' : '') {
                        return '<span class="badge badge-success">SUCCESS</span>';
                    } elseif ($item->transaction_status == 'SHIPPING' ? 'selected' : '') {
                        return '<span class="badge badge-primary">SHIPPING</span>';
                    }
                })
                ->rawColumns(['action', 'transaction_status'])
                ->make(true);
        }
        return view('pages.admin.transaction.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Transaction::findOrFail($id);
        return view('pages.admin.transaction.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    { {
            $data = $request->all();

            $item = Transaction::findOrFail($id);

            $item->update($data);

            return redirect()->route('transaction.index');
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Transaction::findOrFail($id);

        $item->delete();

        return redirect()->route('transaction.index');
    }
}
