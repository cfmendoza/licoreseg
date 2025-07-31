<?php

namespace Modules\Ventas\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Notifications\InvoiceSend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Yajra\DataTables\Facades\DataTables;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::with('details', 'customer')->orderBy('id', 'desc')->get();
        return view('ventas::index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ventas::create');
    }

    /**
     * Store a newly created resource in storage.
     */




public function store(Request $request)
{
    $data = $request->validate([
        'cliente_id'           => 'nullable|exists:leg_customers,id',
        'total'                => 'required|numeric',
        'products'             => 'required|array',
        'products.*.id'        => 'required|exists:leg_products,id',
        'products.*.quantity'  => 'required|integer|min:1',
        'products.*.price_unit'=> 'required|numeric',
        'products.*.subtotal'  => 'required|numeric',
    ]);

    DB::beginTransaction();

    try {
        $sale = Sale::create([
            'customer_id' => $data['cliente_id'] ?? null,
            'user_id'     => auth()->id(), 
            'date'        => now(),
            'total'       => $data['total'],
            'status'      => 'finalized',
        ]);

        $detailItems = collect($data['products'])->map(function($prod) use ($sale) {
            return [
                'sale_id'     => $sale->id,
                'product_id'  => $prod['id'],
                'quantity'    => $prod['quantity'],
                'unit_price'  => $prod['price_unit'],
                'subtotal'    => $prod['subtotal'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
        })->toArray();

        SaleDetail::insert($detailItems);

        // Descontar stock
        foreach ($data['products'] as $prod) {
            $product = Product::find($prod['id']);
            $product->stock -= $prod['quantity'];
            $product->save();
        }

        DB::commit();

        return redirect()
            ->route('ventas.index')
            ->with('success', 'Venta creada correctamente.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()
            ->withInput()
            ->with('error', 'Error al crear la venta: ' . $e->getMessage());
    }
}



    /**
     * Show the specified resource.
     */
public function show($id)
{
    $sale = Sale::with('details.product', 'customer')->findOrFail($id);
    return view('ventas::show', compact('sale'));
}



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('ventas::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}

    public function getClientes()
    {
        return response()->json(Customer::all());
    }



public function dataTableSales()
{
    $query = DB::table('leg_sales as sales')
        ->join('leg_customers as customers', 'sales.customer_id', '=', 'customers.id')
        ->join('leg_sale_details as s_details', 'sales.id', '=', 's_details.sale_id')
        ->join('leg_products as products', 's_details.product_id', '=', 'products.id')
        ->select(
            'sales.id',
            'customers.name as cliente',
            'sales.total',
            'sales.date',
            DB::raw('GROUP_CONCAT(products.name SEPARATOR ", ") as productos')
        )
        ->groupBy('sales.id', 'customers.name', 'sales.total', 'sales.date');

    return DataTables::query($query)
        ->addIndexColumn()
        ->addColumn('acciones', fn($row) =>
            '<a href="'.route('ventas.show', $row->id).'" class="btn btn-sm btn-primary">Ver</a>'
        )
        ->rawColumns(['acciones'])
        ->toJson();
}



public function sendInvoice(Request $request, $id)
{
    $request->validate([
        'email' => 'required|email',
    ]);

    $sale = Sale::with(['customer', 'details.product'])->findOrFail($id);

    // Crear un destinatario anónimo con solo un correo
    $recipient = (object)[
        'email' => $request->email,
        'name' => $sale->customer->name ?? 'Cliente',
        'routeNotificationForMail' => fn () => $request->email,
    ];

    Notification::route('mail', $request->email)
        ->notify(new InvoiceSend($sale));

    return redirect()->route('ventas.index')->with('success', 'Factura enviada correctamente.');
}




}
