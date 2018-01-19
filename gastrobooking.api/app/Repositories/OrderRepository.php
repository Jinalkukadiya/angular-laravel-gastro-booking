<?php
/**
 * Created by PhpStorm.
 * RestaurantOpen: tOm_HydRa
 * Date: 9/10/16
 * Time: 12:06 PM
 */

namespace App\Repositories;

use App\Entities\Client;
use App\Entities\MenuList;
use App\Entities\Order;
use App\Entities\OrderDetail;
use App\Entities\Photo;
use App\Entities\RestaurantOpen;
use App\Entities\Restaurant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;


class OrderRepository
{

    public function save($restaurantId){

        $client = app('Dingo\Api\Auth\Auth')->user()->client;
        $order = $this->getClientOrder($client->ID, $restaurantId);
        if ($order){
            return $order;
        }
        $order = new Order();
        $order->ID_restaurant = $restaurantId;
        $order->ID_client = $client->ID;
        $order->status = 5;
//        $order->order_number = $this->getOrderNumber($restaurantId);
        $order->save();
        return $order;

    }

    public function getClientOrder($client_id, $restaurantId){
        return Order::where(["ID_client" => $client_id, "status" => 5, "ID_restaurant" => $restaurantId])->first();

    }

    public function getOrderNumber($rest_id){
        $orders = Order::where(["ID_restaurant"=>$rest_id])->orderBy("id", "desc")->get();
        $today = Carbon::now("Europe/Prague");
        $order_number = 1;
        if (count($orders)){
            $order = $orders;
            if(!$today->diffInDays(new Carbon($order->created_at))){

                $order_number = $order->order_number + 1;
            }
        }
        return $order_number;
    }

    public function checkAndCancel($id) {
        $order = Order::find($id);
        foreach($order->orders_detail as $order_detail) {
            if ($order_detail->status != 3) {
                return $order;
            }
        }
        $order->status = 3;
        $order->save();

        return $order;
    }

    public static function getOrders($request){

        $condition_query = "1=1 ";
        if ( $request->id != "" && $request->id != null )
        {
            $condition_query .= " AND restaurant.id ='".$request->id."'";
        }
        else
        {
            if ( $request->name != "" && $request->name != null ) $condition_query .= " AND restaurant.name like '%".$request->name."%'";
            if ( $request->unassigned == "true" ) $condition_query .= " AND restaurant.id_user_dealer IS NULL";
                //$condition_query .= " AND restaurant.id_user_dealer IS ".($request->unassigned ? "NULL" :"NOT NULL");
            if ( $request->country != "" && $request->country != null ){
                if ( $request->district != "" && $request->district != null ){
                    $condition_query .= " AND restaurant.id_district = '".$request->district."'";
                }else{
                    $condition_query .= " AND district.country = '".$request->country."'";
                }
            }

            if ($request->status != "" && $request->status != null ){
                $condition_query .= " AND restaurant.status = '".$request->status."'";
            }
        }

        $result = Restaurant::select(
                'restaurant.id as id',
                'restaurant.name as name',
                 DB::raw('CONCAT(restaurant.street,  " ", restaurant.city) as address') ,
                'restaurant.id_district as id_district',
                'restaurant.phone as phone',
                'district.name as district',
                'district.country as country',
                'restaurant.id_user_dealer as id_user_dealer',
                'restaurant.status as status',
                'restaurant.id_user_acquire as id_user_acquire', 
                'restaurant.id_user_contract as id_user_contract',
                'restaurant.id_user as id_user',      
                'user_p.phone as owner',
                'user_c.name as contract',
                'user_d.name as dealer')
                ->leftJoin('user as user_d', 'user_d.id', '=', 'restaurant.id_user_dealer')
                ->leftJoin('user as user_c', 'user_c.id', '=', 'restaurant.id_user_contract') 
                ->leftJoin('user as user_p', 'user_p.id', '=', 'restaurant.id_user')                                  
                ->leftJoin('district', 'district.id', '=', 'restaurant.id_district')
                ->whereRaw($condition_query)
                ->orderBy('restaurant.id', 'ASC')
                ->get();

            //$currentPage = LengthAwarePaginator::resolveCurrentPage();

            $pagedData = $result->slice(($request->currentPage - 1) * $request->perPage, $request->perPage)->all();

            return new LengthAwarePaginator($pagedData, count($result), $request->perPage);            
    }
}