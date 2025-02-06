<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detalleventa extends Model
{
  protected $table = 'detalleventa';
  protected $fillable = ['precio', 'cantidad', 'id_producto', 'id_venta'];

    public function venta()
    {
        return $this->belongsTo(Venta::class,'id_venta');
    }
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
    public function detalles($id)
{
    $venta = Venta::with(['cliente', 'productos'])->findOrFail($id);

    if (!$venta) {
        abort(404, 'La venta no fue encontrada.');
    }

    $venta = Venta::with(['detalleventa.producto', 'cliente'])->findOrFail($id);
    return view('ventas.detalles', compact('venta'));
}

}



