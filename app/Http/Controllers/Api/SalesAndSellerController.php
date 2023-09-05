<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Seller;
use Illuminate\Support\Facades\Validator;

class SalesAndSellerController extends Controller
{
    public function index(){

        $salesAndSellers = Sale::with('seller')->get();
        
        if(count($salesAndSellers) > 0){

            $arraySaleaAndSeller = array();

            foreach($salesAndSellers as $saleAndSeller){
                $arraySaleaAndSeller [] = [
                    'id_seller' => $saleAndSeller->seller->id,
                    'name' => $saleAndSeller->seller->name,
                    'email' => $saleAndSeller->seller->email,
                    'id_sale' => $saleAndSeller->id,
                    'value' => $saleAndSeller->value,
                    'commission' => $saleAndSeller->commission,
                ];
            }

            return response()->json([
                'status' => 200,
                'salesAndSellers' => $arraySaleaAndSeller
            ], 200);

        } else {

            return response()->json([
                'status' => 404,
                'salesAndSellers' => 'data not found'
            ], 404);
        }
    }

    public function storeSale(Request $request){

        $validator = Validator::make($request->all(), [
            'value' => 'required|numeric',
        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 422,
                'error' => $validator->messages()
            ], 422);
        } else {

            $commission = $request->value * 0.085;
            $seller = Seller::first();

            $sale = Sale::create([
                'value' => $request->value,
                'commission' => $commission ?? 0.0,
                'seller_id' => $seller->id ?? 1
            ]);

            if($sale){

                return response()->json([
                    'status' => 200,
                    'message' => 'successfully registered data'
                ], 200);
            } else {

                return response()->json([
                    'status' => 500,
                    'message' => 'it was not possible to register the data'
                ], 500);
            }
        }
    }

    public function showSale($id){

        $sales = Sale::find($id);
        
        if($sales){

            return response()->json([
                'status' => 200,
                'sales' => $sales
            ], 200);

        } else {

            return response()->json([
                'status' => 404,
                'sales' => 'sale not found'
            ], 404);
        }
    }

    public function editSale($id){

        $sales = Sale::find($id);
        
        if($sales){

            return response()->json([
                'status' => 200,
                'sales' => $sales
            ], 200);

        } else {

            return response()->json([
                'status' => 404,
                'sales' => 'sale not found'
            ], 404);
        }
    }

    public function updateSale(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'value' => 'required|numeric',
        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 422,
                'error' => $validator->messages()
            ], 422);
        } else {

            $sale = Sale::find($id);

            if($sale){

                $commission = $request->value * 0.085;

                $sale->update([
                    'value' => $request->value,
                    'commission' => $commission
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'record updated successfully'
                ], 200);
            } else {

                return response()->json([
                    'status' => 404,
                    'message' => 'could not update record'
                ], 404);
            }
        }        
    }

    public function deleteSale($id){

        $sale = Sale::find($id);

        if($sale){

            $sale->delete();

            return response()->json([
                'status' => 200,
                'message' => 'successfully deleted sale'
            ], 200);
        } else {

            return response()->json([
                'status' => 404,
                'message' => 'sale not found'
            ], 404);
        }
    }
}
